<?php


namespace YMAb\model;

use MyCLabs\Enum\Enum;

class RequestStatus extends Enum
{
    const CREATED = 0;
    const DONE = 1;
    const IN_PROCESS = 2;
    const ERROR = 3;
}