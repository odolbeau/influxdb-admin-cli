<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClusterAdminsShowCommand extends Command
{
    protected $jsonOutput = true;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('cluster_admins:show')
            ->setDescription('Get cluster admins')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $influxDB = $this->getInfluxDB($input, $output);

        $this->write(
            $input,
            $output,
            $influxDB->getClusterAdmins()
        );
    }
}
