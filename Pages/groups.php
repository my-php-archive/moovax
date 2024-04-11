<?php
if(!defined($config['define'])) { die; }
if(!$_GET['filter'] || !in_array($_GET['filter'], array('Todos', 'Oficiales', 'Comunidades')) || ($_GET['filter'] == 'Comunidades' && !$logged['id'])) { $_GET['filter'] = 'Todos'; }
if(!$_GET['filter2']) { $_GET['filter2'] = 'temas'; }
?>
<div id="main_content">
<div class="breadcrumb">
<ul>
<li class="first"><a href="/" accesskey="1" class="home"></a></li>
<li><a href="/comunidades/" title="Comunidades">Comunidades</a></li>
<?php
if($_GET['cat'] && mysql_num_rows($query = mysql_query('SELECT `name`, `id` FROM `groups_categories` WHERE `id` = \''.intval($_GET['cat']).'\''))) {
  $nme = mysql_fetch_row($query);
  echo '<li><a href="/comunidades/categoria/'.$nme[1].'/" title="'.$nme[0].'">'.$nme[0].'</a></li>';
}
?>
<li class="last"></li>
</ul>
</div>
<div class="clear"></div>
<div class="ult_temas_com">
<div class="filtrar_portal">
<li><a<?=($_GET['filter'] == 'Todos' ? ' class="selected"' : '');?> href="#" id="filterTodos" onclick="comunidades.filter_com('Todos','1','<?=($_GET['cat'] ? htmlspecialchars($_GET['cat']) : '-1');?>'); return false" title="Todos">Todos</a></li>
<li><a<?=($_GET['filter'] == 'Oficiales' ? ' class="selected"' : '');?> href="#" id="filterOficiales" onclick="comunidades.filter_com('Oficiales', '', '<?=($_GET['cat'] ? htmlspecialchars($_GET['cat']) : '-1');?>'); return false" title="Oficiales">Oficiales</a></li>
<?php
if($logged['id']) { echo '<li><a'.($_GET['filter'] == 'Comunidades' ? ' class="selected"' : '').' href="#" id="filterComunidades" onclick="comunidades.filter_com(\'Comunidades\', \'\', \''.($_GET['cat'] ? htmlspecialchars($_GET['cat']) : '-1').'\'); return false" title="Mis comunidades">Mis comunidades</a></li> '; }
?>
</div>
<div class="clearBoth"></div>
<div class="new-portal clearbeta">
<div class="new-portal-title">
<span id="titleTodos"<?=($_GET['filter'] != 'Todos' ? ' style="display:none;"' : '');?>>&Uacute;ltimos temas creados</span>
<span id="titleOficiales"<?=($_GET['filter'] != 'Oficiales' ? ' style="display:none;"' : '');?>>&Uacute;ltimos temas oficiales</span>
<span id="titleComunidades"<?=($_GET['filter'] != 'Comunidades' ? ' style="display:none;"' : '');?>>&Uacute;ltimos temas de <a style="color:#0033CC;" href="/comunidades/mis-comunidades/">mis comunidades</a></span>
</div>
<div align="center" id="loading_filter" style="display:none;padding:10px"><img src="<?=$config['images'];?>/images/loading.gif" title="Cargando..." border="0"></div>
<div id="filter_comunidades" class="new-portal-data">
<!-- empiezan los post -->
<?php
include('./ajax/groups-filter.php');
?>
</div>
</div>
</div>
<div class="ult_comm_com">
<div style="border:1px solid #C8C82D;background:#FFFFCC;padding:4px;">
<span class="floatR" style="margin-top:3px;margin-right:3px;"><input class="Boton BtnGreen" onclick="<?=($logged['id'] ? 'location.href=\'/comunidades/crear/\'' : 'solo_usuarios(); return false;');?>" value="Crear comunidad" title="Crear comunidad" type="button" /></span>
<span class="floatL" style="margin-top:8px;margin-left:6px;">
<b class="size13">Cre&aacute; tu comunidad!</b>
</span>
<div class="clear"></div>
<br class="space"><?=$config['name'];?> te da la posibilidad de crear tus propias comunidades para que puedas compartir tus cosas, gustos e inter&eacute;ses con los dem&aacute;s.
</div>
<div class="clear"></div>
<br class="space" />
<div id="estadisticasBox"><!-- estadisticas -->
<!--<div class="box_title"><span class="box_txt estadisticas">Estad&iacute;sticas</span><span class="box_rss"></span></div>-->
<div style="border:1px solid #ccc;-moz-border-radius:5px;border-radius:5px" class="box_cuerpo_content">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody><tr>
<td width="50%" align="left"><a class="usuarios_online" href="/online/"><?=$pstats['online'];?> usuarios online</a></td>
<td width="50%" align="left"><?=$pstats['groups'];?> comunidades</td>
</tr>
<tr>
<td width="50%" align="left"><?=$pstats['groups_topics'];?> temas</td>
<td width="50%" align="left"><?=$pstats['groups_comments'];?> respuestas</td>
</tr>
</tbody></table>
<div style="clear:both;"></div>
</div>
</div>
<br class="space" />
<div class="box_title_content">
<div class="box_txt">&Uacute;ltimos comentarios</div>
<div class="box_rss"><span class="floatR"><img title="Actualizar" style="cursor: pointer;" src="<?=$config['images'];?>/images/icons/reload.png?v3.2.3" onclick="comunidades.update_comments('<?=($_GET['cat'] ? htmlspecialchars($_GET['cat']) : '-1');?>'); return false;" alt="Actualizar"></span></div>
</div>
<div class="box_cuerpo_content">
<span id="ult_comm">
<?php
include('./ajax/groups-comments.php');
?>
</span>
</div>
<br class="space" />
<div class="box_title_content">
<div class="box_txt">
TOPs Comunidades
</div><div class="box_rss" style="display: none;" id="loading_tops">
<img style="" original="<?=$config['images'];?>/images/cargando.gif" src="<?=$config['images'];?>/images/cargando.gif">
</div>
</div>
<div class="box_cuerpo_content" style="padding: 0px;">
<div class="filterBy">
<span class="floatL">Filtrar por:</span>
<a id="tabTopsComTemas" onclick="comunidades.TopsComFilter('temas'); comunidades.TopsComTabs('Temas'); return false;" class="here">Temas</a> - <a id="tabTopsComMiembros" onclick="comunidades.TopsComFilter('miembros'); comunidades.TopsComTabs('Miembros'); return false;">Miembros</a>
<script type="text/javascript">var TopsComTabsHere = 'Temas';</script>
</div>
<div id="box_tops_com">
<?php
include('./ajax/groups-tops.php');
?>
</div>
<div id="error_tops_com" style="display: none; margin: 6px;"></div>
</div>
<br class="space">
<div class="ult_comunidades">
<div class="box_title_content">
<div class="box_txt">&Uacute;ltimas Comunidades</div>
</div>
<style>
.listDisc {
  padding-left:20px
}
.listDisc li {
  list-style:disc;
}
</style>
<div class="box_cuerpo_content">
<ul class="listDisc">
<?php
$quersy = mysql_query('SELECT `name`, `url` FROM `groups` WHERE `status` = \'0\' ORDER BY `id` DESC LIMIT 10');
if(mysql_num_rows($quersy)) {
  while($rw = mysql_fetch_row($quersy)) {
    echo '<li><a href="/comunidades/'.$rw[1].'/" class="size10">'.cut($rw[0], 20, '...').'</a></li>';
  }
} else { echo '<div class="redBox" id="sin_comments_muro">Nada por aqu&iacute;...</div>'; }
?>
</ul>
<div style="background:#FFFFCC; border:1px solid #FFCC33; padding:5px;margin:5px 0 0 0;font-weight: bold; text-align:center;-moz-border-radius: 5px">
<a<?=(!$logged['id'] ? ' onclick="solo_usuarios(); return false;"' : '');?> href="/comunidades/crear/" style="color:#0033CC">&iquest;Qu&eacute; esperas para crear la tuya?</a>
</div>
</div>
</div>
</div>
<div class="ult_com_right">
<div class="box_title_content">
<div class="box_txt">Comunidad destacada</div>
</div>
<div class="box_cuerpo_content">
<div style="text-align:center" class="box_cuerpo oficial">
<?php
$row = mysql_fetch_assoc(mysql_query('SELECT g.`name`, g.`url`, g.`avatar` FROM `groups` AS g INNER JOIN `groups_members` AS m ON m.`group` = g.`id` WHERE g.`status` = \'0\' && m.`status` = \'0\' GROUP BY g.id ORDER BY RAND(), COUNT(m.id) ASC LIMIT 1'));
?>
<div class="avaComunidad">
<a href="/comunidades/<?=$row['url'];?>/"><img title="<?=$row['name'];?>" height="130" width="130" alt="<?=$row['url'];?>" onerror="error_avatar(this);" src="<?=$row['avatar'];?>" class="avatar"></a>
</div>
<a title="<?=$row['name'];?>" style="font-weight:bold;font-size: 12px;color:#1A7706" href="/comunidades/<?=$row['url'];?>/"><?=$row['name'];?></a>
</div>
</div>
<br class="space" />
<div align="center" id="ads_300x250"></div>
</div>
<div style="clear:both"></div></div></div> </div>