<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require_once('ftp.php');
$file = 'archivo.txt';
$file_remote = 'remote.txt';

$myFtp = new FTP('31.220.16.118','u303615875','123456');
$myFtp->uploadFile($file);
$myFtp->renameFile($file,'nuevo.txt');
//$myFtp->deleteFile($file);
echo $myFtp->sizeOfFile($file_remote);
$myFtp->closeConnection();
$myFtp->showLog();