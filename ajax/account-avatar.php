<?php
if(!defined('ok')) { die; }
$row = mysql_fetch_row($query);
?>
<script type="text/javascript">

function load_new_avatar()
{
	var f=document.forms.per;

	if(f.avatar.value.substring(0, 7)!='http://')
	{
		f.avatar.focus();
		dialogBox.alert('Error!', 'La direccion de tu avatar debe comenzar con http://');
		return;
	}

	window.newAvatar = new Image();
	window.newAvatar.src = f.avatar.value;
	newAvatar.loadBeginTime = (new Date()).getTime();
	newAvatar.onerror = show_error;
	newAvatar.onload = show_new_avatar;
	avatar_check_timeout();
}

function avatar_check_timeout()
{
	if(((new Date()).getTime()-newAvatar.loadBeginTime)>15)
	{
		dialogBox.alert('Error!', 'Este avatar no es recomendable. <b>Raz&oacute;n:</b> Muy lento');
		document.forms.per.avatar.focus();
	}
}
function show_error(){
	dialogBox.alert('Error!', 'Hubo un error al leer la imagen. Por favor, verifica que la direccion sea correcta.');
	document.forms.per.avatar.focus();
}
function show_new_avatar(){document.getElementById('miAvatar').src = newAvatar.src;}
function comprobar(avatar) {
if(avatar == ''){ $('#MostrarError1').show();  return false;} else $('#MostrarError1').hide(); account.edit_avatar();}
function set_default()
{
	$('#avatar').val( '<?=$config['images'];?>/images/avatar.gif').focus();

}
</script>
<form name="per" method="post" action="/enviar-avatar/">
		<div class="boxtitleProfile clearfix">
			<h3 style="margin-bottom:-6px;">Editar mi avatar</h3>

		</div>
	<div id="exito" class="yellowBox" style="display:none; margin:10px;"></div>
	<table width="100%" cellpadding="4">
						<tr valign="top">
							<td width="130px" valign="top">
							<div class="fondoavatar" style="overflow: auto; width: 130px;" align="right">
								<img alt="" src="<?=$row[1];?>" width="120" weight="120" align="left" vspace="4" hspace="4" id="miAvatar" onerror="error_avatar(this)" /></div></td>

							<td width="640px" valign="top"><br /><br /><center>Escribe una direcci&oacute;n v&aacute;lida para tu <strong>avatar</strong>.<br />Ejemplo: <b><?=$config['url'];?>/avatar.gif</b><br /><br />

							<input type="text"  size="64" maxlength="255" name="avatar" id="avatar" value="<?=$row[1];?>" />
							<input style="margin-left:-2px;" type="button" class="Boton Small BtnGreen" value="Previsualizar" onclick="load_new_avatar()" /><br />
							<div id="MostrarError1" class="capsprot" style="width: 300px; margin-top: 8px;">Falta agregar el avatar.</div>
							<label>
							<a href="#" onclick="set_default(); return false" title="Seleccionar avatar default">Sin ningun avatar <span style="font-size:10px;">(avatar default)</span>.</a>
							</label>
							</center>

							</td>
						</tr>

        <tr>
          <td colspan="3" align="center">
		  			<hr class="divider">
						<div class="redBox">* Si el avatar contiene pornograf&iacute;a, es morboso. Se borrar&aacute;.</div>
					</td>

				</tr>
			</table>
						<div align="center"><input onclick="return comprobar(this.form.avatar.value);" class="Boton BtnGray" value="Guardar cambios" title="Guardar cambios" type="button"></div>
				<input type="hidden" name="id_user" value="<?=$row[0];?>" />
					</form>