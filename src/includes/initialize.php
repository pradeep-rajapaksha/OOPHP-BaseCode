<?php 
date_default_timezone_set('Asia/Colombo');

defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT','C:/xampp/htdocs/LAB/OOPHP2/PhotoGallery2/');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.'includes/');

// Load config file first
require_once(LIB_PATH."config.php");

// Load basic functions
require_once(LIB_PATH."functions.php");

// load core objects
require_once(LIB_PATH."session.php");
require_once(LIB_PATH."database.php");
require_once(LIB_PATH."databaseobject.php");
require_once(LIB_PATH."pagination.php");

// load database related classes
require_once(LIB_PATH."user.php");
require_once(LIB_PATH."photograph.php");
require_once(LIB_PATH."comment.php");
?>