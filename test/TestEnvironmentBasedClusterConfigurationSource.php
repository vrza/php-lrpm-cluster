<?php

namespace PHPLRPM\Cluster\Test;

use PHPLRPM\Cluster\Filters\RendezvousHashingShardingConfigurationFilter;
use PHPLRPM\Cluster\Providers\EnvironmentBasedClusterConfigurationProvider;
use PHPLRPM\Cluster\ShardingConfigurationSource;
use PHPLRPM\Test\MockConfigurationSource;

class TestEnvironmentBasedClusterConfigurationSource
{
    private $shardingConfigSource;

    public function __construct()
    {
        $this->shardingConfigSource = new ShardingConfigurationSource(
            new MockConfigurationSource(),
            new EnvironmentBasedClusterConfigurationProvider(),
            new RendezvousHashingShardingConfigurationFilter()
        );
    }

    public function loadConfiguration(): array
    {
        return $this->shardingConfigSource->loadConfiguration();
    }
}
