<?php
if(!$_POST['id'] || !isset($_POST['tipo'])) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes de est&aacute;r logueado'); }
if(!mysql_num_rows($s = mysql_query('SELECT `id`, `user`, `status`, `author` FROM `friends` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: Esto no existe'); }
list($id, $user, $status, $author) = mysql_fetch_row($s);
if($user != $logged['id']) { die('0: Esta solicitud no te pertenece'); }
if($author == $logged['id']) { die('0: No te pases de vivo LOL'); }
if($status != '0') { die('0: Error provocado'); }
//Autor
if(!mysql_num_rows($s = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `id` = \''.$author.'\''))) { die('0: WTF ._.'); }
$row = mysql_fetch_row($s);
if($_POST['tipo'] == '1') {
  mysql_query('UPDATE `friends` SET `status` = \'1\' WHERE `id` = \''.$id.'\' LIMIT 1');
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$author.'\', \'7\', \'/'.$logged['nick'].'\', \'0\', \''.time().'\', \''.$logged['nick'].'\')') or die('0: '.mysql_error());
  mysql_query('INSERT INTO `activity` (`author`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$author.'\', \''.time().'\', \'8\')');
  die('1: Ahora '.$row[1].' y tu son amigos');
}
mysql_query('DELETE FROM `friends` WHERE `id` = \''.$id.'\' LIMIT 1'); //&nbsp;:/
echo '1: Haz rechazado la solicitud de amista de '.$row[1];
///wiiiiiiiiiiiiiiiiii