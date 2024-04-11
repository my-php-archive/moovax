<?php
if(!defined('help')) { die; }
if(!allow('admin_help')) { fatal_error('Que hac&eacute;s chulo!'); }
?>
<div id="cuerpocontainer">
<div style="width:680px;float:left">
<div class="boxtitleProfile clearfix">
<h3>Categor&iacute;as</h3>
</div>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="linksList">
<thead>
<tr>
<th>&nbsp;</th>
<th>Categor&iacute;a</th>
<th>Art&iacute;culos</th>
<th>URL</th>
<th>Descripci&oacute;n</th>
<th>Editar</th>
<th>Eliminar</th>
</tr>
</thead>
<tbody>
<?php
$query = mysql_query('SELECT * FROM `help_categories` ORDER BY `name` ASC');
if(mysql_num_rows($query)) {
  while($p = mysql_fetch_assoc($query)) {
?>
<tr id="category_<?=$p['id'];?>">
<td style="width:10px"><img src="<?=$config['images'];?>/images/ayuda/carpeta.png" alt="Categoria" title="Categoria" /></td>
<td style="text-align:left"><a href="/ayuda/<?=$p['url'];?>/"><?=$p['name'];?></a></td>
<td style="width:50px"><?=mysql_num_rows(mysql_query('SELECT `id` FROM `articles` WHERE `status` = \'0\' && `cat` = \''.$p['id'].'\''));?></td>
<td><?=$p['url'];?></td>
<td><?=$p['description'];?></td>
<td style="width:50px"><a href="#" onclick="help.edit_category('<?=$p['id'];?>'); return false;"><img src="<?=$config['images'];?>/images/ayuda/editar.png" alt="Editar categor&iacute;a" title="Editar categor&iacute;a" /></td>
<td style="width:50px"><a href="#" onclick="help.del_category('<?=$p['id'];?>'); return false"><img src="<?=$config['images'];?>/images/ayuda/borrar.png" alt="Eliminar categor&iacute;a" title="Eliminar categor&iacute;a" /></a></td>
</tr>
<?php
}
} else { echo '<div class="redBox">Nada por aqu&iacute;</div>'; }
?>
</tbody>
</table>

<br >
<div align="left">
<input type="button" class="Boton BtnPurple" value="Agregar categor&iacute;a" onclick="help.add_category();return false">
</div>
</div>
<div style="width:235px;float:left;margin-left:4px;padding:4px;border-left:1px dashed #CCC;">
<div class="boxtitleProfile clearfix">
<h3>Centro de Ayuda</h3>
</div>
Hola <b><?=$logged['nick'];?></b>, desde esta secci&oacute;n podr&aacute;s administrar el sistema ayuda de Voope.
<br><br>
Podras agregar art&iacute;culos nuevos, editar los art&iacute;culos, eliminar los art&iacute;culos, agregar categor&iacute;as, editar categor&iacute;as y eliminar categor&iacute;as de los art&iacute;culos.<br><br>Ten en cuenta que al momento de crear un art&iacute;culo puedes usar c&oacute;digos BBC.
</div>
<div class="clearBoth"></div>
</div><!-- /cuerpocontainer -->