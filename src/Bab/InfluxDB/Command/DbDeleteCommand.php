<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbDeleteCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('db:delete')
            ->setDescription('Delete a database')
            ->addArgument('name', InputArgument::REQUIRED, 'DB name')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $this->getInfluxDB($input, $output)->deleteDatabase($name);

        $output->writeln(sprintf('<comment>Database "<info>%s</info>" deleted</comment>', $name));
    }
}
