<?php
if(!$_POST['para'] || !$_POST['mensaje']) { die('0: Faltan datos'); }
if(!$_POST['asunto']) { $_POST['asunto'] = 'Sin asunto'; } //Why not
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(!mysql_num_rows($user = mysql_query('SELECT `id`, `nick`, `receive_pms` FROM `users` WHERE `nick` = \''.mysql_clean($_POST['para']).'\''))) { die('3: El usuario ingresado no existe'); }
$ps = mysql_fetch_row($user);
if($ps[0] == $logged['id']) { die('0: Que gracioso'); }
if($ps[2] == '1') { die('0: El usuario no permite que le envien mensajes'); }
if(strlen($_POST['mensaje']) < 20) { die('3: El mensaje debe tener al menos 20 caracteres'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `messages` WHERE `author` = \''.$logged['id'].'\' && `time` > \''.(time()-160).'\''))) { die('2: Espera unos minutos para enviar otro mp'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `author` = \''.$ps[0].'\' && `user` = \''.$logged['id'].'\''))) { die('0: Te has portado mal, este wey te a bloqueado'); }
mysql_query('INSERT INTO `messages` (`author`, `receiver`, `issue`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$ps[0].'\', \''.mysql_clean($_POST['asunto']).'\', \''.mysql_clean($_POST['mensaje']).'\', \''.time().'\')') or die('0: '.mysql_error());
die('1: El mensaje fue enviado a '.$ps[1]);