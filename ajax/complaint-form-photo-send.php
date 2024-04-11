<?php
if(!isset($_POST['razon']) || !$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!ctype_digit($_POST['razon']) || $_POST['razon'] > 7) { die('0: Error provocado'); }
if(!mysql_num_rows($pq = mysql_query('SELECT `id`, `author`, `status` FROM `photos` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La foto no existe'); }
$row = mysql_fetch_row($pq);
if($row[1] == $logged['id']) { die('0: No es posible denunciar tu foto'); }
if($row[2] != 0) { die('0: La foto fue eliminada'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `complaints` WHERE `author` = \''.$logged['id'].'\' && `id_post` = \''.$row[0].'\' && `what` = \'1\''))) { die('0: Ya haz denunciado esta foto'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `complaints` WHERE `time` > \''.(time()-120).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Debes esperar para realizar otra denuncia'); }
if(strlen($_POST['comentario']) > 255) { die('0: El comentario excede los 255 caracteres'); }
mysql_query('INSERT INTO `complaints` (`type`, `author`, `id_post`, `what`, `comment`, `time`) VALUES (\''.$_POST['razon'].'\', \''.$logged['id'].'\', \''.$row[0].'\', \'1\', \''.mysql_clean($_POST['comentario']).'\', \''.time().'\')') or die('0: '.mysql_error());
die('1: La foto ha sido denunciada con &eacute;xito!');