<?php
if(!$_POST['id'] || !$_POST['type']) { die('0: Faltan datos guachon'); }
include('../config.php');
include('../functions.php');
if($_POST['type'] != 'post' && $_POST['type'] != 'foto') { die('0: Chupavergas'); }
if($_POST['type'] == 'post') {
  if(!allow('delete_posts')) { die('0: Andate a la concha de tu hermana'); }
  if(!mysql_num_rows($lll = mysql_query('SELECT `id`, `title`, `status` FROM `posts` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El post no existe'); }
  $row = mysql_fetch_row($lll);
  if($row[2] == '0') { die('0: El post no est&aacute; eliminado'); }
  $uss = mysql_fetch_assoc(mysql_query('SELECT rank FROM `users` WHERE `id` = \''.$row[2].'\''));
  if($uss['rank'] == '7') { die('0: No podes eliminar el post de un admin'); }
  mysql_query('DELETE FROM `posts` WHERE `id` = \''.$row[0].'\' LIMIT 1');
  mysql_query('DELETE FROM `history_mod` WHERE `post` = \''.$row[0].'\' && `type` = \'0\'');
  mysql_query('DELETE FROM `comments` WHERE `id_post` = \''.$row[0].'\'');
  mysql_query('DELETE FROM `favorites` WHERE `id_pf` = \''.$row[0].'\' && `type` = \'0\'');
} else {
  if(!allow('delete_photos')) { die('0: Andate a la concha de tu hermana'); }
  if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `status` FROM `photos` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La foto no existe'); }
  $row = mysql_fetch_row($query);
  if($row[1] == $logged['id']) { die('0: Tu eres el autor de esta foto'); }
  if($row[2] == '0') { die('0: Esta foto ya fue reactivada'); }
  mysql_query('DELETE FROM `photos` WHERE `id` = \''.$row[0].'\' LIMIT 1');
  mysql_query('DELETE FROM `history_mod` WHERE `post` = \''.$row[0].'\' && `type` = \'1\'');
}
die('1');