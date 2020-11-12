<?php


namespace YMAb;

use YMAb\model\Request;
use YMAb\service\RequestService;
use PDO;
use Exception;

class YMAb
{
    /**
     * @var array(token => self)
     */
    private static $instanceByToken = [];

    /**
     * @var Request[]
     */
    private $requestPool = [];

    /**
     * @var Config
     */
    private $config;

    /**
     * @var RequestService
     */
    private $requestService;

    /**
     * @var PDO
     */
    private $PDO;

    private function __construct(Config $config)
    {
        $this->config = $config;
        if ($config->isWorkWithDB()) {
            $this->connectToDB();
        }
        $this->requestService = new RequestService($this);
    }

    /**
     * @param string $token
     * @param Config $config
     * @return YMAb
     */
    public static function getInstance(string $token, Config $config): YMAb
    {
        if (!key_exists($token, self::instanceByToken)) {
            self::instanceByToken[$token] = new self($config);
            /**
             * @var YMAb $instance
             */
            $instance = self::instanceByToken[$token];
            $instance->getConfig()->setToken($token);
        }
        return self::instanceByToken[$token];
    }



    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * Attempt to connect to the database
     * @return bool
     */
    public function connectToDB(): bool
    {
        if (!$this->getConfig()->isWorkWithDB()) {
            return false;
        }
        $config = $this->getConfig();
        $PDO = null;
        try {
            $dns = $config->getDbDriver() .
                ":host=" . $config->getDbHost() .
                ";port=" . $config->getDbPort() .
                ";dbname=" . $config->getDbSchema();
            $PDO = new PDO($dns);
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (Exception $e) {
            return false;
        }
        $this->PDO = $PDO;
        return true;
    }

    public function isConnectedToDB(): bool
    {
        return $this->PDO instanceof PDO;
    }

    /**
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->PDO;
    }

    /**
     * @return RequestService
     */
    public function getRequestService(): RequestService
    {
        return $this->requestService;
    }



}