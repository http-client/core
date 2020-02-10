<?php

declare(strict_types=1);

namespace HttpClient\WeChat\MediaPlatform;

/**
 * @group 用户管理
 */
trait ManagesUsers
{
    public function getUser($openid, $lang = null)
    {
        return $this->request('GET', 'cgi-bin/user/info', [
            'query' => ['openid' => $openid, 'lang' => $lang],
        ]);
    }

    public function batchUsers($list)
    {
        return $this->request('POST', 'cgi-bin/user/info/batchget', [
            'json' => ['user_list' => $list],
        ]);
    }

    public function getUsers($nextOpenid = null)
    {
        return $this->request('GET', 'cgi-bin/user/get', [
            'query' => ['next_openid' => $nextOpenid],
        ]);
    }

    public function getTaggedUsers($tagId, $nextOpenid = null)
    {
        return $this->request('POST', 'cgi-bin/user/tag/get', [
            'json' => ['tagid' => $tagId, 'next_openid' => $nextOpenid],
        ]);
    }

    public function updateRemark($openid, $remark)
    {
        return $this->request('POST', 'cgi-bin/user/info/updateremark', [
            'json' => ['openid' => $openid, 'remark' => $remark],
        ]);
    }

    public function getBlacklist($beginOpenid = null)
    {
        return $this->request('POST', 'cgi-bin/tags/members/getblacklist', [
            'json' => ['begin_openid' => $beginOpenid],
        ]);
    }

    public function blacklisting(array $openids)
    {
        return $this->request('POST', 'cgi-bin/tags/members/batchblacklist', [
            'json' => ['openid_list' => $openids],
        ]);
    }

    public function unblacklist(array $openids)
    {
        return $this->request('POST', 'cgi-bin/tags/members/batchunblacklist', [
            'json' => ['openid_list' => $openids],
        ]);
    }
}
