<?php

namespace Bab\InfluxDB;

use Buzz\Browser;

class InfluxDB
{
    protected $host;
    protected $port;
    protected $user;
    protected $password;

    public function __construct($host = '127.0.0.1', $port = '8086', $user = 'root', $password = 'root')
    {
        $this->host     = $host;
        $this->port     = $port;
        $this->user     = $user;
        $this->password = $password;
    }

    /**
     * getClusterServers
     *
     * @return void
     */
    public function getClusterServers()
    {
        return $this->get('/cluster/servers');
    }

    /**
     * get
     *
     * @param string $url
     * @param array $headers
     *
     * @return void
     */
    public function get($url, $headers = array())
    {
        $browser = new Browser();

        return $browser->get($this->getFullUrl($url), $headers)->getContent();
    }

    /**
     * getFullUrl
     *
     * @param string $url
     *
     * @return string
     */
    public function getFullUrl($url)
    {
        return sprintf(
            'http://%s:%d%s?u=%s&p=%s',
            $this->host,
            $this->port,
            $url,
            $this->user,
            $this->password
        );
    }
}
