<?php
if(!defined('adm')) { die; }
if(!allow('friend_sites')) { fatal_error('No tienes permisos para estar ac&aacute;'); }
?>
<div id="adm-right">
	<div class="user_info">
		<h2>Webs amigas</h2>
	</div>
    <?php
    $query = mysql_query('SELECT `id`, `url`, `name`, `time` FROM `urls` ORDER BY `id` DESC');
    if(mysql_num_rows($query)) {
    ?>
    <table class="linksList">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>ID</th>
				<th>Nombre</th>
				<th>Url</th>
                <th>Agregada</th>
                <th>Eliminar</th>
			</tr>
		</thead>
		<tbody>
        <tr id="new_few" style="display: none;"></tr>
        <?php
        while($hey = mysql_fetch_row($query)) {
        ?>
        <tr id="url<?=$hey[0];?>">
            <td style="width:0px" title=""><img src="<?=$config['images'];?>/images/url.png" /></span></td>
            <td style="width:10px"><?=$hey[0];?></td>
			<td style="width:120px"><?=$hey[2];?></td>
			<td style="width:120px"><a href="<?=$hey[1];?>">IR</a></td>
            <td style="width:120px"><?=timefrom($hey[3]);?></td>
            <td style="width:120px"><a onclick="admin.delete_web(<?=$hey[0];?>); return false;" href="#"><img src="<?=$config['images'];?>/images/delete.png" /></a></td>
		</tr>
        <?php
        }
        ?>
		</tbody>
	</table>
    <?php
    } else { echo '<div class="redBox"><b class="size11" style="text-align:center">No hay webs amigas</b></div>'; }
    ?>
	<div class="clear"></div>
</div>
<div style="clear:both"></div><span class="floatR"><input class="Boton Small BtnGreen" onclick="admin.add_web(); return false;" value="Agregar nueva web" type="button" /></span>