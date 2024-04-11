<?php
if(!$_POST['id']) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0Debes estar logueado para realizar esta acci&oacute;n'); }
if(!mysql_num_rows($nt = mysql_query('SELECT `id`, `id_user` FROM `notifications` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0La notificacion ingresada no existe'); }
list($id, $user) = mysql_fetch_row($nt);
if($user != $logged['id']) { die('0Esta notificacion no te pertenece pacha'); }
mysql_query('DELETE FROM `notifications` WHERE `id` = \''.$id.'\' LIMIT 1'); //Stylo eeeer34
die('1Hecho!');