<?php

namespace PHPLRPM\Cluster;

use PHPLRPM\Cluster\Filters\ShardingConfigurationFilter;
use PHPLRPM\Cluster\Providers\ClusterConfigurationProvider;
use PHPLRPM\ConfigurationSource;
use RuntimeException;

abstract class ShardingConfigurationSource implements ConfigurationSource
{
    /** @var ConfigurationSource */
    protected $confSource;

    /** @var ClusterConfigurationProvider */
    protected $clusterConfProvider;

    /** @var ShardingConfigurationFilter */
    protected $configurationFilter;

    abstract public function __construct();

    public function loadConfiguration(): array
    {
        $this->validateInitializedProperties();
        $inputConfig = $this->confSource->loadConfiguration();
        $clusterConfig = $this->clusterConfProvider->loadClusterConfiguration();
        return $this->filterConfig($inputConfig, $clusterConfig);
    }

    private function filterConfig(array $inputConfig, ClusterConfiguration $clusterConf): array
    {
        return $this->configurationFilter->filterConfig($inputConfig, $clusterConf);
    }

    private function validateInitializedProperties(): void
    {
        if (!(isset($this->confSource))
            || !($this->confSource instanceof ConfigurationSource)
        ) {
            throw new RuntimeException(
                'ShardingConfigurationSource::confSource must be initialized and implement ConfigurationSource'
            );
        }

        if (!(isset($this->clusterConfProvider))
            || !($this->clusterConfProvider instanceof ClusterConfigurationProvider)
        ) {
            throw new RuntimeException(
                'ShardingConfigurationSource::clusterConfProvider must be initialized and implement ClusterConfigurationProvider'
            );
        }

        if (!(isset($this->configurationFilter))
            || !($this->configurationFilter instanceof ShardingConfigurationFilter)
        ) {
            throw new RuntimeException(
                'ShardingConfigurationSource::configurationFilter must be initialized and implement ShardingConfigurationFilter'
            );
        }
    }
}
