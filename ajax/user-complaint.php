<?php
if(!isset($_POST['razon']) || !$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!mysql_num_rows($ppp = mysql_query('SELECT `id`, `nick`, `ban`, `act` FROM `users` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El usuario no existe'); }
$qt = mysql_fetch_row($ppp);
if($qt[2] == 1) { die('0: Este usuario ya se encuentra baneado'); }
if($qt[3] == 0) { die('0: Este usuario no tiene su cuenta activa'); }
if($qt[0] == $logged['id']) { die; }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `complaints` WHERE `status` = \'0\' && `author` = \''.$logged['id'].'\' && `id_post` = \''.$qt[0].'\' && `what` = \'2\''))) { die('0: Ya hab&iacute;as denunciado este usuario antes'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `complaints` WHERE `time` > \''.(time()-120).'\' && `type` = \'2\''))) { die('0: Debes esperar para denunciar otro usuario'); }
if($_POST['razon'] > 5 || !ctype_digit($_POST['razon'])) { die('0: Error provocado'); }
mysql_query('INSERT INTO `complaints` (`type`, `author`, `num`, `id_post`, `what`, `comment`, `status`, `time`) VALUES (\''.$_POST['razon'].'\', \''.$logged['id'].'\', \'0\', \''.$qt[0].'\', \'2\', \''.mysql_clean($_POST['comentario']).'\', \'0\', \''.time().'\')');
die('1: El usuario '.$qt[1].' ha sido denunciado exitosamente.');