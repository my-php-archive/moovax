<?php
include('config.php');
include('functions.php');
$ip = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDER_FOR'];
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `ips_ban` WHERE `ip` = \''.mysql_clean($ip).'\''))) {
  mysql_query('INSERT INTO `ips_ban` (`ip`, `type`, `time`, `author`) VALUES (\''.mysql_clean($ip).'\', \'1\', \''.time().'\', \'1\')');
}
if($_GET['few']) { header('location: /'); die; } 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8">
 <title>HELLO!</title>
 <script type="text/javascript">
<!--
if (self.parent.frames.length && self.parent.frames.length != 0) self.parent.location = document.location;
neva = "HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!\n\
HELLO!";
if(window.opera){
  window.onkeydown = function(e){
    if(e.keyCode != 18 && e.keyCode != 27 && e.keyCode != 32 && e.keyCode !=  115){
      if(Math.random() > .5) for(var i = 0; i < 35; i++) document.getElementById('roll').Back();
      else for(var i = 0; i < 53; i++) document.getElementById('roll').Forward();
      document.getElementById('roll').Play();
    }
    else if(e.keyCode == 115){
      for(x in neva.split('\n')){
        alert(neva.split('\n')[x]);
      }
    }
    return false;
  }
}else{
  window.onkeydown = function(e){
    if(e.keyCode !=  13 && e.keyCode != 27 && e.keyCode != 32){
      if(Math.random() > .5) for(var i = 0; i < 35; i++) document.getElementById('roll').Back();
      else for(var i = 0; i < 53; i++) document.getElementById('roll').Forward();
      document.getElementById('roll').Play();
    }
    return false;
  }
}
/* document.onkeydown = function(){
  for(var i = 0; i < 35; i++) document.getElementById('roll').Back();
  document.getElementById('roll').Play();
  return false;
} */
window.resizeTo(640,600);
window.moveTo(0,0);
for (i = 1; i <= 800; i++){
setTimeout('window.moveTo(1599,1199);', i+"000");
i++;
setTimeout('window.moveTo(0,1199);', i+"000");
i++;
setTimeout('window.moveTo(1599,0);', i+"000");
i++;
setTimeout('window.moveTo(0,0);', i+"000");
}
//-->
</script>
</head>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18361677-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<body onbeforeunload="for(x in neva.split('\n')){ alert(neva.split('\n')[x]); } return false;">
<script type="text/javascript">
<!--
if(window.attachEvent){
  document.body.onkeydown = function(){
    if(Math.random() > .5) for(var i = 0; i < 35; i++) document.getElementById('roll').Back();
    else for(var i = 0; i < 53; i++) document.getElementById('roll').Forward();
    document.getElementById('roll').Play();
    return false;
  }
}
//-->
</script>
<div style="text-align: center;"><embed id="roll" src="batman.swf" width="400" height="300"></embed></div>
<p style="text-align: center; font-size: 32pt;">HELLO!<br></p>
<p style="text-align: center; font-size: 16pt;"><a href="http://open.spotify.com/track/5ME41QPTAuRFpYpybS2eyx">Listen to this track legally on Spotify</a></p>
</body>
</html>