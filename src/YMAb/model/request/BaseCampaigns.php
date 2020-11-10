<?php


namespace YMAb\model\request;


use YMAb\model\Protocol;
use YMAb\model\Request;

class BaseCampaigns extends Request
{
    /**
     * Shop ID in Balancer (like 5f40b11325508f46d92cdf1d)
     * @var string
     */
    private $shop;

    /**
     * BaseCampaigns constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = "/rest/request/add";
        $this->params = [];
        $this->protocol = new Protocol(Protocol::PUT);
        $this->method = "base.Campaigns";
    }

    /**
     * @return string
     */
    public function getShop(): string
    {
        return $this->shop;
    }

    /**
     * @param string $shop
     */
    public function setShop(string $shop): void
    {
        $this->shop = $shop;
        $this->params["shop"] = $shop;
        $this->updateParameter("shop", $shop);
    }

}