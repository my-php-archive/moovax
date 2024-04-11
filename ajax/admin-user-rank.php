<?php
include('../config.php');
include('../functions.php');
if(!allow('edit_ranks')) { die('0: Anda a cagar kaissar'); }
if($_POST['user'] && $_POST['rango']) {
  if(!mysql_num_rows($query = mysql_query('SELECT `id`, `rank` FROM `users` WHERE `nick` = \''.mysql_clean($_POST['user']).'\''))) { die('0: El usuario ingresado no existe'); }
  if(!mysql_num_rows($ranks = mysql_query('SELECT `id` FROM `ranks` WHERE `id` = \''.intval($_POST['rango']).'\''))) { die('0: El rango ingresado no existe. Que intentas? ._.'); }
  list($id, $rank) = mysql_fetch_row($query);
  if($id == $key) { die('0: Ehh, este sos vos guachon'); }
  $ov = mysql_fetch_assoc($ranks);
  if($ov['id'] == $rank) { die('0: El usuario ya posee este rango'); }
  if($id == 1) { die('0: No puedes editar al big master'); }
  mysql_query('UPDATE `users` SET `rank` = \''.$ov['id'].'\' WHERE `id` = \''.$id.'\'');
  die('1: Cambios guardados!');
  //Hecho!
}
?>
1:
<div class="form-container" id="edit_cat">
	<div style="display: none;margin-bottom:10px;padding:8px;" class="redBox" id="error_data"></div>
	<div class="data">
		<label>Usuario:</label>
		<input type="text" value="" name="user" id="user" class="c_input">
	</div>
	<div class="data">
		<label class="floatL">Asignar al rango:</label>
			<select style="width:220px" id="rango" name="rango">
            <option value="">Seleccionar rango</option>
            <?php
            $fw = mysql_query('SELECT `id`, `name` FROM `ranks` ORDER BY id ASC');
            while(list($id, $name) = mysql_fetch_row($fw)) {
              echo '<option value="'.$id.'">'.$name.'</option>';
            }
            ?>
			</select>
	</div>
	<div class="clear"></div>
</div>