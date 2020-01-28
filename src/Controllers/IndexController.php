<?php
/**
 * 操作类
 */

namespace Jamespi\Kong\Controllers;

use Jamespi\Kong\Common\HttpHelper;
class IndexController{

    public function addService(){
        $http = new HttpHelper();
        $baseUri = 'http://47.112.160.146:8001';
        $body = [
            'name' => 'james_service',
            'url' => 'http://music.taihe.com'
        ];
        $apiStr = '/services/';
        $http->post($baseUri, $body, $apiStr);
    }

    public function getServices($baseUri, $apiStr){
        $http = new HttpHelper();
        return $http->get($baseUri, $apiStr);
    }

    public function addApi(){
        return "aaa";
    }

    public function addRoutes(){

    }

    public function addPlugins(){

    }

    public static function testaa(){
        return "bb";
    }

}