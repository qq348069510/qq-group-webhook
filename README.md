# QQ群WebHook机器人助手 v1.1.0

#### 介绍
QQ群WebHook机器人助手

#### 使用说明

1.  引入WebHook.php文件，并引用类 `use QQGroup\WebHook;`
2.  实例化助手对象并设置Key `$qqGroupWebHook = new WebHook("Key");`
3.  如果需要重新设置Key可使用 `$qqGroupWebHook->setKey("Key");`
4.  推送消息 `$qqGroupWebHook->send("消息");` 返回true为推送成功，false则是推送失败
5.  获取错误信息 `$qqGroupWebHook->getErrorMessage();` 用于获取上一次失败后的错误信息
6.  可设置是否启用消息处理程序 `$qqGroupWebHook->setMessageHandler(true);` 启用后非字符串类型将转换成合法可执行的PHP代码，有助于开发者测试读取数据 true为启用，false则不启用 默认为true开启
7.  批量推送消息  
    调用方法 `$batSend = $qqGroupWebHook->batSend($keys,"默认消息内容");` $keys为key的数组列表`$keys = array("key1","key2","key3")` 支持每个key推送不同的消息 `$keys = array("key1",array("key2","key2的消息内容"),array("key3","key3的消息内容"))` 无指定内容为默认消息  
    获取返回数据 $batSend返回内容为二维数组 `array ( 0 => array ( 0 => 'key1', 1 => true ), 1 => array ( 0 => 'key2', 1 => false, 2 => '错误信息' ),......)` 下标0为当前的key 下标1为是否成功 下标2为失败时的错误信息

#### Composer
##### 安装
    composer require qq348069510/qq-group-webhook -vvv

##### 更新
    composer update qq348069510/qq-group-webhook -vvv

##### 删除
    composer remove qq348069510/qq-group-webhook -vvv

#### 注意事项
为了避免被滥用，tests/WebHook.php文件请在测试后删除

#### 版本日志

##### v1.1.0
      修复一处错误
      增加批量推送功能，操作更方便
##### v1.0.0
      QQ群WebHook机器人的消息推送功能
      支持消息处理程序,让WebHook可玩性更高

#### 参与开发

1. IT老酸奶(qq348069510)