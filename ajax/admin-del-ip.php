<?php
if(!$_POST['id']) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id'] || !allow('ban_ip')) { die; }
if(!mysql_num_rows($m = mysql_query('SELECT `id`, `author` FROM `ips_ban` WHERE `id` = \''.mysql_clean($_POST['id']).'\''))) { die('0La ip no existe'); }
list($id, $author) = mysql_fetch_row($m);
if($author != $logged['id'] && $logged['rank'] != 9) { die('0No puedes eliminar una ip que no baneaste tu'); }
mysql_query('DELETE FROM `ips_ban` WHERE `id` = \''.$id.'\' LIMIT 1');
die('1'); //Hecho