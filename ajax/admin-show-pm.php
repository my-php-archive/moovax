<?php
/* Paradiseeeee */
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(!allow('show_mps')) { die('0: No tienes permisos para estar ac&aacute; uiy'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `issue`, `body` FROM `messages` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El mensaje no existe'); }
$row = mysql_fetch_row($query);
?>
1:
<div class="form-container" id="denunciar-post">
    <div style="display: none;margin-bottom:10px;padding:8px;" class="redBox" id="error_data"></div>
	<div align="left" class="data">
	    <font class="size12">
		    <b>Asunto:</b> <span style="font-weight:normal"><?=$row[1];?></span>
        </font>
	</div>
	<div align="left" class="data">
	    <font class="size12">
		<b>Mensaje enviado:</b></font> <br class="space">
		<div style="border:1px solid #CCC; padding:5px;height:150px;overflow:auto"><?=BBposts($row[2], false, false, false, true);?></div>
	</div>
</div>