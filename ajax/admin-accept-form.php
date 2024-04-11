<?php
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `what`, `author`, `comment`, `type` FROM `complaints` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La denuncia ingresada no existe'); }
$row = mysql_fetch_assoc($query);
if($row['author'] == $logged['id']) { die('0: No puedes aceptar tus denuncias'); }
if(($row['what'] == '0' && !allow('complaints_posts')) || ($row['what'] == '1' && !allow('complaints_photos')) || ($row['what'] == '2' && !allow('complaints_users'))) { die('0: Que haces? :/'); }
switch($row['what']) {
  case '0': $title = 'Causa de eliminaci&oacute;n del post'; break;
  case '1': $title = 'Causa de eliminaci&oacute;n de la imagen'; break;
  case '2': $title = 'Raz&oacute;n de advertencia';
}
?>
1:
<div id="edit_cat" class="form-container">
	<div id="error_data" class="redBox" style="display: none;margin-bottom:10px;padding:8px;"></div>
	<div class="data">
		<label><?=$title;?>:</label>
		<input type="text" class="c_input" id="cause" name="cause" value="<?=$row['comment'];?>">
	</div>
	<div class="clear"></div>
</div>