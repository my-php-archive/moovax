<?php
if(!$_POST['user']) { die('0: Faltan datos?'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(!mysql_num_rows($m = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `id` = \''.intval($_POST['user']).'\'')))  { die('0: Putinga.com.ar'); }
list($id, $nick) = mysql_fetch_row($m);
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `friends` WHERE (`author` = \''.$logged['id'].'\' && `user` = \''.$id.'\') || (`user` = \''.$logged['id'].'\' && `author` = \''.$id.'\')'))) { die('0: No sos amigo de este sujeto'); }
echo '1: &iquest;De verdad deseas eliminar a <b>'.$nick.'</b> de tus amigos?';