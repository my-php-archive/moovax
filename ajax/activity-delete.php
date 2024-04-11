<?php
if(!$_POST['id'] || !ctype_digit($_POST['id'])) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0Debes loguearte'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `type`, `what` FROM `activity` WHERE `id` = \''.(int)$_POST['id'].'\''))) { die('0La actividad que intentas borrar no existe'); }
$r = mysql_fetch_row($query);
if($author != $logged['id'] && $logged['rank'] != '9') { die; } //-yao
mysql_query('DELETE FROM `activity` WHERE `type` = \''.$r[2].'\' && `author` = \''.$r[1].'\' && `what` = \''.$r[3].'\'');
echo '1';