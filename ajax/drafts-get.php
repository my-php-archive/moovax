<?php
if(!$_POST['id']) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0Debes loguearte'); }
if(!mysql_num_rows($query = mysql_query('SELECT `author`, `type`, `title`, `body` FROM `drafts` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0El borrador no existe'); }
$row = mysql_fetch_row($query);
if($row[0] != $logged['id']) { die('0Que puto...'); }
if($row[1] != 1) { die('0Este tipo de borrador no puede ser visto desde aqu&iacute;'); }
?>
1<div style="text-align:left; padding-left:15px;">
	<strong>T&iacute;tulo:</strong><br>
	<input type="text" onfocus="this.select()" style="width:480px" value="<?=$row[2];?>"><br>
	<strong>Contenido:</strong><br>
	<textarea onfocus="this.select()" style="width:490px; height:140px"><?=$row[3];?></textarea>
</div>