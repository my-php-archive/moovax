<?php
include('../config.php');
include('../functions.php');
if(!allow('stitches')) { die('0: No ten&eacute;s permisos para est&aacute;r ac&aacute;'); }
if($_POST) {
  if(!$_POST['user'] || !$_POST['cantidad']) { die('0: Faltan datos'); }
  if(!mysql_num_rows($query = mysql_query('SELECT `id`, `nick`, `ban` FROM `users` WHERE `nick` = \''.mysql_clean($_POST['user']).'\''))) { die('0: El usuario especificado no existe'); }
  $row = mysql_fetch_row($query);
  if($row[0] == $logged['id']) { die('0: No puedes darte puntos a ti mismo'); }
  if($row[2] == 1) { die('0: Este usuario est&aacute; baneado'); }
  if(!ctype_digit($_POST['cantidad'])) { die('0: La cantidad debe de ser un n&uacute;mero positivo, sin + ni -'); }
  mysql_query('UPDATE `users` SET `points` = `points` + \''.$_POST['cantidad'].'\' WHERE `id` = \''.$row[0].'\' LIMIT 1');
  die('1: Se han agregado '.$_POST['cantidad'].' puntos al usuario '.$row[1]);
}
?>
1: <div class="form-container" id="restar-dinero">
	<div style="display: none;margin-bottom:10px;padding:8px;" class="redBox" id="error_data"></div>
	<div class="data">
		<label>Usuario<span class="color_red">*</span></label>
		<input type="text" name="user" id="user" class="c_input">
	</div>
	<div class="data">
		<label class="floatL">Cantidad a enviar<span class="color_red">*</span></label>
		<input type="text" name="cantidad" id="cantidad" class="c_input">
	</div>
	<div class="clear"></div>
	<span class="floatL"><span class="color_red">*</span>Campos obligatorios.</span><br>
	<span class="size9 floatL"> - La cantidad de puntos a dar debe ser una cantidad redonda</span><br>

</div>