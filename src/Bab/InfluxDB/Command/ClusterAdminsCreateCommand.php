<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClusterAdminsCreateCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('cluster_admins:create')
            ->setDescription('Create cluster admins')
            ->addArgument('name', InputArgument::REQUIRED, 'Admin name')
            ->addArgument('password', InputArgument::REQUIRED, 'Admin password')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $this->getInfluxDB($input, $output)->createClusterAdmin($name, $input->getArgument('password'));

        $output->writeln(sprintf('<comment>Cluster admin "<info>%s</info>" created</comment>', $name));
    }
}
