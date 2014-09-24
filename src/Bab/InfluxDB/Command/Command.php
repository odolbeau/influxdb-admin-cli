<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Bab\InfluxDB\InfluxDB;

class Command extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->addOption('host', 'H', InputOption::VALUE_REQUIRED, 'Which host?', '127.0.0.1')
            ->addOption('port', null, InputOption::VALUE_REQUIRED, 'Which port?', 8086)
            ->addOption('user', 'u', InputOption::VALUE_REQUIRED, 'Which user?', 'root')
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Which password? If nothing provided, password is asked', null)
            ->addOption('raw', null, InputOption::VALUE_NONE, 'Do not pretty print result', null)
        ;
    }

    /**
     * getInfluxDB
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return InfluxDB
     */
    protected function getInfluxDB(InputInterface $input, OutputInterface $output)
    {
        $password = $input->getOption('password');
        if (null === $password) {
            $dialog = $this->getHelperSet()->get('dialog');
            $password = $dialog->askHiddenResponse($output, 'Password?', false);
        }

        return new InfluxDB(
            $input->getOption('host'),
            $input->getOption('port'),
            $input->getOption('user'),
            $password
        );
    }

    protected function write(InputInterface $input, OutputInterface $output, $content)
    {
        if ($input->getOption('raw')) {
            $output->writeln($content);

            return;
        }

        $array = json_decode($content);

        $output->writeln(json_encode($array, JSON_PRETTY_PRINT));
    }
}
