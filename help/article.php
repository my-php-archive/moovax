<?php
if(!defined('help')) { die; }
if(!$_GET['id']) { fatal_error('El campo id es requerido'); }
if(!mysql_num_rows($query = mysql_query('SELECT a.*, u.nick, u.id AS uid FROM `articles` AS a INNER JOIN `users` AS u ON u.id = a.author WHERE a.`id` = \''.intval($_GET['id']).'\''))) { fatal_error('No existe'); }
$row = mysql_fetch_assoc($query);
if($row['status'] != 0 && !allow('admin_help')) { fatal_error('El arti<b>culo</b> se encuentra eliminado'); }
$_SERVER['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDED_FOR'];
$cat = mysql_fetch_assoc(mysql_query('SELECT `name`, `url` FROM `help_categories` WHERE `id` = \''.$row['cat'].'\''));
$row['visits'] = mysql_num_rows(mysql_query('SELECT `id` FROM `post_visits` WHERE `type` = \'3\' && `post` = \''.$row['id'].'\''));
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `post_visits` WHERE `ip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\' && `type` = \'3\''))) {
  mysql_query('INSERT INTO `post_visits` (`post`, `ip`, `time`, `type`) VALUES (\''.$row['id'].'\', \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\', \''.time().'\', \'3\')') or die(mysql_error());
  $row['visits'] = $row['visits'] + 1;
  //echo 'few?';
}
?>
<script>
var id_art = <?=$row['id'];?>;
</script>
<div id="cuerpocontainer">
<div id="ver-art-left">
<div class="post-title">
<?=$row['title'];?>
</div>
<div class="post-container">
<?php
/* phil colins */
if($row['status'] != 0) { echo '<div class="redBox">El art&iacute;culo se encuentra eliminado</div>'; }
?>
<span property="dc:content"><?=BBposts($row['body']);?></span>
<br class="space">
<br>
<hr class="divider">
<span class="floatR" id="tipsy_top">
<?php
$url = $config['url'].'/ayuda/'.$cat['url'].'/'.$row['id'].'/'.url($row['title']).'.html';
?>
<a href="http://www.facebook.com/share.php?u=<?=$url;?>" rel="nofollow" target="_blank" title="Facebook" class="SocialIcons facebook"></a><a href="http://twitter.com/home?status=Les%20recomiendo%20este%20post:%20<?=$url;?>" rel="nofollow" target="_blank" title="Twitter" class="SocialIcons twitter"></a>
<a href="http://www.stumbleupon.com/submit?url=<?=$url;?>" rel="nofollow" target="_blank" title="StumbleUpon" class="SocialIcons stumbleupon"></a><a href="http://del.icio.us/post?url=<?=$url;?>" rel="nofollow" target="_blank" title="Delicious" class="SocialIcons delicious"></a>
<a href="http://digg.com/submit?phase=2&url=<?=$url;?>" rel="nofollow" target="_blank" title="Digg" class="SocialIcons digg"></a><a href="http://reddit.com/submit?url=<?=$url;?>" rel="nofollow" target="_blank" title="Reddit" class="SocialIcons reddit"></a>
</span>
<div class="clearfix"></div>
</div>
<br class="space">
<?php
if(allow('admin_help') || $logged['id'] == $row['uid']) {
?>
<input type="button" value="Volver" title="Volver a Ayuda" class="Boton Small BtnGray" onclick="location.href='/ayuda/'"> <input type="button" onclick="location.href='/ayuda/articulos/editar/<?=$row['id'];?>/'" title="Editar este art&iacute;culo" value="Editar" class="Boton Small BtnGray">
<input type="button" onclick="help.del_art(); return false" title="Eliminar este art&iacute;culo" class="Boton Small BtnGray" value="Eliminar">
<?php
}
?>
</div>
<div id="ver-art-right">
<div align="center">
<div align="center" id="ads_300x250"></div>
</div>
<br class="space">
<div class="box_title_content">
<div class="box_txt">Informaci&oacute;n</div>
</div>
<div class="box_cuerpo_content">
<b>Visitas: </b><?=$row['visits'];?><br>
<b>Autor: </b><a href="/perfil/<?=$row['nick'];?>" title="Ver perfil"><span property="dc:author"><?=$row['nick'];?></span></a><br>
<b>Fecha: </b><span property="dc:date"><?=date('d.m.Y', $row['time']);?> a las <?=date('h:s', $row['time']);?> hrs.</span><br>
<b>Categor&iacute;a: </b> <a href="/ayuda/<?=$row['url'];?>"><?=$cat['name'];?></a>
</div>
<br class="space">
<div class="box_title_content">
<div class="box_txt">Ver m&aacute;s art&iacute;culos</div>
</div>
<div class="box_cuerpo_content">
<ul>
<?php
$ps = mysql_query('SELECT a.`id`, a.`title`, cat.url FROM `articles` AS a INNER JOIN `help_categories` AS cat ON cat.id = a.cat WHERE a.`status` = \'0\' && a.`title` LIKE \'%'.$row['title'].'%\' && a.`id` != \''.$row['id'].'\' ORDER BY a.id DESC LIMIT 5') or die('Reporta este error a un moderador: '.mysql_error());
if(mysql_num_rows($ps)) {
  while($r = mysql_fetch_assoc($ps)) { echo '<li class="categoriaPost" style="margin-bottom:0px;"><a href="/ayuda/'.$r['url'].'/'.$r['id'].'/'.url($r['title']).'.html" target="_self" title="'.$r['title'].'">'.$r['title'].'</a></li> '; }
} else { echo '<div class="redBox">No hay relacionados</div>'; }
?>
</ul>
</div>
</div>
<div class="clearBoth"></div>
</div><!-- /cuerpocontainer -->