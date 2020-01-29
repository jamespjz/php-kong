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
        $uri = (reset($uriArr)=='http' || reset($uriArr)=='https') ? $uriArr[1] : $uriArr[0];

        if (is_numeric(end($uriArr))) {
            $port = end($uriArr);
        }

        if(!$check->ping($uri, $port)){
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