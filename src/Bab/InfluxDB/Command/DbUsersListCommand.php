<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbUsersListCommand extends Command
{
    protected $jsonOutput = true;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('db_users:list')
            ->setDescription('List database users')
            ->addArgument('database', InputArgument::REQUIRED, 'DB name')
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
            $influxDB->getDatabaseUsers($input->getArgument('database'))
        );
    }
}
