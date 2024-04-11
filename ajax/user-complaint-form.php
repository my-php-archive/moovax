<?php
if(!$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!mysql_num_rows($pp = mysql_query('SELECT `id`, `act`, `ban` FROM `users` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El usuario que vas a denunciar no existe'); }
list($id, $st, $bn) = mysql_fetch_row($pp);
if($id == $logged['id']) { die('0; No es posible denunciarte a ti mismo'); } /* inglip */
if($st == 0) { die('0: Este usuario no tiene su cuenta activada'); }
if($bn == 1) { die('0: Este usuario est&aacute; baneado'); }
?>
1:
<div class="redBox" style="display: none;margin-bottom:10px;padding:8px;" id="error_data"></div>
<div class="data">
    <font class="size12">
	    <b>Razón de la denuncia:</b>
    </font>
    <br>
	<select tabindex="1" id="razon" name="razon">
	    <option value="0">Hace Spam</option>
		<option value="1">Es Racista o irrespetuoso</option>
		<option value="2">Publica información personal</option>
		<option value="3">Publica Pornografia</option>
		<option value="4">No cumple con el protocolo</option>
		<option value="5">Otra razón (especificar)</option>
	</select>
</div>
<div class="data">
    <label>Comentarios</label>
	<textarea onblur="no_foco(this);" onfocus="foco(this);" style="height: 50px;" name="comentario" id="comentario" class="c_input_desc"></textarea>
	<font size="1">En el caso de ser cuenta <b>clon</b>, se debe indicar el usuario original.</font>
</div>