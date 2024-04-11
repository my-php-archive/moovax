<?php
if(!$_POST['id'] || !$_POST['post'] || !$_POST['user'] || !$_POST['score'] || !$_POST['type']) { die('0: Faltan datos :D!(?'); }
include('../config.php');
include('../functions.php');
if(!$logged['id'] || $_POST['user'] != $logged['id']) { die('0: Debes de estar logueado'); }
if($_POST['score'] != '1' && $_POST['score'] != '-1') { die('0: Error provocado mijo'); }
if(!mysql_num_rows($ppp = mysql_query('SELECT `id`, `status`, `cat`, `title` FROM `posts` WHERE `id` = \''.intval($_POST['post']).'\''))) { die('0: El post no existe'); }
list($id_p, $status_p, $cat_p, $title_p) = mysql_fetch_row($ppp);
if($status_p != '0') { die('0: El post est&aacute; eliminado'); }
if(!mysql_num_rows($ccc = mysql_query('SELECT `id`, `author` FROM `comments` WHERE `id` = \''.intval($_POST['id']).'\' && `id_post` = \''.$id_p.'\''))) { die('0: El comentario no existe'); }
$row = mysql_fetch_assoc($ccc);
if($row['author'] == $key) { die('0: No es posible votar tus propios comentarios mijo'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `c_votes` WHERE `author` = \''.$logged['id'].'\' && `comment` = \''.$row['id'].'\''))) { die('0: Ya hab&iacute;as votado este comentario antes'); }
if(mysql_num_rows(mysql_query('SELECT `time` FROM `c_votes` WHERE `time` > \''.(time()-20).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Debes esperar 20 segundos para volver a votar'); }
/*****************************************************************************/
mysql_query('UPDATE `comments` SET '.($_POST['score'] == '1' ? '`positive` = `positive`+1' : '`negative` = `negative` +1').' WHERE `id` = \''.$row['id'].'\'');
mysql_query('INSERT INTO `c_votes` (`author`, `comment`, `type`, `time`) VALUES (\''.$logged['id'].'\', \''.$row['id'].'\', \''.($_POST['score'] == '1' ? '1' : '-1').'\', \''.time().'\')');
$cat = mysql_fetch_row(mysql_query('SELECT `url` FROM `categories` WHERE `id` = \''.$cat_p.'\''));
$url = '/posts/'.$cat[0].'/'.$id_p.'/'.url($title_p).'.html';
mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$row['author'].'\', \'8\', \''.$url.'#cmt_'.$row['id'].'$'.($_POST['score'] == '1' ? '0' : '1').'\', \'0\', \''.time().'\', \''.$title_p.'\')') or die('0: '.mysql_error());
die('1');