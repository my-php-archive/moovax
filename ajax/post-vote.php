<?php
if(!$_POST['post'] || !$_POST['puntos']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if($_POST['puntos'] > 10 || $_POST['puntos'] < 1 || !ctype_digit($_POST['puntos'])) { die('0: Que haces cabeza?'); }
if(!$logged['id']) { die('0: No est&aacute;s logueado'); }
if(!allow('add_points')) { die('0: Tu rango no te permite dar puntos'); }
if(!mysql_num_rows($ppp = mysql_query('SELECT `id`, `author`, `status`, `title`, `cat` FROM `posts` WHERE `id` = \''.intval($_POST['post']).'\''))) { die('0: El post ingresado no existe'); }
$row = mysql_fetch_row($ppp);
if($row[1] == $logged['id']) { die('0: No es posible votar tus propios posts'); }
if($row[2] != '0') { die('0: El post est&aacute; eliminado'); }
if($logged['points2'] < $_POST['puntos']) { die('0: No tienes esa cantidad de puntos disponible'); }
if($logged['points2'] < 1) { die('0: No te queda puntos'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `votes` WHERE `id_post` = \''.$row[0].'\' && `author` = \''.$logged['id'].'\''))) { die('0: Ya hab&iacute;as votado este post antes'); }
if(mysql_num_rows(mysql_query('SELECT `time` FROM `votes` WHERE `time` = \''.(time()-30).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Debes esperar 30 segundos para volver a votar'); }
mysql_query('UPDATE `users` SET `points` = `points` + \''.intval($_POST['puntos']).'\' WHERE `id` = \''.$row[1].'\'');
mysql_query('UPDATE `users` SET `points2` = \''.($logged['points2']-$_POST['puntos']).'-'.date('dmy').'\' WHERE `id` = \''.$key.'\'');
mysql_query('INSERT INTO `votes` (`id_post`, `time`, `author`, `points`) VALUES (\''.$row[0].'\', \''.time().'\', \''.$logged['id'].'\', \''.intval($_POST['puntos']).'\')');
mysql_query('UPDATE `posts` SET `points` = `points` + \''.$_POST['puntos'].'\' WHERE `id` = \''.$row[0].'\' LIMIT 1');
$cat = mysql_fetch_row(mysql_query('SELECT `url` FROM `categories` WHERE `id` = \''.$row[4].'\''));
$url = '/posts/'.$cat[0].'/'.$row[0].'/'.url($row[3]).'.html@$'.intval($_POST['puntos']);
mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$row[1].'\', \'2\', \''.$url.'\', \'0\', \''.time().'\', \''.$row[3].'\')');
mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$row[3].'\', \''.$url.'\', \''.$row[0].'\', \''.time().'\', \'11\')');
die('1: El post fue votado satisfactoramente');
?>