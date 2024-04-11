<?php
if(!defined('ok')) { die; }
/* pinte tu nombre me dijiste bella */
$num = mysql_num_rows(mysql_query($query));
$per = 20;
$tw = ceil($num / $per);
$_GET['p'] = (ctype_digit($_GET['p']) && $_GET['p'] <= $tw && $_GET['p'] > 0 ? $_GET['p'] : 1);
$limit = ($_GET['p']-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per);
?>
<div class="user_info">
    <h2>Comentarios de @<?=$row['nick'];?> (<?=$num;?>)</h2>
</div>
<?php
if($num) {
 while($nm = mysql_fetch_assoc($query)) {
?>
<div id="info" style="border-top:1px solid #CCC;">
	<span class="categoriaPost <?=$nm['url'];?>" title="<?=$nm['name'];?>"></span>
	<a style="font-size:15px;color:#124679;" title="<?=$nm['title'];?>" href="/posts/<?=$nm['url'];?>/<?=$nm['id'];?>/<?=url($nm['title']);?>.html#cmt_2" target="_self">
		<?=cut($nm['title'], 55, '...');?>
	</a>

	<span class="floatR" title="<?=$nm['name'];?>">
		<font style="font-size:14px;color:#666"><?=$nm['name'];?></font>
	</span>
	<div class="barra-dashed"></div>
	<b class="size12"><?=timefrom($nm['time']).' '.$nm['nick'];?> dijo: </b>
		 <?=BBposts($nm['body'], true, false, false, true);?>
</div>
<?php
}
//echo $_GET['p'];
?>
<div class="clear"></div><br class="space"><hr class="divider">
<div class="paginadorCom" style="width:643px">
<?php
if($_GET['p'] > 1) { echo '<div class="floatL before"><a href="/perfil/'.$row['nick'].'/comentarios/'.($_GET['p']-1).'"><b>&laquo; Anterior</b></a></div>'; }
if($_GET['p'] < $tw) { echo '<div class="floatR next"><a href="/perfil/'.$row['nick'].'/comentarios/'.($_GET['p']+1).'"><b>Siguiente &raquo;</b></a></div>'; }
} else { echo '<div class="yellowBox">@'.$row['nick'].' no tiene comentarios en posts hechos.</div>'; }
?>
</div>

<div class="clear"></div>