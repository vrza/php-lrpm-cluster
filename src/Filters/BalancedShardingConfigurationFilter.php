<?php

namespace PHPLRPM\Cluster\Filters;

use PHPLRPM\Cluster\ClusterConfiguration;

class BalancedShardingConfigurationFilter implements ShardingConfigurationFilter
{
    public function filterConfig(array $inputConfig, ClusterConfiguration $clusterConfig): array
    {
        $numberOfInstances = $clusterConfig->getNumberOfInstances();
        $instanceNumber = $clusterConfig->getInstanceNumber();
        $outputConfig = [];

        ksort($inputConfig);
        $i = 0;
        foreach ($inputConfig as $key => $value) {
            if ($i++ % $numberOfInstances === $instanceNumber) {
                $outputConfig[$key] = $value;
            }
        }

        return $outputConfig;
    }
}
