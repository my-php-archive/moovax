<?php
if(!$_POST['id'] || !$_POST['post'] || !$_POST['user'] || !$_POST['score'] || !$_POST['type']) { die('0: Faltan datos'); }
if($_POST['type'] != 'foto' || ($_POST['score'] != 1 && $_POST['score'] != '-1')) { die('0: Error'); } //Frijoles
include('../config.php');
include('../functions.php');
if(!$logged['id'] || $_POST['user'] != $key) { die('0: Error provocado por el usuario'); }
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `photos` WHERE `id` = \''.intval($_POST['post']).'\''))) { die('0: EL post no existe'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author` FROM `p_comments` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El comentario que intentas votar no existe'); }
list($id, $author) = mysql_fetch_row($query);
if($author == $logged['id']) { die('0: No es posible votar tu comentario'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `c_votes` WHERE `type2` = \'1\' && `comment` = \''.$id.'\' && `author` = \''.$logged['id'].'\''))) { die('0: Ya haz votado este comentario'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `c_votes` WHERE `time` > \''.(time()-30).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Debes esperar 30 segundos para votar otro comentario'); }
$ccc = ($_POST['score'] == 1 ? array(1, 'positive') : array('-1', 'negative'));
mysql_query('UPDATE `p_comments` SET `'.$ccc[1].'` = '.$ccc[1].' + 1 WHERE `id` = \''.$id.'\' LIMIT 1');
mysql_query('INSERT INTO `c_votes` (`author`, `comment`, `type`, `time`, `type2`) VALUES (\''.$logged['id'].'\', \''.$id.'\', \''.$ccc[0].'\', \''.time().'\', \'1\')') or die('0: '.mysql_error());
die('1:');