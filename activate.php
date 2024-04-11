<?php
if(!$_GET['hash'] || !$_GET['mail']) { header('location: /index.php'); }
include('config.php');
include('functions.php');
if(!mysql_num_rows($activate = mysql_query('SELECT `id_user`, `mail` FROM `mails` WHERE `hash` = \''.mysql_clean($_GET['hash']).'\' && `mail` = \''.mysql_clean(str_replace('-', '@', $_GET['mail'])).'\' && `type` = \'0\'')));
$row = mysql_fetch_row($activate);
if(!mysql_num_rows($users = mysql_query('SELECT `id`, `act`, `ban`, password FROM `users` WHERE `id` = \''.intval($row[0]).'\''))) { die('Usted no existe'); }
$user = mysql_fetch_assoc($users);
if($user['ban'] != '0') { die('Usted fue baneado'); }
if($user['act'] == '1') { die('Su cuenta ya fue activada'); }
mysql_query('UPDATE `users` SET `act` = \'1\' WHERE `id` = \''.$user['id'].'\'');
mysql_query('DELETE FROM `mails` WHERE `id_user` = \''.$row[0].'\' && `type` = \'0\'');
setcookie($config['cookie_name'], $user['id'].'%'.$user['password'], time()+8000, '/');
header('location: /cuenta');
?>