<?php
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: logueate'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `status`, `name`, `url` FROM `groups` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La comunidad no existe'); }
list($id, $author, $status, $name, $url) = mysql_fetch_row($query);
if($status != 0) { die('0: La comunidad fue eliminada'); }
if($author != $logged['id'] && !allow('elimgroup')) { die('0: No puedes eliminar esta comunidad'); }
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `groups_members` WHERE `user` = \''.$logged['id'].'\' && `status` = \'0\''))) { die('0: Para eliminar la comunidad debes ser miembro'); }
mysql_query('UPDATE `groups` SET `status` = \'1\' WHERE `id` = \''.$id.'\' LIMIT 1');
mysql_query('INSERT INTO `groups_actions` (`author`, `group`, `action`, `title`, `time`) VALUES (\''.$logged['id'].'\', \''.$id.'\', \'3\', \''.$name.'\', \''.time().'\')');
mysql_query('DELETE FROM `activity` WHERE `what` = \''.$id.'\' && `type` > 4 && `type` < 8'); //No lo soneee
echo '1: La comunidad fue eliminada';