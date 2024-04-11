<?php
if(!$_POST['user']) { die; }
include('../config.php');
include('../functions.php');
if(!mysql_num_rows($fue = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `id` = \''.intval($_POST['user']).'\''))) { die('0: El usuario ingresado no existe che'); }
$paq = mysql_fetch_row($fue);
if($paq[0] == $logged['id']) { die('0: Puto'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `author` = \''.$paq[0].'\' && `user` = \''.$logged['id'].'\''))) { die('0: Este usuario te a bloqueado'); }
echo '1: ¿Estás seguro que deseas agregar a <b>'.$paq[1].'</b> a tus amigos?<br><br><b>'.$paq[1].'</b> deberá aceptar tu solicitud de amistad.';