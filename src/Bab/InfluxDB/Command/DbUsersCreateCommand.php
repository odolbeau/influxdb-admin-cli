<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbUsersCreateCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('db_users:create')
            ->setDescription('Create a new database user')
            ->addArgument('database', InputArgument::REQUIRED, 'DB name')
            ->addArgument('name', InputArgument::REQUIRED, 'User name')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $this->getInfluxDB($input, $output)->createDatabaseUser(
            $input->getArgument('database'),
            $name,
            $input->getArgument('password')
        );

        $output->writeln(sprintf('<comment>Database user "<info>%s</info>" created</comment>', $name));
    }
}
