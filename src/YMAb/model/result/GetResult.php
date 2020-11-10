<?php


namespace YMAb\model\result;


use YMAb\model\Protocol;
use YMAb\model\Request;

class GetResult extends Request
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var string
     */
    private $urlBase;

    public function __construct()
    {
        parent::__construct();
        $this->urlBase = $this->url = "/rest/request/getByRequestId";
        $this->params = [];
        $this->protocol = new Protocol(Protocol::GET);
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
        $this->url = $this->urlBase . "?requestId=" . $request->getRequestId();
    }
}