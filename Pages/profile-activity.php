<?php
if(!defined('ok') && !$_GET['_']) { die; }
if(!$_GET['_']) {
?>
<div class="user_info">
    <h2>&Uacute;ltima actividad de <?=$row['nick'];?>
    <span style="float: right;">
    <select id="last-activity-filter" onchange="activity.filter(<?=$row['id'];?>, this.value);">
	    <option value="-1">Todas</option>
		<option value="1">Post nuevo</option>
		<option value="2">Comentario en un post</option>
		<option value="3">Tema nuevo</option>
		<option value="4">Respuesta en un tema</option>
		<option value="5">Cre&oacute; una comunidad</option>
		<option value="6">Se uni&oacute; a una comunidad</option>
        <option value="7">Recomend&oacute; una comunidad</option>
		<option value="8">Nuevo amigo</option>
        <option value="9">Foto nueva</option>
        <option value="10">Comentario en una foto</option>
        <option value="11">Post votado</option>
        <option value="12">Publicaciones en muro</option>
        <option value="13">Respuesta en muro</option>
        <option value="14">Likes</option>
	</select>
    </span>
  	<div class="clear"></div></h2>
</div>
<div class="perfil-main clearfix">
  <div id="profile-load"><div class="perfil-content general">
  <div class="widget big-info clearfix">
  <div id="last-activity-container" class="last-activity">
  <?php
  } else {
    if(!$_GET['id_user']) { die('0: Faltan datos...'); }
    include('../config.php');
    include('../functions.php');
    if(!mysql_num_rows($query = mysql_query('SELECT * FROM `users` WHERE `id` = \''.(int)$_GET['id_user'].'\''))) { die('0: El usuario no existe'); }
    $row = mysql_fetch_assoc($query);
    $where = '';
    //if() { die('0: faltan datos...'); }
    if($_GET['filter'] && $_GET['filter'] > 0 && $_GET['filter'] < 15) {
      $where .= ' && `type` = \''.(int)$_GET['filter'].'\'';
    } else {
      unset($_GET['filter']); //
    }
    if($_GET['lastid'] && ctype_digit($_GET['lastid'])) {
      $where .= ' && id < \''.(int)$_GET['lastid'].'\'';
    }
    $idtime = ctype_digit($_GET['idtime']) && $_GET['idtime'] > 0 && $_GET['idtime'] < 7 ? $_GET['idtime'] : 0;
    echo '1';
  }
  $times = array(time(), time()-86400, time()-172800, time()-604800, time()-2592000, time()-5184000, 0);
  $titles = array(0, 'Hoy', 'Ayer', 'D&iacute;as anteriores', 'Semanas anteriores', 'Mes pasado', 'Actividad m&aacute;s antigua');
  $div = array(0, 'today', 'yesterday', 'week', 'week-ant', 'month', 'all');
  $limit = 25;
  for($i=1;$i<=6;$i++) {
    $query = mysql_query('SELECT *, COUNT(id) AS num FROM `activity` WHERE `author` = \''.$row['id'].'\' && `time` > '.$times[$i].' && `time` < '.$times[$i-1].$where.' GROUP BY what, type ORDER BY `id` DESC LIMIT '.$limit) or die(mysql_error());
    if(mysql_num_rows($query)) {
      $limit = $limit-mysql_num_rows($query);
      if($i > $idtime) {
        echo '<div id="last-activity-date-'.$div[$i].'" class="date-sep">
        <h3>'.$titles[$i].'</h3>';
      }
      while($act = mysql_fetch_assoc($query)) {
        $lastid = $act['id']; //-yao
        echo '<div class="sep">';
        switch($act['type']) {
          case '1':
            echo '<img src="/media/images/notificaciones/post.png"> Cre&oacute; un nuevo post: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '2':
            echo '<img src="/media/images/notificaciones/comentario.png"> Coment&oacute; '.($act['num'] > 1 ? $act['num'].' veces en ' : '').' el post: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '3':
            echo '<img src="/media/images/notificaciones/post.png"> Cre&oacute; un nuevo tema: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '4':
            echo '<img src="/media/images/notificaciones/comment_add.png"> Respondi&oacute; '.($act['num'] > 1 ? $act['num'].' veces' : '').' en el tema: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '5':
            echo '<img src="/media/images/notificaciones/post.png"> Cre&oacute; una nueva comunidad: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '6':
            echo '<img src="/media/images/notificaciones/user_add.png"> Se uni&oacute; a la comunidad: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '7':
            echo '<img src="/media/images/notificaciones/like.png"> Recomend&oacute; la comunidad: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '8':
            //$img = 'favorito.png';
            $newfriend = mysql_fetch_row(mysql_query('SELECT id, `nick`, `avatar` FROM `users` WHERE `id` = \''.$act['what'].'\''));
            echo '<a href="/'.$row['nick'].'"><img src="'.$row['avatar'].'" onerror="error_avatar(this)" width="15" height="15"></a> @<a href="/perfil/'.$row['nick'].'">'.$row['nick'].'</a> ahora es amigo de <img width="15" onerror="error_avatar(this)" height="15" src="'.$newfriend[2].'"> @<a class="hovercard" data-uid="'.$newfriend[0].'" href="/'.$newfriend[1].'" title="'.$newfriend[1].'">'.$newfriend[1].'</a>';
            break;
          case '9':
            echo '<img src="/media/images/notificaciones/camera.png"> Agreg&oacute; una nueva foto: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '10':
            echo '<img src="/media/images/notificaciones/comentario_photo.png"> Coment&oacute; la foto: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '11':
            $cant = explode('@$', $act['url']);
            echo '<img src="/media/images/notificaciones/puntos.png"> Dej&oacute; <b>'.$cant[1].'</b> puntos en el post: <a href="'.$cant[0].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '12':
            echo '<img src="/media/images/notificaciones/muro.png"> Comparti&oacute; una nueva publicaci&oacute;n: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '13':
            echo '<img src="/media/images/notificaciones/muro.png"> Respondi&oacute; '.($row['nick'] == $act['title'] ? 'su' : 'a una').' publicaci&oacute;n: <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          case '14':
            echo '<img src="/media/images/notificaciones/like.png"> Le gusta la publicaci&oacute;n en el muro de <a href="'.$act['url'].'" title="'.$act['title'].'">'.$act['title'].'</a>';
            break;
          default: continue;
        }
        echo ' <span class="time">'.timefrom($act['time']).'</span>'; //while
        if($act['author'] == $logged['id'] || $logged['rank'] == '9') {
          echo '<span class="remove"><a href="#" onclick="activity.del('.$act['id'].', this); return false;">x</a></span>';
        }
        echo '</div>';
      } //while -yao
      if($i > $idtime) { echo '</div>'; }
      if($limit < 1) { break; }
    } //num_rows
  } //for
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `activity` WHERE `author` = \''.$row['id'].'\' && `id` < \''.$lastid.'\''.($_GET['filter'] ? ' && `type` = \''.(int)$_GET['filter'].'\'' : '').' GROUP BY what, type'))) {
    echo '<h3 id="last-activity-view-more"><a href="" onclick="activity.more(\''.$row['id'].'\', \''.($_GET['filter'] ? $_GET['filter'] : '-1').'\', \''.$lastid.'\', \''.($i).'\');return false;">Ver m&aacute;s actividad</a></h3>';
  }
  if($limit == '25') { echo '<div class="redBox">Nada por here... <br /><img src="http://foros.gxzone.com/attachments/44734d1333667732-exito_meme.jpg"></div>'; }
  if($_GET['_']) { die; }
  ?>
</div>
</div>
</div>
</div>
</div>