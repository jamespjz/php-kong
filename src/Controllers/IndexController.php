<?php
/**
 * 操作类
 */

namespace Jamespi\Kong\Controllers;

use Jamespi\Kong\Common\HttpHelper;
use Jamespi\Kong\Common\CheckHelper;
class IndexController{

    protected $baseUri;

    public function __construct(string $baseUri)
    {
        $port = '8001';
        $this->baseUri = $baseUri;
        $check = new CheckHelper();
        $uriArr = explode(":", $baseUri);
        if ($uriArr[1]) {
            $port = $uriArr[1];
        }
        if(!$check->ping($uriArr[0], $port)){
            return 'this ip port address failed to connect.';
        }
    }

    public function addService(array $body, string $apiStr)
    {
        $http = new HttpHelper();
        $http->post($this->baseUri, $body, $apiStr);
    }

    public function getServices(string $apiStr)
    {
        $http = new HttpHelper();
        return $http->get($this->baseUri, $apiStr);
    }

    public function addApi()
    {
        return "aaa";
    }

    public function addRoutes()
    {

    }

    public function addPlugins()
    {

    }

}