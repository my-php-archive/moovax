<?php
if(!defined('ok')) { die; }
/* Me pone maaaal */
$tot = mysql_num_rows(mysql_query($query));
$per = 20;
$ppp = ceil($tot / $per);
$_GET['p'] = $_GET['p'] > 0 && ctype_digit($_GET['p']) && $_GET['p'] <= $ppp ? $_GET['p'] : 1;
$limit = ($_GET['p']-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per) or die(mysql_error());
if($tot) {
?>
<div class="user_info clearfix">
    <h2>&Uacute;ltimas fotos de @<?=$row['nick'];?></h2>
</div>
<span id="ult_img">
<table class="linksList">
    <thead>
	    <tr>
		    <th>&nbsp;</th>
			<th style="text-align:left">Ultimas fotos</th>
			<th>Visitas</th>
			<th>Puntos</th>
			<th>Fecha</th>
		</tr>
	</thead>
    <tbody>
    <?php
    while($pq = mysql_fetch_assoc($query)) {
    ?>
	<tr>
	    <td style="width:10px"><span class="categoriaPost <?=$pq['url'];?>" title="<?=$pq['name'];?>"></span></td>
		<td><a class="floatL" href="/fotos/fotos/<?=$pq['id'];?>/<?=url($pq['title']);?>.html" target="_self" title="Prob ano" alt="<?=$pq['title'];?>"><?=cut($pq['title'], 55, '...');?></a></td>
		<td style="width:70px">NaN visitas</td>
		<td style="width:70px"><?=$pq['votes'];?> puntos</td>
		<td style="width:150px"><?=timefrom($pq['time']);?></td>
	</tr>
    <?php
    }
    ?>
	</tbody>
</table>
<div class="clear"></div><hr class="divider">
<!-- vaginado -->
<div class="paginadorCom" style="width:643px">
<?php
if($_GET['p'] > 1) { echo '<div class="floatL before"><a href="/perfil/'.$row['nick'].'/fotos/'.($_GET['p']-1).'"><b>&laquo; Anterior</b></a></div>'; }
if($_GET['p'] < $ppp) { echo '<div class="floatR next"><a href="/perfil/'.$row['nick'].'/fotos/'.($_GET['p']+1).'"><b>Siguiente &raquo;</b></a></div>'; }
echo '</div></span>';
} else { echo '<div class="redBox"><b style="text-align:center" class="size11">@'.$row['nick'].' a&uacute;n no ha agregado ninguna foto</b></div>'; }
?>
<div class="clear"></div>