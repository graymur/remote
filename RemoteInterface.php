<?php
/**
 * Created by Graymur
 * Date: 17.10.2014
 * Time: 11:03
 */

namespace Graymur\Remote;

interface RemoteInterface
{
    public function connect();
    public function upload($source, $target);
    public function download($source, $target, $mode = null);
    public function rename($old, $new);
    public function delete($filename);
    public function stat($filename);
    public function exec($cmd);
    public function cd($directory);
    public function filesize($filename);
    public function close();
    public function pwd();
}