<?php
if(!$_POST['id'] || !$_POST['post'] || !$_POST['user']) { die('0: Faltan datos...'); }
include('../config.php');
include('../functions.php');
if($_POST['user'] != $logged['id']) { die('0: And&aacute; a cagar'); }
if(!$logged['id']) { die('0: Debes est&aacute;r logueado para realizar esta acci&oacute;n'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `status` FROM `posts` WHERE `id` = \''.intval($_POST['post']).'\''))) { die('0: el post no existe'); }
list($id_post, $id_author, $status) = mysql_fetch_row($query);
if($status != '0') { die('0: El post est&aacute; eliminado'); }
if(!mysql_num_rows($comment = mysql_query('SELECT `id`, `author` FROM `comments` WHERE id = \''.intval($_POST['id']).'\' && `id_post` = \''.$id_post.'\''))) { die('0: El comentario no existe'); }
$row = mysql_fetch_row($comment);
if(!allow('delete_comments') && $row[1] != $key && $id_author != $key) { die('0: Ehh, que haces cabeza de mandril?'); }
mysql_query('DELETE FROM `comments` WHERE `id` = \''.$row[0].'\' && `id_post` = \''.$id_post.'\' LIMIT 1'); // -sisi
mysql_query('DELETE FROM `activity` WHERE `what` = \''.$row[0].'\' && `type` = \'2\'');
die('1:');