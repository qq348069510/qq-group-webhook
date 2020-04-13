<?php

// +----------------------------------------------------------------------
// | QQ群WebHook机器人助手 [ QQGroupWebHook ] v1.0.0
// +----------------------------------------------------------------------
// | 版权所有 2020 IT老酸奶 https://github.com/qq348069510/qq-group-webhook
// +----------------------------------------------------------------------
// | 开源协议 Apache2.0 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

require_once "../src/WebHook.php";

use QQGroup\WebHook;

$qqGroupWebHook = new WebHook("key");
$text = "测试消息\n" . date("Y-m-d H:i:s");
if ($qqGroupWebHook->send($text)) {
    echo "普通消息推送成功";
} else {
    echo "普通消息推送失败," . $qqGroupWebHook->getErrorMessage();
}
echo "</br>";
$array = array(
    "code" => 1,
    "msg" => "OK",
    "data" => array(
        "text" => "文本",
        "date" => date("Y-m-d H:i:s")
    ),
);
if ($qqGroupWebHook->send($array)) {
    echo "数组消息推送成功";
} else {
    echo "数组消息推送失败," . $qqGroupWebHook->getErrorMessage();
}
echo "</br>";
if ($qqGroupWebHook->send($qqGroupWebHook)) {
    echo "对象消息推送成功";
} else {
    echo "对象消息推送失败," . $qqGroupWebHook->getErrorMessage();
}