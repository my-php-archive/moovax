<?php
if(!defined('adm')) { die; }
if(!allow('show_mps')) { fatal_error('No tienes permisos para estar aqu&iacute;'); }
?>
<div id="adm-right">
	<div class="user_info">
		<h2>Mensajes enviados</h2>
	</div>
    <table class="linksList">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Asunto</th>
				<th>De</th>
				<th>Para</th>
				<th>Estado</th>
				<th>Ver</th>
				<th>Eliminar</th>
            </tr>
		</thead>
		<tbody>
        <?php
        $mp = 'SELECT u.`nick`, s.`id`, s.`receiver`, s.`issue`, s.`body`, s.`time`, s.`author_status`, s.`receiver_status` FROM `messages` AS s INNER JOIN `users` AS u ON u.id = s.author ORDER BY s.`id` DESC';
        $num = mysql_num_rows(mysql_query($mp));
        $_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) ? $_GET['p'] : 1;
        $per = 20;
        $tot = ceil($num / $per);
        if($_GET['p'] > $tot) { $_GET['p'] = 1; }
        $limit = ($_GET['p']-1)*$per;
        $query = mysql_query($mp.' LIMIT '.$limit.', '.$per);
        while($r = mysql_fetch_assoc($query)) {
        ?>
        <tr id="mensaje_deleted_<?=$r['id'];?>">
		    <td style="width:10px" ><img src="<?=$config['images'];?>/images/mensaje.png" align="absmiddle"></td>
			<td style="text-align:left"><?=$r['issue'];?></td>
			<td style="width:75px"><a href="/perfil/<?=$r['nick'];?>"><?=$r['nick'];?></a></td>
            <?php
            $m = mysql_fetch_assoc(mysql_query('SELECT `nick` FROM `users` WHERE `id` = \''.$r['receiver'].'\''));
            //echo $m['nick'];
            ?>
			<td style="width:75px"><a href="/perfil/<?=$m['nick'];?>"><?=$m['nick'];?></a></td>
			<td style="width:75px"><span id="msg_<?=$r['id'];?>"><?=($r['author_status'] == '0' || $r['receiver_status'] == '0' ? 'Activo' : 'Eliminado');?></span></td>
			<td style="width:75px"><a href="#" onclick="admin.ver_mp('<?=$r['id'];?>'); return false" title="Ver mensaje"><img src="<?=$config['images'];?>/images/eye.png" title="Ver mensaje" align="absmiddle"></a></td>
			<td style="width:75px"><?=($r['author_status'] == '0' || $r['receiver_status'] == '0' ? '<a id="del_mp_'.$r['id'].'" href="#" onclick="admin.del_mp(\''.$r['id'].'\'); return false" title="Eliminar mensaje"><img src="'.$config['images'].'/images/icons/borrar.png" align="absmiddle"></a>' : '');?></td>
        </tr>
        <?php
        }
        ?>
	   </tbody>
	</table>

  <div class="clear"></div>
  <hr class="divider">
  <?php
  if($_GET['p'] > 1) { echo '<span class="floatL size12" style="font-weight:bold"><a title="Anteriores" href="/admin/mensajes/page/'.($_GET['p']-1).'">&#171; Anteriores</a></span>'; }
  if($_GET['p'] < $tot) { echo '<span class="floatR size12" style="font-weight:bold"><a title="Siguientes" href="/admin/mensajes/page/'.($_GET['p']+1).'">Siguientes &#187;</a></span>'; }
  ?>
</div>