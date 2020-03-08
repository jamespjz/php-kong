<?php
/**
 * 插件相关操作类
 */

namespace Jamespi\Kong\Controllers;

use Jamespi\Kong\Common\HttpHelper;
use Jamespi\Kong\Common\CheckHelper;
class PluginController{

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
     * 注册全局插件
     * @param array $body 新增实体数据
     * @return string
     */
    public function addPlugin(array $body):string{
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr='/plugins');
    }

    /**
     * 注册与特定路由关联的插件
     * @param array $body 新增实体数据
     * @param string $routeName 路由名称/ID
     * @return string
     */
    public function addRoutePlugin(array $body, string $routeName):string {
        $apiStr = '';
        if ($routeName) {
            $apiStr .= '/routes/'.$routeName;
        }
        $apiStr .= '/plugins';
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr);
    }

    /**
     * 注册与特定服务关联的插件
     * @param array $body 新增实体数据
     * @param string $serviceName 服务名称/ID
     * @return string
     */
    public function addServicePlugin(array $body, string $serviceName):string {
        $apiStr = '';
        if ($serviceName) {
            $apiStr .= '/services/'.$serviceName;
        }
        $apiStr .= '/plugins';
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr);
    }

    /**
     * 注册与特定消费者关联的插件
     * @param array $body 新增实体数据
     * @param string $consumerName 消费者名称/ID
     * @return string
     */
    public function addConsumerPlugin(array $body, string $consumerName):string {
        $apiStr = '';
        if ($consumerName) {
            $apiStr .= '/consumers/'.$consumerName;
        }
        $apiStr .= '/plugins';
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr);
    }

    /**
     * 查询所有/特定插件信息
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function getPlugins(string $pluginName = ''):string{
        $apiStr = '';
        if ($pluginName)    $apiStr .= '/plugins/'.$pluginName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 获取特定路由相关所有/特定插件信息
     * @param string $routeName 路由名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function getRoutePlugins(string $routeName, string $pluginName = ''):string {
        $apiStr = "/routes/".trim($routeName, "/")."/plugins";
        if ($pluginName)    $apiStr .= '/'.$pluginName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 获取特定服务相关所有/特定插件信息
     * @param string $serviceName 服务名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function getServicePlugins(string $serviceName, string $pluginName = ''):string{
        $apiStr = "/services/".trim($serviceName, "/")."/plugins";
        if ($pluginName)    $apiStr .= '/'.$pluginName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 获取特定消费者所有/特定相关插件信息
     * @param string $consumerName 消费者名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function getConsumerPlugins(string $consumerName, string $pluginName = ''):string {
        $apiStr = "/consumers/".trim($consumerName, "/")."/plugins";
        if ($pluginName)    $apiStr .= '/'.$pluginName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 创建更新全局插件
     * @param array $body 更新实体数据
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function editPlugin(array $body, string $pluginName):string{
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, "/plugins/".trim($pluginName,"/"));
    }

    /**
     * 创建更新与特定路由相关的插件
     * @param array $body 更新实体数据
     * @param string $routeName 路由名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function editRoutePlugin(array $body, string $routeName, string $pluginName):string {
        $apiStr = "/routes/".trim($routeName,"/")."/plugins/".$pluginName;
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, $apiStr);
    }

    /**
     * 创建更新与特定服务相关的插件
     * @param array $body 更新实体数据
     * @param string $serviceName 路由名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function editServicePlugin(array $body, string $serviceName, string $pluginName):string {
        $apiStr = "/services/".trim($serviceName,"/")."/plugins/".$pluginName;
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, $apiStr);
    }

    /**
     * 创建更新与特定消费者相关的插件
     * @param array $body 更新实体数据
     * @param string $consumerName 消费者名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function editConsumerPlugin(array $body, string $consumerName, string $pluginName):string {
        $apiStr = "/consumers/".trim($consumerName,"/")."/plugins/".$pluginName;
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, $apiStr);
    }

    /**
     * 删除全局的特定插件
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function deletePlugin(string $pluginName):string {
        $http = new HttpHelper();
        return $http->delete($this->baseUri, "/plugins/".trim($pluginName,"/"));
    }

    /**
     * 删除与路由相关的特定插件
     * @param string $routeName 路由名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function deleteRoutePlugin(string $routeName, string $pluginName):string {
        $apiStr = "/routes/".trim($routeName,"/")."/plugins/".$pluginName;
        $http = new HttpHelper();
        return $http->delete($this->baseUri, $apiStr);
    }

    /**
     * 删除与服务相关的特定插件
     * @param string $serviceName 服务名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function deleteServicePlugin(string $serviceName, string $pluginName):string {
        $apiStr = "/services/".trim($serviceName,"/")."/plugins/".$pluginName;
        $http = new HttpHelper();
        return $http->delete($this->baseUri, $apiStr);
    }

    /**
     * 删除与消费者相关的特定插件
     * @param string $consumerName 消费者名称/ID
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function deleteConsumerPlugin(string $consumerName, string $pluginName):string {
        $apiStr = "/consumers/".trim($consumerName,"/")."/plugins/".$pluginName;
        $http = new HttpHelper();
        return $http->delete($this->baseUri, $apiStr);
    }

    /**
     * 检索已启用的插件
     * @return string
     */
    public function enabledPlugins():string {
        $apiStr = '/plugins/enabled';
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 检索插件架构
     * @param string $pluginName 插件名称/ID
     * @return string
     */
    public function schemaPlugin(string $pluginName):string {
        $apiStr = '/plugins/schema/'.$pluginName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 获取所有或特定证书信息
     * @param string $certificatesName 证书名称/ID
     * @return string
     */
    public function getCertificates(string $certificatesName):string {
        $apiStr = '/certificates';
        if ($certificatesName)    $apiStr .= '/'.$certificatesName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 创建证书
     * @param array $body 更新实体数据
     * @return string
     */
    public function addCertificates(array $body):string {
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr='/certificates');
    }

    /**
     * 创建更改证书
     * @param array $body 更新实体数据
     * @param string $certificatesName 证书名称/ID
     * @return string
     */
    public function editCertificates(array $body, string $certificatesName):string {
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, "/certificates/".trim($certificatesName,"/"));
    }

    /**
     * 删除证书
     * @param string $certificatesName 证书名称/ID
     * @return string
     */
    public function deleteCertificates(string $certificatesName):string {
        $http = new HttpHelper();
        return $http->delete($this->baseUri, "/certificates/".trim($certificatesName,"/"));
    }

    /**
     * 创建CA证书
     * @param array $body 更新实体数据
     * @return string
     */
    public function addCaCertificates(array $body):string {
        $apiStr = "/ca_certificates";
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr);
    }

    /**
     * 获取所有或特定CA证书信息
     * @param string $certificatesName 证书名称/ID
     * @return string
     */
    public function getCaCertificates(string $certificatesName):string {
        $apiStr = '/ca_certificates';
        if ($certificatesName)    $apiStr .= '/'.$certificatesName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 创建更改CA证书
     * @param array $body 更新实体数据
     * @param string $certificatesName 证书名称/ID
     * @return string
     */
    public function editCaCertificates(array $body, string $certificatesName):string {
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, "/ca_certificates/".trim($certificatesName,"/"));
    }

    /**
     * 删除CA证书
     * @param string $certificatesName 证书名称/ID
     * @return string
     */
    public function deleteCaCertificates(string $certificatesName):string {
        $http = new HttpHelper();
        return $http->delete($this->baseUri, "/ca_certificates/".trim($certificatesName,"/"));
    }

    /**
     * 创建SNI
     * @param array $body 更新实体数据
     * @return string
     */
    public function addSNI(array $body):string {
        $apiStr = "/snis";
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr);
    }

    /**
     * 创建与特定证书关联的SNI
     * @param array $body 更新实体数据
     * @param string $certificatesName 证书名称/ID
     * @return string
     */
    public function addCertificatesSNI(array $body, string $certificatesName):string {
        $apiStr = '';
        if ($certificatesName) {
            $apiStr .= '/certificates/'.$certificatesName;
        }
        $apiStr .= '/snis';
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr);
    }

    /**
     * 获取所有或特定SNI信息
     * @param string $sniName SNI名称/ID
     * @return string
     */
    public function getSNI(string $sniName = ''):string {
        $apiStr = '/snis';
        if ($sniName)  $apiStr .= '/'.$sniName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 获取特定证书相关的所有或特定SNI信息
     * @param string $certificatesName 证书名称/ID
     * @param string $sniName SNI名称/ID
     * @return string
     */
    public function getCertificatesSNI(string $certificatesName, string $sniName = ''):string {
        $apiStr = '';
        if ($certificatesName)  $apiStr .= '/certificates/'.$certificatesName;
        $apiStr .= '/snis';
        if ($sniName)  $apiStr .= '/snis/'.$sniName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 创建更新SNI
     * @param array $body 更新实体数据
     * @param string $sniName SNI名称/ID
     * @return string
     */
    public function editSNI(array $body, string $sniName):string {
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, "/snis/".trim($sniName,"/"));
    }

    /**
     * 创建更新特定证书相关的SNI
     * @param array $body 更新实体数据
     * @param string $certificatesName 证书名称/ID
     * @param string $sniName SNI名称/ID
     * @return string
     */
    public function editCertificatesSNI(array $body, string $certificatesName, string $sniName):string {
        $apiStr = "/certificates/".trim($certificatesName,"/")."/snis/".$sniName;
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, $apiStr);
    }

    /**
     * 删除SNI或特定证书关联的SNI
     * @param string $sniName SNI名称/ID
     * @param string $certificatesName 证书名称/ID
     * @return string
     */
    public function deleteCertificatesSNI(string $sniName, string $certificatesName = ''):string {
        $apiStr = '';
        if ($certificatesName)  $apiStr .= "/certificates/".trim($certificatesName,"/");
        $apiStr .= "/snis/".$sniName;
        $http = new HttpHelper();
        return $http->delete($this->baseUri, $apiStr);
    }

    /**
     * 创建上游服务
     * @param array $body 更新实体数据
     * @return string
     */
    public function addUpstreamsService(array $body):string {
        $apiStr = "/upstreams";
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr);
    }

    /**
     * 获取所有或特定上游服务信息
     * @param string $upstreamsName 上游服务名称/ID
     * @return string
     */
    public function getUpstreams(string $upstreamsName = ''):string {
        $apiStr = '/upstreams';
        if ($upstreamsName) $apiStr .= "/".$upstreamsName;
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 获取特定目标相关的上游
     * @param string $targetsName 目标对象名称/ID
     * @return string
     */
    public function getTargetsUpstreams(string $targetsName):string {
        $apiStr = '/targets/'.$targetsName."/upstreams";
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 创建或更新上游或目标对象相关上游
     * @param array $body 更新实体数据
     * @param string $upstreamsName 上游服务名称/ID
     * @param string $targetsName 目标对象名称/ID
     * @return string
     */
    public function editTargetsUpstream(array $body, string $upstreamsName, string $targetsName = ''):string {
        $apiStr = '';
        if ($targetsName)   $apiStr .= '/targets/'.$targetsName;
        $apiStr .= '/upstreams/'.$upstreamsName;
        $http = new HttpHelper();
        return $http->put($this->baseUri, $body, $apiStr);
    }

    /**
     * 删除上游或目标对象相关上游
     * @param string $upstreamsName 上游服务名称/ID
     * @param string $targetsName 目标对象名称/ID
     * @return string
     */
    public function deleteTargetsUpstream(string $upstreamsName, string $targetsName = ''):string {
        $apiStr = '';
        if ($targetsName)   $apiStr .= '/targets/'.$targetsName;
        $apiStr .= '/upstreams/'.$upstreamsName;
        $http = new HttpHelper();
        return $http->delete($this->baseUri, $apiStr);
    }

    /**
     * 显示节点的上游运行状况
     * @param string $upstreamsName 上游服务名称/ID
     * @return string
     */
    public function getUpstreamsHealth(string $upstreamsName):string {
        $apiStr = '/upstreams/'.$upstreamsName."/health";
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }
    
    /**
     * 创建特定上游相关的目标对象
     * @param array $body 更新实体数据
     * @param string $upstreamsName 上游主机(host:port)/ID
     * @return string
     */
    public function addUpstreamTargets(array $body, string $upstreamsName):string {
        $apiStr = "/upstreams/".$upstreamsName."/targets";
        $http = new HttpHelper();
        return $http->post($this->baseUri, $body, $apiStr);
    }

    /**
     * 列出与特定上游相关目标对象
     * @param string $upstreamsName 上游主机(host:port)/ID
     * @return string
     */
    public function getUpstreamTargets(string $upstreamsName):string {
        $apiStr = '/upstreams/'.$upstreamsName."/targets";
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    /**
     * 删除目标
     * @param string $upstreamsName 上游主机名称/ID
     * @param string $targetsName 目标(host:port)/ID
     * @return string
     */
    public function deleteUpstreamTargets(string $upstreamsName, string $targetsName):string {
        $apiStr = '/upstreams/'.$upstreamsName."/targets/".$targetsName;
        $http = new HttpHelper();
        return $http->delete($this->baseUri, $apiStr);
    }

}