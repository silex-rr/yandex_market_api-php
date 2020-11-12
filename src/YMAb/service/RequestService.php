<?php


namespace YMAb\service;


use Curl\Curl;
use YMAb\model\result\GetResult;
use YMAb\model\Protocol;
use YMAb\model\Request;
use YMAb\model\RequestStatus;
use YMAb\repository\RequestRepository;
use YMAb\YMAb;

class RequestService
{
    /**
     * @var RequestRepository
     */
    private $requestRepository;

    /**
     * @var YMAb
     */
    private $context;

    /**
     * RequestService constructor.
     * @param
     */
    public function __construct(YMAb $context)
    {
        $this->context = $context;
        $this->requestRepository = new RequestRepository();
        $this->startWorkWithDB();
    }

    /**
     * IF the table doesn't exists in the DB, this method tries to create it.
     *
     * @return bool TRUE if table exists and available
     */
    public function startWorkWithDB(): bool
    {
        if (!$this->context->isConnectedToDB()) {
            return false;
        }
        return $this->requestRepository->startWorkWithDB(
            $this->context->getPDO(),
            $this->context->getConfig()->getDbTable()
        );
    }

    public function getResult(Request $request): ?GetResult
    {
        $getResult = new GetResult();
        if (empty($request->getRequestId())) {
            return null;
        }
        $getResult->setRequest($request);

        $this->sendRequest($getResult);

        return $getResult;
    }

    public function sendRequest(Request $request): void
    {
        $curl = new Curl();
        $url = $this->context->getConfig()->getUrl()
            . $request->getUrl();
        $params = json_encode($request->getParams());
        $paramsJson = ["param" => $params];
        switch ($request->getProtocol()->getValue()) {
            case Protocol::PUT:
                $curl->put($url, $paramsJson);
                break;
            case Protocol::GET:
                $curl->get($url, $paramsJson);
                break;
            case Protocol::POST:
                $curl->post($url, $paramsJson);
                break;
        }

        if ($curl->error) {
            $request->setStatus(new RequestStatus(RequestStatus::ERROR));
            $request->setResponse("Error: " . $curl->errorCode . ": " . $curl->errorMessage );
        }

        $request->setResponse($curl->getResponse());
    }

    /**
     * It will try to find Request in DB by RequestId
     * @param string $requestId
     * @return Request|null
     */
    public function findByRequestId(string $requestId): ?Request
    {
        return $this->requestRepository->findByRequestId($requestId);
    }

}