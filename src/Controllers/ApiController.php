<?php
/**
 * 接口相关操作类 - （kong在0.14.x之前版本适用）
 * @package Jamespi\Kong\Controllers
 * @author ZT PHP DEV TEAM PIJIANZHONG(jianzhongpi@163.com)
 * @create 2020年1月30日 下午1:50
 */

namespace Jamespi\Kong\Controllers;

use Jamespi\Kong\Common\HttpHelper;
use Jamespi\Kong\Common\CheckHelper;
class ApiController{

    protected $baseUri;

    /**
     * IndexController constructor.
     * @param string $baseUri
     */
    public function __construct(string $baseUri)
    {
        $port = '8001';
        $this->baseUri = $baseUri;
        $check = new CheckHelper();
        $uriArr = explode(":", $baseUri);
        $uri = (reset($uriArr)=='http' || reset($uriArr)=='https') ? $uriArr[1] : $uriArr[0];

        if (is_numeric(end($uriArr))) {
            $port = end($uriArr);
        }

        //检测ip端口是否正常
        if(!$check->ping($uri, $port)){
            return 'this ip port address failed to connect.';
        }
    }

    /**
     * 注册接口
     * @param array $body 新增实体数据
     * @return string
     */
    public function addApi(array $body):string
    {
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr='/apis');
    }

    /**
     * 获取特定接口信息
     * @param string $apiName 接口名称/ID
     * @return string
     */
    public function getApi(string $apiName):string
    {
        if ($apiName){
            //服务相关路由
            $apiStr = "/apis/".trim($apiName, "/");
        }else{
            $apiStr = "/apis";
        }

        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 更新指定接口
     * @param array $body 更新实体数据
     * @param string $apiName 接口名称/ID
     * @return string
     */
    public function editApi(array $body, string $apiName):string
    {
        $http = new HttpHelper();
        return $http->path($this->baseUri, $body, "/apis/".trim($apiName,"/"));
    }

    /**
     * 新增/更新指定服务
     * @param array $body 新增/更新实体数据
     * @param string $apiName 接口名称/ID
     * @return string
     */
    public function addEditApi(array $body, string $apiName)
    {
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, "/apis/".trim($apiName,"/"));
    }

    /**
     * 删除指定服务
     * @param string $apiName 接口名称/ID
     * @return string
     */
    public function deleteApi(string $apiName):string
    {
        $http = new HttpHelper();
        return $http->delete($this->baseUri, "/apis/".trim($apiName,"/"));
    }

}