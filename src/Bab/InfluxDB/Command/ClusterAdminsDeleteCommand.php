<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClusterAdminsDeleteCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('cluster_admins:delete')
            ->setDescription('Delete cluster admin')
            ->addArgument('name', InputArgument::REQUIRED, 'Admin name')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $this->getInfluxDB($input, $output)->deleteClusterAdmin($name);

        $output->writeln(sprintf('<comment>Cluster admin "<info>%s</info>" deleted.</comment>', $name));
    }
}
