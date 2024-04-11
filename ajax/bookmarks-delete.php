<?php
if(!$_POST['id'] || !isset($_POST['type'])) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!mysql_num_rows($fsq = mysql_query('SELECT `id`, `author`, `type`, `id_pf` FROM `favorites` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El favorito no existe'); }
$os = mysql_fetch_row($fsq);
if($os[1] != $logged['id']) { die('0: Este favorito no te pertenece ._.'); }
if($os[2] != $_POST['type']) { die('0: Error provocado?'); }
mysql_query('DELETE FROM `notifications` WHERE `url` REGEXP \'/posts/.*/'.$os[3].'/.*.html\' && `author` = \''.$logged['id'].'\' && `type` = \'1\'') or die('0: '.mysql_error());
mysql_query('UPDATE `favorites` SET `status` = \'1\' WHERE `id` = \''.$os[0].'\' && `author` = \''.$logged['id'].'\''); //El favorito se inserta una vez, que alpedo estoy, no?
die('1: Favorito borrado puto');
/* ji */