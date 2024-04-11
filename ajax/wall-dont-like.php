<?php
if(!$_POST['id'] || !$_POST['tipo']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if($_POST['tipo'] == 'comment') {
  if(!mysql_num_rows($pq = mysql_query('SELECT id, author, profile FROM `walls` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El comentrio no existe'); }
  list($id_c, $author_c, $profile_c) = mysql_fetch_row($pq);
  if($author_c == $logged['id']) { die('0: Tu eres el autor del comentario :/'); }
  if(!mysql_num_rows($ppp = mysql_query('SELECT `id` FROM `w_likes` WHERE `author` = \''.$logged['id'].'\' && `what` = \''.$id_c.'\' && `type` = \'0\''))) { die('0: Tu nunca le has dado me gusta a esta publicacio&oacute;n'); }
  $pq = mysql_fetch_row($ppp);
  mysql_query('DELETE FROM `w_likes` WHERE `id` = \''.$pq[0].'\' LIMIT 1');
  //mysql_query('DELETE FROM `notifications` WHERE `')
} else {
  if(!mysql_num_rows($pq = mysql_query('SELECT `id`, `author`, `what` FROM `w_replies` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La respuesta no existe'); }
  list($id, $author, $what) = mysql_fetch_row($pq);
  if($author == $logged['id']) { die; }
  if(!mysql_num_rows($pqqq = mysql_query('SELECT `id` FROM `w_likes` WHERE `author` = \''.$logged['id'].'\' && `what` = \''.$id.'\' && `type` = \'1\''))) { die; }
  $er = mysql_fetch_row($pqqq);
  mysql_query('DELETE FROM `w_likes` WHERE `id` = \''.$er[0].'\' LIMIT 1');
}
echo '1: No te gusta esto';