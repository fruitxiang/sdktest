<?php
namespace BaiduSmartapp\OpenapiClient;
use BaiduSmartapp\OpenapiClient\HttpClient;



class GetUnionidRequest {
    public $accessToken; // string
    public $openid; // string

    function __construct() {
        $this->accessToken = "";
        $this->openid = "";
    }
}

/**
 *  array do ($params)
 */
class GetUnionid{
    private $data;
    private $errMsg;

    /**
     * @return bool true 请求成功, 调用 getData 获取返回值；false 请求失败 调用 getErrMsg 获取错误详情；
     */
    public function do(GetUnionidRequest $params){
        $client = new HttpClient();
        $client->setMethod("POST");
        $client->setHost("openapi.baidu.com");
        $client->setPath("/rest/2.0/smartapp/getunionid");
        $client->setContentType("application/x-www-form-urlencoded");
        $client->addGetParam("access_token", $params->accessToken);
        $client->addPostParam("openid",  $params->openid);

        $res = $client->execute();
        if ($res['status_code'] < 200 || $res['status_code'] >=300) {
            $this->errMsg = sprintf("error response body [%s]", json_encode($res));
            return false;
        }
        if ($res['body'] != false){
            $resBody = json_decode($res['body'], true);
            if (isset($resBody['errno']) && $resBody['errno'] === 0) {
                $this->data = $resBody['data'];
                $this->errMsg = sprintf("error response [%s]", $res['body']);
                return true;
            }
            $this->errMsg = sprintf("error response [%s]", $res['body']);
            return false;
        }
        $this->errMsg = sprintf("error response body [%s]", json_encode($res));
        return false;
    }

    public function getErrMsg(){
        return $this->errMsg;
    }

    public function getData(){
        return $this->data;
    }
}