<?php

namespace app\common\lib;

class Encryption
{

    //加严密文生成
    static public function salt()
    {
        $str = self::randomkeys(16);
        return md5($str);
    }

    /**
     * md5加密
     * @param String 明文
     * @param String 加严字符串
     * @return String 密文
     */
    static public function enMd5($str, $salt)
    {
        $pwd = md5(md5(md5($str) . $salt) . "key=" . $salt);
        return $pwd;
    }

    /**
     * aes密钥生成
     * @param String 原密钥
     * @return String 16位数新密钥
     */
    static public function enKey($key)
    {
        $str = md5("key=" . $key);
        return substr($str, 0, 16);
    }

    /**
     * aes加密 ecb 128
     * @param String 明文
     * @param String 秘钥
     * @return String 密文
     */
    static public function enAes($encrypt, $key)
    {
        $data = openssl_encrypt($encrypt, 'aes-128-ecb', $key, true, '');
        return base64_encode($data);
    }

    /**
     * aes解密 ecb 128
     * @param String 密文字符串
     * @param String 商户号秘钥
     * @return String 解密之后的字符串
     */
    static public function deAes($decrypt, $key)
    {
        $encryptedData = base64_decode($decrypt);
        $decrypted = openssl_decrypt($encryptedData, 'aes-128-ecb', $key, true, '');
        return $decrypted;
    }

    //随机生成字符串
    static public function randomkeys($length)
    {
        $key = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $key .= $pattern[mt_rand(0, 35)];    //生成php随机数   
        }
        return $key;
    }
}
