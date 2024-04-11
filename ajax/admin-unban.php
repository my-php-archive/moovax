<?php
if(!$_POST['id'] || !ctype_digit($_POST['id'])) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!allow('ban')) { die('0: Puto'); }
if(!mysql_num_rows($bbb = mysql_query('SELECT `id`, `ban` FROM `users` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El usuario que intenta desbnanear no existe'); }
list($id, $ban) = mysql_fetch_row($bbb);
if(!mysql_num_rows($vvvs = mysql_query('SELECT `id_mod` FROM `banned` WHERE `id_user` = \''.$id.'\'')) || $ban == '0') { die('0: Este usuario no se encuentra baneado'); }
$row = mysql_fetch_row($vvvs);
if($id == $logged['id']) { die('0: WTF?'); }
if($row[0] != $key && $logged['rank'] != '9') { die('0: No puedes desbanear a un usuario que no baneaste tu'); }
mysql_query('UPDATE `users` SET `ban` = \'0\' WHERE `id` = \''.$id.'\' LIMIT 1');
mysql_query('DELETE FROM `banned` WHERE `id_user` = \''.$id.'\'');
die('1: Usuario desbaneado con &eacute;xito');
/* Esto lo hice depre as&iacute; que si tiene errores es mi culpa como todo. */