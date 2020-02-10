<?php

declare(strict_types=1);

namespace HttpClient\WeChat\MediaPlatform;

/**
 * @group 标签管理
 */
trait ManagesTags
{
    /**
     * 创建标签
     *
     * @param string $name
     *
     * @return mixed
     */
    public function createTag($name)
    {
        return $this->request('POST', 'cgi-bin/tags/create', [
            'json' => ['name' => $name],
        ]);
    }

    public function getTags()
    {
        return $this->request('GET', 'cgi-bin/tags/get');
    }

    public function updateTag($id, $name)
    {
        return $this->request('POST', 'cgi-bin/tags/update', [
            'json' => ['tag' => ['id' => $id, 'name' => $name]],
        ]);
    }

    public function deleteTag($id)
    {
        return $this->request('POST', 'cgi-bin/tags/delete', [
            'json' => ['tag' => ['id' => $id]],
        ]);
    }

    public function tagUsers(array $openids, $tagId)
    {
        return $this->request('POST', 'cgi-bin/tags/members/batchtagging', [
            'json' => ['openid_list' => $openids, 'tagid' => $tagId],
        ]);
    }

    public function untagUsers(array $openids, $tagId)
    {
        return $this->request('POST', 'cgi-bin/tags/members/batchuntagging', [
            'json' => ['openid_list' => $openids, 'tagid' => $tagId],
        ]);
    }

    public function getTagIdsForUser($openid)
    {
        return $this->request('POST', 'cgi-bin/tags/getidlist', [
            'json' => ['openid' => $openid],
        ]);
    }
}
