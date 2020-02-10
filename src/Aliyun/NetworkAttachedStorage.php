<?php

declare(strict_types=1);

namespace HttpClient\Aliyun;

use HttpClient\Client;

class NetworkAttachedStorage extends Client
{
    use NetworkAttachedStorage\EncapsulatesRequests,
        NetworkAttachedStorage\ManagesRegions,
        NetworkAttachedStorage\ManagesZones,
        NetworkAttachedStorage\ManagesFileSystems,
        NetworkAttachedStorage\ManagesMountTargets,
        NetworkAttachedStorage\ManagesAccessGroups,
        NetworkAttachedStorage\ManagesAccessRules;
    // NetworkAttachedStorage\ManagesSnapshots,
    // NetworkAttachedStorage\ManagesSnapshotPolicies,
    // NetworkAttachedStorage\ManagesSnapshotTasks,
    // NetworkAttachedStorage\ManagesTags;

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->setBaseUri('https://'.$this->options['endpoint']);
    }
}
