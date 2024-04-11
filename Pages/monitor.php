<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('logueate'); }
//if(empty($logged['notifications'])) { $logged['notifications'] = '0:1,1:1,2:1,3:1,4:1,5:1,6:1,7:1,8:1,9:1,10:1,11:1,12:1,13:1,14:1,15:1'; }
$t = '';
$xp = explode(',', $logged['notifications']);
foreach($xp as $value) {
  $x = explode(':', $value);
  //if($x[1] == 1) { $t .= ','.$x[0]; }
  $arr[$x[0]] = $x[1];
}
//print_r($arr);
//$where = 'n.type IN('.substr($t, 1).')';
$query = mysql_query('SELECT n.*, u.nick, u.avatar FROM `notifications` AS n INNER JOIN `users` AS u ON u.id = n.author WHERE n.id_user = \''.$logged['id'].'\' GROUP BY n.id ORDER BY n.`time` DESC LIMIT 20') or die(mysql_error());
?>
<div class="breadcrumb">
<ul>
<li class="first"><a href="/" accesskey="1" class="home"></a></li>
<li><a href="/monitor">Notificaciones</a></li>
<li class="last"></li>
</ul>
</div><div class="clear"></div>
<div style="width:760px;padding:4px;float:left">
<br class="space">
<div class="notificaciones">
<span style="font-size: 16px; font-weight: bold;">&Uacute;ltimas notificaciones</span>
<div class="clearBoth"></div>
<hr class="divider">
<span id="notifications">
<?php
while($row = mysql_fetch_assoc($query)) {
  switch($row['type']) {
    case '0':
      $txt = 'Coment&oacute; tu post: ';
      $img = 'comentario';
      $type = 'comment';
      break;
    case '1':
      $txt = 'Agreg&oacute; a favoritos tu post: ';
      $img = 'favorito';
      $type = 'favorite';
      break;
    case '2':
      $p = explode('@$', $row['url']);
      $txt = 'Dej&oacute; <b>'.$p[1].'</b> puntos a tu post: ';
      $row['url'] = $p[0];
      $img = 'puntos';
      $type = 'points';
      break;
    case '3':
      $txt = 'Dej&oacute; un comentario en tu muro: ';
      $img = 'muro';
      $type = 'comment';
      break;
    case '4':
      $txt = 'Te mencion&oacute; en el comentario: ';
      $img = 'user_add';
      $type = 'comment';
      break;
    case '5':
      $txt = 'Coment&oacute; una foto tuya: ';
      $img = 'comment_add';
      $type = 'comment';
      break;
    case '6':
      $txt = 'Cre&oacute; un nuevo post: ';
      $img = 'post';
      $type = 'new-post';
      break;
    case '7':
      $txt = 'Acept&oacute; tu solicitud de amistad: ';
      $img = 'user_add';
      $type = 'new-friend';
      break;
    case '8':
      $xp = explode('$', $row['url']);
      $txt = 'Vot&oacute; '.($xp[1] == 0 ? 'Positivo' : 'Negativo').' tu comentario en ';
      $row['url'] = $xp[0];
      $img = ($xp[1] == 0 ? 'positive' : 'negative');
      $type = 'comment-vote';
      break;
    case '9':
      $txt = 'Respond&oacute; en el muro: ';
      $img = 'user_add';
      $type = 'reply';
      break;
    case '10':
      $txt = 'Respondi&oacute; a tu publicacac&oacute;n: ';
      $img = 'comment_add';
      $type = 'reply';
      break;
    case '11':
      $txt = 'Le gusta tu publicaci&oacute;n en el muro de ';
      $img = 'like';
      $type = 'like';
      break;
    case '12':
      $txt = 'Agreg&oacute; a favoritos tu foto titulada ';
      $img = 'favorito';
      $type = 'favorite';
      break;
    case '13':
      $txt = 'Actualiz&oacute; su estado: ';
      $img = 'muro';
      $type = 'status';
      break;
    case '14':
      $vg = explode('#', $row['url']);
      $txt = 'Dej&oacute; '.$vg[1].' puntos a tu foto: ';
      $row['url'] = $vg[0];
      $img = 'puntos';
      $type = 'points';
      break;
    case '15':
      $txt = 'Agreg&oacute; una nueva foto: ';
      $img = 'camera';
      $type = 'new-photo';
      break;
    case '16':
      $txt = 'Te recomienda la comunidad: ';
      $img = 'like';
      $type = 'groups';
    case '17':
      $xp = explode('#', $row['url']);
      $type = 'groups';
      $txt = 'Vot&oacute; '.($xp[1] == 0 ? 'positivo' : 'negativo').' tu tema titulado: ';
      $img = ($xp[1] == 0 ? 'positive' : 'negative');
      $row['url'] = $xp[1];
      break;
    case '18':
      $txt = 'Respondi&oacute; a tu tema: ';
      $type = 'groups';
      $img = 'comment_add';
      break;
    case '19':
      $type = 'groups';
      $txt = 'Cre&oacute; un nueva tema: ';
      $img = 'post';
      break;
    case '20':
      $type = 'comment_add';
      $txt = 'Respondi&oacute; a tu tema: ';
      $type = 'groups';
      break;
  }
  //echo $arr[$row['type']];
  echo '<div class="noti_cont '.$type.'" id="notification_'.$row['id'].'"'.($arr[$row['type']] == 0 ? ' style="display: none;"' : '').'>
        <a onclick="del_notification(\''.$row['id'].'\');return false;" title="Cerrar"><span class="cerrar"></span></a>
        <img src="'.$row['avatar'].'" class="noti_ava_cont" onerror="error_avatar(this)" height="40" width="40">
        <span class="noti_nick"><a href="/perfil/'.$row['nick'].'/">'.$row['nick'].'</a></span> <span class="noti_hace">'.timefrom($row['time']).'</span><span id="loading_noti" style="display:none;"><img src="'.$config['images'].'/images/load.gif" border="0"></span>
        <br><span class="noti_notificacion"><img align="absmiddle" border="0" src="'.$config['images'].'/images/notificaciones/'.$img.'.png"> '.$txt.'<a href="'.$row['url'].'">'.(!empty($row['title']) ? $row['title'] : 'IR!').'</a></span>
        <div class="clearBoth"></div>
        </div>';
}
?>
<div class="clearBoth"></div>
</span>
</div>
</div>
<div style="width:185px;float:right;padding:4px;">
<div class="categoriaList box">

        <div style="font-size: 16px; font-weight: bold;">
			Filtrar Actividad
		</div> <br />

		<ul>
		    <li><label><img src="<?=$config['images'];?>/images/notificaciones/favorito.png" /><input type="checkbox" onclick="filter('favorite', this)"<?=($arr[12] == 1 || $arr[1] == 1 ? ' checked="checked"' : '');?> /> Favoritos</label></li>
			<li><label><img src="<?=$config['images'];?>/images/notificaciones/puntos.png" /><input type="checkbox" onclick="filter('points', this)"<?=($arr[2] == 1 || $arr[14] == 1 ? ' checked="checked"' : '');?> /> Puntos Recibidos</label></li>
			<li><label><img src="<?=$config['images'];?>/images/notificaciones/comentario.png" /><input type="checkbox" onclick="filter('comment', this)"<?=($arr[0] == 1 || $arr[3] == 1 || $arr[4] == 1 ? ' checked="checked"' : '');?> /> Comentarios</label></li>
			<li><label><img src="<?=$config['images'];?>/images/notificaciones/negative.png" /><input type="checkbox" onclick="filter('comment-vote', this)"<?=($arr[8] == 1 ? ' checked="checked"' : '');?> /> Votos en comentarios</label></li>
			<li><label><img src="<?=$config['images'];?>/images/notificaciones/positive.png" /><input type="checkbox" onclick="filter('like', this)"<?=($arr[11] == 1 ? ' checked="checked"' : '');?> /> Likes</label></li>
			<li><label><img src="<?=$config['images'];?>/images/notificaciones/user_add.png" /><input type="checkbox" onclick="filter('new-friend', this)"<?=($arr[7] == 1 ? ' checked="checked"' : '');?> /> Nuevo amigo</label></li>
            <li><label><img src="<?=$config['images'];?>/images/notificaciones/quote.png" /><input type="checkbox" onclick="filter('status', this)"<?=($arr[13] == 1 ? ' checked="checked"' : '');?> /> Estados</label></li>
            <li><label><img src="<?=$config['images'];?>/images/notificaciones/comentario.png" /><input type="checkbox" onclick="filter('reply', this)"<?=($arr[9] == 1 || $arr[10] == 1 ? ' checked="checked"' : '');?> /> Respuesta en muro</label></li>
            <li><label><img src="<?=$config['images'];?>/images/notificaciones/camera.png" /><input type="checkbox" onclick="filter('new-photo', this)"<?=($arr[15] == 1 ? ' checked="checked"' : '');?> /> Nueva foto</label></li>
            <li><label><img src="<?=$config['images'];?>/images/notificaciones/post.png" /><input type="checkbox" onclick="filter('new-post', this)"<?=($arr[6] == 1 ? ' checked="checked"' : '');?> /> Nuevo post</label></li>
            <li><label><img src="<?=$config['images'];?>/images/notificaciones/post.png" /><input type="checkbox" onclick="filter('groups', this)"<?=($arr[16] == 1 ? ' checked="checked"' : '');?> /> Comunidades</label></li>
		</ul>
	</div>
</div><div style="clear:both"></div></div>
</div>
<style>
.categoriaList {margin-bottom: 10px;}
.categoriaList li {
	display: block;
	padding: 3px 6px;
	border-bottom: 1px #EEE dotted;
	position: relative;
    margin: 0px 0;
	border-bottom:1px dotted #AEAEAE;
}
.categoriaList li.active {
	text-shadow: 0 1px 0 #133873;
	font-weight: bold;
	background:#3466b7;
}
.categoriaList li.active:hover {
	text-shadow: 0 1px 0 #133873;
	font-weight: bold;
	background:#3466b7;
}
.categoriaList li.active .count {
	text-shadow: 0 1px 0 #133873;
	font-weight: bold;
	color: #FFF;
}
.categoriaList li.active a {color: #FFF;}
.categoriaList li:hover {
	border-bottom: 1px #CCC dotted;
	background: #EEE;
}
.categoriaList li .count  {
	font-weight: bold;
	color: #69900F;
	position: absolute;
	right: 6px;
	top: 3px;
}
.highlight-data {
	float: left;
	width: 237px;
}
#sidebar .highlight-data { width: 203px;}
.highlight-data a {
	width: 160px!important;
	height: 16px!important;
}
#sidebar .highlight-data a , .highlight-data a.ui-button  {
	width: auto!important;
	height: auto!important;
}
.list.recomendados .list-element .highlight-data span.value {
	float: none;
	font-weight: normal;
	font-size: 11px;
	color: #999;
}

</style>