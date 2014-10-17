<?php
/**
 * Created by Graymur
 * Date: 17.10.2014
 * Time: 11:42
 */

spl_autoload_register(function ($className) {
    include_once('..' . DIRECTORY_SEPARATOR . str_replace('Graymur\\Remote\\', '', $className) . '.php');
});

use \Graymur\Remote\Factory;

$ftpConnection = Factory::get('FTP', '', '', '');