<?php


namespace YMAb\model\request;


use YMAb\model\Protocol;
use YMAb\model\Request;

class BaseCampaigns extends Request
{
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
     * @param null|string $shop
     */
    public function setShop(?string $shop): void
    {
        $this->setShop($shop);
    }

}