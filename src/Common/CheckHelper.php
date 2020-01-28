<?php
/**
 * 帮助工具方法类
 */

namespace Jamespi\Kong\Common;

class CheckHelper{

    function ping(string $ip, string $port):bool
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {        //IPv6
            $socket = socket_create(AF_INET6, SOCK_STREAM, SOL_TCP);
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {    //IPv4
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        } else {
            return false;
        }

        if (!isset($port)) {
            //没有写端口则指定为80
            $port = '80';
        }
        @$ok = socket_connect($socket, $ip, $port);
        socket_close($socket);

        if ($ok) {
            //echo "连接OK\n";
            return true;
        } else {
            //echo "socket_connect() failed.\nReason: ($ok) " . socket_strerror($ok) . "\n";
            return false;
        }
    }

}