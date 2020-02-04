<?php
/**
 * 消费者相关操作类
 * @package Jamespi\Kong\Controllers
 * @author ZT PHP DEV TEAM PIJIANZHONG(jianzhongpi@163.com)
 * @create 2020年1月30日 上午11:20
 */

namespace Jamespi\Kong\Controllers;

use Jamespi\Kong\Common\HttpHelper;
use Jamespi\Kong\Common\CheckHelper;
class ConsumersController{

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
     * 添加路由
     * @param array $body 新增实体数据
     * @param string $serviceName 服务名称/ID
     * @return string
     */
    public function addRoute(array $body, string $serviceName):string
    {
        if ($serviceName) {
            $apiStr = '/services/'.$serviceName;
        }else{
            $apiStr = '/routes';
        }
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr);
    }

    /**
     * 查询所有路由信息
     * @return string
     */
    public function getRoutes():string
    {
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr='/routes');
    }

    /**
     * 获取特定路由信息
     * @param string $serviceName 服务名称/ID
     * @param string $routeName 路由名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function getRoute(string $serviceName, string $routeName, string $pluginName):string
    {
        $apiStr = '';
        if ($pluginName){
            //插件关联路由
            $apiStr = "/plugins/".trim($serviceName, "/")."/route";
        }else{
            if ($routeName){
                if ($serviceName){
                    //服务相关路由
                    $apiStr .= "/services/".trim($serviceName, "/");
                }
                //路由特定路由
                $apiStr .= "/routes/".$routeName;
            }else{
                $apiStr .= "/routes";
            }
        }

        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 更新路由
     * @param array $body 更新实体数据
     * @param string $serviceName 服务名称/ID
     * @param string $routeName 路由名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function editRoute(array $body, string $serviceName, string $routeName, string $pluginName):string
    {
        $apiStr = '';
        if ($pluginName){
            //插件关联路由
            $apiStr = "/plugins/".trim($serviceName, "/")."/route";
        }else{
            if ($routeName){
                if ($serviceName){
                    //服务相关路由
                    $apiStr .= "/services/".trim($serviceName, "/");
                }
                //路由特定路由
                $apiStr .= "/routes/".$routeName;
            }
        }
        $http = new HttpHelper();
        return $http->path($this->baseUri, $body, $apiStr);
    }

    /**
     * 新增/更新指定服务
     * @param array $body 新增/更新实体数据
     * @param string $serviceName 服务名称/ID
     * @param string $routeName 路由名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function addEditRoute(array $body, string $serviceName, string $routeName, string $pluginName):string
    {
        $apiStr = '';
        if ($pluginName){
            //插件关联路由
            $apiStr = "/plugins/".trim($serviceName, "/")."/route";
        }else{
            if ($routeName){
                if ($serviceName){
                    //服务相关路由
                    $apiStr .= "/services/".trim($serviceName, "/");
                }
                //路由特定路由
                $apiStr .= "/routes/".$routeName;
            }
        }
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, $apiStr);
    }

    /**
     * 删除指定服务
     * @param string $serviceName 服务名称/ID
     * @param string $routeName 路由名称/ID
     * @return string
     */
    public function deleteRoute(string $serviceName, string $routeName):string
    {
        $apiStr = '';
        if (empty($serviceName) || empty($routeName)){
            if ($serviceName){
                //服务相关路由
                $apiStr .= "/services/".trim($serviceName, "/");
            }
            //路由特定路由
            $apiStr .= "/routes/".$routeName;
        }else{
            return 'Please select operating conditions';
        }
        $http = new HttpHelper();
        return $http->delete($this->baseUri, $apiStr);
    }

}