<?php
/**
 * 操作类
 */

namespace Jamespi\Kong\Controllers;

use Jamespi\Kong\Common\HttpHelper;
class IndexController{

    public function index(){
        $http = new HttpHelper();
        $baseUri = 'http://47.112.160.146:8001';
        $body = [
            'name' => 'james_service',
            'url' => 'http://music.taihe.com'
        ];
        $apiStr = '/services/';
        $http->Post($baseUri, $body, $apiStr);
    }

}