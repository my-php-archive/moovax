<?php
if(!$_GET['id_user'] || !isset($_GET['type'])) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Loguate'); }
if(!mysql_num_rows($roq = mysql_query('SELECT `id` FROM `users` WHERE `id` = \''.intval($_GET['id_user']).'\''))) { die('0El usuario que intentas bloquear no existe'); }
$row = mysql_fetch_row($roq);
if($row[0] == $logged['id']) { die('0No puedes bloquearte a ti mismo'); }
if($_GET['type'] == 0) {
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `user` = \''.$row[0].'\' && `author` = \''.$logged['id'].'\''))) { die('0Ya hab&iacute;s bloqueado a este usuario'); }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `time` > \''.(time()-60).'\' && `author` = \''.$logged['id'].'\''))) { die('0Debes esperar para realizar esta acci&oacute;n'); }
  mysql_query('INSERT INTO `blocked` (`author`, `user`, `time`) VALUES (\''.$logged['id'].'\', \''.$row[0].'\', \''.time().'\')');
} else {
  if(!mysql_num_rows($b = mysql_query('SELECT `id` FROM `blocked` WHERE `user` = \''.$row[0].'\' && `author` = \''.$logged['id'].'\''))) { die('0: Error'); }
  $a = mysql_fetch_row($b);
  mysql_query('DELETE FROM `blocked` WHERE `id` = \''.$a[0].'\' LIMIT 1');
}
die(1);
?>