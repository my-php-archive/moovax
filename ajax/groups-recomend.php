<?php
if(!(int)$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(!mysql_num_rows($aja = mysql_query('SELECT `id`, `status`, `url`, `name`, `author` FROM `groups` WHERE `id` = \''.(int)$_POST['id'].'\''))) { die('0: La comunidad no existe'); }
$row = mysql_fetch_assoc($aja);
if($row['status'] != 0) { die('0: No es posible recomendar a esta comunidad'); }
if($row['author'] == $logged['id']) { die('0: No puedes recomendar tu propia comunidad'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `notifications` WHERE `url` REGEXP \'/comunidades/'.$row['url'].'[/]?\' && `type` = \'16\' && `author` = \''.$logged['id'].'\''))) { die('0: Ya haz recomendado esta comunidad'); }
$friends = mysql_query('SELECT IF(`author` = \''.$logged['id'].'\', `user` , `author`) FROM `friends` WHERE (`author` = \''.$logged['id'].'\' || `user` = \''.$logged['id'].'\') && `status` = \'1\'');
mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$row['name'].'\', \'/comunidades/'.$row['url'].'\', \''.$row['id'].'\', \''.time().'\', \'7\')') or die('0: '.mysql_error());
while($r = mysql_fetch_row($friends)) {
  if($r[0] == $logged['id'] || $row['author'] == $r[0]) { continue; }
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$r[0].'\', \'16\', \'/comunidades/'.$row['url'].'\', \'0\', \''.time().'\', \''.$row['name'].'\')') or die('0: '.mysql_error());
}
echo '1: La comunidad fue recomendada';