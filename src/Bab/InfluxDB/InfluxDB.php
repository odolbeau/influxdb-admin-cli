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
     * @return string
     */
    public function getClusterServers()
    {
        return $this->get('/cluster/servers')->getContent();
    }

    /**
     * getClusterAdmins
     *
     * @return string
     */
    public function getClusterAdmins()
    {
        return $this->get('/cluster_admins')->getContent();
    }

    /**
     * createDatabase
     *
     * @param string $name
     *
     * @return void
     */
    public function createDatabase($name)
    {
        $this->post('/db', array(), json_encode(array('name' => $name)));
    }

    /**
     * deleteDatabase
     *
     * @param string $name
     *
     * @return void
     */
    public function deleteDatabase($name)
    {
        $this->delete('/db/'.$name);
    }

    /**
     * get
     *
     * @param string $url
     * @param array  $headers
     *
     * @return Response
     */
    protected function get($url, $headers = array())
    {
        return (new Browser())->get($this->getFullUrl($url), $headers);
    }

    /**
     * post
     *
     * @param string $url
     * @param array  $headers
     * @param string $content
     *
     * @return Response
     */
    protected function post($url, $headers = array(), $content = '')
    {
        return (new Browser())->post(
            $this->getFullUrl($url),
            $headers,
            $content
        );
    }

    /**
     * delete
     *
     * @param string $url
     * @param array  $headers
     * @param string $content
     *
     * @return Response
     */
    protected function delete($url, $headers = array(), $content = '')
    {
        return (new Browser())->delete(
            $this->getFullUrl($url),
            $headers,
            $content
        );
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
