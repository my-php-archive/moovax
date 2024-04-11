<?php
if(!$_POST['id'] || !isset($_POST['type'])) { die('0: Faltan datos'); }
if(!ctype_digit($_POST['type'])) { die('0: Error provocado'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate macho'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `status` FROM `favorites` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El favorito no existe'); }
$rsa = mysql_fetch_assoc($query);
if($rsa['author'] != $logged['id']) { die('0: Esto no te pertenece'); }
if($rsa['status'] != '1') { die('0: Esto no se encuentra eliminado'); }
mysql_query('UPDATE `favorites` SET `status` = \'0\' WHERE `id` = \''.$rsa['id'].'\' LIMIT 1'); //-uhhh
die('1: Hecho!');
?>