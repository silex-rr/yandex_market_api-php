<?php
namespace YMAb\repository;

use PDO;
use DateTime;
use Exception;
use YMAb\model\Protocol;
use YMAb\model\Request;
use YMAb\model\RequestStatus;

class RequestRepository
{
    /**
     * @var PDO
     */
    private $PDO;

    /**
     * @var string
     */
    private $tableName;

    public function startWorkWithDB(PDO $PDO, $tableName): bool
    {
        $this->PDO = $PDO;
        $this->tableName = $tableName;

        if(!$this->tableExists()) {
            return $this->tableCreate();
        }
        return true;
    }

    private function createRequestByData($data): ?Request
    {
        if (!class_exists($data["requestClass"])) {
            return null;
        }
        try {
            /**
             * @var Request $request
             */
            $request = new $data["requestClass"]();
        } catch (Exception $exception) {
            return null;
        }
        $request->setRequestId($data["requestId"]);

        $request->setProtocol(new Protocol($data["protocol"]));
        $request->setStatus($data["status"]);
        $timeCreate = null;
        if (!empty($data["timeCreate"])) {
            try {
                $timeCreate = new DateTime($data["timeCreate"]);
            } catch (Exception $exception) {
            }
        }
        $request->setTimeCreate($timeCreate);
        $timeResponse = null;
        if (!empty($data["timeResponse"])) {
            try {
                $timeResponse = new DateTime($data["timeResponse"]);
            } catch (Exception $exception) {
            }
        }
        $request->setTimeResponse($timeResponse);
        $request->setResponse($data["response"]);

        return $request;
    }

    /**
     * @param string $requestId
     * @return Request|null
     */
    public function findByRequestId(string $requestId): ?Request
    {
        $prepared = $this->PDO
            ->prepare("SELECT * FROM `" . $this->tableName . "` WHERE `requestId` = :requestId;");
        $prepared->execute([
            ":requestId" => $requestId
        ]);
        $result = $prepared->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        return $this->createRequestByData($result);
    }

    public function save(Request $request): void
    {
        $inDB = true;
        if ($request->getStatus() === RequestStatus::CREATED) {
            $requestInDB = $this->findByRequestId($request->getRequestId());
            if (is_null($requestInDB)) {
                $inDB = false;
            }
        }

        $PDOStatement = null;
        if ($inDB) {
            $PDOStatement = $this->PDO->prepare("
                UPDATE `" . $this->tableName . "`
                    SET
                    `requestClass` = :requestClass,
                    `protocol` = :protocol,
                    `status` = :status,
                    `timeCreate` = :timeCreate,
                    `timeResponse` = :timeResponse,
                    `response` = :response
                WHERE `requestId` = :requestId
            ");
        } else {
            $PDOStatement = $this->PDO->prepare("
                INSERT INTO `" . $this->tableName . "`
                    (`requestId`,
                    `requestClass`,
                    `protocol`,
                    `status`,
                    `timeCreate`,
                    `timeResponse`,
                    `response`)
                    VALUE 
                    (:requestId,
                    :requestClass,
                    :protocol,
                    :status,
                    :timeCreate,
                    :timeResponse,
                    :response);
            ");
        }
        $timeCreate = null;
        if (!is_null($request->getTimeCreate())) {
            $timeCreate = $request->getTimeCreate()->format("Y-m-d H:i:s");
        }
        $timeResponse = null;
        if (!is_null($request->getTimeResponse())) {
            $timeResponse = $request->getTimeResponse()->format("Y-m-d H:i:s");
        }
        $PDOStatement->execute([
            ":requestId" => $request->getRequestId(),
            ":requestClass" => get_class($request),
            ":protocol" => $request->getProtocol()->getValue(),
            ":status" => $request->getStatus()->getValue(),
            ":timeCreate" => $timeCreate,
            ":timeResponse" => $timeResponse,
            ":response" => $request->getResponse()
        ]);
    }

    /**
     * Check if a table exists in the current database.
     *
     * @return bool TRUE if table exists, FALSE if no table found.
     */
    public function tableExists(): bool
    {

        // Try a select statement against the table
        // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
        try {
            $result = $this->PDO->query("SELECT 1 FROM `" . $this->tableName . "` LIMIT 1;");
        } catch (Exception $e) {
            // We got an exception == table not found
            return false;
        }

        // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
        return $result !== false;
    }

    private function tableCreate(): bool
    {
        try {
            $this->PDO->query("
                CREATE TABLE IF NOT EXISTS `" . $this->tableName . "` (
                    `requestId`                    VARCHAR(60) PRIMARY KEY,
                    `requestClass`                 VARCHAR(255) NOT NULL,
                    `protocol`                     VARCHAR(4) NOT NULL,
                    `status`                       INT NOT NULL,
                    `timeCreate`                   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `timeResponse`                 TIMESTAMP DEFAULT NULL,
                    `response`                     TEXT DEFAULT NULL,
                    KEY `idx_timeCreate` (`timeCreate`),
                    KEY `idx_timeResponse` (`timeResponse`)
                );
            ");
        } catch (Exception $e) {
            // We got an exception == table not found
            return false;
        }

        return true;
    }
}