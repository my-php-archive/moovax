<?php
if(!$_POST['comentario'] || !$_POST['perfil'] || !$_POST['comment']) { die('0: Faltan datos :$'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(strlen($_POST['comentario']) < 3 || strlen($_POST['comentario']) > 250) { die('0: El comentario debe tener entre 3 y 250 caracteres'); }
if(!mysql_num_rows($r = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `id` = \''.intval($_POST['perfil']).'\''))) { die('0: El usuario no existe'); }
list($id, $nick) = mysql_fetch_row($r);
if(!mysql_num_rows($q = mysql_query('SELECT `id`, `profile`, `author` FROM `walls` WHERE `id` = \''.mysql_clean($_POST['comment']).'\''))) { die('0: El comentario no existe'); }
$peq = mysql_fetch_row($q);
if($id != $peq[1]) { die('0: WTF?'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `w_replies` WHERE `author` = \''.$logged['id'].'\' && `time` > \''.(time()-30).'\''))) { die('0: Debes esperar para realizar esta acci&oacute;n'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE (`author` = \''.$peq[1].'\' || `author` = \''.$peq[2].'\') && `user` = \''.$logged['id'].'\''))) { die('0: Has sido bloqueado'); }
$query = mysql_query('SELECT `author` FROM `w_replies` WHERE `what` = \''.$peq[0].'\' GROUP BY `author`');
$url = '/'.$nick.'/muro/'.$peq[0];
while($i = mysql_fetch_row($query)) {
  if($i[0] == $logged['id'] || $i[0] == $peq[1]) { continue; }
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$i[0].'\', \'9\', \''.$url.'\', \'0\', \''.time().'\', \''.$nick.'\')') or die('0: '.mysql_error());
}
if($logged['id'] != $peq[2]) {
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$peq[2].'\', \'10\', \''.$url.'\', \'0\', \''.time().'\', \''.$nick.'\')') or die('0: '.mysql_error());
}
mysql_query('INSERT INTO `w_replies` (`author`, `what`, `body`, `like`, `time`) VALUES (\''.$logged['id'].'\', \''.$peq[0].'\', \''.mysql_clean($_POST['comentario']).'\', \'0\', \''.time().'\')');
$id = mysql_insert_id();
mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$nick.'\', \''.$url.'\', \''.$id.'\', \''.time().'\', \'13\')') or die('0: '.mysql_error());
?>
1:
<ul id="cl_<?=$id;?>" class="commentList">                                                                                                                                                                  <li class="ufiItem" id="cmt_521">
<div class="clearfix">
<a href="/perfil/<?=$logged['nick'];?>" class="autorPic"><img width="32" height="32" alt="<?=$logged['nick'];?>" src="<?=$logged['avatar'];?>"></a>
<span class="close"><a href="#" onclick="muros.del_sub_comment(<?=$id;?>); return false" class="uiClose" title="Eliminar"></a></span>                                                                <div class="mensaje">
@<a href="/perfil/<?=$logged['nick'];?>" class="autorName a_blue"><?=$logged['nick'];?></a>
<span><?=htmlspecialchars($_POST['comentario']);?></span>
<div class="cmInfo">Menos de un minuto &middot; <a onclick="muros.i_like(<?=$id;?>, 'sub_comment', this); return false;" class="a_blue">Me gusta</a> <span class="cm_like" style=""> &middot; <i></i>
<a onclick="muros.ver_likes(<?=$id;?>, 'sub-comment'); return false;" id="lk_cm_<?=$id;?>" class="a_blue">Se el primero en gustarle esto</a></span></div>
</div>
</div>
</li>
</ul>