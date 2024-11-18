<?php

$sDbHost = 'localhost';
$sDbName = 'library';
$sDbUser = 'root';
$sDbPwd = '130505';
$sDbPort = '3306';
$dbConn = mysqli_connect($sDbHost, $sDbUser, $sDbPwd, $sDbName, $sDbPort) or die('Connection Failed');
?>
