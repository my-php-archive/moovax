<?php
if(!$_POST['id'] || !$_POST['pass1'] || !$_POST['pass2'] || !$_POST['mail']) { die('0: Faltan datos, pete'); }
include('../config.php');
include('../functions.php');
if($logged['id']) { die; }
if($_POST['pass1'] != $_POST['pass2']) { die('0: Las contrase&ntilde;as no coinciden'); }
if(!mysql_num_rows($pq = mysql_query('SELECT * FROM `mails` WHERE `hash` = \''.mysql_clean($_POST['id']).'\' && `type` = \'1\''))) { die('0: Error provocado'); }
$stq = mysql_fetch_assoc($pq);
if($_POST['mail'] != $stq['mail']) { die('0: Error provocado'); }
$q = mysql_fetch_row(mysql_query('SELECT `id`, `ban` FROM `users` WHERE `id` = \''.$stq['id_user'].'\''));
if($q[1] == 1) { die('0: El usuario se encuentra baneado'); }
if(strlen($_POST['pass1']) < 3 || strlen($_POST['pass1']) > 34) { die('0: La contrase&ntilde;a debe tener entre 3 y 34 caracteres'); }
mysql_query('UPDATE `users` SET `password` = \''.md5($_POST['pass1']).'\' WHERE `id` = \''.$q[0].'\' LIMIT 1');
mysql_query('DELETE FROM `mails` WHERE `id` = \''.$stq['id'].'\'');
die('1: La contrase&ntilde;a a sido cambiada con &eacute;xito');