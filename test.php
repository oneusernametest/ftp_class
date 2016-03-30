<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('ftp.php');

$myFtp = new FTP('31.220.16.118','u303615875','123456');
$myFtp->connect();
//$myFtp->showLog();