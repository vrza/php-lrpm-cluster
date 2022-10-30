<?php

namespace PHPLRPM\Cluster\Filters;

use PHPLRPM\Cluster\ClusterConfiguration;

class HashingShardingConfigurationFilter implements ShardingConfigurationFilter
{
    public function filterConfig(array $inputConfig, ClusterConfiguration $clusterConfig): array
    {
        $numberOfInstances = $clusterConfig->getNumberOfInstances();
        $instanceNumber = $clusterConfig->getInstanceNumber();
        $outputConfig = [];

        foreach ($inputConfig as $key => $value) {
            if (crc32($key) % $numberOfInstances === $instanceNumber) {
                $outputConfig[$key] = $value;
            }
        }

        return $outputConfig;
    }
}
