<?php

declare(strict_types=1);

namespace HttpClient\Aliyun\NetworkAttachedStorage;

class Filesystem extends Client
{
    public function list(array $params = [])
    {
        return $this->request(array_merge([
            'Action' => 'DescribeFileSystems',
        ], $params));
    }

    public function get($fileSystemId, array $params = [])
    {
        return $this->list(array_merge([
            'FileSystemId' => $fileSystemId,
        ], $params));
    }

    public function create(array $params)
    {
        return $this->request([
            'Action' => 'CreateFileSystem',
        ] + $params);
    }

    public function delete($fileSystemId)
    {
        return $this->request([
            'Action' => 'DeleteFileSystem',
            'FileSystemId' => $fileSystemId,
        ]);
    }

    public function update($fileSystemId, $description = null)
    {
        return $this->request([
            'Action' => 'ModifyFileSystem',
            'FileSystemId' => $fileSystemId,
            'Description' => $description,
        ]);
    }
}
