<?php
if(!$_POST['foto']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Para realizar esta acci&oacute;n es necesario loguearte'); }
if(!mysql_num_rows($p = mysql_query('SELECT `id`, `author`, `status`, `cat`, `title` FROM `photos` WHERE `id` = \''.intval($_POST['foto']).'\''))) { die('0: La foto no existe'); }
$rps = mysql_fetch_row($p);
if($rps[1] == $logged['id']) { die('0: No es posible agregar tus fotos a favoritos'); }
if($rps[2] != 0) { die('0: La foto se encuentra eliminada'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `favorites` WHERE `id_pf` = \''.$rps[0].'\' && `author` = \''.$logged['id'].'\' && `type` = \'1\''))) { die('0: Esta foto ya es tu favorito'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `favorites` WHERE `time` > \''.(time()-120).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Debes esperar para realizar esta acci&oacute;n'); }
mysql_query('INSERT INTO `favorites` (`author`, `id_pf`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$rps[0].'\', \''.time().'\', \'1\')');
$cat = mysql_fetch_row(mysql_query('SELECT `url` FROM `p_categories` WHERE `id` = \''.$rps[3].'\''));
$url = '/fotos/'.$cat[0].'/'.$rps[0].'/'.url($rps[4]).'.html';
mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$rps[1].'\', \'12\', \''.$url.'\', \'0\', \''.time().'\', \''.$rps[4].'\')');
echo '1: Foto agregada con &eacute;xito&excl;';