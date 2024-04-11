<?php
if(!$_POST['user']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate capo'); }
if(!mysql_num_rows($psa = mysql_query('SELECT id, nick, ban, `friends_request` FROM `users` WHERE `id` = \''.intval($_POST['user']).'\''))) { die('0: El usuario no existe'); }
$pa = mysql_fetch_row($psa);
if($pa[0] == $logged['id']) { die('0: Amist&aacute; no hagas esto -uiy'); }
if($pa[2] == '1') { die('0: El usuario est&aacute; baneado'); }
if($pa[3] == 1) { die('0: El usuario no admite solicitudes de amistad'); }
if(mysql_num_rows($ld = mysql_query('SELECT `status`, `id`, `author` FROM `friends` WHERE (`author` = \''.$logged['id'].'\' && `user` = \''.$pa[0].'\') || (`user` = \''.$logged['id'].'\' && `author` = \''.$pa[0].'\')'))) {
  $r = mysql_fetch_row($ld);
  if($r[0] == 0 && $r[2] != $logged['id']) {
    mysql_query('UPDATE `friends` SET `status` = \'1\' WHERE `id` = \''.$r[1].'\'');
    die('1: Ahora tu y '.$pa[1].' son amigos!');
  }
  die('0: Ya se le mand&oacute; solicitud a este usuario');
}
if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `user` = \''.$logged['id'].'\' && `author` = \''.$pa[0].'\''))) { die('0: Este usuario te ha bloqueado por puto'); }
mysql_query('INSERT INTO `friends` (`author`, `user`, `status`, `time`) VALUES (\''.$logged['id'].'\', \''.$pa[0].'\', \'0\', \''.time().'\')');
die('1: Solicitud enviada!');