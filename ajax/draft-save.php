<?php
$title = trim($_POST['title']);
$body = trim($_POST['body']);
if(!$title || !$body || !$_POST['cat'] || $_POST['cat'] == '-1') { die('{"ok":0,"id":"Faltan datos"}'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('{"ok":0,"id":"Logueate"}'); }
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `categories` WHERE `id` = \''.intval($_POST['cat']).'\''))) { die('{"ok":0,"id":"La categor&iacute;a no existe"}'); }
if(strlen($title) < 4) { die('{"ok":0,"id":"El titulo debe tener al menos 4 caracteres"}'); }
if($_POST['sticky'] == 1 && !allow('sticky')) { $_POST['sticky'] = 0; } //Problem?
if(mysql_num_rows(mysql_query('SELECT `id` FROM `drafts` WHERE `time` > \''.(time()-30).'\' && `author` = \''.$logged['id'].'\''))) { die('{"ok":0,"id":"Espera un minuto para volver a guardar"}'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `drafts` WHERE `author` = \''.$logged['id'].'\'')) > 90) { die('{"ok":0,"id":"Superas el limite de 90 borradores por usuario"}'); }
if($_POST['id'] && ctype_digit($_POST['id'])) {
  if(!mysql_num_rows($vc = mysql_query('SELECT `id`, `author`, `type` FROM `drafts` WHERE `id` = \''.$_POST['id'].'\''))) { die('{"ok":0,"id":"El borrador no existe"}'); }
  $r = mysql_fetch_row($vc);
  if($r[1] != $logged['id']) { die('{"ok":0,"id":"El borrador no te pertenece"}'); }
  //if($r[2] > time()-120) { die('0Debes esperar un minuto para volver a guardar'); }
  if($r[2] != 0) { die; }
  mysql_query('UPDATE `drafts` SET `title` = \''.mysql_clean($title).'\', `body` = \''.mysql_clean($body).'\', `cat` = \''.intval($_POST['cat']).'\', `sticky` = \''.($_POST['sticky'] ? 1 : 0).'\', `closed` = \''.($_POST['cerrado'] ? 1 : 0).'\', `private` = \''.($_POST['privado'] ? 1 : 0).'\', `time` = \''.time().'\' WHERE `id` = \''.$r[0].'\' LIMIT 1') or die('0'.mysql_error());
} else {
  mysql_query('INSERT INTO `drafts` (`author`, `title`, `type`, `body`, `cat`, `sticky`, `closed`, `private`, `time`) VALUES (\''.$logged['id'].'\', \''.mysql_clean($title).'\', \'0\', \''.mysql_clean($body).'\', \''.intval($_POST['cat']).'\', \''.($_POST['sticky'] ? 1 : 0).'\', \''.($_POST['cerrado'] ? 1 : 0).'\', \''.($_POST['privado'] ? 1 : 0).'\', \''.time().'\')');
  $r[0] = mysql_insert_id();
}
die('{"ok":1,"id":'.$r[0].'}');