<?php
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author` FROM `drafts` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El borrador no existe'); }
$r = mysql_fetch_row($query);
if($r[1] != $logged['id']) { die('0: El borrador no te pertenece puto'); }
mysql_query('DELETE FROM `drafts` WHERE `id` = \''.$r[0].'\' LIMIT 1');
die('1');