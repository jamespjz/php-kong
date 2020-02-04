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

    /**
     * 发起更新PATCH操作
     * @param string $baseUri 请求URI
     * @param array $body 更新实体数据
     * @param string $apiStr 请求路径/参数
     * @return string
     */
    public function path(string $baseUri, array $body, string $apiStr):string
    {
        $client = new HttpClient( ['base_uri' => $baseUri] );
        $res = $client->request('PATCH', $apiStr, ['json' => $body ]);
        $data = $res->getBody()->getContents();

        return $data;
    }

    /**
     * 添加/更新PUT操作
     * @param string $baseUri 请求URI
     * @param array $body 添加/更新实体数据
     * @param string $apiStr 请求路径/参数
     * @return string
     */
    public function put(string $baseUri, array $body, string $apiStr):string
    {
        $client = new HttpClient( ['base_uri' => $baseUri] );
        $res = $client->request('PUT', $apiStr, ['json' => $body ]);
        $data = $res->getBody()->getContents();

        return $data;
    }

    /**
     * 删除DELETE操作
     * @param string $baseUri 请求URI
     * @param string $apiStr 请求路径/参数
     * @return string
     */
    public function delete(string $baseUri, string $apiStr)
    {
        $client = new HttpClient( ['base_uri' => $baseUri] );
        $res = $client->request('DELETE', $apiStr);
        $data = $res->getBody()->getContents();

        return $data;
    }

}