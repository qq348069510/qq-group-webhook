<?php

// +----------------------------------------------------------------------
// | QQ群WebHook机器人助手 [ QQGroupWebHook ] v1.1.0
// +----------------------------------------------------------------------
// | 版权所有 2020 IT老酸奶 https://github.com/qq348069510/qq-group-webhook
// +----------------------------------------------------------------------
// | 开源协议 Apache2.0 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------


namespace QQGroup;

class WebHook
{

    private $key;
    private $errorMessage;
    private $MessageHandler = true;

    const SEND = 1;

    /**
     * WebHook constructor.
     * @param $key
     */
    public function __construct($key = "")
    {
        $this->key = $key;
    }

    /**
     * 推送消息
     * @param $msg int|string|array|object 消息内容
     * @return bool
     */
    public function send($msg)
    {
        if (empty($this->key)) die("Key不能为空");
        $url = $this->apiUrl(self::SEND) . "?key=" . $this->key;
        $data = json_encode(array(
            "content" => array(
                array(
                    "type" => 0,
                    "data" => $this->MessageHandler($msg)
                )
            )
        ));
        $headers = array(
            "Content-Type" => "application/json"
        );
        $response = $this->httpCurlPost($url, $data, $headers);
        if ($response != "") {
            $jsonResponse = json_decode($response, true);
            if (empty($jsonResponse)) {
                $this->errorMessage = $response;
            } else {
                $this->errorMessage = $this->errorNoToMessage($jsonResponse['ec']);
            }
            return false;
        }
        return true;
    }

    /**
     * 批量推送消息
     * @param $keys array 批量操作的key，非空数组
     * @param null|int|string|array|object $msg 默认消息内容
     * @return array
     */
    public function batSend($keys, $msg = null)
    {
        if (!is_array($keys) || empty($keys)) die("请使用非空数组");
        $results = array_fill(0, count($keys), []);
        foreach ($keys as $num => $key) {
            $result = [];
            if (is_array($key)) {
                $this->key = $key[0];
                $result[0] = $key[0];
                if (!isset($key[1]) || empty($key[1])) {
                    $send = $this->send($msg);
                } else {
                    $send = $this->send($key[1]);
                }
            } else {
                $this->key = $key;
                $result[0] = $key;
                $send = $this->send($msg);
            }
            $result[1] = true;
            if (!$send) {
                $result[1] = false;
                $result[2] = $this->getErrorMessage();
            }
            $results[$num] = $result;
        }
        return $results;
    }

    /**
     * 获取最近一次发生错误的错误消息
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * 重新设置Key
     * @param mixed $key string Key
     */
    public function setKey($key)
    {
        if (empty($key)) die("Key不能为空");
        $this->key = $key;
    }

    /**
     * 设置是否启用消息处理程序
     * @param bool $MessageHandler true为启用消息处理程序
     */
    public function setMessageHandler($MessageHandler = true)
    {
        $this->MessageHandler = $MessageHandler;
    }

    /**
     * 消息处理程序
     * @param $message
     * @return mixed
     */
    private function MessageHandler($message)
    {
        if ($this->MessageHandler) {
            if (!is_string($message)) {
                $message = var_export($message, true);
            }
        }
        return $message;
    }

    /**
     *  设置接口
     * @param $type int 接口类型
     * @return string
     */
    private function apiUrl($type)
    {
        switch ($type) {
            case self::SEND :
                return "https://app.qun.qq.com/cgi-bin/api/hookrobot_send";
            default :
                die("接口错误");
        }
    }

    /**
     * 错误代码对应的错误信息列表
     * @return array
     */
    private function errorNo()
    {
        return [
            "1003" => "Key错误，请检查！",
            "1005" => "此机器人未开启消息推送！",
            "5003" => "参数或数据格式不正确！"
        ];
    }

    /**
     * 将错误代码转换成文本消息
     * @param $errorNo
     * @return mixed|string
     */
    private function errorNoToMessage($errorNo)
    {
        if (isset($this->errorNo()[$errorNo])) {
            return $this->errorNo()[$errorNo];
        } else {
            return "未知错误！";
        }
    }

    /**
     * Http Post请求
     * @param $url
     * @param null $post
     * @param null $header
     * @return bool|string
     */
    private function httpCurlPost($url, $post = null, $header = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            if (is_array($post)) {
                $post = http_build_query($post);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if (!empty($header) || is_array($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        if (!$response) {
            $response = curl_error($ch);
        }
        curl_close($ch);
        return $response;
    }
}