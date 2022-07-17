<?php

namespace App\CustomUtil;

use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter as BaseEncrypter;

class CustomEncrypter
{
    /**
     * @var BaseEncrypter
     */
    private $encrypter;

    /**
     * Encrypter constructor.
     *
     * @param $pwd
     */
    public function __construct($pwd)
    {
        $this->encrypter = new BaseEncrypter($this->makeKey($pwd));
    }

    /**
     * Call BaseEncrypter encrypt function
     *
     * @param $data
     * @return string|bool
     */
    public function encrypt($data)
    {
        try {
            return $this->encrypter->encrypt($data);
        } catch (EncryptException $exception) {
            return false;
        }
    }

    /**
     * Call BaseEncrypter decrypt function
     *
     * @param $data
     * @return string|bool
     */
    public function decrypt($data)
    {
        try {
            return $this->encrypter->decrypt($data);
        } catch (DecryptException $exception) {
            return false;
        }
    }

    /**
     * Make a key from pass phrase
     *
     * @param $pwd
     * @return string
     */
    private function makeKey($pwd)
    {
        while ($this->getKeySize($pwd) < 16) {
            $pwd = $this->pad($pwd);
        }

        while ($this->getKeySize($pwd) > 16) {
            $pwd = $this->shrink($pwd);
        }

        return $this->encode($pwd);
    }

    /**
     * Verify key size
     *
     * @param $string
     * @return int
     */
    private function getKeySize($string)
    {
        return mb_strlen($this->encode($string), '8bit');
    }

    /**
     * Encode string
     *
     * @param $string
     * @return string
     */
    private function encode($string)
    {
        return base64_encode($string);
    }

    /**
     * Shrink a string
     *
     * @param $string
     * @return string
     */
    private function shrink($string)
    {
        return substr($string, 0, strlen($string) - 1);
    }

    /**
     * Pad a string with itself to lengthen
     *
     * @param $string
     * @return string
     */
    private function pad($string)
    {
        return $string . $string;
    }
}
