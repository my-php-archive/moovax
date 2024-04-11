<?php
$title['default'] = $config['slogan'];
$error = '';
if(!$_GET['idco'] || !(int)$_GET['id']) { return $error = 'Faltan datos...';  }
if(!mysql_num_rows($co = mysql_query('SELECT * FROM `groups` WHERE `url` = \''.mysql_clean($_GET['idco']).'\''))) { return $error = 'La comunidad no existe'; }
$group = mysql_fetch_assoc($co);
if($group['status'] != '0') { return $error = 'La comunidad fue eliminada'; }
if($group['private'] == '1' && !$logged['id']) { return $error = 'Para ver esta comunidad primero debes registrarte'; }
$ismember = false;
if($logged['id']) {
  if(mysql_num_rows($m = mysql_query('SELECT id, `rank`, `status` FROM `groups_members` WHERE `group` = \''.$group['id'].'\' && `user` = \''.$logged['id'].'\''))) {
    list($idmember, $currentrank, $status) = mysql_fetch_row($m);
    if($status != 1) { $ismember = true; }
  }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\''))) {
    $error = 'Fuiste baneado de la comunidad';
  }
}
if(!mysql_num_rows($tem = mysql_query('SELECT * FROM `groups_topics` WHERE `id` = \''.(int)$_GET['id'].'\' && `group` = \''.$group['id'].'\''))) { return $error = 'El tema no existe'; }
$row = mysql_fetch_assoc($tem);
if(($row['private'] == 1 || $row['private'] == 2) && !$logged['id']) { return $error = 'Este tema es privado'; }
if($row['private'] == 2 && !$ismember) { return $error = 'Para ver este tema debes loguearte'; }
if($row['status'] != '0' && $currentrank != '4' && $currentrank != '5') { return $error = 'El tema se encuentra eliminado'; }
$title['default'] = $row['title'];
?>