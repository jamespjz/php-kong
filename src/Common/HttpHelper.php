<?php
/**
 * http请求帮助类
 */

namespace Jamespi\Kong\Common;

use \GuzzleHttp\Client as HttpClient;
class HttpHelper {

    /**
     * 发起post请求
     * @param string $baseUri 请求URI
     * @param array $body 请求实体参数
     * @param string $apiStr 请求路径
     * @return string
     */
    public function post(string $baseUri, array $body, string $apiStr):string
    {
        $client = new HttpClient( ['base_uri' => $baseUri] );
        $res = $client->request('POST', $apiStr, ['json' => $body ]);
        $data = $res->getBody()->getContents();

        return $data;
    }

    /**
     * 发起get请求
     * @param string $baseUri 请求URI
     * @param string $apiStr 请求路径
     * @return string
     */
    public function get(string $baseUri, string $apiStr):string
    {
        $client = new HttpClient( ['base_uri' => $baseUri] );
        $res = $client->request('GET', $apiStr);
        $data = $res->getBody()->getContents();

        return $data;
    }

}