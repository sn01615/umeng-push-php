基于Upush的服务端官方示例文件修改
-
- 增加命名空间
- 推送到packagist

安装：
```bash
composer require sn01615/umeng-php
```

customizedcast，通过alias进行推送, 对单个或者多个alias进行推送
```php
$cc = (new UmengPush('***', '***'))
    ->setProductionMode(false)
    ->sendAndroidCustomizedcast([
            'ticker' => '1', // 必填 通知栏提示文字
            'title' => '2', // 必填 通知标题
            'text' => '3', // 必填 通知文字描述
//            'mipush' => true, // 离线推送
//            'mi_activity' => 'xxx.XXXActivity',
        ], [
            'aaa' => 1111, // 可选，用户自定义key-value。只对"通知"
        ], 
        $alias = '12345', // 开发者填写自己的alias, 要求不超过500个alias, 多个alias以英文逗号间隔
        $aliasType = 'XXX');
```


单播(个人不推荐使用，因为token会变，推荐客户端给用户设置alias，使用alias+aliasType进行推送)

```php
use Umeng\UmengPush;

$key = "****";
$secret = "*****";
$push = new UmengPush($key, $secret);
$values = [
    'ticker' => '1', // require 通知栏提示文字
    'title' => '2', // require 通知标题
    'text' => '3', // require 通知文字描述
    'after_open' => 'go_app' // require 值可以为:
    // "go_app": open app
    // "go_url": 跳转到URL
    // "go_activity": open activity
    // "go_custom": 用户自定义内容。
];
echo $push->sendAndroidUnicast($values, [], 'device token');
# result: {"ret":"SUCCESS","data":{"msg_id":"uu77312149835056871500"}}
```
广播
```php
$key = "****";
$secret = "*****";
$push = new UmengPush($key, $secret);
$values = [
    'ticker' => '1', // 必填 通知栏提示文字
    'title' => '2', // 必填 通知标题
    'text' => '3', // 必填 通知文字描述
    'after_open' => 'go_app' // 必填 值可以为:
    // "go_app": 打开应用
    // "go_url": 跳转到URL
    // "go_activity": 打开特定的activity
    // "go_custom": 用户自定义内容。
];
echo $push->sendAndroidBroadcast($values, []);
# result: {"ret":"SUCCESS","data":{"task_id":"us41183149835484509400"}}
```

##### README
```
1.What's this?
This is a demo code for php developers who choose Umeng to push notifications to their apps. For more infomation about Umeng, please refer to http://www.umeng.com/.

2.What can I do with this demo?
There's a 'src' sub-directory in which you can find a Demo.php. Yep, just fill in some fields in it and use php to run it. This code may be not the best, but it can work and help you develop fast at the beginning. Feel free to change the code, and we'll be much appreciated if you have any suggestion about the code.

3.What do I need to run the demo?
We write the code following the standard of PHP 5.0+, so PHP version under 5.0 should not be preferred. 

4.No step 4, just run it. 

Notes:
We build this project on Mac with Sublime Text 2, so sometimes it doesn't look beautiful when switching to other platforms such as Ubuntu. But it doesn't hurt much except the beauty. Forgive us for this, and we are sure to do better.
```
