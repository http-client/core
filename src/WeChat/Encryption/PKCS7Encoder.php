<?php

declare(strict_types=1);

namespace HttpClient\WeChat\Encryption;

class PKCS7Encoder
{
    /**
     * @var int
     */
    protected $blockSize = 32;

    /**
     * @param string $text
     *
     * @return string
     */
    public function encode($text)
    {
        $amount = $this->blockSize - (strlen($text) % $this->blockSize);

        if ($amount === 0) {
            $amount = $this->blockSize;
        }

        $value = '';
        for ($i = 0; $i < $amount; ++$i) {
            $value .= chr($amount);
        }

        return $text.$value;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public function decode($text)
    {
        $pad = ord(substr($text, -1));

        if ($pad < 1 || $pad > $this->blockSize) {
            $pad = 0;
        }

        return substr($text, 0, (strlen($text) - $pad));
    }
}
