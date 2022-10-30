<?php

namespace PHPLRPM\Cluster\Test;

use PHPLRPM\Cluster\Filters\RendezvousHashingShardingConfigurationFilter;
use PHPLRPM\Cluster\Providers\FileBasedClusterConfigurationProvider;
use PHPLRPM\Cluster\ShardingConfigurationSource;
use PHPLRPM\Test\MockConfigurationSource;

class TestFileBasedClusterConfigurationSource
{
    private const CONFIG_FILE = __DIR__ . '/lrpm-cluster.conf';

    private $shardingConfigSource;

    public function __construct()
    {
        $this->shardingConfigSource = new ShardingConfigurationSource(
            new MockConfigurationSource(),
            new FileBasedClusterConfigurationProvider(self::CONFIG_FILE),
            new RendezvousHashingShardingConfigurationFilter()
        );
    }

    public function loadConfiguration(): array
    {
        return $this->shardingConfigSource->loadConfiguration();
    }
}
