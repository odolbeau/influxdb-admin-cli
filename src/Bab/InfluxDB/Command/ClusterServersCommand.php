<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClusterServersCommand extends Command
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('cluster:servers')
            ->setDescription('Get servers state')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $influxDB = $this->getInfluxDB($input, $output);

        $this->write(
            $input,
            $output,
            $influxDB->getClusterServers()
        );
    }
}
