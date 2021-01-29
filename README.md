基于Upush的服务端官方示例文件修改
-
- 增加命名空间
- 推送到packagist

安装：
```bash
composer require sn01615/umeng-php
```

customizedcast，通过alias进行推送, 对单个或者多个alias进行推送

2020年4月14日：测试有效

2020年5月11日：iOS Customizedcast支持
```php
# Android
$cc = (new UmengPush('$key', '$secret'))
    // ->updateTimestamp() // 更新签名使用的时间
    // ->setProductionMode(false)
    //    ->setGetUrlAndBody(true) // 直接返回url和body
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

# iOS
$cc = (new UmengPush('***', '***'))
    // ->updateTimestamp() // 更新签名使用的时间
    // ->setProductionMode(false)
    //    ->setGetUrlAndBody(true) // 直接返回url和body
    ->sendIOSCustomizedcast([
        // 'alert' => '', // 可为JSON类型和字符串类型
        'alert' => [
            'title' => '1',
            'subtitle' => '2',
            'body' => '3',
        ],
    ], [
        'aaa' => 1111, // 可选，用户自定义内容, "d","p"为友盟保留字段，
                       // key不可以是"d","p"
    ], $alias = '12345', // 开发者填写自己的alias, 要求不超过500个alias, 多个alias以英文逗号间隔
    $aliasType = 'XXX');

var_dump($cc);
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
