<?php
if(!$_GET['action']) { die('0: Faltan datos'); }
if(!$_GET['pm'] && ($_GET['action'] == 'delete' || $_GET['action'] == 'unread')) { die('0: Puto'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if($_GET['action'] != 'delete' && $_GET['action'] != 'unread' && $_GET['action'] != 'pmgs' && $_GET['action'] != 'send') { die('0: Cuentale eeer34'); }
if($_GET['action'] == 'delete') {
  //if(!$_GET['pm']) { die('0: Faltan datos'); }
  if(!mysql_num_rows($mps = mysql_query('SELECT `id`, `author`, `receiver`, `author_status`, `receiver_status`, `author_read`, `receiver_read` FROM `messages` WHERE `id` = \''.intval($_GET['pm']).'\''))) { die('0: El mensaje no existe'); }
  $pm = mysql_fetch_assoc($mps);
  if($pm['author'] != $logged['id'] && $pm['receiver'] != $logged['id']) { die('0: El mensaje no te pertenece ._.'); }
  if($pm['author'] == $logged['id']) { $where = 'author_status'; } else { $where = 'receiver_status'; } //donde buscamos?
  if($pm[$where] == 1) {
    mysql_query('UPDATE `messages` SET '.$where.' = \'2\' WHERE `id` = \''.$pm['id'].'\' LIMIT 1');
  } else {
    mysql_query('UPDATE `messages` SET `'.$where.'` = \'1\' WHERE `id` = \''.$pm['id'].'\'');
  }
} elseif($_GET['action'] == 'unread') {
  //if(!$_GET['pm']) { die('0: Faltan datos'); }
  if(!mysql_num_rows($mps = mysql_query('SELECT `id`, `author`, `receiver`, `author_status`, `receiver_status`, `author_read`, `receiver_read` FROM `messages` WHERE `id` = \''.intval($_GET['pm']).'\''))) { die('0: El mensaje no existe'); }
  $pm = mysql_fetch_assoc($mps);
  if($pm['author'] != $logged['id'] && $pm['receiver'] != $logged['id']) { die('0: El mensaje no te pertenece ._.'); }
  if($pm['author'] == $logged['id']) { $where = 'author_read'; } else { $where = 'receiver_read'; }
  if($pm[$where] == 0) { die('0: Este mensaje no fue le&iacute;do'); }
  mysql_query('UPDATE `messages` SET '.$where.' = \'0\' WHERE `id` = \''.$pm['id'].'\' LIMIT 1');
} else {
  if(!$_GET['para'] || !$_GET['mensaje']) { die('0: Faltan datoss'); }
  if(!$_GET['asunto']) { $_GET['asunto'] = 'Sin asunto'; } //Why not
  if(!mysql_num_rows($user = mysql_query('SELECT `id`, `nick`, `receive_pms` FROM `users` WHERE `nick` = \''.mysql_clean($_GET['para']).'\''))) { die('3: El usuario ingresado no existe'); }
  $ps = mysql_fetch_row($user);
  if($ps[0] == $logged['id']) { die('0: Que gracioso'); }
  if($ps[2] == '1') { die('0: El usuario no permite que le envien mensajes'); }
  if(strlen($_GET['mensaje']) < 20) { die('3: El mensaje debe tener al menos 20 caracteres'); }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `messages` WHERE `author` = \''.$logged['id'].'\' && `time` > \''.(time()-160).'\''))) { die('2: Espera unos minutos para enviar otro mp'); }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `author` = \''.$ps[0].'\' && `user` = \''.$logged['id'].'\''))) { die('0: Te has portado mal, este wey te a bloqueado'); }
  mysql_query('INSERT INTO `messages` (`author`, `receiver`, `issue`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$ps[0].'\', \''.mysql_clean($_GET['asunto']).'\', \''.mysql_clean($_GET['mensaje']).'\', \''.time().'\')') or die('0: '.mysql_error());
  die('1: El mensaje fue enviado a '.$ps[1]);
}
if($_GET['ajax']) {
  echo '1:';
} else {
  header('location: /mensajes');
}