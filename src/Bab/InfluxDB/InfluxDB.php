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
     * createClusterAdmin
     *
     * @param string $name
     * @param string $password
     *
     * @return void
     */
    public function createClusterAdmin($name, $password)
    {
        $this->post('/cluster_admins', array(), json_encode(array('name' => $name, 'password' => $password)));
    }

    /**
     * deleteClusterAdmin
     *
     * @param string $name
     *
     * @return void
     */
    public function deleteClusterAdmin($name)
    {
        $this->delete('/cluster_admins/' . $name);
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
     * createDatabaseUser
     *
     * @param string $database
     * @param string $name
     * @param string $password
     *
     * @return void
     */
    public function createDatabaseUser($database, $name, $password)
    {
        $this->post(
            sprintf('/db/%s/users', $database),
            array(),
            json_encode(array('name' => $name, 'password' => $password))
        );
    }

    /**
     * deleteDatabaseUser
     *
     * @param string $database
     * @param string $name
     *
     * @return void
     */
    public function deleteDatabaseUser($database, $name)
    {
        $this->delete(sprintf('/db/%s/users/%s', $database, $name));
    }

    /**
     * getDatabaseUsers
     *
     * @param string $database
     *
     * @return string
     */
    public function getDatabaseUsers($database)
    {
        return $this->get(sprintf('/db/%s/users', $database))->getContent();
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
        return $this->getBrowser()->get($this->getFullUrl($url), $headers);
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
        return $this->getBrowser()->post(
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
        return $this->getBrowser()->delete(
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
    protected function getFullUrl($url)
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

    /**
     * getBrowser
     *
     * @return Browser
     */
    protected function getBrowser()
    {
        return new Browser(
            new \Buzz\Client\Curl()
        );
    }
}
