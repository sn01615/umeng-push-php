<?php
namespace Umeng\UmengPush\ios;

use Umeng\UmengPush\IOSNotification;

class IOSGroupcast extends IOSNotification
{

    function __construct()
    {
        parent::__construct();
        $this->data["type"] = "groupcast";
        $this->data["filter"] = NULL;
    }
}