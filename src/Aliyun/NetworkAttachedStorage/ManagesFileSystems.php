<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

trait ManagesFileSystems
{
    public function describeFileSystems(array $params = [])
    {
        return $this->encapsulatesRequest(array_merge([
            'Action' => 'DescribeFileSystems',
        ], $params));
    }

    public function describeFileSystem($fileSystemId, array $params = [])
    {
        return $this->describeFileSystems(array_merge([
            'FileSystemId' => $fileSystemId,
        ], $params));
    }

    public function createFileSystem($protocolType, $storageType, $zoneId, $encryptType, $description = null)
    {
        return $this->encapsulatesRequest([
            'Action' => 'CreateFileSystem',
            'EncryptType' => $encryptType,
            'ProtocolType' => $protocolType,
            'StorageType' => $storageType,
            'ZoneId' => $zoneId,
            'Description' => $description,
        ]);
    }

    public function deleteFileSystem($fileSystemId)
    {
        return $this->encapsulatesRequest([
            'Action' => 'DeleteFileSystem',
            'FileSystemId' => $fileSystemId,
        ]);
    }

    public function modifyFileSystem($fileSystemId)
    {
        return $this->encapsulatesRequest([
            'Action' => 'ModifyFileSystem',
            'FileSystemId' => $fileSystemId,
            'Description' => $description,
        ]);
    }
}
