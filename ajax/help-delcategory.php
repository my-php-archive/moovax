<?php
if(!$_POST['id'] || !$_POST['newcat']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!allow('admin_help')) { die('0: No ten&eacute;s permisos para estar aqu&iacute;!'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id` FROM `help_categories` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La categoria no existe'); }
list($elim) = mysql_fetch_row($query);
if(!mysql_num_rows($news = mysql_query('SELECT `id` FROM `help_categories` WHERE `id` = \''.intval($_POST['newcat']).'\''))) { die; }
$row = mysql_fetch_row($news);
if($row[0] == $elim) { die('0: Debes seleccionar una categoria diferente a la que vas a eliminar'); }
mysql_query('DELETE FROM `help_categories` WHERE `id` = \''.$elim.'\' LIMIT 1');
mysql_query('UPDATE `articles` SET `cat` = \''.$row[0].'\' WHERE `cat` = \''.$elim.'\'');
die('1: La categor&iacute;a fue eliminada satisfactoriamente');
?>