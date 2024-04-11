<?php
if(!defined('adm')) { die; }
if(!allow('edit_ranks')) { fatal_error('Chupala moyano'); }
?>
<div id="adm-right">
	<div class="user_info">
		<h2>Rangos de <?=$config['name'];?></h2>

	</div><table class="linksList">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Rango</th>
				<th>Usuarios</th>
				<th>Editar</th>
				<th>Eliminar</th></tr>

		</thead>
		<tbody>
        <?php
        $query = mysql_query('SELECT `id`, `name`, `img`, `points` FROM `ranks` ORDER BY `id` DESC');
        while($mm = mysql_fetch_row($query)) {
          echo '<tr id="rango_'.$mm[0].'">
				<td style="width:20px" title="'.$mm[1].'"><img src="'.$config['images'].'/images/rangos/'.$mm[2].'" align="absmiddle"></td>
				<td style="text-align:left">'.$mm[1].'</td>
				<td style="width:75px">('.mysql_num_rows(mysql_query('SELECT `id` FROM `users` WHERE `rank` = \''.$mm[0].'\'')).' usuarios)</td>
				<td style="width:75px"><a id="edit_'.$mm[0].'" href="#" onclick="admin.edit_grade(\''.$mm[0].'\'); return false" title="Editar rango"><img src="'.$config['images'].'/images/icons/sort.png" title="Editar rango" align="absmiddle"></a></td>
				<td style="width:75px"><a id="del_'.$mm[0].'" href="#" onclick="admin.del_grade(\''.$mm[0].'\'); return false" title="Eliminar rango"><img src="'.$config['images'].'/images/icons/borrar.png" title="Eliminar rango" align="absmiddle"></a></td>
                </tr>';
        }
        ?>
    	</tbody>
		</table>
		<br class="space">
		<span class="floatL"><input type="button" value="Asignar rangos" onclick="admin.user_grade(); return false" class="Boton Small BtnGray"></span>

		<span class="floatR"><input type="button" value="Nuevo rango" onclick="admin.new_grade(); return false" class="Boton Small BtnGray"></span>
		<div class="clear"></div></div>