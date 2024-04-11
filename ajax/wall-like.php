<?php
if(!$_POST['id'] || !$_POST['tipo']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate macho'); }
if(!ctype_digit($_POST['id']) || ($_POST['tipo'] != 'comment' && $_POST['tipo'] != 'sub_comment')) { die; }
if($_POST['tipo'] == 'comment') {
  if(!mysql_num_rows($pq = mysql_query('SELECT `id`, `author`, `profile` FROM `walls` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: No existe'); }
  list($id, $author, $profile) = mysql_fetch_row($pq);
  if($author == $logged['id']) { die('0: No puedes votar tu publicaci&oacute;n'); }
  //if(mysql_num_rows(mysql_query('SELECT `id` FROM `w_likes` WHERE `time` > \''.(time()-60).'\' && `type` = \'0\' && `author` = \''.$logged['id'].'\''))) { die('0: Tienes que esperar para volver a votar'); }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `w_likes` WHERE `what` = \''.$id.'\' && `author` = \''.$logged['id'].'\' && `type` = \'0\''))) { die('0: Ya has votado esto'); }
  mysql_query('INSERT INTO `w_likes` (`author`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$id.'\', \''.time().'\', \'0\')');
  //$id = mysql_insert_id();
  $pq = mysql_fetch_row(mysql_query('SELECT nick FROM `users` WHERE `id` = \''.$profile.'\''));
  $uri = '/'.$pq[0].'/muro/'.$id;
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$author.'\', \'11\', \''.$uri.'\', \'0\', \''.time().'\', \''.$pq[0].'\')');
  mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$pq[0].'\', \''.$uri.'\', \''.$id.'\', \''.time().'\', \'14\')');
} else {
  if(!mysql_num_rows($pq = mysql_query('SELECT `id`, `author`, `what` FROM `w_replies` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La respuesta no existe'); }
  $rw = mysql_fetch_assoc($pq);
  if($rw['author'] == $logged['id']) { die('0: No es posible votar tu comentario'); }
  if(mysql_num_rows(mysql_query('SELECT `time` FROM `w_likes` WHERE `author` = \''.$logged['id'].'\' && `time` > \''.(time()-60).'\' && `type` = \'1\''))) { die('0: Debes esperar para volver a votar'); }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `w_likes` WHERE `author` = \''.$logged['id'].'\' && `what` = \''.$rw['id'].'\' && `type` = \'1\''))) { die('0: Ya votaste esto'); }
  mysql_query('INSERT INTO `w_likes` (`author`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$rw['id'].'\', \''.time().'\', \'1\')');
  //$id = mysql_insert_id();
}
die('1: Te gusta esto');
?>