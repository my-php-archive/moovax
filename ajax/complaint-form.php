<?php
if(!$_POST['id']) { die('0: Faltan datos...'); }
include('../config.php');
include('../functions.php');
if(!$key) { die('0: No puedes denunciar si no est&aacute;s logueado'); }
if(!ctype_digit($_POST['id'])) { die('0: La denuncia debe de ser un n&uacute;mero'); }
if(!mysql_num_rows($rpost = mysql_query('SELECT id, author, status FROM `posts` WHERE id = \''.intval($_POST['id']).'\''))) { die('0: El post no existe'); }
$row = mysql_fetch_assoc($rpost);
if($row['author'] == $key) { die('0: No puedes denunciar tus posts'); }
if($row['status'] != '0') { die('0: El post ya se encuentra eliminado o en acumulaci&oacute;n de denuncias'); }
?>
1:
<div class="form-container" id="denunciar-post">
	<div style="display: none;margin-bottom:10px;padding:8px;" class="redBox" id="error_data"></div>
	<div class="data">
						<font class="size12">
						<b>Raz&oacute;n de la denuncia:</b></font><br>
						<select tabindex="1" id="razon" name="razon">
							<option value="1">Re-post</option>
							<option value="2">Se hace Spam</option>
							<option value="3">Tiene enlaces muertos</option>
							<option value="4">Es Racista o irrespetuoso</option>
							<option value="5">Contiene información personal</option>
							<option value="6">El Titulo esta en mayúscula</option>
							<option value="7">Contiene Pornografia</option>
							<option value="8">Es Gore o asqueroso</option>
							<option value="9">Está mal la fuente</option>
							<option value="10">Post demasiado pobre</option>
							<option value="11">Pide contraseña y no está</option>
							<option value="12">No cumple con el protocolo</option>
							<option value="13">Otra razón (especificar)</option>
						</select>

	</div>
	<div class="data">
		<label>Comentarios</label>
		<textarea onblur="no_foco(this);" onfocus="foco(this);" style="height: 50px;" name="comentario" id="comentario" class="c_input_desc"></textarea>
		<font size="1">En el caso de ser Re-post se debe indicar el enlace del post original.</font>
	</div>

</div>