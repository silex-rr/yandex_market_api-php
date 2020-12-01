<?php


namespace YMAb\model;

use DateTime;

abstract class Request
{
    use RequestParameters;

    /**
     * @var string API url
     */
    protected $url;
    /**
     * @var array
     */
    protected $params;
    /**
     * @var Protocol
     */
    protected $protocol;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string ID which set by YMA balancer
     */
    protected $requestId;

    /**
     * @var mixed JSON
     */
    protected $response;

    /**
     * @var RequestStatus
     */
    protected $status;

    /**
     * @var DateTime
     */
    protected $timeCreate;

    /**
     * @var DateTime
     */
    protected $timeResponse;

    /**
     * Shop ID in Balancer (like 5f40b11325508f46d92cdf1d)
     * @var string|null
     */
    protected $shop;

    /**
     * @var int|null
     */
    protected $priority;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->status = new RequestStatus(RequestStatus::CREATED);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return Protocol
     */
    public function getProtocol(): Protocol
    {
        return $this->protocol;
    }

    /**
     * @return string|null
     */
    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    /**
     * @param string $requestId
     */
    public function setRequestId(string $requestId): void
    {
        $this->requestId = $requestId;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response): void
    {
        $this->response = $response;
    }

    /**
     * @return RequestStatus
     */
    public function getStatus(): RequestStatus
    {
        return $this->status;
    }

    /**
     * @param RequestStatus $status
     */
    public function setStatus(RequestStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return DateTime|null
     */
    public function getTimeCreate(): ?DateTime
    {
        return $this->timeCreate;
    }

    /**
     * @param DateTime $timeCreate
     */
    public function setTimeCreate(DateTime $timeCreate): void
    {
        $this->timeCreate = $timeCreate;
    }

    /**
     * @return ?DateTime
     */
    public function getTimeResponse(): ?DateTime
    {
        return $this->timeResponse;
    }

    /**
     * @param DateTime $timeResponse
     */
    public function setTimeResponse(DateTime $timeResponse): void
    {
        $this->timeResponse = $timeResponse;
    }

    /**
     * @param Protocol $protocol
     */
    public function setProtocol(Protocol $protocol): void
    {
        $this->protocol = $protocol;
    }

    /**
     * @return string|null
     */
    public function getShop(): ?string
    {
        return $this->shop;
    }

    /**
     * @param string|null $shop
     */
    public function setShop(?string $shop): void
    {
        $this->shop = $shop;
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int|null $priority
     */
    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }



}