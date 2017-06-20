<?php
namespace Umeng\UmengPush\android;

use Umeng\UmengPush\AndroidNotification;

class AndroidUnicast extends AndroidNotification
{

    function __construct()
    {
        parent::__construct();
        $this->data["type"] = "unicast";
        $this->data["device_tokens"] = NULL;
    }
}