<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('Por qu&eacute; no vas y te logueas pinche joto?'); }
if($logged['rank'] == 1) { fatal_error('Tu rango no te permite crear comunidades'); }
if($_POST) {
  $name = trim($_POST['nombre']);
  $url = strtolower(trim($_POST['shortname']));
  if(!$name || !$url || !$_POST['imagen'] || !$_POST['categoria'] || !$_POST['imagen'] || !$_POST['descripcion'] || !$_POST['rango_default']) { fatal_error('Faltan datos'); }
  if(!ctype_alnum($url)) { fatal_error('La url s&oacute;lo debe contener letras y numeros'); }
  if(strlen($name) > 32 || strlen($name) < 4) { fatal_error('El nombre debe tener entre 4 y 32 caracteres'); }
  if(!mysql_num_rows(mysql_query('SELECT `id` FROM `groups_categories` WHERE `id` = \''.intval($_POST['categoria']).'\''))) { fatal_error('La categoria ingresada no existe'); }
  if(!filter_var($_POST['imagen'], FILTER_VALIDATE_URL)) { fatal_error('La url de la im&aacute;gen ingresada no es v&aacute;lida'); }
  if(!$get = getimagesize($_POST['imagen'])) { fatal_error('La url ingresada no corresponde a la de una imagen'); }
  if($get[0] > 1024 || $get[1] > 1024) { fatal_error('La im&aacute;gen no puede exceder los 1024x1024pixeles.'); }
  if(strlen($_POST['descripcion']) < 15) { fatal_error('La descripci&oacute;n debe tener al menos 15 caracteres'); }
  if($_POST['rango_default'] > 3 || $_POST['rango_default'] < 1 || !ctype_digit($_POST['rango_default'])) { fatal_error('Chupame la japi'); }
  if($logged['rank'] != '9') { unset($_POST['oficial']); }
  if($_POST['idco'] && ctype_digit($_POST['idco'])) {
    if(!mysql_num_rows($rws = mysql_query('SELECT `id`, `status`, `url` FROM `groups` WHERE `id` = \''.$_POST['idco'].'\''))) { fatal_error('La comunidad no existe'); }
    $pp = mysql_fetch_row($rws);
    if($pp[1] != 0) { fatal_error('La comunidad fue eliminada'); }
    if(!mysql_num_rows($r = mysql_query('SELECT `rank` FROM `groups_members` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$pp[0].'\''))) { fatal_error('No perteneces a esta comunidad'); }
    $rank = mysql_fetch_row($r);
    if($rank[0] != 5 && !allow('editgroup')) { fatal_error('No tienes permisos hijo de la re concha de tu hermana puto demierda'); }
    if($url != $pp[2]) { fatal_error('Qu&eacute; intentas!?'); }
    mysql_query('UPDATE `groups` SET `name` = \''.mysql_clean($name).'\', `desc` = \''.mysql_clean($_POST['descripcion']).'\', `avatar` = \''.mysql_clean($_POST['imagen']).'\', `cat` = \''.intval($_POST['categoria']).'\', `private` = \''.($_POST['privada'] ? 1 : 0).'\', `rankdefault` = \''.intval($_POST['rango_default']).'\', `type` = \''.($_POST['oficial'] ? 1 : 0).'\' WHERE `id` = \''.$pp[0].'\' LIMIT 1') or fatal_error('Error en la query:'.mysql_error());
    mysql_query('INSERT INTO `groups_actions` (`author`, `group`, `action`, `title`, `url`, `time`) VALUES (\''.$logged['id'].'\', \''.$pp[0].'\', \'2\', \''.mysql_clean($name).'\', \'/comunidades/'.$pp[2].'\', \''.time().'\')');
    fatal_error('La comunidad fue editada satisfactoriamente', 'EAAA!', 'Ir a la comunidad', '/comunidades/'.$pp[2].'/', 'BtnBlack');
  }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups` WHERE `url` = \''.mysql_clean($url).'\''))) { fatal_error('El nombre corto ingresado ya est&aacute; en uso'); }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups` WHERE `time` > \''.(time()-86400).'\' && `author` = \''.$logged['id'].'\'')) && $logged['rank'] != 9) { fatal_error('S&oacute;lo puedes crear una comunidad por d&iacute;a'); }
  mysql_query('INSERT INTO `groups` (`author`, `name`, `url`, `desc`, `avatar`, `status`, `time`, `cat`, `type`, `private`, `rankdefault`) VALUES (\''.$logged['id'].'\', \''.mysql_clean($name).'\', \''.mysql_clean($url).'\', \''.mysql_clean($_POST['descripcion']).'\', \''.mysql_clean($_POST['imagen']).'\', \''.($_POST['oficial'] ? 1 : 0).'\', \''.time().'\', \''.intval($_POST['categoria']).'\', \'0\', \''.($_POST['privada'] ? 1 : 0).'\', \''.intval($_POST['rango_default']).'\')') or fatal_error(mysql_error());
  $id = mysql_insert_id();
  mysql_query('INSERT INTO `groups_members` (`user`, `status`, `group`, `rank`, `time`) VALUES (\''.$logged['id'].'\', \'0\', \''.$id.'\', \'5\', \''.time().'\')');
  mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.mysql_clean($name).'\', \'/comunidades/'.mysql_clean($url).'\', \''.$id.'\', \''.time().'\', \'5\')') or die(mysql_error());
  fatal_error('Tu comunidad ya se encuentra creada. Todo el mundo la est&aacute; viendo', 'YEAH!', 'Ir a mi nueva comunidad', '/comunidades/'.htmlspecialchars($url).'/', 'BtnBlue');
}
if($_GET['id']) {
  if(!mysql_num_rows($query = mysql_query('SELECT * FROM `groups` WHERE `url` = \''.mysql_clean($_GET['id']).'\''))) { fatal_error('La comunidad no existe'); }
  $row = mysql_fetch_assoc($query);
  if($row['status'] != 0) { fatal_error('La comunidad fue eliminada'); }
  //Miembro?
  if(!mysql_num_rows($few = mysql_query('SELECT `rank` FROM `groups_members` WHERE `group` = \''.$row['id'].'\' && `user` = \''.$logged['id'].'\'')) && !allow('editgroup')) { fatal_error('No eres miembro de la comunidad'); }
  $rank = mysql_fetch_row($few);
  if($rank[0] != 5 && !allow('editgroup')) { fatal_error('No tenes permisos para editar esta comunidad hijo de puta'); }
  $edit = true;
}
?>
<div id="main_content">
<div class="breadcrumb">
<ul>
<li class="first"><a href="/" accesskey="1" class="home"></a></li>
<li><a href="/comunidades/" title="Comunidades">Comunidades</a></li>
<li style="font-weight:bold;"><?=($edit ? 'Editar' : 'Crear');?> Comunidad</li><li class="last"></li>
</ul>
</div>
<div class="clear"></div>
<div class="creartema-left">
<?php
if(!$edit) {
?>
<div class="box_title_content">
<div class="box_txt">Importante</div>
</div>
<div class="box_cuerpo_content">Antes de crear una comunidad es importante que leas el <a href="/static/protocolo/">protocolo</a>.<br /><br />
Al crear la comunidad vas a ser due&ntilde;o/Administrador de tal por lo tanto tendr&aacute;s todos los permisos de un Administrador.<br /><br />
Podes crear tu propio protocolo para tu comunidad, pero siempre respetando el protocolo general.<br /><br />

Si tenes dudas sobre las comunidades visita <a href="/ayuda/categoria/comunidades/">este enlace</a>.</div>
<br class="space">
<div class="yellowBox" style="margin-bottom:12px;font-weight:bold;">Tienes <b>Ilimitadas</b> comunidades disponibles para crear</div>
<?php } ?>
<div class="box_title_content"><div class="box_txt">Destacados</div></div><div class="box_cuerpo_content"><p align="center"></p></div>
</div>

<div class="creartema-right"><div class="box_title_content"><div class="box_txt"><?=($edit ? 'Editando la comunidad '.$row['name'] : 'Crear nueva comunidad');?></div></div>
<div class="box_cuerpo_content">
<form name="add_comunidad" method="post" action="/comunidades/creando/">
<?php
if($edit) { echo '<input type="hidden" id="idco" name="idco" value="'.$row['id'].'" />'; }
?>
<div class="form-container">
<div class="dataL"><label for="uname">Nombre de la comunidad</label>
<input class="c_input"<?=($edit ? ' value="'.$row['name'].'"' : '');?> name="nombre" tabindex="1" datatype="text" dataname="Nombre" type="text" />
</div>
<div class="dataR">
<label for="uname" style="float:left;">Nombre corto</label>
<span class="gif_cargando" id="shortname" style="top:0px;float:right;display:none;"><img src="<?=$config['images'];?>/images/icons/cargando.gif" alt="" /></span>
<input onfocus="foco(this);" class="c_input" name="shortname" tabindex="2" onkeyup="comunidades.crear_shortname_key(this.value)" onblur="no_foco(this);comunidades.crear_shortname_check(this.value)" datatype="text"<?=($edit ? 'value="'.$row['url'].'"' : '');?> dataname="Nombre corto" style="width:254px;" type="text" />
<div class="desform">URL de la comunidad: <br /><strong><?=$config['url'];?>/comunidades/<span id="preview_shortname"></span></strong></div>
<span id="msg_crear_shortname"></span>
</div>
<div class="clearBoth"></div>
<div class="dataL">
<label for="uname">Imagen</label>
<input  class="c_input" value="<?=($edit ? $row['avatar'] : 'http://');?>" name="imagen" tabindex="3" datatype="url" dataname="Imagen" type="text" />
</div>
<div class="dataR">
<span class="gif_cargando floatR" id="subcategoria" style="top: 0px;"></span>
<label for="fname">Categoria</label>
<select style="width:264px;margin-top:5px; height: 25px;vertical-align:middle;" name="categoria">
<option value="-1" selected="true">Elegir una categor&iacute;a</option>
<?php
$query = mysql_query('SELECT id, name FROM `groups_categories` ORDER BY `name` ASC');
while(list($id, $name) = mysql_fetch_row($query)) {
  echo '<option value="'.$id.'"'.($id == $row['cat'] && $edit ? ' selected="true"' : '').'>'.$name.'</option>';
}
?>
</select>
</div>
<div class="clearBoth"></div>
<div class="data">
<label for="uname">Descripci&oacute;n</label>
<textarea  class="c_input_desc autogrow" style="display:block;width:540px;" name="descripcion" tabindex="7" datatype="text" dataname="Descripcion"><?=($edit ? $row['desc'] : '');?></textarea>
</div>
</div>
<hr style="clear: both; margin-bottom: 15px; margin-top: 20px;" class="divider" />
<div class="dataL dataRadio">
<label for="lname"><b>Acceso</b></label>
<div class="postLabel"><br />

<fieldset>
  <legend><label for="privada_1" class="tit_lab">Todos</label></legend>
  <table>
  <tr>
  <td style="width:18px;padding:0px;margin:0px;"><input name="privada" id="privada_1" value="0"<?=($row['private'] == 0 && $edit ? ' checked="checked"' : '');?> tabindex="9" type="radio" /></td>
  <td><p class="descRadio">Toda persona que entra a <?=$config['name'];?> tiene la posibilidad de entrar y ver el contenido de tu comunidad.</p></td>
  </tr>
  </table>
</fieldset>
<fieldset>
  <legend><label for="privada_2" class="tit_lab">S&oacute;lo usuarios registrados</label></legend>
  <table>
  <tr>
  <td style="width:18px;padding:0px;margin:0px;"><input name="privada" id="privada_2" value="1"<?=($row['private'] == 1 && $edit ? ' checked="checked"' : '');?> type="radio" /></td>
  <td><p class="descRadio">Todo aquel que no este registrado en <?=$config['name'];?> no podr&aacute; ver el contenido de tu comunidad.</p></td>
  </tr>
  </table>
</fieldset>
</div>
</div>
<div class="dataR dataRadio" id="rango_default">
<label for="fname"><b>Permisos</b></label>
<div class="postLabel">
<br />

<fieldset>
  <legend>
  <label for="permisos_1" class="tit_lab">Posteador</label>
  </legend>
  <table>
  <tr>
  <td style="width:18px;padding:0px;margin:0px;"><input name="rango_default" id="permisos_1" value="3"<?=($row['rankdefault'] == 1 && $edit ? ' checked="checked"' : '');?> type="radio" /></td>
  <td><p class="descRadio">Los usuarios al ingresar en tu comunidad podr&aacute;n comentar y crear temas.</p></td>
  </tr>
  </table>
</fieldset>

<fieldset>
<legend><label for="permisos_2" class="tit_lab">Comentador</label></legend>
<table>
<tr>
<td style="width:18px;padding:0px;margin:0px;"><input name="rango_default" id="permisos_2" value="2"<?=($row['rankdefault'] == 2 && $edit ? ' checked="checked"' : '');?> type="radio" /></td>
<td><p class="descRadio">Los usuarios al participar en tu  comunidad s&oacute;lo podr&aacute;n comentar pero no estar&aacute;n habilitados para crear nuevos temas.</p></td>
</tr>
</table>
</fieldset>
<fieldset>
<legend>
<label for="permisos_3" class="tit_lab">Visitante</label>
</legend>
<table>
<tr>
<td style="width:18px;padding:0px;margin:0px;"><input name="rango_default" id="permisos_3" value="1"<?=($row['rankdefault'] == 3 && $edit ? ' checked="checked"' : '');?> type="radio" /></td>
<td>
<p class="descRadio">Los usuarios al participar en tu comunidad no podr&aacute;n comentar ni tampoco crear temas.</p>
</td>
</tr>
</table>
</fieldset>
</div>
<fieldset>
<legend class="tit_lab">Nota:</legend>
<p class="descRadio">
El permiso seleccionado se le asignar&aacute; autom&aacute;ticamente al usuario que se haga miembro, sin embargo, podr&aacute;s modificar el permiso a cada usuario especifico.</p>

</fieldset>
</div>
<?php if($logged['rank'] == '9') { ?>
<div class="postLabel"><br />

<fieldset>
  <legend><label for="privada_1" class="tit_lab">Oficial</label></legend>
  <table>
  <tr>
  <td style="width:18px;padding:0px;margin:0px;"><input name="oficial" id="oficial" value="1"<?=($row['type'] == 1 && $edit ? ' checked="checked"' : '');?> tabindex="9" type="radio" /></td>
  <td><p class="descRadio">La comunidad ser&aacute; oficial.</p></td>
  </tr>
  </table>
</fieldset>

</div>
<?php } ?>


<hr style="clear: both; margin-bottom: 15px; margin-top: 20px;" class="divider" /><div id="buttons" align="left"><input tabindex="14" title="<?=($edit ? 'Editar' : 'Crear');?> comunidad" value="<?=($edit ? 'Editar' : 'Crear');?> comunidad" class="Boton BtnRed" name="Enviar" type="submit" /></div></form></div>
<div style="clear:both"></div></div>
<div style="clear:both"></div></div>
</div></div>