<?php
if(!$_POST['user']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes estar logueado para realizar esta acci&oacute;n'); }
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `users` WHERE `id` = \''.mysql_clean($_POST['user']).'\''))) { die('0: El usuario no existe'); }
if($_POST['user'] == $logged['id']) { die('0: WTF?'); }
if(!mysql_num_rows($r = mysql_query('SELECT `id`, `user`, `status` FROM `friends` WHERE (`user` = \''.$logged['id'].'\' && `author` = \''.mysql_clean($_POST['user']).'\') || (`user` = \''.mysql_clean($_POST['user']).'\' && `author` = \''.$logged['id'].'\')'))) { die('0: El amigo no existe'); }
$rs = mysql_fetch_row($r);
if($rs[2] != '1') { die('0: El amigo nunca acept&oacute; tu solicitud'); }
mysql_query('DELETE FROM `friends` WHERE `id` = \''.$rs[0].'\'');
die('1: Amigo borrado');