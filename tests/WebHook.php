<?php

// +----------------------------------------------------------------------
// | QQ群WebHook机器人助手 [ QQGroupWebHook ] v1.1.0
// +----------------------------------------------------------------------
// | 版权所有 2020 IT老酸奶 https://github.com/qq348069510/qq-group-webhook
// +----------------------------------------------------------------------
// | 开源协议 Apache2.0 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

require_once "../src/WebHook.php";

use QQGroup\WebHook;

$qqGroupWebHook = new WebHook("key");
$text = "测试消息\n" . date("Y-m-d H:i:s");

echo "单次推送消息</br>";
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
echo "<hr>批量推送消息</br>";
$text = "批量推送测试消息\n" . date("Y-m-d H:i:s");
$sends = array(
    "9b2efdef59daf69504f46a1e9f0338ea8119912c",
    "5f2ba8fdf99c0e137d43708e3f3a8c5689d9192e",
    array(
        "7605336e401314f0dcb98eb5b8d9afb21fb2577b",
        "这里是批量推送的单独消息\n" . date("Y-m-d H:i:s")
    )
);
$batSend = $qqGroupWebHook->batSend($sends, $text);
foreach ($batSend as $item) {
    echo "key：" . $item[0] . "，";
    if ($item[1]) {
        echo "消息推送成功";
    } else {
        echo "消息推送失败，" . $item[2];
    }
    echo "</br>";
}