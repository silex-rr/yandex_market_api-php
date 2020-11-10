<?php


namespace YMAb\model;


trait RequestParameters
{
    protected $params;

    protected function updateParameter($name, $value): void
    {
        if(empty($name)) {
            return;
        }
        if(empty($value)
            && key_exists($name, $this->params)
        ) {
            unset($this->params[$name]);
        }
        $this->params[$name] = $value;
    }
}