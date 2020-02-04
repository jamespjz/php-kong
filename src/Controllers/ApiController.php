<?php
/**
 * 接口相关操作类
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
     * 查询所有服务信息
     * @return string
     */
    public function getServices():string
    {
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr='/services');
    }

    /**
     * 获取特定服务信息
     * @param string $serviceName 请求路径
     * @return string
     */
    public function getService(string $serviceName):string
    {
        $http = new HttpHelper();
        return $http->get($this->baseUri, "/services/".trim($serviceName, "/"));
    }

    /**
     * 更新指定服务
     * @param array $body 更新实体数据
     * @param string $serviceName 请求路径
     * @return string
     */
    public function editService(array $body, string $serviceName):string
    {
        $http = new HttpHelper();
        return $http->path($this->baseUri, $body, "/services/".trim($serviceName,"/"));
    }

    /**
     * 新增/更新指定服务
     * @param array $body
     * @param string $serviceName
     * @return string
     */
    public function addEditService(array $body, string $serviceName)
    {
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, "/services/".trim($serviceName,"/"));
    }

    /**
     * 删除指定服务
     * @param string $serviceName
     * @return string
     */
    public function deleteService(string $serviceName):string
    {
        $http = new HttpHelper();
        return $http->delete($this->baseUri, "/services/".trim($serviceName,"/"));
    }

}