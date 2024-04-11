<?php
if(!$_POST['voto'] || !(int)$_POST['tema'] || ($_POST['voto'] != '1' && $_POST['voto'] != '-1')) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `status`, `author`, `group`, `title` FROM `groups_topics` WHERE `id` = \''.(int)$_POST['tema'].'\''))) { die('0: El tema no existe'); }
$row = mysql_fetch_row($query);
if($row[1] != '0') { die('0: El tema se encuentra eliminado'); }
if($row[2] == $logged['id']) { die('0: No puedes votar tus propios temas'); }
//Te necesito para la url -ok
list($group, $status, $url) = mysql_fetch_row(mysql_query('SELECT `id`, `status`, `url` FROM `groups` WHERE `id` = \''.$row[3].'\''));
if($status != '0') { die('0: El grupo se encuentra eliminado'); }
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `groups_members` WHERE `group` = \''.$group.'\' && `user` = \''.$logged['id'].'\' && `status` = \'0\''))) { die('0: Para votar debes ser miembro'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group.'\''))) { die('0: Fuiste baneado de la comunidad'); }
//if($_POST['voto'] != '1' && $_POST['voto'] != '-1') { die('0: Chupaverga'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_votes` WHERE `topic` = \''.$row[0].'\' && `author` = \''.$logged['id'].'\''))) { die('0: No puedes volver a votar este tema'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_votes` WHERE `time` > \''.(time()-120).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Debes esperar'); }
mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$row[2].'\', \'17\', \'/comunidades/'.$url.'/'.$row[0].'/'.url($row[4]).'.html#'.($_POST['voto'] == '1' ? '0' : '1').'\', \'0\', \''.time().'\', \''.$row[4].'\')');
mysql_query('UPDATE `groups_topics` SET `votes` = `votes` '.($_POST['voto'] == '1' ? '+' : '-').' 1 WHERE `id` = \''.$row[0].'\'') or die('0: '.mysql_error());
mysql_query('INSERT INTO `groups_votes` (`author`, `topic`, `time`) VALUES (\''.$logged['id'].'\', \''.$row[0].'\', \''.time().'\')');
die('1: Votado satisfactoriamente!');