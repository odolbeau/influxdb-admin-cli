<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbCreateCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('db:create')
            ->setDescription('Create a new database')
            ->addArgument('name', InputArgument::REQUIRED, 'DB name')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $this->getInfluxDB($input, $output)->createDatabase($name);

        $output->writeln(sprintf('<comment>Database "<info>%s</info>" created</comment>', $name));
    }
}
