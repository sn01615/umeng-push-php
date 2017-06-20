<?php
namespace Umeng\UmengPush\ios;

use Umeng\UmengPush\IOSNotification;

class IOSBroadcast extends IOSNotification
{

    function __construct()
    {
        parent::__construct();
        $this->data["type"] = "broadcast";
    }
}