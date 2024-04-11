<?php
if(!defined($config['define'])) { die('error'); }
if($logged['id']) {
  $cuandoi = mktime(0,0,0,02,28,2012);
  $totali = round((time() - $cuandoi)/86400);
?>
<div id="estadisticas"><div class="icon"></div><div class="txt"><span style="color:#666666;">Somos</span> <b><?=$pstats['users'];?></b> <span style="color:#666666;">Moovers</span> (<b><?=mysql_num_rows(mysql_query('SELECT `id` FROM `users` WHERE `time` > \''.(time()-86400).'\''));?></b><span style="color:#666666;"> hoy) hicimos </span><b><?=$pstats['posts'];?></b> <span style="color:#666666;">posts, agregamos</span> <b><?=$pstats['photos'];?></b> <span style="color:#666666;">imágenes y comentamos</span> <b><?=$pstats['comments'];?></b> <span style="color:#666666;">veces</span><span style="color:#666666;">, en</span> <b><?=$totali;?></b> <span style="color:#666666;">d&iacute;as online.</span></div></div>
<?php } ?>
<style>
.ult_post_container .posts:hover{
background-color:none;
}
</style>
<script type="text/javascript">
	var filtro_portal = 'Posts';
</script>

	<div id="portal-left">
	<div class="filtrar_portal">
			<li><a class="selected" href="#" id="filterPosts" onclick="web.portal_filter('Posts'); return false" title="Posts">Posts</a></li>
			<!--<li><a href="#" id="filterMuros" onclick="web.portal_filter('Muros'); return false" title="Muros">Muros</a></li>-->
			<li><a href="#" id="filterFotos" onclick="web.portal_filter('Fotos'); return false" title="Fotos">Fotos</a></li>
            </div><div class="clearBoth"></div>
			<div class="portal_container">
				<span class="floatR" id="showPosts">
				<?=($logged['id'] ? '<a href="/posts/agregar/">Agregar post</a> - ' : '');?><a href="/posts/">Ver m&aacute;s</a> - <a href="/rss/ultimos-posts.php" title="&Uacute;ltimos posts RSS"><span class="icons rss"></span></a>
				</span>
				<span class="floatR" id="showFotos" style="display:none">
			    <?=($logged['id'] ? '<a href="/fotos/agregar/">Agregar foto</a> - ' : '');?>	<a href="/imagenes/">Ver m&aacute;s</a>
				</span>
				<div class="portal_title">
					<span id="titlePosts">&Uacute;ltimos posts en la web</span>
                    <!---<span id="titleMuros" style="display:none">&Uacute;ltimas noticias en muros</span>-->
                    <span id="titleFotos" style="display:none">&Uacute;ltimas im&aacute;genes en la web</span>
				</div>
				<div class="barra-dashed"></div>
				<div align="center" id="loading_filter" style="display:none;padding:10px"><img src="<?=$config['images'];?>/images/loading.gif" title="Cargando..." border="0"></div>
				<div id="filter_portal">
                <?php
                include('ajax/portal-filter.php');
                ?>

                	</div>
                    </div>
			<br class="space"><div class="box_top_cats">
					<div class="portal_container">

					<div class="portal_title">
								TOP's categor&iacute;as
					</div>
				<div class="barra-dashed"></div>
                <?php
                $my = mysql_query('SELECT cat.id, cat.name, cat.url, COUNT(p.id) AS conteo FROM categories AS cat INNER JOIN posts AS p ON p.cat = cat.id WHERE p.status = \'0\' GROUP BY p.cat ORDER BY conteo DESC LIMIT 5') or die(mysql_error());
                while($ff = mysql_fetch_assoc($my)) {
                ?>
				<div class="ult_post_container" style="padding:5px">
						<span class="categoriaPost <?=$ff['url'];?>" title="<?=$ff['name'];?>"></span> <a href="/posts/<?=$ff['url'];?>/" target="_self" title="<?=$ff['name'];?>" alt="<?=$ff['name'];?>">
						<?=$ff['name'];?>
						</a>
						<span class="ult_post_cat"><?=$ff['conteo'];?> posts</span>
				</div>
                <hr class="divider" style="margin:0px;">
                <?php
                }
                ?>
                </div>
				<div style="clear:both;"></div>
		</div>
			<div class="box_news_users">
				<div class="portal_container">
					<div class="portal_title">
						&Uacute;ltimos amigos
					</div>
				<div class="barra-dashed"></div>
                <?php
                $query = mysql_query('SELECT nick, avatar, `id` FROM `users` ORDER BY `id` DESC LIMIT 10');
                while($user = mysql_fetch_row($query)) {
                ?>
                <div class="box_news_users_con2">
					<div class="box_news_users_ava">

						<a class="hovercard" data-uid="<?=$user[2];?>" href="/<?=$user[0];?>" title="<?=$user[0];?>">
							<img src="<?=$user[1];?>" alt="" onerror="error_avatar(this)">
						</a>
				    </div>
			    </div>
                <?php
                }
                ?>


					<div class="clear"></div>
				</div>
			</div>



    </div>
<div id="portal-right">
<?php
if($num = mysql_num_rows($query = mysql_query('SELECT `id` FROM `friends` WHERE `status` = \'0\' && `user` = \''.$logged['id'].'\''))) {
?>
<div style="border:1px solid #C8C82D;background:#FFFFCC;padding:4px;">
	<span style="margin-top:1px;margin-right:3px;" class="floatR">
		<input type="button" title="Ver todas" value="Ver todas" onclick="friends.requests(); return false;" style="-moz-border-radius:0px;-webkit-border-radius:0px;border-radius:0px;" class="Boton BtnGreen">
	</span>
	<span style="margin-top:7px;margin-left:3px;" class="floatL">
		<b class="size13">Solicitudes de amistad (<span id="cant_soli"><?=$num;?></span>)</b>
	</span>
	<div class="clear"></div>
</div>
<br class="space">
<?php
}
if(!$logged['id']) {
?>
<a href="#" onclick="accounts.registro_load_form(); return false;" class="maxiButton">&iexcl;Registrate ahora!</a>
<div align="center">
<style type="text/css">#stickymsg{
position: fixed;
bottom: 10px;
line-height: 16px;
right: 10px;
z-index: 30000;
opacity: 0.8;
width: 260px;
height: auto;
background: #005080;
color: #fff;
text-shadow: rgba(0,0,0,0.3) 0px -1px 0px;
padding: 10px;
text-decoration: none;
font-size: 11px;
font-family: Tahoma;
border: 1px solid #00172E;
box-shadow: rgba(0,0,0,0.3) 4px 3px 4px, inset #00172E 0px 1px 10px;
border-radius: 4px;
}
#stickymsg a{ color: #fff; font-weight:bold; text-decoration: none; }
#stickymsg:hover{ opacity: 1; }</style>
<div id="stickymsg">Bienvenido a Moovax<br>Por favor<a title="" class="bbc_url" onclick="accounts.registro_load_form(); return false;" href="#"> registrate</a> o <a title="" class="bbc_url" onclick="open_login_box(); return false;" href="#">logueate</a> para disfrutar al máximo de la web!</div></div>
<?php
} else { echo '<a href="/envivo/" class="maxiButton">Moovax en vivo</a>'; }
?>
<br class="space" />
	<div class="box_title_content_fb">

		<div class="box_txt_fb"><?=$config['name'];?> - Hazte fan!</div>
		<div class="box_rss"></div>
	</div>
	<div class="box_cuerpo_content_fb" align="center"><a rel="nofollow" href="https://www.facebook.com/pages/Moovax/198549130246671" target="_blank"><b><?=$config['name'];?></b> en facebook</a></div>
	<br class="space">

	<div class="box_title_content_fb">

		<div class="box_txt_fb" id="show" style="cursor: pointer;">&Uacute;ltimas novedades en nuestro Twitter</div>
		<div class="box_rss"></div>
	</div>
	<div class="box_cuerpo_content_fb" align="center" id="showpixel" style="display:none;"><script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 4,
  interval: 30000,
  width: 250,
  height: 300,
  theme: {
    shell: {
      background: '#078cad',
      color: '#ffffff'
    },
    tweets: {
      background: '#9c9c9c',
      color: '#ffffff',
      links: '#000000'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    behavior: 'all'
  }
}).render().setUser('MoovaxWeb').start();
</script></div>
<script>
$('#show').click(function(){
  $('#showpixel').fadeToggle();
});
</script>
<br class="space" />
			<div class="box_title_content">
				<div class="box_txt">&Uacute;ltimos comentarios en...</div>

				<div class="box_rss"><span class="icons citar"></span></div>
			</div>
			<div class="box_cuerpo_content" style="padding:0px;">
				<div class="filterBy">
					<span class="floatL">Filtrar por:</span> <a id="tabPosts" onclick="posts.up_comments(); tabs.filterComms('Posts'); return false;" class="here">Posts</a> - <a id="tabFotos" onclick="fotos.up_comments(); tabs.filterComms('Fotos'); return false;">Fotos</a> - <a id="tabComunidades" onclick="comunidades.update_comments('-1'); tabs.filterComms('Comunidades'); return false;">Comunidades</a>
                    <script type="text/javascript">var filterCommsHere = 'Posts';</script>

				</div>
				<div style="padding:6px;">
					<span id="ult_comm">
                    <?php
                    include('ajax/update-comments.php');
                    ?>
					</span>
				</div>
			</div>
			<br class="space" />
			<div class="box_title_content">
				<div class="box_txt">
					TOPs posts
				</div>

				<div class="box_rss"><img src="<?=$config['images'];?>/images/icons/stats.png" align="absmiddle"></div>
			</div>
			<div class="box_cuerpo_content" style="padding: 0px;">
				<div class="filterBy">
                    <a id="tabTopsPostsHoy" onclick="posts.TopsPostsFilter('hoy'); tabs.TopsPostsTabs('Hoy'); return false;">Hoy</a> -
                    <a id="tabTopsPostsAyer" onclick="posts.TopsPostsFilter('ayer'); tabs.TopsPostsTabs('Ayer'); return false;">Ayer</a> -
                    <a id="tabTopsPostsSemana" onclick="posts.TopsPostsFilter('semana'); tabs.TopsPostsTabs('Semana'); return false;" class="here">Semana</a> -
                    <a id="tabTopsPostsMes" onclick="posts.TopsPostsFilter('mes'); tabs.TopsPostsTabs('Mes'); return false;">Mes</a> -
                    <a id="tabTopsPostsHistorico" onclick="posts.TopsPostsFilter('historico'); tabs.TopsPostsTabs('Historico'); return false;">Hist&oacute;rico</a>
                    <script type="text/javascript">var TopsPostsTabsHere = 'Semana';</script>

				</div>
					<ol><div id="box_tops_posts">
                    <?php
                    include('ajax/posts-tops.php');
                    ?>
                    </div>
                    </ol>
					<div id="error_tops_posts" style="display: none; margin: 6px;"></div>
			</div>
            <br class="space" />
            <center>
            <div id="few" style="">
<object width="350" height="24" id="webplayer" data="http://freeshoutcast.com/webplayer/player.swf" type="application/x-shockwave-flash">
<param value="http://freeshoutcast.com/webplayer/player.swf" name="movie">
<param value="playerID=webplayer&amp;tracker=ffffff&amp;loader=E5E5E5&amp;initialvolume=100&amp;autostart=yes&amp;titles=Moovax&amp;soundFile=http://free.freeshoutcast.com:37762/;stream.nsv" name="FlashVars">
<param value="high" name="quality">
<param value="false" name="menu">
<param value="transparent" name="wmode">
</object>
            <object width="240" height="20" id="dewplayer-rect" data="/dewplayer-rect.swf?mp3=http://free.freeshoutcast.com:37762/;stream.nsv" type="application/x-shockwave-flash"><param value="transparent" name="wmode"><param value="/dewplayer-rect.swf?mp3=http://free.freeshoutcast.com:37762/;stream.nsv" name="movie"></object>


            </div>
            </center>
            <script>
            $('#radios').click(function(){
              radio = readCookie("radio");
              if(radio) {
                eraseCookie("radio");
                $('#few').fadeOut(500);
                $('#radios').html('Mostrar radio');
              } else {
                createCookie("radio", "1", 1);
                $('#few').show();
                $('#radios').html('Ocultar radio');
              }
            });
            </script>
			</div>
			<div class="clearBoth"></div>
			<br class="space"><div align="center">
						<div class="ads_728x90"><center></center></div>

				</div><br class="space">
			<div class="box_cuerpo_content" style="border-top:1px solid #CCC;">
			    <table>
                <tr>
                <?php
                $query = mysql_query('SELECT `url`, `name` FROM `urls` ORDER BY `id` ASC');
                while($f = mysql_fetch_row($query)) {
                  echo '<td width="140px"><span class="BulletIcons verde"></span><a href="'.$f[0].'" title="'.$f[1].'" target="_blank">'.$f[1].'</a></td>';
                }
                if(mysql_num_rows($query) < 7) {
                  for($i=0;$i<=(6 - mysql_num_rows($query));$i++) {
                    echo '<td width="140px"><span class="BulletIcons verde"></span><a href="http://moovax.net/static/contactanos/" title="Anunciate acá!" target="_blank">Anunciate acá!</a></td> ';
                  }
                }
                ?>
				</tr>
                </table>

			</div><br class="space"></div>
<div class="clear"></div><div style="clear:both"></div></div>