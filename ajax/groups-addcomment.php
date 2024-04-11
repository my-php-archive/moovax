<?php
$body = trim($_POST['body']);
if(!$body || !$_POST['tema']) { die('0: Faltan datos...'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `status`, `author`, `title`, `group`, `closed` FROM `groups_topics` WHERE `id` = \''.(int)$_POST['tema'].'\''))) { die('0: El tema no existe'); }
$r = mysql_fetch_row($query);
if($r[1] != '0') { die('0: El tema no existe'); }
if($r[5] == '1') { die('0: El tema se encuentra cerrado'); }
$group = mysql_fetch_assoc(mysql_query('SELECT * FROM `groups` WHERE `id` = \''.$r[4].'\''));
if($group['status'] != 0) { die('0: El grupo se encuentra eliminado'); }
if(!mysql_num_rows($member = mysql_query('SELECT `id`, `rank` FROM `groups_members` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\' && `status` = \'0\''))) { die('0: No eres miembro de la comunidad'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\''))) { die; }
list($id, $currentrank) = mysql_fetch_row($member);
if($currentrank == '1') { die('0: Tu rango no te permite realizar comentarios'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_comments` WHERE `time` > \''.(time()-30).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Debes esperar para realizar esta acci&oacute;n'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `user` = \''.$logged['id'].'\' && `author` = \''.$r[2].'\''))) { die('0: Este usuario te tiene bloqueado, no puedes comentar -put'); }
if(strlen($body) < 3) { die('0: El comentario debe tener al menos 3 caracteres'); }
mysql_query('INSERT INTO `groups_comments` (`author`, `body`, `id_topic`, `time`) VALUES (\''.$logged['id'].'\', \''.mysql_clean($body).'\', \''.$r[0].'\', \''.time().'\')') or die('0: '.mysql_error());
$id = mysql_insert_id();
$url = '/comunidades/'.$group['url'].'/'.$r[0].'/'.url($r[3]).'.html#cmt_'.$id;
if($logged['id'] != $r[2]) {
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$r[2].'\', \'18\', \''.$url.'\', \'0\', \''.time().'\', \''.$r[3].'\')');
}
$com = mysql_query('SELECT u.id FROM `groups_comments` AS c INNER JOIN `users` AS u ON u.id = c.`author` WHERE c.`id_topic` = \''.$r[0].'\' GROUP BY u.id');
while($rs = mysql_fetch_row($com)) {
  if($rs[0] == $logged['id'] || $rs[0] == $r[2]) { continue; }
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$rs[0].'\', \'20\', \''.$url.'\', \'0\', \''.time().'\', \''.$r[3].'\')');
}
mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$r[3].'\', \''.$url.'\', \''.$id.'\', \''.time().'\', \'4\')') or die('0: '.mysql_error());
echo '1: <div class="coment-user" id="cmt_'.$id.'">
<div class="comment-container-autor">
<div class="comment-title">
<div class="floatL">
<span id="comment_'.$id.'" user_cmt="'.$logged['nick'].'" text_cmt="'.htmlspecialchars($body).'"></span>
<a href="/perfil/'.$logged['nick'].'" title="'.$logged['nick'].'">'.$logged['nick'].'</a> -
<span class="size11">Hace instantes</span>
</div>
<div class="floatR answerOptions">
<ul>
<li class="answerPerfil"><a href="/'.$logged['nick'].'" title="Ver perfil de '.$logged['nick'].'" target="_self"><span class="ver-perfil"></span></a></li>
<li class="answerCitar"><a onclick="citar_comment('.$id.'); return false" href="#" title="Citar Comentario"><span class="citar-comentario"></span></a></li>
<li class="answerBorrar"><a onclick="if (!confirm(\'\xbfEstas seguro que desea eliminar este comentario?\')); comunidades.del_comment(\''.$id.'\'); return false;" href="#" title="Eliminar comentario"><span class="borrar-comentario"></span></a></li>
</ul>
</div>
</div>
<div class="comment-cuerpo">'.BBposts(htmlspecialchars($body), false, true, false, true).'</div> </div> </div>';