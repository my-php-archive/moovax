<?php
if(!$_POST['id'] || !ctype_digit($_POST['id'])) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Para denunciar una foto debes loguearte'); }
if(!mysql_num_rows($qs = mysql_query('SELECT `id`, `author`, `status` FROM `photos` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La foto que intentas denunciar no existe'); }
list($id, $author, $status) = mysql_fetch_row($qs);
if($author == $logged['id']) { die('0: No es posible denunciar tu foto'); }
if($status != 0) { die('0: La foto ya fue eliminada'); }
?>
1:
<div class="form-container" id="denunciar-post">
	<div style="display: none;margin-bottom:10px;padding:8px;" class="redBox" id="error_data"></div>
	<div class="data">
						<font class="size12">
						<b>Razón de la denuncia:</b></font><br>
						<select style="width:180px" tabindex="1" id="razon" name="razon">
							<option value="0">Foto ya agregada</option>
							<option value="1">Hace Spam</option>
							<option value="2">Contiene Pornografia</option>
							<option value="3">Es Gore o asqueroso</option>
							<option value="4">Contiene violencia</option>
							<option value="5">Es racista</option>
							<option value="6">No cumple con el protocolo</option>
							<option value="7">Otra razón (especificar)</option>
						</select>
	</div>
	<div class="data">
		<label>Comentarios</label>
		<textarea onblur="no_foco(this);" onfocus="foco(this);" style="height: 50px;" name="comentario" id="comentario" class="c_input_desc"></textarea>
		<font size="1">En el caso de ser Re-foto se debe indicar el enlace de la foto original.</font>
	</div>

</div>