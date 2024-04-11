<?php
if(!defined('ok')) { die; }
$row = mysql_fetch_assoc($query);
?>
<div class="boxtitleProfile clearfix">
    <h3 style="margin-bottom:-6px;">Preferencias del sitio</h3>
</div>
<div id="exito" class="yellowBox" style="display:none; margin:10px;"></div>
    <form name="save_preferences">
	    <div class="column-complete">
		    <div class="left-column">
			    Mostrar mi informaci&oacute;n a:
			</div>
			<div class="right-column">
			    <span class="text-right-column">
				    <select name="mostrar_info" size="1">
					    <option<?=($row['show_info'] == '0' ? ' selected="selected"' : '');?> value="0">A todos</option>
						<option<?=($row['show_info'] == '1' ? ' selected="selected"' : '');?> value="1">Nadie</option>
						<option<?=($row['show_info'] == '2' ? ' selected="selected"' : '');?> value="2">Amigos</option>
						<option<?=($row['show_info'] == '3' ? ' selected="selected"' : '');?> value="3">Registrados</option>
					</select>
				</span>
			</div>
		</div>
		<div class="column-complete">
		    <div class="left-column">
			    Permitir comentarios en mi muro:
			</div>
			<div class="right-column">
			    <span class="text-right-column">
			        <select name="recibir_muro" size="1">
					    <option<?=($row['walls_comments'] == '0' ? ' selected="selected"' : '');?> value="0">Si</option>
						<option<?=($row['walls_comments'] == '1' ? ' selected="selected"' : '');?> value="1">No</option>
					</select>
				</span>
			</div>
		</div>
		<div class="column-complete">
		    <div class="left-column">
			    Recibir solicitudes de amistad:
			</div>
			<div class="right-column">
			    <span class="text-right-column">
				    <select name="recibir_amistad" size="1">
					    <option<?=($row['friends_request'] == '0' ? ' selected="selected"' : '');?> value="0">Si</option>
						<option<?=($row['friends_request'] == '1' ? ' selected="selected"' : '');?> value="1">No</option>
					</select>
				</span>
			</div>
		</div>
		<div class="column-complete">
		    <div class="left-column">
			    Recibir mensajes privados:
			</div>
			<div class="right-column">
			    <span class="text-right-column">
			        <select name="recibir_mp" size="1">
					    <option<?=($row['receive_pms'] == '0' ? ' selected="selected"' : '');?> value="0">Si</option>
						<option<?=($row['receive_pms'] == '1' ? ' selected="selected"' : '');?> value="1">No</option>
					</select>
				</span>
			</div>
		</div>
		<br><br><div align="center">

		<input type="hidden" name="id_user" value="<?=$logged['id'];?>">
		<input class="Boton BtnGray" onclick="account.edit_settings();" value="Guardar cambios" title="Guardar cambios" type="button"></div>
		</form>