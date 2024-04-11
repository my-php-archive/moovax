<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('Debes estar logueado para ver esta secci&oacute;n'); }
if($_GET['fav'] != 'posts' && $_GET['fav'] != 'photos') { $_GET['fav'] = 'posts'; }
if($_GET['fav'] == 'posts') {
  $tot = mysql_num_rows(mysql_query('SELECT f.id FROM `favorites` AS f INNER JOIN `posts` AS p ON p.id = f.id_pf WHERE f.`status` = \'0\' && f.`author` = \''.$logged['id'].'\' && p.`status` = \'0\' && f.`type` = \'0\''));
  $t = 'posts';
  $v = 'o';
} else {
  $tot = mysql_num_rows(mysql_query('SELECT f.id FROM `favorites` AS f INNER JOIN photos AS p ON p.id = f.id_pf WHERE f.status = \'0\' && f.author = \''.$logged['id'].'\' && p.`status` = \'0\' && f.`type` = \'1\''));
  $t = 'fotos';
  $v = 'a';
}
?>
<div class="breadcrumb">
    <ul>
	    <li class="first"><a href="/" accesskey="1" class="home"></a></li>
		<li><a href="/posts/bookmarks/">Mis posts favoritos</a></li>
		<li class="last"></li>
	</ul>
</div>
<div class="clear"></div>
<div style="padding:5px;float:left">
    <div style="font-size:14px; color:#333;font-weight:bold" class="floatL">Total de <?=$t;?> favorit<?=$v;?>s (<span id="favorites_num"><?=$tot;?></span>) </div>
	<div class="floatR"><b style="font-size:14px; color:#333">Ver favoritos en: </b>
	    <input type="button" value="Posts" class="DeluxeButton blue-chrome<?=($_GET['fav'] == 'posts' ? ' here' : '');?>" onclick="location='/posts/bookmarks/'">
		<input type="button" value="Fotos" class="DeluxeButton blue-chrome<?=($_GET['fav'] == 'photos' ? ' here' : '');?>" onclick="location='/fotos/bookmarks/'">
	</div>
    <div cass="clear"></div>
	<br><br>
    <div id="filter_var">
    <?php
    include('./ajax/favorites-'.$_GET['fav'].'.php');
    ?>
    </div>
</div>
	<div style="width:164px;padding:4px;float:right">
	<div align="center" id="ads_160x600">[ADS]</div>
	</div>
<div class="clear"></div>	<div style="clear:both"></div></div>
	</div>

