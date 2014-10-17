<?php
/**
 * Created by Graymur
 * Date: 17.10.2014
 * Time: 11:36
 */

namespace Graymur\Remote\Protocols;

use Graymur\Remote\RemoteException;

class SSH extends \Graymur\Remote\RemoteAbstract
{
    protected $port = 22;
    protected $sftp;

    public function connect()
    {
        if (!$this->link = ssh2_connect($this->server, $this->port))
        {
            throw new RemoteException('Failed to connect to SSH server in ' . __METHOD__);
        }

        if (!ssh2_auth_password($this->link, $this->login, $this->password))
        {
            throw new RemoteException('Failed to login to SSH server in ' . __METHOD__);
        }

        $this->sftp = ssh2_sftp($this->link);

        return 0;
    }

    public function upload($source, $target)
    {
        return ssh2_scp_send($this->link, $source, $target, 0644);
    }

    public function download($source, $target, $mode = null)
    {
        ssh2_scp_recv($this->link, $source, $target);
        return file_exists($target);
    }

    public function rename($old, $new)
    {
        return ssh2_sftp_rename($this->sftp, $old, $new);
    }

    public function delete($filename)
    {
        return ssh2_sftp_unlink($this->sftp, $filename);
    }

    public function stat($filename)
    {
        return ssh2_sftp_stat($this->sftp, $filename);
    }

    public function cd($directory)
    {
        return $this->exec("cd $directory");
    }

    public function filesize($filename)
    {
        $stat = $this->stat($filename);
        return $stat['size'];
    }

    public function exec($cmd)
    {
        $stream = ssh2_exec($this->link, $cmd);

        stream_set_blocking($stream, true);

        $responce = '';

        while ($o = fgets($stream))
        {
            $responce .= $o;
        }

        return $responce;
    }

    public function pwd()
    {
        return $this->exec('pwd');
    }

    public function close()
    {
        return true;
    }
}