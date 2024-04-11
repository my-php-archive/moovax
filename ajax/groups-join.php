<?php
if(!$_POST['id'] || !$_POST['sa']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `status`, `author`, `rankdefault`, `name`, `url` FROM `groups` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La comunidad no existe'); }
$row = mysql_fetch_row($query);
if($row[1] != 0) { die('0: La comunidad fue eliminada'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `group` = \''.$row[0].'\' && `user` = \''.$logged['id'].'\''))) { die('0: Fuiste baneado de la comunidad'); }
//if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_members` WHERE `user` = \''.$logged['id'].'\' && `time` > \''.(time()-60).'\'')) && $logged['nick'] != 'ignacioviglo') { die('0: Debes esperar para realizar esta acci&oacute;n'); }
if($_POST['sa'] == 'add') {
  if(mysql_num_rows($mmm = mysql_query('SELECT `id`, `status` FROM `groups_members` WHERE `group` = \''.$row[0].'\' && `user` = \''.$logged['id'].'\''))) {
    $ca = mysql_fetch_row($mmm);
    if($ca[1] != 1) { die('0: Ya parteneces a esta comunidad'); }
    mysql_query('UPDATE `groups_members` SET `status` = \'0\' WHERE `id` = \''.$ca[0].'\' LIMIT 1');
  } else {
    mysql_query('INSERT INTO `groups_members` (`user`, `status`, `group`, `rank`, `time`) VALUES (\''.$logged['id'].'\', \'0\', \''.$row[0].'\', \''.($row[2] == $logged['id'] ? 5 : $row[3]).'\', \''.time().'\')') or die('0: '.mysql_error());
  }
  mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$row[4].'\', \'/comunidades/'.$row[5].'\', \''.$row[0].'\', \''.time().'\', \'6\')');
} else {
  if($row[2] == $logged['id']) { die('0: No puedes irte de tu propia comunidad -mirada'); }
  if(!mysql_num_rows($pd = mysql_query('SELECT `id`, `status` FROM `groups_members` WHERE `group` = \''.$row[0].'\' && `user` = \''.$logged['id'].'\''))) { die('0: No eres miembro de esta comunidad'); }
  list($id, $status) = mysql_fetch_row($pd);
  if($status != 0) { die('0: Error provocado'); }
  mysql_query('UPDATE `groups_members` SET `status` = \'1\' WHERE `id` = \''.$id.'\'');
  mysql_query('DELETE FROM `activity` WHERE `author` = \''.$logged['id'].'\' && `type` = \'6\' && `what` = \''.$row[0].'\'');
}
echo '1';