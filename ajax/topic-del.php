<?php
$cause = trim($_POST['causa']);
if((!$cause && $_POST['action'] == 'eliminar') || !(int)$_POST['tema'] || !$_POST['action']) { die('0: Faltan datos turrito'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Faltan datos'); }
if(substr($cause, 0, 17) == 'Causa del borrado') { die('0: Que gracioso!'); }
if(!mysql_num_rows($te = mysql_query('SELECT `id`, `author`, `status`, `group`, `title` FROM `groups_topics` WHERE `id` = \''.(int)$_POST['tema'].'\''))) { die('0: El tema no existe'); }
list($id, $author, $status, $group, $title) = mysql_fetch_row($te);
$GgG = mysql_fetch_assoc(mysql_query('SELECT * FROM `groups` WHERE `id` = \''.$group.'\''));
if(!mysql_num_rows($g = mysql_query('SELECT `id`, `rank` FROM `groups_members` WHERE `group` = \''.$group.'\' && `user` = \''.$logged['id'].'\' && `status` = \'0\'')) && !allow('elimtopic')) {
  die('0: Debes ser miembro para realizar esta acci&oacute;n');
}
if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group.'\''))) { die; }
list($idmember, $currentrank) = mysql_fetch_row($g);
if($_POST['action'] == 'eliminar') {
  if($status != '0') { die('0: Este tema ya fue eliminado'); }
  if($author != $logged['id'] && !allow('elimtopic') && $curretrank != '4' && $currentrank != '5') { die('0: No tienes permisos para borrar esto'); }
  if($author != $logged['id']) {
    $body = 'Hola! lamento contarte que tu tema titulado: '.$title.' a sido borrado'."\n".'Causa: '.$cause."\n".'Gracias por comprender';
    mysql_query('INSERT INTO `messages` (`author`, `receiver`, `issue`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$author.'\', \'Tema eliminado\', \''.mysql_clean($body).'\', \''.time().'\')') or die('0: few'.mysql_error());
  }
  mysql_query('UPDATE `groups_topics` SET `status` = \'1\' WHERE `id` = \''.$id.'\'');
  mysql_query('INSERT INTO `groups_actions` (`author`, `group`, `action`, `title`, `url`, `reason`, `time`) VALUES (\''.$logged['id'].'\', \''.$group.'\', \'1\', \''.$title.'\', \'/comunidades/'.$GgG['url'].'/'.$id.'/'.url($title).'.html\', \''.mysql_clean($cause).'\', \''.time().'\')') or die('0: '.mysql_error());
  echo '1: Tema eliminado!';
  mysql_query('DELETE FROM `activity` WHERE `what` = \''.$id.'\' && (`type` = \'3\' || `type` = \'4\')') or die('0: '.mysql_error());
} else {
  if($status != '1') { die('0: El tema no se encuentra eliminado'); }
  if($author != $logged['id'] && $currentrank != 5 && $currentrank != 4 && !allow('elimtopic')) { die('0: No es posible reactivar este tema'); }
  mysql_query('UPDATE `groups_topics` SET `status` = \'0\' WHERE `id` = \''.$id.'\'') or die('0: few'.mysql_error());
  mysql_query('INSERT INTO `groups_actions` (`author`, `group`, `action`, `title`, `url`, `time`) VALUES (\''.$logged['id'].'\', \''.$group.'\', \'4\', \''.$title.'\', \'/comunidades/'.$GgG['url'].'/'.$id.'/'.url($title).'.html\', \''.time().'\')') or die('0: '.mysql_error());
  echo '1: El tema fue reactivado con &eacute;xito';
}