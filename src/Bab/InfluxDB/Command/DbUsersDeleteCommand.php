<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbUsersDeleteCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('db_users:delete')
            ->setDescription('Delete a database user')
            ->addArgument('database', InputArgument::REQUIRED, 'DB name')
            ->addArgument('name', InputArgument::REQUIRED, 'User name')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $this->getInfluxDB($input, $output)->deleteDatabaseUser(
            $input->getArgument('database'),
            $name
        );

        $output->writeln(sprintf('<comment>Database user "<info>%s</info>" deleted</comment>', $name));
    }
}
