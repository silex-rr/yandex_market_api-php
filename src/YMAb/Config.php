<?php


namespace YMAb;


class Config
{
    #### DataBase settings

    /**
     * @var bool
     */
    private $workWithDB = false;

    /**
     * @var string
     */
    private $dbDriver = "mysql";
    /**
     * @var string
     */
    private $dbHost = "localhost";
    /**
     * @var int
     */
    private $dbPort = 3306;
    /**
     * @var string
     */
    private $dbSchema;
    /**
     * @var string
     */
    private $dbUsername;
    /**
     * @var string
     */
    private $dbPassword;
    /**
     * @var string
     */
    private $dbTable = "ymabRequest";

    #### API Settings

    /**
     * Access token to balancer API
     * @var string
     */
    private $token;

    /**
     * Balancer URL
     * @var string
     */
    private $url;



    /**
     * @return string
     */
    public function getDbDriver(): string
    {
        return $this->dbDriver;
    }

    /**
     * @param string $dbDriver
     */
    public function setDbDriver(string $dbDriver): void
    {
        $this->dbDriver = $dbDriver;
    }

    /**
     * @return string
     */
    public function getDbHost(): string
    {
        return $this->dbHost;
    }

    /**
     * @param string $dbHost
     */
    public function setDbHost(string $dbHost): void
    {
        $this->dbHost = $dbHost;
    }

    /**
     * @return int
     */
    public function getDbPort(): int
    {
        return $this->dbPort;
    }

    /**
     * @param int $dbPort
     */
    public function setDbPort(int $dbPort): void
    {
        $this->dbPort = $dbPort;
    }

    /**
     * @return string
     */
    public function getDbSchema(): string
    {
        return $this->dbSchema;
    }

    /**
     * @param string $dbSchema
     */
    public function setDbSchema(string $dbSchema): void
    {
        $this->dbSchema = $dbSchema;
    }

    /**
     * @return string
     */
    public function getDbUsername(): string
    {
        return $this->dbUsername;
    }

    /**
     * @param string $dbUsername
     */
    public function setDbUsername(string $dbUsername): void
    {
        $this->dbUsername = $dbUsername;
    }

    /**
     * @return string
     */
    public function getDbPassword(): string
    {
        return $this->dbPassword;
    }

    /**
     * @param string $dbPassword
     */
    public function setDbPassword(string $dbPassword): void
    {
        $this->dbPassword = $dbPassword;
    }

    /**
     * @return string
     */
    public function getDbTable(): string
    {
        return $this->dbTable;
    }

    /**
     * @param string $dbTable
     */
    public function setDbTable(string $dbTable): void
    {
        $this->dbTable = $dbTable;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return bool
     */
    public function isWorkWithDB(): bool
    {
        return $this->workWithDB;
    }

    /**
     * @param bool $workWithDB
     */
    public function setWorkWithDB(bool $workWithDB): void
    {
        $this->workWithDB = $workWithDB;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }


}