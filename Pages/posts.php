<?php
if(!defined($config['define'])) { die; }
$if = '';
$cats = false;
if($_GET['categoria'] && mysql_num_rows($cat = mysql_query('SELECT `id`, `name`, `url` FROM `categories` WHERE `url` = \''.mysql_clean($_GET['categoria']).'\''))) {
  $cat = mysql_fetch_row($cat);
  $if = '&& p.cat = \''.$cat[0].'\'';
  $cats = true;
}
/* Slave to love */
$pais = '';
$title = '';
$f = false;
if(!empty($_COOKIE['pais_home']) && $_COOKIE['pais_home'] != '-1' && mysql_num_rows($countries = mysql_query('SELECT `id`, `name`, `img_pais` FROM `countries` WHERE `img_pais` = \''.mysql_clean($_COOKIE['pais_home']).'\''))) {
  $pp = mysql_fetch_row($countries);
  $if .= ' && u.`country` = \''.$pp[0].'\'';
  $title = ' en '.$pp[1];
  $f = true;
}
?>

		<div class="breadcrumb">
			<ul>

				<li class="first"><a href="/" accesskey="1" class="home"></a></li>
				<li><a href="/posts/">Posts</a></li>
                <?php
                if($cats) { echo '<li><a href="/posts/'.$cat[2].'/">'.$cat[1].'</a></li>'; }
                ?>

				<li class="last"></li>

			</ul>
		</div><div class="clear"></div>
		<div id="post-left_p">
<div class="px5">
	<script type="text/javascript">
		function errorr(searchbox){
			if(searchbox == 'Buscar...'){ $('#searchbox').focus();  return false;}
			//Doble Seguridad! :E
			if(searchbox == ''){ $('#searchbox').focus();  return false;}
		}
	</script>

	<style>
	.label_cat .categoriaPost:hover{
		background-color:transparent;
	}
	</style>
	<!-- Buscador -->
	<form  method="GET" action="/posts/buscador/" name="search_form">
	<div class="buscarfor1">
		<input class="buscarinp1" type="text" value="Buscar..." onfocus="if (this.value == 'Buscar...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Buscar...';}" name="q" id="searchbox" autocomplete="off"/>
        <input class="buscarbot1" onclick="return errorr(this.form.searchbox.value);" type="submit" value="Buscar" /></div>
        <?php
        if($cats) {
          echo '<input type="checkbox" value="'.$cat[2].'" name="categoria" id="cats" > <label class="size12 label_cat" for="cats"><span class="categoriaPost '.$cat[2].'"></span> <b>Buscar s&oacute;lo en: '.$cat[1].'</b></label><br>';
        }
        ?>
    </form>

<h2 class="ultimos_p">
<?php
$num = mysql_num_rows(mysql_query('SELECT id FROM posts WHERE `time` > \''.(time()-86400).'\' '.($cats ? ' && cat = \''.$cat[0].'\'' : '')));
?>
  <div class="floatR pdh"><?=($num > 0 ? '+' : '').$num;?> posts de hoy <?=($cats ? 'en la categor&iacute;a '.strtolower($cat[1]) : '');?></div>

  <img src="<?=$config['images'];?>/images/noti.png"> &Uacute;ltimos posts<?=$title;?></h2>
<div id="ult_posts">
<?php
$i = 0;
if(!allow('delete_posts')) { $if .= ' && p.status = \'0\''; }
$posts = 'SELECT p.id, p.title, p.points, p.sticky, p.private, p.status, cat.url, cat.name, u.nick FROM posts AS p INNER JOIN `users` AS u ON u.id = p.author LEFT JOIN categories AS cat ON cat.id = p.cat WHERE 1=1 '.$if.' '.$pais.' ORDER BY p.sticky DESC, p.id DESC';
$num = mysql_num_rows(mysql_query($posts));
$per = 20;
$paginas = ceil($num / $per); //40/20=2
$_GET['p'] = isset($_GET['p']) ? intval($_GET['p']) : 0;
$limitar = 0;
if(($_GET['p']) < $paginas) {
    $limitar = $_GET['p']*$per;
}
$query = mysql_query($posts.' LIMIT '.$limitar.', '.$per);
if(mysql_num_rows($query)) {
while($row = mysql_fetch_assoc($query)) {
?>
<div class="short<?=($row['sticky'] == '1' ? '3' : (++$i%2 ? '2' : '1'));?>"<?=($row['status'] != 0 ? ' style="background-color: #EED5D2"' : '');?>>
		<div class="icono">
			<span class="floatL categoriaPost <?=$row['url'];?>"></span>
		</div>
		<div class="title floatR">
			<h2>

				<a class="vistapre" href="/ajax/post-preview2.php?type=post&id=<?=$row['id'];?>" title="Previsualizar" rel="facebox"></a>
                <?php
                if($row['sticky'] == '0' && $logged['id']) { echo '<a class="report_p" onclick="posts.denunciar_post(\''.$row['id'].'\'); return false;" title="Denunciar"></a>'; }
                ?>
				<a<?=($row['private'] == '1' ? ' class="categoriaPost privado"' : '');?> href="/posts/<?=$row['url'];?>/<?=$row['id'];?>/<?=url($row['title']);?>.html" target="_self" title="<?=$row['title'];?>" alt="<?=$row['title'];?>"><?=cut($row['title'], 50, '...');?></a>
			</h2>
				<div class="des">
					<strong>Categor&iacute;a:</strong>
					<a href="/posts/<?=$row['url'];?>/"><?=$row['name'];?></a> |
					<strong>Puntos:</strong>
					<span id="cant_pts_post_9142"><?=$row['points'];?></span> |
					<strong>Enviado por:</strong> <a href="/<?=$row['nick'];?>" class="autorp2">@<?=$row['nick'];?></a>

				</div>
		</div>
	</div>
<?php
}
} else {
  echo '<div class="redBox">Nada por aqu&iacute;...</div>';
}
?>


<br />

<hr class="divider">
<div class="paginadorCom" style="width:640px">
<?php
if($_GET['p']>0) {
  echo '<div class="floatL before"><a href="/posts'.($cats ? '/'.$cat[2] : '').'/page/'.($_GET['p']-1).'" class=""><b>&laquo; Anterior</b></a></div>  ';
} else {
  echo '<div class="floatL before"><a href="/posts'.($cats ? '/'.$cat[2] : '').'/page/0" onclick="return false" class="desactivado"><b>&laquo; Anterior</b></a></div>';
}
echo '<div class="floatR next"><a href="/posts'.($cats ? '/'.$cat[2] : '').'/page/'.($_GET['p']+1).'" class="'.(($_GET['p']+1) >= $paginas ? 'desactivado' : '').'" '.(($_GET['p']+1) >= $paginas ? 'onclick="return false"' : '').'> <b>Siguiente &raquo;</b></a></div> ';
?>

    </div>
    <div class="clearfix"></div>
<div class="clearBoth"></div>
	</div>
</div>
</div>

		<div id="post-right_p">
				<input class="Boton BtnGreen" style="width: 300px;" onclick="location.href='/posts/agregar/'" value="Agregar nuevo post" title="Agregar nuevo post" type="button">
				<br class="space">
				<input class="Boton BtnGray" style="width: 300px;" onclick="location.href='/posts/rand'" value="Ver post al azar" title="Ver post al azar" type="button">
			<br class="space"> <br class="space">
        <style>
    		#show-paises-lista {
    			cursor: pointer
    		}
    		#paises-lista {
    			display: block;
    			border: 3px solid #CCC;
    			background: #EEE;
    			padding: 3px;
                border-radius: 6px;
    		}
    		#paises-lista li{
    			display: block;
    			float: left;
    			width: 45%;
    			padding: 3px;
    		}
	    </style>
	<div class="clearfix clearBeta clearboth" style="margin-bottom:10px">
		<div id="show-paises-lista" class="clearfix clearBeta clearboth">
			<span class="floatL" style="padding:3px 0 0">
				<a style="font-size:10px;color:#005494;font-weight:bold">Filtrar informaci&oacute;n para:</a>
			</span>
			<span class="floatR" style="background:#004a95;font-weight:bold;color:#FFF; -moz-border-radius:3px;padding:3px 6px;-webkit-border-radius:3px; border-radius:3px">
								<img src="<?=$config['images'];?>/images/icons/banderas/<?=($f === true ? $pp[2] : 'global');?>.png" width="11" style="margin:0 3px 0 2px;vertical-align:middle" /> <?=($f === true ? $pp[1] : 'Global');?>
							</span>
		</div>
		<div class="clearfix clearBeta clearboth" style="margin-top:5px">
			<ul id="paises-lista" class="clearfix clearBeta clearboth" style="display:none">
				<li><a data-country="-1"><img data-lazy="http://o1.t26.net/images/global.png" width="11" style="margin:0 3px 0 2px" /> Global</a> </li>
								<li><a data-country="uy"><img data-lazy="http://o1.t26.net/images/flags/uy.png" /> Uruguay</a> </li>
								<li><a data-country="ar"><img data-lazy="http://o1.t26.net/images/flags/ar.png" /> Argentina</a> </li>
								<li><a data-country="cl"><img data-lazy="http://o1.t26.net/images/flags/cl.png" /> Chile</a> </li>
								<li><a data-country="co"><img data-lazy="http://o1.t26.net/images/flags/co.png" /> Colombia</a> </li>
								<li><a data-country="es"><img data-lazy="http://o1.t26.net/images/flags/es.png" /> España</a> </li>
								<li><a data-country="us"><img data-lazy="http://o1.t26.net/images/flags/us.png" /> Estados Unidos</a> </li>
								<li><a data-country="mx"><img data-lazy="http://o1.t26.net/images/flags/mx.png" /> México</a> </li>
								<li><a data-country="pe"><img data-lazy="http://o1.t26.net/images/flags/pe.png" /> Perú</a> </li>
								<li><a data-country="ve"><img data-lazy="http://o1.t26.net/images/flags/ve.png" /> Venezuela</a> </li>
							</ul>
		</div>
	</div>
<script>
	$('#show-paises-lista').click(function(){
		$('#paises-lista li a img[data-lazy]').each(function(){
			$(this).attr('src', $(this).attr('data-lazy'));
		});
		$('#paises-lista').slideToggle('slow');
	});
	$("[data-country]").click(function() {
	    $('#paises-lista').css('opacity', 0.3);
		var pais = $(this).attr('data-country');
		eraseCookie("pais_home");
		createCookie("pais_home", pais, 1);
		pais = readCookie("pais_home");
		if (pais) {
			location.reload();
		}
	});

</script>

			<div class="box_title_content">
				<div class="box_txt">
					&Uacute;ltimos comentarios<?=$title;?></div>

					<div class="box_rss">
						<a class="floatR" href="#" onclick="posts.up_comments('<?=($cats ? $cat[2] : '-1');?>', '<?=($f === true ? $pp[0] : '-1');?>'); return false;"  title="Actualizar"><img src="<?=$config['images'];?>/images/icons/reload.png" align="absmiddle" /></a>
					</div>
			</div>
			<div class="box_cuerpo_content"><span id="ult_comm">
            <?php
            include('ajax/update-comments.php');
            ?>
			</span></div><br class="space">

			<div align="center" id="ads_300x250"></div><br class="space">
			<div class="box_title_content">
				<div class="box_txt">

					TOP's categor&iacute;as
				</div>
			</div>

			<div class="box_cuerpo_content">
				<b class="size14">Categor&iacute;a</b>
				<span class="floatR">
					<b class="size14">Posts</b>
				</span>
                <div class="clearBoth"></div>
                <hr class="divider">
                <?php
                $query = mysql_query('SELECT cat.name, cat.url, COUNT(cat.id) AS conteo FROM categories AS cat INNER JOIN posts AS p ON p.cat = cat.id WHERE p.status = \'0\' GROUP BY cat.id ORDER BY conteo DESC LIMIT 10');
                while($s = mysql_fetch_assoc($query)) {
                  echo '<li style="border-bottom:1px dashed #AEAEAE;border-top:0px;padding:3px;" id="info2">
			                <span class="categoriaPost '.$s['url'].'" title="'.$s['name'].'"></span>
			                <a href="/posts/'.$s['url'].'/" title="'.$s['name'].'"> '.$s['name'].'</a> <span class="floatR">'.$s['conteo'].'</span>
                       </li>';
                }
                ?>


             </div>
		   	</div>
	<div class="clear"></div>
<div style="clear:both"></div></div>
	</div>