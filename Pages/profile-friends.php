<?php
if(!defined('ok')) { die; }
$tot = mysql_num_rows(mysql_query($query));
$per = 50;
$num = ceil($tot / $per);
$_GET['p'] = (ctype_digit($_GET['p']) && $_GET['p'] > 1 && $_GET['p'] <= $num) ? $_GET['p'] : 1;
$limit = ($_GET['p']-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per) or die(mysql_error());
?>
<div class="user_info clearfix">
    <h2>Amigos de @<?=$row['nick'];?> (<span id="can_buddies"><?=$tot;?></span>)</h2>
</div>
<div id="error_del"></div>
<div class="box_cuerpo_content" style="border-top:1px solid #C9CACB;">
<?php
if($tot) {
  while($pq = mysql_fetch_assoc($query)) {
?>
<div id="amis_<?=$pq['uid'];?>">
<table>
    <tbody>
	<tr>
	    <td valign="middle" align="left" >
		    <a href="/perfil/<?=$pq['nick'];?>/">
			<img src="<?=$pq['avatar'];?>" onerror="error_avatar(this)" alt="Avatar" height="70" width="70"></a>
		</td>
		<td valign="top" align="left" width="310px">
		    <a title="<?=$pq['nick'];?>" href="/perfil/<?=$pq['nick'];?>/" style="color:#956100;font-size:15px;">
			<b>@<?=$pq['nick'];?></b></a><br>
			<b>Son amigos desde el <?=date('d/m/Y', $pq['time']);?></b>
			<br><span class="size10">
            <?php
            if($pq['status'] != '0') {
              $status = mysql_fetch_row(mysql_query('SELECT `name` FROM `status` WHERE `id` = \''.$pq['status'].'\''));
            } else { $status[0] = 'Sin estado'; }
            echo $status[0];
            ?></span><br>
            <?php
            if($logged['id'] == $row['id']) {
            ?>
            <img alt="Eliminar usuario de mi lista de amigos" src="<?=$config['images'];?>/images/eliminar.gif" align="absmiddle" width="10px" height="10px">
            <a style="color:#124679;"onclick="if (!confirm('\xbfEstas seguro que deseas eliminar a este usuario de tus amigos?')) return false; friends.del_wall('<?=$pq['uid'];?>'); return false;"  title="Eliminar usuario de mi lista de amigos">Eliminar</a>
            <?php
            }
            if(!mysql_num_rows(mysql_query('SELECT `id` FROM `online` WHERE `user` = \''.$pq['uid'].'\''))) {
              echo '<span class="BulletIcons rojo" alt="Desconectad'.($pq['sex'] == 0 ? 'o' : 'a').'" title="Desconectado'.($pq['sex'] == 0 ? 'o' : 'a').'"></span>Desconectad'.($pq['sex'] == 0 ? 'o' : 'a').' ';
            } else { echo '<span class="BulletIcons verde" alt="Desconectad'.($pq['sex'] == 0 ? 'o' : 'a').'" title="Conectad'.($pq['sex'] == 0 ? 'o' : 'a').'"></span>Conectad'.($pq['sex'] == 0 ? 'o' : 'a').' '; }
            ?>

         </td>
	</tr>
	</tbody>
</table>
<hr class="divider">
</div>
<?php
}
if($_GET['p'] > 1) { echo '<span class="floatL" style="font-size:12px;font-weight:bold"><a href=\'/perfil/'.$row['nick'].'/amigos/'.($_GET['p']-1).'\'>&#171; Anterior</a></span>'; }
if($_GET['p'] < $num) { echo '<span class="floatR" style="font-size:12px;font-weight:bold"><a href=\'/perfil/'.$row['nick'].'/amigos/'.($_GET['p']+1).'\'>Siguiente &#187;</a></span>'; }
} else { echo '<div class="redBox">@'.$row['nick'].' no tiene ning&uacute;n amigo a&ntilde;adido.</div>'; }
?>

<div class="clearBoth"></div></div></div><div style="clear:both"></div></div>

	</div>