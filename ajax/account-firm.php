<?php
if(!defined('ok')) { die; }
$row = mysql_fetch_row($query);
?>
<div class="boxtitleProfile clearfix">
    <h3 style="margin-bottom:-6px;">Editar mi firma</h3>
</div>
<div id="exito" class="yellowBox" style="display:none; margin:10px;"></div>
<?php
if($_GET['_']) { echo '<a href="/cuenta/firma">Mostrar editor</a> '; }
?>
<form name="save_signature">
		<textarea  name="firma" tabindex="1" style="width:745px;" rows="6" id="VPeditor" name="VPeditor"><?=$row[1];?></textarea>
	<div id="MostrarError1" class="capsprot">La firma no debe tener m&aacute;s de 255 car&aacute;cteres.</div>
	<br /><div align="left"><input class="Boton BtnGray" type="button" onclick="account.edit_signature();" value="Guardar cambios" title="Guardar cambios" /></div>
	<input type="hidden" name="id_user" value="<?=$row[0];?>">
</form>
