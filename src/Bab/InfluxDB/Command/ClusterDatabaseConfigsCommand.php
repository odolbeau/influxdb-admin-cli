<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ClusterDatabaseConfigsCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('cluster:database_configs')
            ->setDescription('Update a database configuration')
            ->addArgument('name', InputArgument::REQUIRED, 'The DB name to update')
            ->addArgument('file', InputArgument::REQUIRED, 'The file containing data')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $fs = new Filesystem();
        $file = $input->getArgument('file');
        if (!$fs->exists($file)) {
            throw new \InvalidArgumentException('Unable to find file.');
        }

        $this->getInfluxDB($input, $output)->createClusterDatabaseConfigs($name, file_get_contents($file));

        $output->writeln(sprintf('<comment>Configuration for database "<info>%s</info>" updated.</comment>', $name));
    }
}
