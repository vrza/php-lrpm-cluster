<?php

namespace PHPLRPM\Cluster;

use PHPLRPM\Cluster\Filters\ShardingConfigurationFilter;
use PHPLRPM\Cluster\Providers\ClusterConfigurationProvider;
use PHPLRPM\ConfigurationSource;

class ShardingConfigurationSource implements ConfigurationSource
{
    private $confSource;
    private $clusterConfProvider;
    /**
     * @var ShardingConfigurationFilter
     */
    private $configurationFilter;

    public function __construct(ConfigurationSource $confSource, ClusterConfigurationProvider $clusterConfProvider, ShardingConfigurationFilter $configurationFilter)
    {
        $this->confSource = $confSource;
        $this->clusterConfProvider = $clusterConfProvider;
        $this->configurationFilter = $configurationFilter;
    }

    public function loadConfiguration(): array
    {
        $inputConfig = $this->confSource->loadConfiguration();
        $clusterConfig = $this->clusterConfProvider->loadClusterConfiguration();
        return $this->filterConfig($inputConfig, $clusterConfig);
    }

    private function filterConfig(array $inputConfig, ClusterConfiguration $clusterConf): array
    {
        return $this->configurationFilter->filterConfig($inputConfig, $clusterConf);
    }
}
