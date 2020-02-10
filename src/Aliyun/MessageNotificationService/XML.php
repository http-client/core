<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\MessageNotificationService;

use XMLWriter;

class XML
{
    public static function make($rootName, array $attributes)
    {
        $xmlWriter = new XMLWriter;
        $xmlWriter->openMemory();
        $xmlWriter->startDocument('1.0', 'UTF-8');
        $xmlWriter->startElementNS(null, $rootName, 'http://mns.aliyuncs.com/doc/v1/');
        foreach (array_filter($attributes) as $key => $value) {
            $xmlWriter->writeElement($key, $value);
        }
        $xmlWriter->endElement();
        $xmlWriter->endDocument();

        return $xmlWriter->outputMemory();
    }
}
