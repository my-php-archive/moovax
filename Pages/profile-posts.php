<?php
if(!defined('ok')) { die; }
?>
<div class="user_info">
    <h2>Posts de @<?=$row['nick'];?></h2>
</div>
<script type="text/javascript">
function errorr(searchbox){
    if(searchbox == ''){ $('.searchbox').focus();  return false;}
}
</script>
<!-- Buscador -->
<?php
if($posts === true) {
?>
<form class="buscarfor1" method="GET" action="/posts/buscador/" name="search_form">
    <input class="buscarinp1" type="text" value="Buscar..." onfocus="if (this.value == 'Buscar...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Buscar...';}" name="q" id="searchbox" autocomplete="off"/><input class="buscarbot1" onclick="return errorr(this.form.searchbox.value);" type="submit" value="Buscar" />
    <input type="hidden" name="autor" value="<?=$row['nick'];?>">
</form>
<br class="space">
<?php
while($rw = mysql_fetch_assoc($query)) {
?>
<div class="short2">
    <div class="icono">
	    <span class="floatL categoriaPost <?=$rw['url'];?>"></span>
	</div>
	<div class="title floatR">
        <h2>
		    <a class="vistapre" href="/ajax/posts.previsualizar.php?type=post&id=<?=$rw['id'];?>" title="Previsualizar" rel="facebox"></a>
			<a href="/posts/<?=$rw['url'];?>/<?=$rw['id'];?>/<?=url($rw['title']);?>.html" target="_self" title="<?=$rw['title'];?>" alt="<?=$rw['title'];?>"><?=cut($rw['title'], 56, '...');?></a>
		</h2>
		<div class="des">
		    <strong>Categor&iacute;a:</strong>
			<a href="/posts/<?=$rw['url'];?>/"><?=$rw['name'];?></a> |
			<strong>Puntos:</strong>
			<span><?=$rw['points'];?></span> |
			<strong>Comentarios:</strong><span> <?=mysql_num_rows(mysql_query('SELECT `id` FROM `comments` WHERE `id_post` = \''.$rw['id'].'\''));?></span>  |
			<strong>Favoritos:</strong><span> <?=mysql_num_rows(mysql_query('SELECT `id` FROM `favorites` WHERE `id_pf` = \''.$rw['id'].'\' && `type` = \'0\''));?></span>
		</div>
	</div>
</div>
<?php
}
?>
<div class="clear"></div>
<hr class="divider">
<?php
if($tot > 15) { echo '<a href="/posts/buscador/?q=&autor='.$row['nick'].'" id="pija">Ver todos</a> '; }
} else { echo '<div class="redBox">@'.$row['nick'].' no tiene posts hechos.</div>'; }
?>
