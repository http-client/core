<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\ObjectStorageService;

trait ManagesServices
{
    public function getServices()
    {
        $headers = $this->authenticateWithHeaders('GET', $resource = '/');

        return $this->request('GET', $resource, [
            'headers' => $headers,
        ]);
    }

    // public function getSignedUrlForGetServices()
    // {
    //     $calculator = new \HttpClient\Aliyun\SignatureCalculator('sha1', 'Fs8QAXZH8seB18G2tXQd5s52pKRWwq6SNZKbgLmcKo5e' ?: $this->options['access_key_secret']);
    //     $signature = $calculator->calculate('GET', $md5 = '', $contentType = '', $date = time() + 99999, [], '/');

    //     $query = http_build_query([
    //         'OSSAccessKeyId' => 'STS.NT7UqZT9WGVenk2JFGcu8q2LD' ?: $this->options['access_key_id'],
    //         'Expires' => $date,
    //         'Signature' => $signature,
    //         'security-token' => 'CAIS7AF1q6Ft5B2yfSjIr5eCHsvuueZ28JSObE2DrkYSb/oUnvfnpjz2IHpMfXlrB+AWtP0wmWtS7PoZlq9zSp1MTk+cyyqoFg8So22beIPkl5Gfz95t0e+IewW6Dxr8w7WhAYHQR8/cffGAck3NkjQJr5LxaTSlWS7OU/TL8+kFCO4aRQ6ldzFLKc5LLw950q8gOGDWKOymP2yB4AOSLjIx5Vch2Dwlsv7kkpHDtUGBtjCglL9J/baWC4O/csxhMK14V9qIx+FsfsLDqnUKs0Ear/km3PYdpmqc5IvBWEM+/xidL+fP7s2+mIPFzGHdcBqAAZ+r6KrY8733FKXy+aBtEpD8JmaSL3ZfSUFeSuJLIVcHbv/oSzYdb4Gboos4/3kXFA7blFVLNJQK/J6Iw9metror053CwyR1nmoFZ8lW2tOneT1LjsD2ooDKqrPmq7NsFNFvJLq/+VCcp+Ry6h+4l2AVzVQSdfQ/LoHPhI5PBAWC',
    //     ]);

    //     return sprintf('https://%s/?%s', $this->options['endpoint'], $query);
    // }
}
