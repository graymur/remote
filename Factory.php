<?php
/**
 * Created by Graymur
 * Date: 17.10.2014
 * Time: 11:01
 */

namespace Graymur\Remote;

class Factory
{
    /**
     * @param string $protocol
     * @param $server
     * @param $login
     * @param $password
     * @param null $port
     * @return RemoteAbstract
     * @throws RemoteException
     */
    static function get($protocol = 'FTP', $server, $login, $password, $port = null)
    {
        $className = "\\Graymur\\Remote\\Protocols\\" . strtoupper($protocol);

        if (!class_exists($className))
        {
            throw new RemoteException("Protocol $protocol is not implemented");
        }

        return new $className($server, $login, $password, $port);
    }
}