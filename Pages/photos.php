<?php
if(!defined($config['define'])) { die; }
$where = '';
if($_GET['categoria'] && mysql_num_rows($ccca = mysql_query('SELECT `id`, `name`, `url` FROM `p_categories` WHERE `url` = \''.mysql_clean($_GET['categoria']).'\''))) {
  $n = mysql_fetch_row($ccca);
  $where .= ' && p.cat = \''.$n[0].'\'';
  $pcat = true;
  $url = $n[2].'/';
}
$sd[0] = '-1';
$pa = false;
if(isset($_COOKIE['pais_home']) && mysql_num_rows($pq = mysql_query('SELECT `id`, `name`, `img_pais` FROM `countries` WHERE `img_pais` = \''.mysql_clean($_COOKIE['pais_home']).'\''))) {
  $sd = mysql_fetch_row($pq);
  $where .= ' && u.`country` = \''.$sd[0].'\'';
  $pa = true;
}
$fuser = false;
if($_GET['user'] && mysql_num_rows($query = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `nick` = \''.mysql_clean($_GET['user']).'\''))) {
  list($id, $nick) = mysql_fetch_row($query);
  $where .= ' && p.author = \''.$id.'\'';
  $add = ' de '.$nick;
  $fuser = true;
  $url = 'user/'.$nick.'/';
}
?>
<div class="breadcrumb">
    <ul>
	    <li class="first"><a href="/" accesskey="1" class="home"></a></li>
		<li><a href="/fotos/">Fotos<?=$add;?></a></li>
        <?php
        if($pcat) { echo '<li><a href="/fotos/'.$n[2].'">'.$n[1].'</a></li>'; }
        ?>
		<li class="last"></li>
	</ul>
</div><div class="clear"></div>

<div id="gallery-left">
    <input class="Boton BtnGreen" style="width: 300px;" onclick="<?=(!$logged['id'] ? 'solo_usuarios();return false;' : 'location.href=\'/fotos/agregar\'');?>" value="Agregar nueva foto" title="Agregar nueva foto" type="button"><br class="space">
	<input class="Boton BtnGray" style="width: 300px;" onclick="location.href='/fotos/rand/'" value="Ver foto al azar" title="Ver foto azar" type="button">
	<br class="space">
	<div class="box_title_content">
	    <div class="box_txt">
		    &Uacute;ltimos comentarios
        </div>
		<div class="box_rss">
		    <a class="floatR" href="#" onclick="fotos.up_comments('<?=($pcat ? $n[0] : '-1');?>', '<?=$sd[0];?>'); return false;"  title="Actualizar"><img src="<?=$config['images'];?>/images/icons/reload.png" align="absmiddle" /></a>
		</div>
	</div>
	<div class="box_cuerpo_content"><span id="ult_comm"><?php include('./ajax/update-comments-photos.php'); ?></span></div>
	<br class="space">
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

								<img src="<?=$config['images'];?>/images/icons/banderas/<?=($pa ? $sd[2] : 'global');?>.png" width="11" style="margin:0 3px 0 2px;vertical-align:middle" /> <?=($pa ? $sd[1] : 'Global');?>							</span>
		</div>
		<div class="clearfix clearBeta clearboth" style="margin-top:5px">
			<ul id="paises-lista" class="clearfix clearBeta clearboth" style="display:none">
				<li><a data-country="0"><img data-lazy="http://o1.t26.net/images/global.png" width="11" style="margin:0 3px 0 2px" /> Global</a> </li>
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
    		$('#paises-lista').fadeToggle('slow');
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
    <div align="center" id="ads_300x250"></div><br class="space">



	<div class="box_title_content">
	    <div class="box_txt">
		    Categor&iacute;as
		</div>
	</div>

			<div class="box_cuerpo_content">
				<b class="size14">Categor&iacute;a</b>
				<span class="floatR">
					<b class="size14">Imgs</b>

				</span><hr class="divider">
                <?php
                $query = mysql_query('SELECT cat.name, cat.url, COUNT(p.id) AS count FROM `p_categories` AS cat INNER JOIN `photos` AS p ON p.cat = cat.id WHERE p.`status` = \'0\''.($fuser ? ' && p.`author` = \''.$id.'\'' : '').' GROUP BY cat.id ORDER BY count DESC LIMIT 10');
                while($r = mysql_fetch_row($query)) {
                  echo '<li style="border-bottom:1px dashed #AEAEAE;border-top:0px;padding:3px;" id="info2">
				            <span class="categoriaPost '.$r[1].'" title="'.$r[0].'"></span>
				            <a href="/fotos/'.$r[1].'/" title="'.$r[0].'">'.$r[0].'</a>
				            <span class="floatR">'.$r[2].'</span>
                        </li>';
                }
                ?>
			</div>

</div>

<div id="gallery-right">
<?php
if(!allow('delete_photos')) { $where .= ' && p.`status` = \'0\''; }
$query = 'SELECT p.id, p.title, p.votes, p.`time`, p.`status`, cat.name, cat.url FROM `photos` AS p INNER JOIN `p_categories` AS cat ON cat.id = p.cat INNER JOIN `users` AS u ON u.id = p.author WHERE 1=1  '.$where.' ORDER BY p.id DESC';
$tot = mysql_num_rows(mysql_query($query));
$per = 20;
$num = ceil($tot / $per);
$_GET['p'] = (isset($_GET['p']) && ctype_digit($_GET['p']) && $_GET['p'] <= $num && $_GET['p'] > 0) ? $_GET['p'] : 1;
$limit = ($_GET['p']-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per) or die(mysql_error());
if(!mysql_num_rows($query)) { echo '<div class="redBox size13">Nada por aqu&iacute;...</div>'; } else {
?>
<table class="linksList">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th><?=(!$add ? 'Ultimas fotos' : 'Foto');?></th>
				<th>Visitas</th>
				<th>Puntos</th>
				<th>Fecha</th>
			</tr>

		</thead>
		<tbody>
        <?php
        while($rq = mysql_fetch_assoc($query)) {
        ?>
        <tr<?=($rq['status'] != 0 ? ' style="background-color: #FFCCFF"' : '');?>>
        	<td style="width:0px" title="Fotos"><span class="categoriaPost <?=$rq['url'];?>"></span></td>
        	<td style="text-align:left"><a href="/fotos/<?=$rq['url'];?>/<?=$rq['id'];?>/<?=url($rq['title']);?>.html" target="_self" title="<?=$rq['title'];?>" alt="<?=$rq['title'];?>"><?=$rq['title'];?></a></td>
        	<td><?=mysql_num_rows(mysql_query('SELECT `id` FROM `post_visits` WHERE `post` = \''.$rq['id'].'\' && `type` = \'2\''));?> visitas</td>
        	<td><?=$rq['votes'];?> puntos</td>
        	<td><?=date('d.m.Y', $rq['time']);?> a las <?=date('G:i', $rq['time']);?> hs.</td>
        </tr>
        <?php
        }
        ?>
	</tbody>
</table>

<div class="clear"></div><hr class="divider">
<?php
if($_GET['p'] < $num) { echo '<span class="floatR size12" style="font-weight:bold"><a title="Fotos maacute;s viejas" href="/fotos/'.$url.'page/'.($_GET['p']+1).'" >Siguientes &#187;</a></span>'; }
if($_GET['p'] > 1) { echo '<span class="floatL size12" style="font-weight:bold"><a title="Fotos m&aacute;s nuevas" href="/fotos/'.$url.'page/'.($_GET['p']-1).'" >&#171; Anteriores</a></span> '; }
}
?>
<div class="clearBoth"></div>
	</div><div style="clear:both"></div></div>
	</div>