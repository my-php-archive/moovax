<?php
if(!defined('adm')) { die; }
if(!allow('ban')) { fatal_error('chupame la pija moyano'); }
?>
<div id="adm-right">
	<div class="user_info">
		<h2>Usuarios baneados</h2>

	</div><table class="linksList">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Usuarios baneados</th>
				<th>Raz&oacute;n</th>
				<th>IP</th>
				<th>Por</th>

				<th>Fecha</th>
				<th>Desbanear</th>
                <?php if(allow('edit_user')) { echo '<th>Editar</th> '; } ?>
            </tr>
		</thead>
		<tbody>
        <?php
        $query = 'SELECT `u`.`id`, `u`.`nick`, u.`lastip`, `ban`.`text`, `ban`.`time`, u2.nick AS modera FROM `users` AS u INNER JOIN `banned` AS ban ON `u`.`id` = `ban`.`id_user` INNER JOIN `users` AS u2 ON ban.`id_mod` = u2.id WHERE `u`.`ban` = \'1\' ORDER BY `ban`.`time` DESC';
        $limit = 50;
        $total = mysql_num_rows(mysql_query($query));
        $num = ceil($total / $limit);
        $_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) && $_GET['p'] <= $num ? $_GET['p'] : 1;
        $act = ($_GET['p']-1)*$limit; //1x2 =2
        $query = mysql_query($query.' LIMIT '.$act.', '.$limit) or die(mysql_error());
        while($row = mysql_fetch_assoc($query)) {
        ?>
        <tr id="user_<?=$row['id'];?>">
				<td style="width:0px" title="<?=$row['nick'];?>"><img src="<?=$config['images'];?>/images/user.png" align="absmiddle"></td>
				<td style="text-align:left"><a href="/perfil/<?=$row['nick'];?>" target="_blank" title="<?=$row['nick'];?>" alt="<?=$row['nick'];?>"><?=$row['nick'];?></a></td>
				<td style="width:100px"><?=$row['text'];?></td>
				<td style="width:120px"><a href="/admin/rastrea/<?=$row['lastip'];?>" title="Rastrear IP"><?=$row['lastip'];?></a></td>
				<td style="width:50px"><a href="/perfil/<?=$row['modera'];?>"><?=$row['modera'];?></a></td>
				<td style="width:50px"><?=date('d/m/Y', $row['time']);?></td>
				<td style="width:50px"><a href="#" onclick="admin.unban('<?=$row['id'];?>'); return false" title="Desbanear cuenta"><img id="banear_<?=$row['id'];?>" src="<?=$config['images'];?>/images/reload.png" title="Desbanear cuenta" align="absmiddle"></a></td>
                <?php
                if(allow('edit_user')) {
                  echo '<td style="width:50px"><a id="few" onclick="admin.edit_user(\''.$row['id'].'\'); return false;" href="#"><img src="'.$config['images'].'/images/icons/edit.png"></a></td>';
                }
                ?>
        </tr>
        <?php
        }
        ?>
				</tbody>
		</table>
		<div class="clear"></div><hr class="divider">
        <?php
        if($_GET['p'] > 1) { echo '<span class="floatL size12" style="font-weight:bold"><a title="Anteriores" href="/admin/baneados/page/'.($_GET['p']-1).'">&#171;Anteriores</a></span>'; }
        if($_GET['p'] < $num) { echo '<span class="floatR size12" style="font-weight:bold"><a title="Siguientes" href="/admin/baneados/page/'.($_GET['p']+1).'">Siguientes &#187;</a></span>'; }
        ?>


        </div>