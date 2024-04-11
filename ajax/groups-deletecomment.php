<?php
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `id_topic` FROM `groups_comments` WHERE `id` = \''.(int)$_POST['id'].'\''))) { die('0: El comentario no existe'); }
$row = mysql_fetch_row($query);
list($idte, $status, $author, $group) = mysql_fetch_row(mysql_query('SELECT `id`, `status`, `author`, `group` FROM `groups_topics` WHERE `id` = \''.$row[2].'\''));
//$currentrank
if($status != '0') { die('0: El tema se encuentra eliminado'); }
if(!mysql_num_rows($query2 = mysql_query('SELECT `id`, `rank` FROM `groups_members` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group.'\''))) { die('0: No eres miembro de la comunidad'); }
$member = mysql_fetch_assoc($query2);
if($row[1] != $logged['id'] && $author != $logged['id'] && $member['rank'] != 4 && $member['rank'] != 5 && !allow('deletereply')) { die('0: No tienes permiso para realizar esta acci&oacute;n'); }
mysql_query('DELETE FROM `groups_comments` WHERE `id` = \''.$row[0].'\'');
die('1');