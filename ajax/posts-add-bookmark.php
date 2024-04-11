<?php
if(!$_POST['post'] || !ctype_digit($_POST['post'])) { die('0: El campo post es requerido'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: No est&aacute;s logueado'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `status`, `cat`, `title` FROM `posts` WHERE `id` = \''.intval($_POST['post']).'\''))) { die('0: El post est&aacute; eliminado'); }
$row = mysql_fetch_row($query);
if($row[1] == $logged['id']) { die('0: No puedes agregar tus posts a favoritos'); }
if($row[2] != '0') { die('0: El post est&aacute; eliminado'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `favorites` WHERE `id_pf` = \''.$row[0].'\' && `author` = \''.$key.'\' && `status` = \'0\' && `type` = \'0\''))) { die('0: Ya hab&iacute;as agregado a favoritos este post ::)'); }
//if(mysql_num_rows(mysql_query('SELECT `time` FROM `favorites` WHERE `time` > \''.(time()-120).'\' && `author` = \''.$key.'\''))) { die('0: No pod&eacute;s realizar tantas acciones'); }
mysql_query('INSERT INTO `favorites` (`author`, `id_pf`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$row[0].'\', \''.time().'\', \'0\')');
$cat = mysql_fetch_row(mysql_query('SELECT `url` FROM `categories` WHERE `id` = \''.$row[3].'\''));
mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$row[1].'\', \'1\', \'/posts/'.$cat[0].'/'.$row[0].'/'.url($row[4]).'.html\', \'0\', \''.time().'\', \''.$row[4].'\')') or die('0: '.mysql_error());
die('1: El post fue agregado a favoritos satisfactoriamente');
?>