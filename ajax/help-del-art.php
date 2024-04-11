<?php
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `status` FROM `articles` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El articulo no existe'); }
$pr = mysql_fetch_row($query);
if($pr[1] != $logged['id'] && !allow('admin_help')) { die('0: No tienes permisos'); }
if($pr[2] != 0) { die('0: El articulo est&aacute; eliminado'); }
mysql_query('UPDATE `articles` SET `status` = \'1\' WHERE `id` = \''.$pr[0].'\' LIMIT 1');
die('1: El art&iacute;culo a sido borrado');