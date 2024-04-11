<?php
if(!defined($config['define'])) { die; }
?>
<div class="breadcrumb">
    <ul>
	    <li class="first"><a href="/" accesskey="1" class="home"></a></li>
		<li><a href="/static/sitemap/">Mapa del sitio</a></li>
		<li class="last"></li>
	</ul>
</div>
<div class="clear"></div>
<div id="sitemap-left">
    <div class="box_title_content">
    <div class="box_txt">
    General
    </div>
    </div>
    <div class="box_cuerpo_content">
    <span class="BulletIcons verde"></span><a href="/" title="Portal">Portal</a><br>
    <span class="BulletIcons verde"></span><a href="/posts/" title="Posts">Posts</a><br>
    <span class="BulletIcons verde"></span><a href="/fotos/" title="Fotos">Fotos</a><br>
    <span class="BulletIcons verde"></span><a href="/posts/buscador/" title="Buscador">Buscador</a><br>
    <span class="BulletIcons verde"></span><a href="/static/enlazanos/" title="Enlazanos">Enlazanos</a><br>
    <span class="BulletIcons verde"></span><a href="/static/protocolo/" title="Protocolo">Protocolo</a><br>
    <span class="BulletIcons verde"></span><a href="/static/terminos/" title="T&eacute;rminos y condiciones">T&eacute;rminos y condiciones</a><br>
    <span class="BulletIcons verde"></span><a href="/ayuda/" title="Ayuda">Ayuda</a><br>
    <span class="BulletIcons verde"></span><a href="/static/faqs/" title="FAQs">FAQs</a><br>
    <span class="BulletIcons verde"></span><a href="/static/widget/" title="Widget">Widget</a><br>
    <span class="BulletIcons verde"></span><a href="/static/premios/" title="Premios">Premios</a><br>
    <span class="BulletIcons verde"></span><a href="/static/contactanos/" title="Cont&aacute;ctanos">Cont&aacute;ctanos</a><br><span class="BulletIcons verde"></span><a href="/chat/" title="Chat">Chat</a><br>
    </div>
</div>
<div id="sitemap-center">

<b class="size16">Categor&iacute;as</b><div class="barra-dashed"></div>
			<div class="DesOpt" onclick="DespleOps('posts','imagenes'); return false;" id="dev_posts">
				Posts
			</div>
			<div class="DesOpt" onclick="DespleOps2('posts'); return false;" id="dov_posts" style="display: none">
				Posts
			</div>
<div class="box_cuerpo_content" style="display: none;" id="div_posts">
<?php
$query = mysql_query('SELECT cat.id, cat.name, cat.url, COUNT(cat.id) AS num FROM `categories` AS cat INNER JOIN `posts` AS p ON p.cat = cat.id WHERE p.`status` = \'0\' GROUP BY cat.id ORDER BY num DESC');
while($rw = mysql_fetch_row($query)) {
  echo '<li style="border-bottom:1px dashed #AEAEAE;border-top:0px;padding:3px;" id="info2"><span class="categoriaPost '.$rw[2].'" title="'.$rw[1].'"></span><a href="/posts/'.$rw[2].'/" title="'.$rw[1].'"> '.$rw[1].'</a> <span style="float:right">('.$rw[3].')</span></li>';
}
?>


 </div><br class="space">

			<div class="DesOpt" onclick="DespleOps('imagenes','posts'); return false;" id="dev_imagenes">
				Im&aacute;genes
			</div>
			<div class="DesOpt" onclick="DespleOps2('imagenes'); return false;" id="dov_imagenes" style="display: none">
				Im&aacute;genes
			</div>
<div class="box_cuerpo_content" style="display: none;" id="div_imagenes">
<?php
$query = mysql_query('SELECT cat.id, cat.url, cat.name, COUNT(p.id) as M FROM `p_categories` AS cat INNER JOIN `photos` AS p ON p.cat = cat.id WHERE p.`status` = \'0\' GROUP BY cat.id ORDER BY COUNT(p.id) DESC');
while($cat = mysql_fetch_assoc($query)) {
  echo '<li style="border-bottom:1px dashed #AEAEAE;border-top:0px;padding:3px;" id="info2"><span class="categoriaPost '.$cat['url'].'" title="'.$cat['name'].'"></span> <a href="/fotos/'.$cat['url'].'/" title="'.$cat['name'].'">'.$cat['name'].'</a><span style="float:right">('.$cat['M'].')</span></li>';
}
?>

</div> </div>
<div id="sitemap-right">
<div class="box_title_content">
<div class="box_txt">
RSS

</div></div>
<div class="box_cuerpo_content">

<span class="size11">
<span class="BulletIcons naranja"></span> <a href="/rss/ultimos-posts.php" title="&Uacute;ltimos posts">&Uacute;ltimos posts</a><br />
<span class="BulletIcons naranja"></span> <a href="/rss/ultimos-posts-atom.php" title="&Uacute;ltimos posts">&Uacute;ltimos posts Atom</a><br />

</span>
</div><br class="space"><div align="center" id="ads_300x250"></div>
</div>
<div style="clear:both"></div></div>
	</div>
