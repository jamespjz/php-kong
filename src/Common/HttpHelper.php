<?php
/**
 * http请求帮助类
 */

namespace Jamespi\Kong\Common;

use \GuzzleHttp\Client as HttpClient;
class HttpHelper {

    /**
     * post 请求
     */
    public function Post($baseUri, $body, $apiStr){
        $client = new HttpClient( ['base_uri' => $baseUri] );
        $res = $client->request('POST', $apiStr, ['body' => $body ]);
        var_dump($res);
        var_dump($res->getBody()->getContents());
    }

}