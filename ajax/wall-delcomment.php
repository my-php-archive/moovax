<?php
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte para realizar esta acc&oacute;n'); }
if(!mysql_num_rows($pq = mysql_query('SELECT `id`, `author`, `profile` FROM `walls` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La publicaci&oacute;n no existe'); }
$la = mysql_fetch_row($pq);
if($la[1] != $logged['id'] && $la[2] != $logged['id'] && !allow('delete_comments')) { die('0: No tienes permisos :S'); }
mysql_query('DELETE FROM `walls` WHERE `id` = \''.$la[0].'\' LIMIT 1');
mysql_query('DELETE FROM `notifications` WHERE `url` REGEXP \'/.*/muro/'.$la[0].'\' && (`type` = \'3\' || `type` = \'13\' || `type` = \'11\' || `type` = \'10\' || `type` = \'9\')') or die('0: '.mysql_error());
mysql_query('DELETE FROM `w_replies` WHERE `what` = \''.$la[0].'\'');
mysql_query('DELETE FROM `w_likes` WHERE `what` = \''.$la[0].'\' && `type` = \'0\'');
mysql_query('DELETE FROM `activity` WHERE `what` = \''.$la[0].'\' && (`type` = \'14\' || `type` = \'13\' || `type` = \'12\')');
die('1: La publicaci&oacute;n ha sido borrada');