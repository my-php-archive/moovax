<?php
if(!defined($config['define']) || !defined('adm')) { die; }
if(!allow('delete_posts')) { fatal_error('Anda a cagar chupaverga'); }
?>
<div id="adm-right">
	<div class="user_info">
		<h2>Papelera de posts</h2>

	</div><table class="linksList">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Posts eliminados</th>
				<th>Fecha</th>
				<th>Moderador</th>
                <th>Causa</th>
				<th>Reactivar</th>
				<th>Suprimir</th>
			</tr>

		</thead>
		<tbody>
        <?php
        $_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) ? $_GET['p'] : 1;
        $query = 'SELECT p.`id`, p.`title`, cat.`url`, u.`nick`, h.`reason`, `h`.`time` FROM `posts` AS p INNER JOIN `history_mod` AS h ON h.post = p.id INNER JOIN `users` AS u ON u.id = h.moderador LEFT JOIN `categories` AS cat ON cat.id = p.cat WHERE p.`status` = \'1\' || p.`status` = \'2\' ORDER BY h.`id` DESC ';
        $total = mysql_num_rows(mysql_query($query));
        $per = 15;
        $ppp = ceil($total / $per);
        if($_GET['p'] > $ppp && $_GET['p'] > 1) { die('Error provocado'); }
        $limit = ($_GET['p']-1)*$per;
        $querys = mysql_query($query.' LIMIT '.$limit.', '.$per) or die(mysql_error());
        while($row = mysql_fetch_assoc($querys)) {
        ?>

        <tr id="post_<?=$row['id'];?>">
				<td style="width:0px" title="<?=$row['name'];?>"><span class="categoriaPost <?=$row['url'];?>"></span></td>
				<td style="text-align:left"><a href="/posts/<?=$row['url'];?>/<?=$row['id'];?>/<?=url($row['title']) ;?>.html" target="_blank" title="<?=$row['title'];?>" alt="<?=$row['title'];?>"><?=$row['title'];?></a></td>
				<td style="width:120px"><span title="07.02.2012 a las 21.02 hs." ts="<?=$row['time'];?>"><?=timefrom($row['time']);?></span></td>
				<td style="width:120px"><a href="/perfil/<?=$row['nick'];?>"><?=$row['nick'];?></a></td>
                <td style="width:120px"><a href="/perfil/<?=$row['reason'];?>"><?=$row['reason'];?></a></td>
				<td style="width:50px"><a id="rct_img_9140" href="#" onclick="admin.reactivar('<?=$row['id'];?>', 'post'); return false" title="Reactivar"><img src="<?=$config['images'];?>/images/icons/reload.png" title="Reactivar" align="absmiddle"></a></td>

				<td style="width:50px"><a id="spr_img_9140" href="#" onclick="admin.suprimir('<?=$row['id'];?>', 'post'); return false" title="Suprimir"><img src="<?=$config['images'];?>/images/icons/borrar.png" title="Suprimir" align="absmiddle"></a></td>
		</tr>
        <?php
        }
        ?>

				</tbody>
		</table>
		<div class="clear"></div>
        <?php
        if($total > $per) {
        ?>
        <hr class="divider">
        <?php
        if($_GET['p'] > 1) { echo '<span class="floatL size12" style="font-weight:bold"><a title="Anteriores" href="/admin/papelera/posts/page/'.($_GET['p']-1).'">&#171; Anteriores</a></span>    '; }
        if($_GET['p'] < $ppp) { echo '<span class="floatR size12" style="font-weight:bold"><a title="Siguientes" href="/admin/papelera/posts/page/'.($_GET['p']+1).'">Siguientes &#187;</a></span>'; }
        }
        ?>

</div>
<!-- end -->