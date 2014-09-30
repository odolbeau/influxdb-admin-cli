<?php

namespace Bab\InfluxDB\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Bab\InfluxDB\InfluxDB;
use Symfony\Component\Filesystem\Filesystem;

class Command extends BaseCommand
{
    protected $jsonOutput = false;

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
            ;

        if ($this->jsonOutput) {
            $this->addOption('raw', null, InputOption::VALUE_NONE, 'Do not pretty print result', null);
        }
    }

    /**
     * getInfluxDB
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return InfluxDB
     */
    protected function getInfluxDB(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();
        $credentials = array();
        $file = rtrim(getenv('HOME'), '/') . '/.influxdb_admin_cli';
        if ($fs->exists($file)) {
            $credentials = json_decode(file_get_contents($file), true);
        }

        if ($input->hasParameterOption(['--host', '-H'])) {
            $host = $input->getOption('host');
        } else {
            $host = isset($credentials['host'])? $credentials['host'] : $input->getOption('host');
        }

        if ($input->hasParameterOption('--port')) {
            $port = $input->getOption('port');
        } else {
            $port = isset($credentials['port'])? $credentials['port'] : $input->getOption('port');
        }

        if ($input->hasParameterOption(['--user', '-u'])) {
            $user = $input->getOption('user');
        } else {
            $user = isset($credentials['user'])? $credentials['user'] : $input->getOption('user');
        }

        if ($input->hasParameterOption(['--password', '-p'])) {
            $password = $input->getOption('password');
        } elseif (isset($credentials['password'])) {
            $password = $credentials['password'];
        } elseif (null === $password = $input->getOption('password')) {
            $dialog = $this->getHelperSet()->get('dialog');
            $password = $dialog->askHiddenResponse($output, 'Password?', false);
        }

        return new InfluxDB($host, $port, $user, $password);
    }

    /**
     * write
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param string          $content
     *
     * @return void
     */
    protected function write(InputInterface $input, OutputInterface $output, $content)
    {
        if (!$input->hasOption('raw') || $input->getOption('raw')) {
            $output->writeln($content);

            return;
        }

        $array = json_decode($content);

        $output->writeln(json_encode($array, JSON_PRETTY_PRINT));
    }
}
