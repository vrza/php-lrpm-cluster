<?php

namespace PHPLRPM\Cluster\Providers;

use PHPLRPM\Cluster\ClusterConfiguration;

interface ClusterConfigurationProvider
{
    public function loadClusterConfiguration(): ClusterConfiguration;
}
