<?php

namespace PHPLRPM\Cluster\Filters;

use PHPLRPM\Cluster\ClusterConfiguration;
use RendezvousHashing\Node;
use RendezvousHashing\WRH;

class RendezvousHashingShardingConfigurationFilter implements ShardingConfigurationFilter
{
    public function filterConfig(array $inputConfig, ClusterConfiguration $clusterConfig): array {
        $numberOfInstances = $clusterConfig->getNumberOfInstances();
        $instanceNumber = $clusterConfig->getInstanceNumber();
        $thisInstance = strval($instanceNumber);

        $weight = 0;
        $nodes = [];
        for ($i = 0; $i < $numberOfInstances; $i++) {
            $nodes[] = new Node(strval($i), $weight);
        }

        $outputConfig = [];
        foreach ($inputConfig as $key => $value) {
            if ($thisInstance === WRH::determineResponsibleNode($nodes, strval($key))->getName()) {
                $outputConfig[$key] = $value;
            }
        }
        return $outputConfig;
    }
}
