<?php
if(!$_POST['id']) { die('0: El campo id es requerido'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes estar logueado'); }
if($_POST['user'] != $logged['id']) { die('0: Hack'); }
if(!mysql_num_rows($p = mysql_query('SELECT `id`, `author`, `status` FROM `photos` WHERE `id` = \''.intval($_POST['foto']).'\''))) { die('0: La foto no existe'); }
list($id, $author, $st) = mysql_fetch_row($p);
if($st != 0) { die('0: La foto se encuentra eliminada'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `photo` FROM `p_comments` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El comentario no existe'); }
$row = mysql_fetch_assoc($query);
if($row['photo'] != $id) { die('0: Sos un chupaverga demierda hijo de la gran bosta, pelotudo'); }
if($row['author'] != $logged['id'] && $author != $logged['id'] && !allow('delete_comments')) { die('0: No tenes permisos para realizar esta acci&oacute;n'); }
mysql_query('DELETE FROM `p_comments` WHERE `id` = \''.$row['id'].'\' LIMIT 1') or die('0: '.mysql_error());
die('1:');