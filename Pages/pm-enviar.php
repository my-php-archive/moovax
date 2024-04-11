<?php
if(!defined($config['define'])) { die; }
if(!$_POST['para'] || !$_POST['mensaje']) { fatal_error('Faltan datos'); }
if(strlen($_POST['mensaje']) < 20) { fatal_error('El mensaje debe tener al menos 20 caracteres'); }
if(!$logged['id']) { fatal_error('Logueate macho'); }
if(!$_POST['asunto']) { $_POST['asunto'] = 'Sin asunto'; }
if($_POST['de'] != $logged['id']) { fatal_error('Uhh, anda a chupar la verga hijo de puta de la re concha de tu madre'); }
if(!mysql_num_rows($s = mysql_query('SELECT `id`, `nick`, `receive_pms` FROM `users` WHERE `nick` = \''.mysql_clean($_POST['para']).'\''))) { fatal_error('El usuario no existe'); }
$ras = mysql_fetch_row($s);
if($ras[0] == $logged['id']) { fatal_error('No te puedes enviar mensajes a ti mismo'); }
if($ras[2] == 1) { fatal_error('El usuario no admite que le envien mp'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `messages` WHERE `time` > \''.(time()-180).'\' && `author` = \''.$logged['id'].'\''))) { fatal_error('Debes esperar unos minutos', 'Anti Flood!'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `author` = \''.$ras[0].'\' && `user` = \''.$logged['id'].'\''))) { fatal_error('Este usuario te a bloqueado', 'Puto!'); }
mysql_query('INSERT INTO `messages` (`author`, `receiver`, `issue`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$ras[0].'\', \''.mysql_clean($_POST['asunto']).'\', \''.mysql_clean($_POST['mensaje']).'\', \''.time().'\')');
//Dame maaaaaaas
fatal_error('El mensaje fue enviado con &eacute;xito a '.$ras[1], 'YEAHH!');