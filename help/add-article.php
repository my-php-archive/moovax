<?php
if(!defined('help')) { die('0: No sabias que formabas parte de la organizacion al qaeda mmm'); }
if(!$logged['id']) { fatal_error('Para agregar pijas debes est&aacute;r logueado'); }
if(!allow('admin_help')) { die; }
if($_GET['id']) {
  if(!ctype_digit($_GET['id'])) { fatal_error('Chupame el pito'); }
  if(!mysql_num_rows($e = mysql_query('SELECT * FROM `articles` WHERE `id` = \''.intval($_GET['id']).'\''))) { fatal_error('El article no existe'); }
  $row = mysql_fetch_assoc($e);
  if($row['author'] != $logged['id'] && !allow('admin_help')) { die; }
  if($row['status'] != 0) { die('0: Se encuentra eliminado q3'); }
  $editing = true;
}
//In the air tonight eeeer34
?>
<div id="cuerpocontainer">
<div style="width:680px;float:left" >
<div id="return_add" style="display:none"></div>
<div id="add_art">
<div class="box_title_content">
<div class="box_txt"><?=($editing ? 'Editar' : 'Agregar');?> art&iacute;culo</div>
</div>
<div class="box_cuerpo_content">
<form method="POST" action="/ayuda/agregar-send.php">
<font class="size11"><b>Titulo:</b></font>
<br />
<input  style="height:14px;" name="titulo" type="text" id="titulo" maxlength="90" size="100"<?=($editing ? ' value="'.$row['title'].'"' : '');?>>
<br >
<div id="MostrarError1" class="capsprot">Debes ingresar el titulo del art&iacute;culo.</div>
<br />
<font class="size11"><b>Mensaje del art&iacute;culo:</b></font>
<br />
<textarea id="VPeditor" style="width:660px;height:180px;" name="articulo" onfocus="foco(this);" onblur="no_foco(this);"><?=($editing ? $row['body'] : '');?></textarea>
<span id="MostrarError2" class="capsprot">El cuerpo del art&iacute;culo no debe estar en blanco.</span>
<br /><br />
<font class="size11"><b>Categor&iacute;a:</b></font>
<br /><br>
<span class="floatL">
<select tabindex="4" name="categoria" id="categoria" style="width:200px">
<option value="-1" selected="selected">Elegir categor&iacute;a</option>
<?php
$query = mysql_query('SELECT `id`, `name` FROM `help_categories` ORDER BY `name` ASC');
while($r = mysql_fetch_row($query)) {
  echo '<option value="'.$r[0].'"'.($r[0] == $row['cat'] && $editing ? ' selected="selected"' : '').'>'.$r[1].'</option>'."\n";
}
?>
</select>
<br>
<span id="MostrarError3" class="capsprot">Selecciona una categor&iacute;a.</span>
</span>
<span class="floatR">
<input class="Boton BtnBlue" onclick="help.<?=($editing ? 'edit_art('.$row['id'].')' : 'add_art()');?>;return false" type="button" value="<?=($editing ? 'Editar' : 'Publicar');?> art&iacute;culo" title="<?=($edit ? 'Editar' : 'Publicar');?> art&iacute;culo" />
</span>
<div class="clearfix"></div>
</form></div></div>
</div>
<div style="width:242px;float:left;margin-left:6px;">
<div class="box_title_content">
<div class="box_txt">Recomendaciones</div>
</div>
<div class="box_cuerpo_content">
Hola <b><?=$logged['nick'];?></b>, desde esta secci&oacute;n podr&aacute;s administrar el sistema ayuda de Voope.
<br><br>
Podras agregar art&iacute;culos nuevos, editar los art&iacute;culos, eliminar los art&iacute;culos, agregar categor&iacute;as, editar categor&iacute;as y eliminar categor&iacute;as de los art&iacute;culos.<br><br>Ten en cuenta que al momento de crear un art&iacute;culo puedes usar c&oacute;digos BBC.
</div>
</div>
<div class="clearBoth"></div>
</div>