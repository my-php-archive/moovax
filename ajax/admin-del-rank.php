<?php
if(!$_POST['id_r']) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!allow('edit_ranks')) { die('0Chupame la pija'); }
if($_POST['id_r'] == '8' || $_POST['id_r'] == '9') { die('0Estos rangos no se tocan'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id` FROM `ranks` WHERE `id` = \''.intval($_POST['id_r']).'\''))) { die('0El rango no existe -baa'); }
$row = mysql_fetch_row($query);
if($_POST['newrango']) {
  if(!ctype_digit($_POST['newrango'])) { die('0Kaissar hackeando -are'); }
  if(!mysql_num_rows($new = mysql_query('SELECT `id` FROM `ranks` WHERE `id` = \''.intval($_POST['newrango']).'\''))) { die('0El rango que especificaste no existe ._.'); }
  $ne = mysql_fetch_assoc($new);
  if($ne['id'] == $row[0]) { die('0El rango especificado es igual al actual. Alto pete sos'); }
  if($ne['id'] == '7' || $ne['id'] == '8') { die('0No puedes darle a todos el rango de mod o admin'); }
  mysql_query('UPDATE `users` SET `rank` = \''.$ne['id'].'\' WHERE `rank` = \''.$row[0].'\'');
  mysql_query('DELETE FROM `ranks` WHERE `id` = \''.$row[0].'\'');
  die('1Datos actualizados!');
}
?>
<div id="edit_cat" class="form-container">
	<div id="error_data" class="redBox" style="display: none; margin-bottom:10px; padding:8px;"></div>
    <input style="display:none;" type="hidden" name="id" id="id" value="aaa" />
	<div class="data">
		<label class="floatL">Qu&eacute; rango tendr&aacute;n los usuarios ahora?</label>
			<select name="newrango" id="newrango" style="width:220px">
            <option value="">Seleccionar rango</option>
            <?php
            $q = mysql_query('SELECT `id`, `name` FROM `ranks` ORDER BY `id` ASC');
            while($rc = mysql_fetch_row($q)) {
              echo '<option'.(($_POST['id_r'] - 1) == $rc[0] ? ' selected="selected"' : '').' value="'.$rc[0].'">'.$rc[1].'</option>';
            }
            ?>
            </select>
	</div>
	<div class="clear"></div>
</div>