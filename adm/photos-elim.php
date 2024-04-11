<?php
if(!defined('adm')) { die; }
if(!allow('delete_photos')) { fatal_error('No tienes permisos para estar ac&aacute;', 'Stop for a minute'); }
?>
<div id="adm-right">
	<div class="user_info">
		<h2>Papelera de fotos</h2>
	</div>
    <table class="linksList">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Fotos eliminadas</th>
				<th>Fecha</th>
				<th>Moderador</th>
				<th>Reactivar</th>
				<th>Suprimir</th>
			</tr>
		</thead>
		<tbody>
        <?php
        $query = 'SELECT p.id, p.title, p.`time`, u.nick, cat.url, cat.name FROM `photos` AS p INNER JOIN history_mod AS h ON h.post = p.id INNER JOIN `users` AS u ON u.id = h.moderador INNER JOIN p_categories AS cat ON cat.id = p.cat WHERE h.type = \'1\' && p.`status` = \'1\' ORDER BY p.id DESC';
        $num = mysql_num_rows(mysql_query($query));
        $per = 20;
        $_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) ? $_GET['p'] : 1;
        $tot = ceil($num / $per);
        if($_GET['p'] > $tot) { $_GET['p'] = 1; }
        $lim = ($_GET['p']-1)*$per;
        $st = mysql_query($query.' LIMIT '.$lim.', '.$per);
        while($row = mysql_fetch_assoc($st)) {
        ?>
        <tr id="post_<?=$row['id'];?>">
		    <td style="width:0px" title="<?=$row['name'];?>"><span class="categoriaPost <?=$row['url'];?>"></span></td>
		    <td style="text-align:left"><a href="/fotos/fotos/<?=$row['id'];?>/<?=url($row['title']);?>.html" target="_blank" title="<?=$row['title'];?>" alt="<?=$row['title'];?>"><?=$row['title'];?></a></td>
		    <td style="width:120px"><span title="<?=date('d.m.Y', $row['time']);?> a las <?=date('G:i', $row['time']);?> hs." ts="<?=$row['time'];?>"><?=timefrom($row['time']);?></span></td>
		    <td style="width:120px"><a href="/perfil/<?=$row['nick'];?>"><?=$row['nick'];?></a></td>
		    <td style="width:50px"><a id="rct_img_<?=$row['id'];?>" href="#" onclick="admin.reactivar('<?=$row['id'];?>', 'foto'); return false" title="Reactivar"><img src="<?=$config['images'];?>/images/icons/reload.png" title="Reactivar" align="absmiddle"></a></td>
		    <td style="width:50px"><a id="spr_img_<?=$row['id'];?>" href="#" onclick="admin.suprimir('<?=$row['id'];?>', 'foto'); return false" title="Suprimir"><img src="<?=$config['images'];?>/images/icons/borrar.png" title="Suprimir" align="absmiddle"></a></td>
		</tr>
        <?php
        }
        ?>
		</tbody>
	</table>
	<div class="clear"></div>
    <?php
    if($_GET['p'] > 1) { echo '<span class="floatL size12" style="font-weight:bold"><a title="Anteriores" href="/admin-area/usuarios/ID/page/1">&#171; Anteriores</a></span>'; }
    if($_GET['p'] < $tot) { echo '<span class="floatR size12" style="font-weight:bold"><a title="Siguientes" href="/admin-area/usuarios/ID/page/3">Siguientes &#187;</a></span>'; }
    ?>
    <hr class="divider">
</div>