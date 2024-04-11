<?php
if(!$_POST['nick']) { die('0: El campo <b>nick</b> es requerido'); }
if(!$_POST['pass']) { die('0: El campo <b>password</b> es requerido'); }
include('../config.php');
include('../functions.php');
if($logged['id']) { die('0: Ya estas logueado la concha de tu madre ._.'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `nick`, `ban`, `act`, `password` FROM `users` WHERE `nick` = \''.mysql_clean($_POST['nick']).'\''))) { die('0: El usuario ingresado no existe'); }
$r = mysql_fetch_row($query);
if($r[4] != md5($_POST['pass'])) { die('0: La contrase&ntilde;a es incorrecta'); }
//mysql_query('DELETE FROM banned WHERE `time` <= \''.time().'\' && `time` != \'0\'');
if($r[2] == '1' && mysql_num_rows($ban = mysql_query('SELECT text FROM banned WHERE id_user = \''.$r[0].'\''))) {
  $row = mysql_fetch_row($ban);
  die('0: Tu cuenta se encuentra baneada por '.$row[0]);
}
if($r[3] == '0') { die('0: Activa tu cuenta'); }
setcookie($config['cookie_name'], $r[0].'%'.$r[4], 0, '/');
$_SERVER['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDED_FOR'];
mysql_query('UPDATE `users` SET `lastip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\' WHERE id = \''.$r[0].'\' LIMIT 1');
mysql_query('UPDATE `online` SET `user` = \''.$r[0].'\', `time` = \''.time().'\' WHERE `ip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\'');
die('1:');