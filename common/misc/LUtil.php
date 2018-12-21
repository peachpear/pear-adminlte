<?php
namespace common\misc;

/**
 * 工具集合
 * Class LUtil
 * @package common\misc
 */
class LUtil
{
    const LOG_PREFIX = 'common.misc.LUtil.';

    /**
     * 判断PHP运行环境检测是否为cli
     * @return bool
     */
    public static function isCli()
    {
        return php_sapi_name() == "cli";
    }

    /**
     * 判断ip是否为局域网ip
     * @param $ip
     * @return bool
     */
    public static function isLAN($ip)
    {
        $ip = ip2long($ip);
        $net_a = ip2long('10.0.0.0') >> 24;  // A类网预留ip的网络地址 10.0.0.0 ～ 10.255.255.255
        $net_b = ip2long('172.16.0.0') >> 20;  // B类网预留ip的网络地址 172.16.0.0 ～ 172.31.255.255
        $net_c = ip2long('192.168.0.0') >> 16;  // C类网预留ip的网络地址 192.168.0.0 ～ 192.168.255.255

        return $ip >> 24 === $net_a || $ip >> 20 === $net_b || $ip >> 16 === $net_c;
    }

    /**
     * 获取随机字符串
     * @param $length
     * @return null|string
     */
    public static function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++)
        {
            $str .= $strPol[rand(0, $max)];  // rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }
}
