<?php
if(!$_POST['foto'] || !$_POST['puntos']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!ctype_digit($_POST['puntos']) || !ctype_digit($_POST['foto'])) { die; }
if($_POST['puntos'] > 10 || $_POST['puntos'] < 1) { die('0: Chupame la pija'); }
if(!mysql_num_rows($q = mysql_query('SELECT `id`, `author`, `status`, `title`, `cat` FROM `photos` WHERE `id` = \''.intval($_POST['foto']).'\''))) { die('0: La foto no existe'); }
$pr = mysql_fetch_row($q);
if($pr[1] == $logged['id']) { die('0: Te vamos a dar el premio al vivo del año'); }
//if($pr[2] != 0) { die('0: La foto est&aacute; eliminada'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `p_votes` WHERE `photo` = \''.$pr[0].'\' && `author` = \''.$logged['id'].'\''))) { die('0: Ya votaste esto'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `p_votes` WHERE `time` > \''.(time()-60).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Debes esperar para volver a votar'); }
if($logged['points2'] < $_POST['puntos']) { die('0: No te quedan esta cantidad de puntos'); }
mysql_query('INSERT INTO `p_votes` (`author`, `photo`, `points`, `time`) VALUES (\''.$logged['id'].'\', \''.$pr[0].'\', \''.intval($_POST['puntos']).'\', \''.time().'\')') or die('0: '.mysql_error());
mysql_query('UPDATE `users` SET `points2` = \''.($logged['points2']-$_POST['puntos']).'-'.date('dmy').'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1') or die('0: '.mysql_error());
mysql_query('UPDATE `photos` SET `votes` = `votes` + '.intval($_POST['puntos']).' WHERE `id` = \''.$pr[0].'\' LIMIT 1') or die('0: '.mysql_error());
mysql_query('UPDATE `users` SET `points` = `points` + '.intval($_POST['puntos']).' WHERE `id` = \''.$pr[1].'\'');
$cat = mysql_fetch_row(mysql_query('SELECT `url` FROM `p_categories` WHERE `id` = \''.$pr[4].'\''));
$url = '/fotos/'.$cat[0].'/'.$pr[0].'/'.url($pr[3]).'.html#'.intval($_POST['puntos']);
mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$pr[1].'\', \'14\', \''.$url.'\', \'0\', \''.time().'\', \''.$pr[3].'\')');
die('1: Votado satisfactoriamente');
?>