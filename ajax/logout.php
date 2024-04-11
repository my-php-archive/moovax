<?php
include('../config.php');
include('../functions.php');
if(!$key) { die('0: Usted no esta logueado -atroll'); }
setcookie($config['cookie_name'], 'xxx', 0, '/');
$ip = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDED_FOR'];
mysql_query('UPDATE `online` SET `user` = \'0\' WHERE `ip` = \''.mysql_clean($ip).'\'');
if($_GET['nope']) { header('location: /'); }  else { echo '1'; }
?>