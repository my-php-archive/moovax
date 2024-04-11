<?php
include('../config.php');
include('../functions.php');
if(!$_GET['id'] || !$_GET['tipo']) { die('0: El campo id y tipo son requeridos'); }
if($_GET['tipo'] != 'post' && $_GET['tipo'] != 'foto') { die('0: Error provocado -mmm'); }
if(!ctype_digit($_GET['id'])) { die('0: Sos puto'); }
if($_GET['tipo'] == 'post') {
  if(!allow('delete_posts')) { die('Anda a cagar mayonesa'); }
  if(!mysql_num_rows($query = mysql_query('SELECT `id`, `status`, `author`, `title` FROM `posts` WHERE `id` = \''.intval($_GET['id']).'\''))) { die('0: El post no existe'); }
  $row = mysql_fetch_assoc($query);
  if($row['status'] == '0') { die('0: El post no se encuentra eliminado'); }
  if($row['author'] == $logged['id']) { die('0: Tu eres el autor del post'); }
  $mod = mysql_fetch_assoc(mysql_query('SELECT `moderador` FROM `history_mod` WHERE `post` = \''.$row['id'].'\''));
  //if($mod[0] != $logged['id'] && $logged['rank'] != 8) { die('0: Este post no fue eliminado por ti, por lo tanto debes pedirle a un administrador que lo reactive'); }
  mysql_query('UPDATE `posts` SET `status` = \'0\' WHERE `id` = \''.$row['id'].'\' LIMIT 1');
  mysql_query('DELETE FROM `history_mod` WHERE `post` = \''.$row['id'].'\' && `type` = \'0\'');
  $body = 'Su post titulado [url=/?page=post&id='.$row['id'].']'.mysql_clean($row['title']).'[/url] a sido reactivado'."\n";
  $body .= 'El equipo de '.$config['name'];
  $title = 'Post reactivado';
} else {
  if(!allow('delete_photos')) { die('0: No tienes permisos'); }
  /* ORLY? */
  if(!mysql_num_rows($it = mysql_query('SELECT `id`, `title`, `author`, `status` FROM `photos` WHERE `id` = \''.intval($_GET['id']).'\''))) { die('0: La foto ingresada no existe'); }
  $row = mysql_fetch_assoc($it);
  if($row['author'] == $logged['id']) { die('0: No puedes reactivar una foto tuya'); }
  if($row['status'] != '1') { die('0: Esta foto no est&aacute; eliminada'); }
  mysql_query('UPDATE `photos` SET `status` = \'0\' WHERE `id` = \''.$row['id'].'\' LIMIT 1');
  mysql_query('DELETE FROM `history_mod` WHERE `post` = \''.$row['id'].'\' && `type` = \'1\'');
  $body = "Su foto titulada \"".$row['title']."\" a sido reactivada.\nEl equipo de ".$config['name'];
  $title = 'Foto reactivada';
}
mysql_query('INSERT INTO `messages` (`author`, `receiver`, `issue`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$row['author'].'\', \''.$title.'\', \''.$body.'\', \''.time().'\')');
die('1: Hecho');