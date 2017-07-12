<?php
namespace Umeng;

use Umeng\UmengPush\android\AndroidBroadcast;
use Umeng\UmengPush\android\AndroidCustomizedcast;
use Umeng\UmengPush\android\AndroidFilecast;
use Umeng\UmengPush\android\AndroidGroupcast;
use Umeng\UmengPush\android\AndroidUnicast;
use Umeng\UmengPush\ios\IOSBroadcast;
use Umeng\UmengPush\ios\IOSCustomizedcast;
use Umeng\UmengPush\ios\IOSFilecast;
use Umeng\UmengPush\ios\IOSGroupcast;
use Umeng\UmengPush\ios\IOSUnicast;

class UmengPush
{

    protected $appkey = NULL;

    protected $appMasterSecret = NULL;

    protected $timestamp = NULL;

    protected $validation_token = NULL;

    protected $production_mode = 'true';

    function __construct($key, $secret)
    {
        $this->appkey = $key;
        $this->appMasterSecret = $secret;
        $this->timestamp = strval(time());
    }

    function sendAndroidBroadcast(array $values, array $extra)
    {
        $_values = [
            'ticker' => '', // 必填 通知栏提示文字
            'title' => '', // 必填 通知标题
            'text' => '', // 必填 通知文字描述
            'after_open' => 'go_app' // 必填 值可以为:
                                         // "go_app": 打开应用
                                         // "go_url": 跳转到URL
                                         // "go_activity": 打开特定的activity
                                         // "go_custom": 用户自定义内容。
        ];
        $extra = [];
        $_values = array_merge($_values, $values);
        try {
            $brocast = new AndroidBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue("appkey", $this->appkey);
            $brocast->setPredefinedKeyValue("timestamp", $this->timestamp);
            foreach ($_values as $key => $value) {
                $brocast->setPredefinedKeyValue($key, $value);
            }
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $brocast->setPredefinedKeyValue("production_mode", $this->production_mode);
            // [optional]Set extra fields
            foreach ($extra as $key => $value) {
                $brocast->setExtraField($key, $value);
            }
            // print("Sending broadcast notification, please wait...\r\n");
            return $brocast->send();
            // print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            return "Caught exception: " . $e->getMessage();
        }
    }

    public function sendAndroidUnicast(array $values, array $extra, $device_tokens)
    {
        $_values = [
            'device_tokens' => $device_tokens, // 必填, 表示指定的单个设备
            'ticker' => '', // 必填 通知栏提示文字
            'title' => '', // 必填 通知标题
            'text' => '', // 必填 通知文字描述
            'after_open' => 'go_app' // 必填 值可以为:
                                         // "go_app": 打开应用
                                         // "go_url": 跳转到URL
                                         // "go_activity": 打开特定的activity
                                         // "go_custom": 用户自定义内容。
        ];
        $_values = array_merge($_values, $values);
        $extra = [];
        try {
            $unicast = new AndroidUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue("appkey", $this->appkey);
            $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
            // Set your device tokens here
            foreach ($_values as $key => $value) {
                $unicast->setPredefinedKeyValue($key, $value);
            }
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $unicast->setPredefinedKeyValue("production_mode", $this->production_mode);
            // Set extra fields
            foreach ($extra as $key => $value) {
                $unicast->setExtraField($key, $value);
            }
            // print("Sending unicast notification, please wait...\r\n");
            return $unicast->send();
            // print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            return "Caught exception: " . $e->getMessage();
        }
    }

    function sendAndroidFilecast(array $values, array $extra, array $tokens)
    {
        $values = [
            'ticker' => '', // 必填 通知栏提示文字
            'title' => '', // 必填 通知标题
            'text' => '', // 必填 通知文字描述
            'after_open' => 'go_app' // 必填 值可以为:
                                         // "go_app": 打开应用
                                         // "go_url": 跳转到URL
                                         // "go_activity": 打开特定的activity
                                         // "go_custom": 用户自定义内容。
        ];
        $extra = [];
        $tokens = implode("\n", $tokens);
        try {
            $filecast = new AndroidFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue("appkey", $this->appkey);
            $filecast->setPredefinedKeyValue("timestamp", $this->timestamp);
            foreach ($values as $key => $value) {
                $filecast->setPredefinedKeyValue($key, $value);
            }
            // print("Uploading file contents, please wait...\r\n");
            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents($tokens);
            foreach ($extra as $key => $value) {
                $filecast->setExtraField($key, $value);
            }
            // print("Sending filecast notification, please wait...\r\n");
            $filecast->send();
            // print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            return "Caught exception: " . $e->getMessage();
        }
    }

    function sendAndroidGroupcast(array $values, array $extra, array $tags)
    {
        $values = [
            'ticker' => '', // 必填 通知栏提示文字
            'title' => '', // 必填 通知标题
            'text' => '', // 必填 通知文字描述
            'after_open' => 'go_app' // 必填 值可以为:
                                         // "go_app": 打开应用
                                         // "go_url": 跳转到URL
                                         // "go_activity": 打开特定的activity
                                         // "go_custom": 用户自定义内容。
        ];
        $extra = [];
        $_tags = [];
        foreach ($tags as $tag) {
            $_tags[] = [
                'tag' => $tag
            ];
        }
        $filter = [
            "where" => [
                "and" => [
                    $_tags
                ]
            ]
        ];
        try {
            $groupcast = new AndroidGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue("appkey", $this->appkey);
            $groupcast->setPredefinedKeyValue("timestamp", $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue("filter", $filter);
            foreach ($values as $key => $value) {
                $groupcast->setPredefinedKeyValue($key, $value);
            }
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $groupcast->setPredefinedKeyValue("production_mode", $this->production_mode);
            foreach ($extra as $key => $value) {
                $groupcast->setExtraField($key, $value);
            }
            // print("Sending groupcast notification, please wait...\r\n");
            $groupcast->send();
            // print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            return "Caught exception: " . $e->getMessage();
        }
    }

    function sendAndroidCustomizedcast(array $values, array $extra, $alias, $aliasType)
    {
        $values = [
            'ticker' => '', // 必填 通知栏提示文字
            'title' => '', // 必填 通知标题
            'text' => '', // 必填 通知文字描述
            'after_open' => 'go_app' // 必填 值可以为:
                                         // "go_app": 打开应用
                                         // "go_url": 跳转到URL
                                         // "go_activity": 打开特定的activity
                                         // "go_custom": 用户自定义内容。
        ];
        $extra = [];
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);
            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->setPredefinedKeyValue("alias", $alias);
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type", $aliasType);
            foreach ($values as $key => $value) {
                $customizedcast->setPredefinedKeyValue($key, $value);
            }
            foreach ($extra as $key => $value) {
                $customizedcast->setExtraField($key, $value);
            }
            // print("Sending customizedcast notification, please wait...\r\n");
            $customizedcast->send();
            // print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            return "Caught exception: " . $e->getMessage();
        }
    }

    function sendAndroidCustomizedcastFileId(array $values, array $extra, array $tokens)
    {
        $values = [
            'ticker' => '', // 必填 通知栏提示文字
            'title' => '', // 必填 通知标题
            'text' => '', // 必填 通知文字描述
            'after_open' => 'go_app' // 必填 值可以为:
                                         // "go_app": 打开应用
                                         // "go_url": 跳转到URL
                                         // "go_activity": 打开特定的activity
                                         // "go_custom": 用户自定义内容。
        ];
        $extra = [];
        $tokens = implode("\n", $tokens);
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);
            // if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->uploadContents($tokens);
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type", "xx");
            foreach ($values as $key => $value) {
                $customizedcast->setPredefinedKeyValue($key, $value);
            }
            foreach ($extra as $key => $value) {
                $customizedcast->setExtraField($key, $value);
            }
            // print("Sending customizedcast notification, please wait...\r\n");
            $customizedcast->send();
            // print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            return "Caught exception: " . $e->getMessage();
        }
    }

    function sendIOSBroadcast()
    {
        try {
            $brocast = new IOSBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue("appkey", $this->appkey);
            $brocast->setPredefinedKeyValue("timestamp", $this->timestamp);
            
            $brocast->setPredefinedKeyValue("alert", "IOS 骞挎挱娴嬭瘯");
            $brocast->setPredefinedKeyValue("badge", 0);
            $brocast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $brocast->setPredefinedKeyValue("production_mode", "false");
            // Set customized fields
            $brocast->setCustomizedField("test", "helloworld");
            print("Sending broadcast notification, please wait...\r\n");
            $brocast->send();
            print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }

    public function sendIOSUnicast(array $values, array $extra, $device_tokens)
    {
        $_values = [
            'alert' => ''
        ];
        $_values = array_merge($_values, $values);
        try {
            $unicast = new IOSUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue("appkey", $this->appkey);
            $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
            // Set your device tokens here
            $unicast->setPredefinedKeyValue("device_tokens", $device_tokens);
            foreach ($_values as $key => $value) {
                $unicast->setPredefinedKeyValue($key, $value);
            }
            $unicast->setPredefinedKeyValue("badge", 0);
            $unicast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $unicast->setPredefinedKeyValue("production_mode", $this->production_mode);
            // Set customized fields
            foreach ($extra as $key => $value) {
                $unicast->setCustomizedField($key, $value);
            }
            // print("Sending unicast notification, please wait...\r\n");
            return $unicast->send();
            // print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            return "Caught exception: " . $e->getMessage();
        }
    }

    function sendIOSFilecast()
    {
        try {
            $filecast = new IOSFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue("appkey", $this->appkey);
            $filecast->setPredefinedKeyValue("timestamp", $this->timestamp);
            
            $filecast->setPredefinedKeyValue("alert", "IOS 鏂囦欢鎾祴璇�");
            $filecast->setPredefinedKeyValue("badge", 0);
            $filecast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $filecast->setPredefinedKeyValue("production_mode", "false");
            print("Uploading file contents, please wait...\r\n");
            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents("aa" . "\n" . "bb");
            print("Sending filecast notification, please wait...\r\n");
            $filecast->send();
            print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }

    function sendIOSGroupcast()
    {
        try {
            /*
             * Construct the filter condition:
             * "where":
             * {
             * "and":
             * [
             * {"tag":"iostest"}
             * ]
             * }
             */
            $filter = array(
                "where" => array(
                    "and" => array(
                        array(
                            "tag" => "iostest"
                        )
                    )
                )
            );
            
            $groupcast = new IOSGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue("appkey", $this->appkey);
            $groupcast->setPredefinedKeyValue("timestamp", $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue("filter", $filter);
            $groupcast->setPredefinedKeyValue("alert", "IOS 缁勬挱娴嬭瘯");
            $groupcast->setPredefinedKeyValue("badge", 0);
            $groupcast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $groupcast->setPredefinedKeyValue("production_mode", "false");
            print("Sending groupcast notification, please wait...\r\n");
            $groupcast->send();
            print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }

    function sendIOSCustomizedcast()
    {
        try {
            $customizedcast = new IOSCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);
            
            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->setPredefinedKeyValue("alias", "xx");
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type", "xx");
            $customizedcast->setPredefinedKeyValue("alert", "IOS 涓�у寲娴嬭瘯");
            $customizedcast->setPredefinedKeyValue("badge", 0);
            $customizedcast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $customizedcast->setPredefinedKeyValue("production_mode", "false");
            print("Sending customizedcast notification, please wait...\r\n");
            $customizedcast->send();
            print("Sent SUCCESS\r\n");
        } catch (\Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }
}

// Set your appkey and master secret here
// $demo = new UmengPush("your appkey", "your app master secret");
// $demo->sendAndroidUnicast();
/* these methods are all available, just fill in some fields and do the test
 * $demo->sendAndroidBroadcast();
 * $demo->sendAndroidFilecast();
 * $demo->sendAndroidGroupcast();
 * $demo->sendAndroidCustomizedcast();
 * $demo->sendAndroidCustomizedcastFileId();
 *
 * $demo->sendIOSBroadcast();
 * $demo->sendIOSUnicast();
 * $demo->sendIOSFilecast();
 * $demo->sendIOSGroupcast();
 * $demo->sendIOSCustomizedcast();
 */