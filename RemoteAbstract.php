<?php
/**
 * Created by Graymur
 * Date: 17.10.2014
 * Time: 11:02
 */

namespace Graymur\Remote;

abstract class RemoteAbstract implements RemoteInterface
{
    protected $server;
    protected $login;
    protected $password;
    protected $port;
    protected $link;

    /**
     * @param $server
     * @param $login
     * @param $password
     * @param null $port
     */
    public function __construct($server, $login, $password, $port = null)
    {
        $this->server       = $server;
        $this->login        = $login;
        $this->password     = $password;

        if (!empty($this->port))
        {
            $this->port = $port;
        }
    }

    public function __destruct()
    {
        if ($this->link)
        {
            $this->close();
        }
    }
}