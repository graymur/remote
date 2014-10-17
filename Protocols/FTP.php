<?php
/**
 * Created by Graymur
 * Date: 17.10.2014
 * Time: 11:36
 */

namespace Graymur\Remote\Protocols;

use Graymur\Remote\RemoteException;

class FTP extends \Graymur\Remote\RemoteAbstract
{
    protected $port = 21;

    public function connect()
    {
        if (!$this->link = ftp_connect($this->server))
        {
            throw new RemoteException('Failed to connect to FTP server in ' . __METHOD__);
        }

        if (!ftp_login($this->link, $this->login, $this->password))
        {
            throw new RemoteException('Failed to login to FTP server in ' . __METHOD__);
        }

        return 0;
    }

    /**
     * @param $source
     * @param $target
     * @param null $mode
     * @return bool
     */
    public function upload($source, $target, $mode = null)
    {
        if (empty($mode)) $mode = FTP_BINARY;
        return ftp_put($this->link, $target, $source, $mode);
    }

    /**
     * @param $source
     * @param $target
     * @param null $mode
     * @return bool
     */
    public function download($source, $target, $mode = null)
    {
        if (empty($mode)) $mode = FTP_BINARY;
        $check = ftp_get($this->link, $target, $source, $mode);
        return file_exists($target);
    }

    /**
     * @param $old
     * @param $new
     * @return bool
     */
    public function rename($old, $new)
    {
        return ftp_rename($this->link, $old, $new);
    }

    /**
     * @param $filename
     * @return bool
     */
    public function delete($filename)
    {
        return ftp_delete($this->link, $filename);
    }

    public function stat($filename) {}

    /**
     * @param $cmd
     * @return bool
     */
    public function exec($cmd)
    {
        return ftp_exec($this->link, $cmd);
    }

    /**
     * @param $directory
     * @return bool
     */
    public function cd($directory)
    {
        return ftp_chdir($this->link, $directory);
    }

    /**
     * @return string
     */
    public function pwd()
    {
        return ftp_pwd($this->link);
    }

    /**
     * @param $filename
     * @return int
     */
    public function filesize($filename)
    {
        return ftp_size($this->link, $filename);
    }

    /**
     * @return bool
     */
    public function close()
    {
        return ftp_close($this->link);
    }
}