<?php
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte guachin'); }
if(!allow('show_contact')) { die('0: No tenes permisos hijo de la re putisima madre que te pari&oacute;'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id` FROM `contact` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El contacto no existe'); }
list($id) = mysql_fetch_row($query);
mysql_query('DELETE FROM `contact` WHERE `id` = \''.$id.'\' LIMIT 1');
die('1');