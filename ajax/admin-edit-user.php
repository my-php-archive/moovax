<?php
include('../config.php');
include('../functions.php');
if(!allow('edit_user')) { die('0chupala con flow'); }
if($_POST) {
  if(!ctype_digit($_POST['id'])) { die('0Puto sois'); }
  if(!$_POST['name'] && !$_POST['message'] && !$_POST['nick']) { die('0Edita algo al menos -mierda'); }
  $query = mysql_query('SELECT `id`, `name`, `message`, `nick`, `rank` FROM `users` WHERE `id` = \''.intval($_POST['id']).'\'');
  $row = mysql_fetch_row($query);
  if($row[4] == '9' && $logged['rank'] != '9') { die('0no pod&eacute;s editar a tus mayores harry -sisi'); }
  if($row[0] == $logged['id']) { die('0No te edites a ti mismo'); }
  if(!$_POST['name']) { $_POST['name'] = $row[1]; }
  if(!$_POST['message']) { $_POST['message'] = $row[2]; }
  if(!$_POST['nick']) { $_POST['nick'] = $row[3]; }
  if(strlen($_POST['name']) > 90) { die('0El nombre no debe ser mayor a 90'); }
  if(ctype_digit($_POST['nick'])) { die('0El nick no permite emm, n&uacute;meros'); }
  if(!preg_match('/^[a-z0-9\_\-]{4,16}$/i', $_POST['nick'])) { die('0el nick debe de tener entre 4 y 16 caracteres y letras'); }
  if(strlen($_POST['message']) > 255) { die('0El mensaje no debe de exceder los 255 caracteres'); }
  mysql_query('UPDATE `users` SET `nick` = \''.mysql_clean($_POST['nick']).'\', `name` = \''.mysql_clean($_POST['name']).'\', `message` = \''.mysql_clean($_POST['message']).'\' WHERE `id` = \''.$row[0].'\' LIMIT 1');
  die('1Datos actualizados!');
}
if(!mysql_num_rows($user = mysql_query('SELECT `id`, `nick`, `name`, `message` FROM `users` WHERE `id` = \''.intval($_GET['id']).'\''))) { die('0: El usuario no existe pacha'); }
$row = mysql_fetch_row($user);
?>
1<form name="edit">
<div style="display: none;" class="redBox" id="error_data"></div>
<div class="data">
	<label>Nick</label>
	<input type="text" name="nick" id="nick" value="<?=$row[1];?>" class="c_input">
</div>
<div class="data">
	<label>Nombre</label>
	<input type="text" name="name" id="name" value="<?=$row[2];?>" class="c_input">
</div>
<div class="data">
	<label>Mensaje (255 limite)</label>
	<textarea style="height: 80px;" name="message" id="message" value="<?=$row[3];?>"  class="c_input_desc"></textarea>
    <div style="clear:both"></div>
</div>
</form>