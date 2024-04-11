<?php
if(!defined('adm')) { die; }
if(!allow('ban_ip')) { fatal_error('No tienes permisos'); }
$query = 'SELECT i.*, u.nick FROM `ips_ban` AS i LEFT JOIN `users` AS u ON u.id = i.author ORDER BY `id` DESC';
$tot = mysql_num_rows(mysql_query($query));
$limit = 20;
$ppp = ceil($tot / $limit);
$p = $_GET['p'] && ctype_digit($_GET['p']) && $_GET['p'] <= $ppp ? $_GET['p'] : 1;
$lim = ($p-1)*$limit;
$query = mysql_query($query.' LIMIT '.$lim.', '.$limit) or die(mysql_error());
echo '<div id="adm-right">';
if($tot) {
?>
<div class="user_info">
<h2>Lista de IPs baneadas (<span id="nums" name="nums"><?=$tot;?></span>)</h2>
</div>
<table class="linksList">
<thead>
<tr>
<th>&nbsp;</th>
<th>IP</th>
<th>Tipo</th>
<th>Por</th>
<th>Eliminar</th>
</tr>
</thead>
<tbody>
<tr style="display: none" id="add_new"></tr>
<?php
while($row = mysql_fetch_assoc($query)) {
?>
<tr id="ip<?=$row['id'];?>">
<td style="width:20px" title="fewfew"><img src="<?=$config['images'];?>/images/vcard.png" align="absmiddle"></td>
<td style="text-align:left"><?=$row['ip'];?></td>
<td style="width:75px">
<?php
switch($row['type']) {
  case 0: echo '<span style="color: #006600;">Total</span>'; break;
  case 1: echo '<span style="color: #CC0033;">Parcial</span>'; break;
  default: echo '-';
}
?></td>
<td><?=$row['nick'];?></td>
<td style="width:75px"><a id="del<?=$row['id'];?>" href="#" onclick="admin.del_ip('<?=$row['id'];?>'); return false" title="Eliminar ip"><img src="<?=$config['images'];?>/images/icons/borrar.png" title="Eliminar ip" align="absmiddle"></a></td>
</tr>
<?php
}
?>
</tbody>
</table>
<br class="space">
<hr class="divider">
<?php
} else { echo '<div class="redBox size13">Nada por aqu&iacute;...</div>'; }
?>
<form onsubmit="admin.add_ip(); return false;" style="text-align: center;" id="ip_add">
<b>Escribe la IP:</b> <input type="text" name="ip" id="ip" /> &nbsp;
<b>Tipo:</b>
<select id="type" name="type">
<option value="0">Total</option>
<option value="1">Parcial</option>
</select> &nbsp;&nbsp;
<input type="submit" class="Boton Small BtnPurple" value="Agregar" type="button" />
</form>

<div id="success" class="yellowBox" style="display:none;">IP agregada con &eacute;xito!</div>

<?php
if($tot>$limit) {
  echo '<hr class="divider"> ';
  if($p<$ppp) { echo '<span class="floatR size12" style="font-weight:bold"><a title="Siguientes" href="/admin/ipban/page/'.($p+1).'">Siguientes &#187;</a></span>'; }
  if($p > 1) { echo '<span class="floatL size12" style="font-weight:bold"><a title="Anteriores" href="/admin/ipban/page/'.($p-1).'">&#171; Anterior</a></span>'; }
}
?>
</div><div style="clear:both"></div></div>   </div>

</div>