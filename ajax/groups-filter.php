<?php
if($_POST['_']) {
  include('../config.php');
  include('../functions.php');
  $cat = $_POST['cat'];
} else {
  $_POST['filter'] = $_GET['filter'];
  $cat = $_GET['cat'];
  if(!defined($config['define'])) { die; }
}
$ifcat = '';
if($cat && $cat != '-1' && mysql_num_rows($query = mysql_query('SELECT `id`, `url` FROM `groups_categories` WHERE `id` = \''.mysql_clean($cat).'\' || `url` = \''.mysql_clean($cat).'\''))) {
  $r = mysql_fetch_row($query);
  $ifcat = '&& g.`cat` = \''.$r[0].'\'';
}
switch($_POST['filter']) {
  case 'Todos':
    $query = 'SELECT g.name, g.url, t.*, u.nick, cat.img, cat.name AS namecat FROM `groups_topics` AS t INNER JOIN `groups` AS g ON g.id = t.group INNER JOIN `users` AS u ON u.id = t.author INNER JOIN `groups_categories` AS cat ON cat.id = g.cat WHERE t.`status` = \'0\' && g.`status` = \'0\''.$ifcat.' ORDER BY t.id DESC';
    break;
  case 'Oficiales':
    $query = 'SELECT g.name, g.url, t.*, u.nick, cat.img, cat.name AS namecat FROM `groups_topics` AS t INNER JOIN `groups` AS g ON g.id = t.group INNER JOIN `users` AS u ON u.id = t.author INNER JOIN `groups_categories` AS cat ON cat.id = g.cat WHERE t.`status` = \'0\' && g.`status` = \'0\' && g.`type` = \'1\''.$ifcat.' ORDER BY t.id DESC';
    break;
  case 'Comunidades':
    if(!$logged['id']) { die('0: Logueate para realizar esta acci&oacute;n'); }
    $query = 'SELECT g.name, g.url, t.`id`, t.`title`, u.nick, cat.img, cat.name AS namecat FROM `groups` AS g INNER JOIN `groups_topics` AS t ON t.group = g.id INNER JOIN `users` AS u ON u.id = t.author INNER JOIN `groups_members` AS m ON m.group = g.id INNER JOIN `groups_categories` AS cat ON cat.id = g.cat WHERE g.`status` = \'0\' && m.`user` = \''.$logged['id'].'\''.$ifcat.' ORDER BY g.id DESC';
    break;
  default: die('0: Error provocado');
}
//Paginado monstruo
if(!$_POST['_']) { echo '<script>var filtro_com = \''.$_POST['filter'].'\';</script>'; } //
$per = 36;
$tot = mysql_num_rows(mysql_query($query));
$num = ceil($tot / $per);
$_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) && $_GET['p'] <= $num ? $_GET['p'] : 1;
$limit = ($_GET['p']-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per) or die('0: '.mysql_error());
if(mysql_num_rows($query)) {
  while($m = mysql_fetch_assoc($query)) {
    echo '<div class="ult_post_container">
          <div style="float:left;margin-right:5px;"><img src="'.$config['images'].'/images/comunidades/categorias/'.$m['img'].'.png" alt="'.$m['namecat'].'" title="'.$m['namecat'].'" /></div>
          <a style="color:#124679;font-size:11px;" href="/comunidades/'.$m['url'].'/'.$m['id'].'/'.url($m['title']).'.html" target="_self" title="'.$m['title'].'" alt="'.$m['title'].'">'.cut($m['title'], 36, '...').'</a>
          <span style="color:#777;">  - Por @<a style="color:#124679;" href="/perfil/'.$m['nick'].'">'.$m['nick'].'</a></span>
          <span class="ult_post_cat"><a style="color:#5c5c5c;" href="/comunidades/'.$m['url'].'/" target="_self" title="Comunidad: '.$m['name'].'" alt="'.$m['name'].'">'.cut($m['name'], 14, '...').'</a>
          </span>
          </div><hr class="divider" style="margin:0px;">';
  }
  if($_GET['p'] > 1 || $_GET['p'] < $num) {
    echo '<div style="background:#FFFFCC; border:1px solid #FFCC33; padding:5px;margin:5px 0 0 0;font-weight: bold; text-align:center;-moz-border-radius: 5px">';
            if($_GET['p'] > 1) { echo '<a style="color:#0033CC; margin-right:10px;" onclick="comunidades.filter_com(\''.$_POST['filter'].'\', \''.($_GET['p'] - 1).'\', \''.($r[0] ? $r[0] : '-1').'\'); return false" href="/comunidades/'.htmlspecialchars($_POST['filter']).($ifcat ? '/categoria/'.$r[0] : '').'/page/'.($_GET['p'] - 1).'" title="Anteriores">&#171; Anteriores</a>'; }
            if($_GET['p'] < $num) { echo '<a style="color:#0033CC; margin-left:'.($_GET['p'] > 1 ? 271 : 10).'px;" onclick="comunidades.filter_com(\''.$_POST['filter'].'\', \''.($_GET['p'] + 1).'\', \''.($r[0] ? $r[0] : '-1').'\'); return false" href="/comunidades/'.htmlspecialchars($_POST['filter']).($ifcat ? '/categoria/'.$r[0] : '').'/page/'.($_GET['p'] + 1).'" title="Siguientes">Siguientes &#187;</a>'; }
    echo '</div>';
  }
} else { echo '<div class="redBox" id="sin_comments_muro">No hay nada...</div>'; }