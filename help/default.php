<?php
if(!defined('help') && !$_GET['ajax']) { die; }
$ppp = '';
if($_GET['cat'] && mysql_num_rows($query = mysql_query('SELECT `id`, `name`, `url` FROM `help_categories` WHERE `url` = \''.mysql_clean($_GET['cat']).'\''))) {
  list($id_cat, $name_cat, $url_cat) = mysql_fetch_row($query);
  $ppp .= ' && `cat` = \''.$id_cat.'\'';
  $pcat = true; //-sape
}
$query = 'SELECT a.id, a.`title`, a.`time`, cat.url, cat.name, u.nick FROM `articles` AS a INNER JOIN `help_categories` AS cat ON cat.id = a.cat INNER JOIN `users` AS u ON u.id = a.`author` WHERE a.`status` = \'0\' '.$ppp.' ORDER BY `a`.`id` DESC';
$tot = mysql_num_rows(mysql_query($query));
$per = 5;
$fr = ceil($tot / $per);
$p = $_GET['p'] && ctype_digit($_GET['p']) && $_GET['p'] <= $fr ? $_GET['p'] : 1;
$act = ($p-1)*$per;
$query = mysql_query($query.' LIMIT '.$act.', '.$per) or die(mysql_error());
$display = '';
if(mysql_num_rows($query)) {
  while($row = mysql_fetch_assoc($query)) {
    $display .= '<div class="ult_art_con">
          <span class="BulletIcons violeta"></span><a href="/ayuda/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html">'.cut($row['title'], 58, '...').'</a>
          <br />'.timefrom($row['time']).' - En <a href="/ayuda/'.$row['url'].'/">'.$row['name'].'</a> - Por <a href="/perfil/'.$row['nick'].'/">'.$row['nick'].'</a>
          </div><hr style="margin:0px;" class="divider">';
  }
 // echo '<hr class="divider" style="margin:0px;">';
  if($p > 1) { $display .= '<span class="floatL" style="font-weight:bold;font-size:12px"><a title="Fotos m&aacute;s nuevas" onclick="filter_home(\''.($pcat ? $url_cat : '-1').'\', \''.($p-1).'\', this); return false;" href="/ayuda/'.($pcat ? $url_cat.'/' : '').'page/'.($p-1).'" >&#171; Anteriores</a></span>'; }
  if($p < $fr) { $display .= '<span class="floatR" style="font-weight:bold;font-size:12px"><a onclick="filter_home(\''.($pcat ? $url_cat : '-1').'\', \''.($p+1).'\', this); return false;" href="/ayuda/'.($pcat ? $url_cat.'/' : '').'page/'.($p+1).'">Siguiente &#187;</a></span>'; }
} else { $display .= '<div class="redBox">Nada por aqu&iacute;</div>'; }
if($_GET['ajax']) { die($display); }
?>
<script> var lastcat = '<?=$url_cat;?>'; </script>
<div id="cuerpocontainer">
<div id="indexL">
<div class="boxtitleProfile clearfix">
<h3>Centro de ayuda</h3>
</div>
Bienvenido al centro de ayuda de <?=$config['name'];?>. Ac&aacute; podr&aacute;s encontrar tutoriales para moverte con m&aacute;s soltura sobre el sitio. Si quer&eacute;s darnos alguna sugerencia para esta secci&oacute;n o para el sitio en general hac&eacute; <a href="/static/contactanos/" target="_blank">click ac&aacute;</a>.
<br class="space">
<br>
<div class="boxtitleProfile clearfix">
<h3>Categor&iacute;as</h3>
</div>
<?php
$query = mysql_query('SELECT cat.url, cat.`name`, COUNT(a.id) FROM `help_categories` AS cat INNER JOIN `articles` AS a ON a.cat = cat.id WHERE a.`status` = \'0\' GROUP BY cat.id ORDER BY COUNT(a.id) DESC LIMIT 6');
if(mysql_num_rows($query)) {
  while($r = mysql_fetch_row($query)) { echo '<ul class="categoriasAyuda" style="margin-right: 5px;"> <li><img src="'.$config['images'].'/images/ayuda/carpeta.png" align="absmiddle"> <a onclick="filter_home(\''.$r[0].'\', \'-1\', this); return false;" href="/ayuda/'.$r[0].'/" title="'.$r[1].'">'.$r[1].'</a> ('.$r[2].')</li></ul> '; }
} else { echo '<div class="redBox">Nada por aqu&iacute;</div>'; }
?>
<div class="clear"></div>
</div>
<div id="indexR">
<div class="boxtitleProfile clearfix">
<h3>&Uacute;ltimos art&iacute;culos</h3>
<span class="floatR">
<img alt="Cargando..." src="<?=$config['images'];?>/images/cargando.gif" width="15px" height="14px" style="display:none;" id="loading_art" />
</span>
</div>
<div id="ult_articulos">
<?=$display;?>
</div>
</div>
<div class="clearBoth"></div>
<div class="clearBoth"></div>
</div><!-- /cuerpocontainer -->