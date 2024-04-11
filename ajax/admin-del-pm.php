<?php
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(!allow('show_mps')) { die('0: No tienes permisos para estar aqu&iacute;'); }
if(!mysql_num_rows($pms = mysql_query('SELECT `id`, `author`, `author_status`, `receiver_status` FROM `messages` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El mp indicado no existe'); }
$row = mysql_fetch_row($pms);
if($row[1] == $logged['id']) { die('0: Esto est&aacute; mal, tu eres el autor del mp'); }
if($row[2] == '1' && $row[3] == '1') { die('0: El pm ya fue eliminado por el receptor y emisor'); }
mysql_query('UPDATE `messages` SET `author_status` = \'2\', `receiver_status` = \'2\', `author_read` = \'1\', `receiver_read` = \'1\' WHERE `id` = \''.$row[0].'\' LIMIT 1') or die('0: '.mysql_error());
die('1: Eliminado');