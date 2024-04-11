<?php
if(!$_POST['id']) { die('0: Faltan datos flanders'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: El usuario no est&aacute; logueado'); }
if(!mysql_num_rows($pq = mysql_query('SELECT `id`, `author`, `what` FROM `w_replies` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La respuesta ingresada no existe'); }
$row = mysql_fetch_row($pq);
if(!mysql_num_rows($pp = mysql_query('SELECT `profile` FROM `walls` WHERE `id` = \''.$row[2].'\''))) { die('0: La respuesta no existe'); }
$r = mysql_fetch_assoc($pp);
if($row[1] != $logged['id'] && !allow('delete_comments') && $r['profile'] != $logged['id']) { die('0: No tenes permisos para borrar esto'); }
mysql_query('DELETE FROM `w_replies` WHERE `id` = \''.$row[0].'\' LIMIT 1');
mysql_query('DELETE FROM `notifications` WHERE `url` REGEXP \'/.*/muro/'.$row[2].'\' && (`type` = \'9\' || `type` = \'10\')') or die('0: '.mysql_error());
mysql_query('DELETE FROM `w_likes` WHERE `what` = \''.$row[0].'\' && `type` = \'1\'');
die('1: Borrado');