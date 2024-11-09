<?php

$sDbHost = 'localhost';
$sDbName = 'library';
$sDbUser = 'root';
$sDbPwd = '130505';

$dbConn = mysqli_connect ($sDbHost, $sDbUser, $sDbPwd) or die('Connection Failed');
mysqli_select_db($dbConn,$sDbName);
?>

