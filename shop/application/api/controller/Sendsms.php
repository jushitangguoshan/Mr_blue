<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/22 0022
 * Time: 16:34
 */

namespace app\api\controller;

use think\Controller;

class Sendsms extends Controller
{
    private $needParams = [
        "number",
        "code"
    ];
    /**
     * 链接外部
     * 用于发送的API接口
     */
    public function send(){
        var_dump($_POST);
        $this->dealPost();
        $params = array ();
        // *** 需用户填写部分 ***
        // 1fixme 必填：是否启用https
        $security = false;
        // 1fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "";
        $accessKeySecret = "";
        // 1fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $_POST["number"];
        // 1fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "";
        // 1fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "";
        // 1fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => $_POST["code"]
        );
        // 1fixme 可选: 设置发送短信流水号
        $params['OutId'] = "12345";
        //1fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $params['SmsUpExtendCode'] = "1234567";
        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        // 此处可能会抛出异常，注意catch
        $content = $this->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            )),
            $security
        );
        ini_set("display_errors", "on"); // 显示错误提示，仅用于测试时排查问题
        // error_reporting(E_ALL); // 显示所有错误提示，仅用于测试时排查问题
        set_time_limit(0); // 防止脚本超时，仅用于测试使用，生产环境请按实际情况设置
        header("Content-Type: text/plain; charset=utf-8"); // 输出为utf-8的文本格式，仅用于测试
        // 验证发送短信(SendSms)接口
        echo json_encode($content);
    }

    /**
     * 处理POST参数
     */
    private function dealPost(){
        foreach ($this->needParams as $value) {
            if (!array_key_exists($value,$_POST)) {
                echo json_encode(["reason"=>"failed","errCode"=>404,"warning"=>"插入必需参数{$value}不存在，请检查"]);
                die;
            }
        }
    }

    /**
     * 发送短信相关  URL请求处理
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $domain
     * @param $params
     * @param bool $security
     * @param string $method
     * @return bool|mixed
     */
    private function request($accessKeyId, $accessKeySecret, $domain, $params, $security=false, $method='POST') {
        $apiParams = array_merge(array (
            "SignatureMethod" => "HMAC-SHA1",
            "SignatureNonce" => uniqid(mt_rand(0,0xffff), true),
            "SignatureVersion" => "1.0",
            "AccessKeyId" => $accessKeyId,
            "Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
            "Format" => "JSON",
        ), $params);
        ksort($apiParams);

        $sortedQueryStringTmp = "";
        foreach ($apiParams as $key => $value) {
            $sortedQueryStringTmp .= "&" . $this->encode($key) . "=" . $this->encode($value);
        }

        $stringToSign = "${method}&%2F&" . $this->encode(substr($sortedQueryStringTmp, 1));

        $sign = base64_encode(hash_hmac("sha1", $stringToSign, $accessKeySecret . "&",true));

        $signature = $this->encode($sign);

        $url = ($security ? 'https' : 'http')."://{$domain}/";

        try {
            $content = $this->fetchContent($url, $method, "Signature={$signature}{$sortedQueryStringTmp}");
            return json_decode($content);
        } catch( \Exception $e) {
            return false;
        }
    }

    /**
     * 发送短信相关接口 处理内容数据
     * @param $str
     * @return mixed|string
     */
    private function encode($str){
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

    /**
     * 发送短信相关接口 获取内容数据
     * @param $url
     * @param $method
     * @param $body
     * @return mixed
     */
    private function fetchContent($url, $method, $body) {
        $ch = curl_init();

        if($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        } else {
            $url .= '?'.$body;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "x-sdk-client" => "php/2.0.0"
        ));

        if(substr($url, 0,5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $rtn = curl_exec($ch);

        if($rtn === false) {
            // 大多由设置等原因引起，一般无法保障后续逻辑正常执行，
            // 所以这里触发的是E_USER_ERROR，会终止脚本执行，无法被try...catch捕获，需要用户排查环境、网络等故障
            trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
        }
        curl_close($ch);

        return $rtn;
    }

}