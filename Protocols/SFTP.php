<?php
/**
 * Created by Graymur
 * Date: 17.10.2014
 * Time: 11:36
 */

namespace Graymur\Remote\Protocols;

use Graymur\Remote\RemoteException;

class SFTP extends SSH
{
    public function download($source, $target, $mode = null)
    {
        $fileResource = "ssh2.sftp://{$this->sftp}/$source";

        $stream = fopen($fileResource, 'r');

        if (!$stream)
        {
            throw new RemoteException("Could not open file: $source in " . __METHOD__);
        }

        $size = filesize($fileResource);

        $contents = '';
        $read = 0;
        $len = $size;

        while ($read < $len && ($buf = fread($stream, $len - $read)))
        {
            $read += strlen($buf);
            $contents .= $buf;
        }

        file_put_contents($target, $contents);

        return file_exists($target);
    }
}