<?php
if(!defined('ok')) {
  if(!$_GET['id_user']) { die('Faltan datos'); }
  include('../config.php');
  include('../functions.php');
  if(!mysql_num_rows($a = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `id` = \''.intval($_GET['id_user']).'\''))) { die('0: El usuario no existe'); }
  $row = mysql_fetch_assoc($a);
}
$atq = '';
if($_GET['id_m'] && ctype_digit($_GET['id_m'])) { $atq .= ' && w.id = \''.intval($_GET['id_m']).'\''; }
//if(!defined($config['define']) && !$_GET['id_user']) { die('Faltan datos'); }
if($_GET['f']) { $atq .= ' && w.`id` < \''.intval($_GET['f']).'\''; }
if(!$_GET['action']) { $_GET['action'] = 'ID'; }
switch($_GET['action']) {
  case 'ID':
    $query = mysql_query('SELECT w.*, u.nick, u.avatar FROM `walls` AS w INNER JOIN `users` AS u ON u.id = w.author WHERE w.profile = \''.$row['id'].'\' '.$atq.' ORDER BY w.id DESC LIMIT 10') or die(mysql_error());
    break;
  case 'Autor':
    $query = mysql_query('SELECT w.*, u.nick, u.avatar FROM `walls` AS w INNER JOIN `users` AS u ON u.id = w.author WHERE w.profile = \''.$row['id'].'\' '.$atq.' && w.author = \''.$row['id'].'\' ORDER BY w.id DESC LIMIT 10') or die(mysql_error());
    break;
  case 'Populares':
    $query = mysql_query('SELECT w.*, u.nick, u.avatar, COUNT(r.id) AS count FROM `walls` AS w INNER JOIN `w_replies` AS r ON r.what = w.id INNER JOIN `users` AS u ON u.id = w.author WHERE w.`profile` = \''.$row['id'].'\' '.$atq.' GROUP BY w.id ORDER BY count DESC');
    break;
  default: die('Error provocado');
}
if(mysql_num_rows($query)) {
    while($ea = mysql_fetch_assoc($query)) {
?>
<script>

</script>
<div id="perfil-wall" class="widget clearfix">
<div id="wall-content">
<div id="pub_<?=$ea['id'];?>" class="Story">
<a class="Story_Pic" href="/perfil/<?=$ea['nick'];?>"><img width="40" onerror="error_avatar(this)" height="40" src="<?=$ea['avatar'];?>" alt="<?=$ea['nick'];?>"></a>
<div class="Story_Content">
<div class="Story_Head">
<?php if($logged['id'] == $ea['author'] || $logged['id'] == $row['id'] || allow('delete_comments')) { echo '<div class="Story_Hide"><a class="qtip uiClose" title="Eliminar la publicaci&oacute;n" onclick="muros.del_comment('.$ea['id'].'); return false;" href="#"></a></div>'; } ?>
<div class="Story_Message">
<div class="autor">@<a class="a_blue" href="/perfil/<?=$ea['nick'];?>"><?=$ea['nick'];?></a></div>
<span><?=BBposts($ea['body'], false, true, false, true, true);?></span>
</div>
</div>
<div class="Story_Foot">
<div class="Story_Info">
<i class="stream w_1"></i>
<span class="text"><?=date('d/m/Y', $ea['time']);?> a las <?=date('G:i', $ea['time']);?></span>
<?php
if($logged['id']) {
  echo ' &middot; ';
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `w_likes` WHERE `author` = \''.$logged['id'].'\' && `what` = \''.$ea['id'].'\' && `type` = \'0\''))) {
    echo '<a class="a_blue" onclick="muros.i_dont_like('.$ea['id'].', \'comment\', this); return false;">Ya no me gusta</a> ';
  } else {
    echo '<a class="a_blue" onclick="muros.i_like('.$ea['id'].', \'comment\', this); return false;">Me gusta</a>';
 }
 echo ' &middot; <a class="a_blue" onclick="muros.show_comment_box('.$ea['id'].'); return false">Comentar</a>';
}
?>
</div>
<!-- cmentarios o likes -->
<ul class="Story_Comments" id="cb_<?=$ea['id'];?>">
<li class="lifi"><i></i></li>
<li class="ufiItem"<?=(!mysql_num_rows(mysql_query('SELECT * FROM `w_likes` WHERE `type` = \'0\' && `what` = \''.$ea['id'].'\'')) ? ' style="display:none;"' : '');?>>
<div class="clearfix">
<i></i>
<span id="lk_<?=$ea['id'];?>" class="floatL">
<?php
$text = '';
$n = mysql_num_rows($rdm = mysql_query('SELECT u.id, u.nick FROM `users` AS u INNER JOIN `w_likes` AS w ON w.`author` = u.id WHERE w.`what` = \''.$ea['id'].'\' && `type` = \'0\''));
if($n > 0) {
  //$r = mysql_query('SELECT u.id, u.nick FROM `users` AS u INNER JOIN `w_likes` AS w ON w.`author` = u.id WHERE w.`what` = \''.$ea['id'].'\' && `type` = \'0\'');
  $text .= 'A ';
  $i = 0;
  $im = false;
  $dif = 0;
  while($wls = mysql_fetch_row($rdm)) {
    if(++$i > 4) {
      $dif = ($n-$i)+1;
      $text .= ' a <a onclick="muros.ver_likes('.$ea['id'].', \'comment\'); return false;" class="a_blue">'.($dif).' persona'.($dif != 1 ? 's' : '').' m&aacute;s</a> ';
      break;
    }
    if($wls[0] == $logged['id']) {
      $text .= ($i != 1 ? ' a' : '').' ti';
      $im = true;
    } else { $text .= '<a data-uid="'.$wls[0].'" class="hovercard a_blue" href="/perfil/'.$wls[1].'">'.$wls[1].'</a>'; }
    $text .= ($i < $n-1 && $i < 4 ? ', ' : ($i+1 == $n || ($i == 3 && $n < $i) ? ' y ' : ' '));
  }
  $text .= ($i == '1' && $im ? 'te' : 'le'.($i > 1 && $dif != 1 ? 's' : '')).' gusta esto';
}
echo $text;
?>
</span>
</div>
</li>
<!-- otro ul de más comentarios mmmm -->
<?php
$num = mysql_num_rows(mysql_query('SELECT `id` FROM `w_replies` WHERE `what` = \''.$ea['id'].'\''));
if($num > 3 && $ea['id'] != $_GET['id_m']) {
?>
<li class="ufiItem" id="view_allcomments<?=$ea['id'];?>">
<div class="more_comments clearfix">
<i></i>
<a onclick="muros.more_comments(<?=$ea['id'];?>); return false" class="a_blue floatL" href="#">Ver los <?=$num;?> comentarios</a>
<img width="16" id="load<?=$ea['id'];?>" height="11" src="http://static.ak.fbcdn.net/rsrc.php/yb/r/GsNJNwuI-UM.gif">
</div>
</li>
<!-- termina -->
<?php } ?>
<li<?=(!$num ? ' style="display:none;"' : '');?> id="more_comments<?=$ea['id'];?>">
<?php
$querys = mysql_query('SELECT w.*, u.id AS uid, u.nick, u.avatar FROM `users` AS u INNER JOIN `w_replies` AS w ON w.`author` = u.id WHERE w.`what` = \''.$ea['id'].'\''.($_GET['id_m'] != $ea['id'] ? ' LIMIT 3' : ''));
while($wall = mysql_fetch_assoc($querys)) {
  echo '<ul class="commentList" id="cl_'.$wall['id'].'">                                                                                                                                                                  <li id="cmt_521" class="ufiItem">
    <div class="clearfix">
    <a class="autorPic" href="http://demo.phpost.net/perfil/'.$wall['nick'].'"><img onerror="error_avatar(this)" width="32" height="32" src="'.$wall['avatar'].'" alt="'.$wall['nick'].'"></a>';
    if($logged['id'] == $wall['uid'] || $logged['id'] == $row['id'] || $logged['id'] == $ea['author'] || allow('delete_comments')) {
      echo '<span class="close"><a title="Eliminar" class="uiClose" onclick="muros.del_sub_comment('.$wall['id'].'); return false" href="#"></a></span>';
    }
    echo '<div class="mensaje">
    @<a class="autorName a_blue" href="/perfil/'.$wall['nick'].'">'.$wall['nick'].'</a>
    <span>'.$wall['body'].'</span>
    <div class="cmInfo">'.timefrom($wall['time']);
    if($logged['id']) {
      echo ' &middot; ';
      $like = mysql_num_rows(mysql_query('SELECT `id` FROM `w_likes` WHERE `author` = \''.$logged['id'].'\' && `what` = \''.$wall['id'].'\' && `type` = \'1\''));
      $nm = mysql_num_rows(mysql_query('SELECT `id` FROM `w_likes` WHERE `type` = \'1\' && `what` = \''.$wall['id'].'\''));
      if($like == 0) {
        echo '<a class="a_blue" onclick="muros.i_like('.$wall['id'].', \'sub_comment\', this); return false;">Me gusta</a> ';
      } else {
        echo '<a class="a_blue" onclick="muros.i_dont_like('.$wall['id'].', \'sub_comment\', this); return false;">Ya no me gusta</a> ';
      }
    }
    echo '<span style="" class="cm_like"> &middot; <i></i>
    <a class="a_blue" id="lk_cm_'.$wall['id'].'" onclick="muros.ver_likes('.$wall['id'].', \'sub_comment\'); return false;">'.($nm > 0 ? $nm.' persona'.($nm != 1 ? 's' : '') : 'Se el primero en gustarle esto').'</a></span></div>
    </div>
    </div>
    </li>
    </ul>';
}
?><div id="return_sub_comentar_muro_<?=$ea['id'];?>" style="display:none;"></div>
</li>
<li>

</li>
<?php if($logged['id']) { ?>
<li id="comentariomostrar<?=$ea['id'];?>" class="ufiItem"<?=(!$num ? ' style="display:none;"' : '');?>>
<div class="newComment">
<input type="text" pid="457" value="Escribe un comentario..." onclick="$('#commentgrande<?=$ea['id'];?>').show(); $(this).hide(); $('#cf_<?=$ea['id'];?>').focus(); return false;" name="hack" id="hack<?=$ea['id'];?>" title="Escribe un comentario....">
<form  action="javascript:muros.add_sub_comment(<?=$row['id'];?>, <?=$ea['id'];?>);" style="display:none" class="formulario" id="commentgrande<?=$ea['id'];?>">
<img width="32" height="32" src="<?=$logged['avatar'];?>">
<textarea onblur="onblur_input(this)" onfocus="onfocus_input(this)" onkeypress="return muros.checkearTecla(event, this)" name="add_wall_comment" pid="<?=$ea['id'];?>" id="cf_<?=$ea['id'];?>" title="Escribe un comentario..." class="comentar onblur_effect" style="max-height: 200px; overflow: hidden; display: block; height: 14px;"></textarea>
<div class="clearBoth"></div>
</form>
</div>
</li>
<?php } ?>
</ul>
<!-- few -->
</div>
</div>
<div class="clearBoth"></div>
</div>
</div>
</div>

<?php
$lastact = $ea['id'];
}
if($_GET['action'] != 'Populares' && mysql_num_rows(mysql_query('SELECT `id` FROM `walls` WHERE `profile` = \''.$row['id'].'\' '.($_GET['action'] == 'Autor' ? '&& author = \''.$row['id'].'\'' : '').' && `id` < \''.$lastact.'\' '.str_replace('w.', '', $atq)))) {
  echo '<a id="pija" name="pija" href="#" onclick="ver_mas(\''.$row['id'].'\', \''.$lastact.'\', \''.$_GET['action'].'\'); return false;">Ver m&aacute;s publicaciones</a>';
}

} else { echo '<div id="sin_comments_muro" class="redBox">'.$row['nick'].' no tiene ning&uacute;n comentario en su muro.</div>'; }
?>