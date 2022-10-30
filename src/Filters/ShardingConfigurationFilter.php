<?php

namespace PHPLRPM\Cluster\Filters;

use PHPLRPM\Cluster\ClusterConfiguration;

interface ShardingConfigurationFilter
{
    public function filterConfig(array $inputConfig, ClusterConfiguration $clusterConfig): array;
}
