# QQ群WebHook机器人助手 v1.0.0

#### 介绍
QQ群WebHook机器人助手

#### 使用说明

1.  引入WebHook.php文件，并引用类 `use QQGroup\WebHook;`
2.  实例化助手对象并设置Key `$qqGroupWebHook = new WebHook("Key");`
3.  如果需要重新设置Key可使用 `$qqGroupWebHook->setKey("Key");`
4.  推送消息 `$qqGroupWebHook->send("消息");` 返回true为推送成功，false则是推送失败
5.  获取错误信息 `$qqGroupWebHook->getErrorMessage();` 用于获取上一次失败后的错误信息
6.  可设置是否启用消息处理程序 `$qqGroupWebHook->setMessageHandler(true);` 启用后非字符串类型将转换成合法可执行的PHP代码，有助于开发者测试读取数据 true为启用，false则不启用 默认为true开启
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
##### v1.0.0
      QQ群WebHook机器人的消息推送功能
      支持消息处理程序,让WebHook可玩性更高

#### 参与开发

1. IT老酸奶(qq348069510)