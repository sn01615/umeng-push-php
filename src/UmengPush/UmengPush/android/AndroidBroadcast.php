<?php
namespace Umeng\UmengPush\android;

use Umeng\UmengPush\AndroidNotification;

class AndroidBroadcast extends AndroidNotification
{

    function __construct()
    {
        parent::__construct();
        $this->data["type"] = "broadcast";
    }
}