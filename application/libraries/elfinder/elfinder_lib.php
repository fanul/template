<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
require_once 'elFinderConnector.class.php';
require_once 'elFinder.class.php';
require_once 'elFinderVolumeDriver.class.php';
require_once 'elFinderVolumeLocalFileSystem.class.php';
*/
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'elFinderConnector.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'elFinder.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'elFinderVolumeLocalFileSystem.class.php';

class Elfinder_lib {

    public function __construct($opts) {
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }

}