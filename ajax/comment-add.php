<?php
$_POST['body'] = ltrim($_POST['body']);
if(!$_POST['body']) { die('0: Faltan datos..'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes estar logueado para realizar esta acci&oacute;n'); }
if(!mysql_num_rows($query = mysql_query('SELECT id, status, author, closed, `cat`, `title` FROM `posts` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El post ingresado no existe'); }
list($id, $status, $author, $close, $cat, $title) = mysql_fetch_row($query);
if($close != '0' && $author != $logged['id']) { die('0: El post est&aacute; cerrado'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `comments` WHERE `time` >= \''.(time()-20).'\' && `author` = \''.$key.'\''))) { die('0: No puedes realizar tantas acciones en tan poco tiempo'); }
if(strlen($_POST['body']) < 2 || strlen($_POST['body']) > 7000) { die('0: El comentario debe de tener al mes 2 caracteres'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `author` = \''.$author.'\' && `user` = \''.$key.'\''))) { die('0: El autor de este post te tiene bloqueado y no es posible comentar'); }
/****************************************************************************************************************************/
mysql_query('INSERT INTO `comments` (`author`, `id_post`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$id.'\', \''.mysql_clean($_POST['body']).'\', \''.time().'\')');
$id_comment = mysql_insert_id();
$ca = mysql_fetch_row(mysql_query('SELECT `url` FROM `categories` WHERE `id` = \''.$cat.'\''));
$url = '/posts/'.$ca[0].'/'.$id.'/'.url($title).'.html#cmt_'.$id_comment;
mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$title.'\', \''.$url.'\', \''.$id_comment.'\', \''.time().'\', \'2\')');
if($logged['id'] != $author) {
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$author.'\', \'0\', \''.$url.'\', \'0\', \''.time().'\', \''.$title.'\')');
}
if(preg_match_all('/@([a-z0-9\_\-]+)/i', $_POST['body'], $result, PREG_SET_ORDER)) {
  $i = 0;
  foreach($result as $match) {
    if(++$i >= 10) { break; }
    if(!mysql_num_rows($user = mysql_query('SELECT `id` FROM `users` WHERE `nick` = \''.mysql_clean($match[1]).'\''))) { continue; }
    $rm = mysql_fetch_row($user);
    if($rm[0] == $logged['id'] || mysql_num_rows(mysql_query('SELECT `id` FROM `notifications` WHERE `id_user` = \''.$rm[0].'\' && `author` = \''.$logged['id'].'\' && `time` > \''.(time()-10*60).'\' && `type` = \'4\''))) { continue; }
    mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$rm[0].'\', \'4\', \''.$url.'\', \'0\', \''.time().'\', \''.$title.'\')');
  }
}
?>
1:
<div id="cmt_<?=$id_comment;?>">
<span id="comment_<?=$id_comment;?>" user_cmt="ignacioviglo" text_cmt='[size=28px]gewgew[/size]'></span>
<div class="comment-container-<?=($author == $key ? 'autor' : 'me');?>">
<div class="comment-title">
<div class="floatL">
<a href="/<?=$logged['nick'];?>">@<?=$logged['nick'];?></a> - <span ts="<?=time();?>" title="<?=date('d.m.Y', time());?> a las <?=date('G:i', time());?> hs."><?=timefrom(time());?></span> - dijo:
</div>

<div class="floatR answerOptions">
<ul>
<li style="display:none" class="numbersvotes">
<div name="puts" id="puts" class="overview">

<span class="negativo">0</span>
</div>
<div class="stats">
<span class="positivo">+0</span> / <span class="negativo">-0</span>
</div>
</li>
<li class="answerPerfil"><a target="_self" title="Ver perfil de <?=$logged['nick'];?>" href="/<?=$logged['nick'];?>"><span class="ver-perfil"></span></a></li>
<li class="answerCitar"><a title="Citar Comentario" href="#" onclick="citar_comment(<?=$id_comment;?>); return false"><span class="citar-comentario"></span></a></li>
<li class="answerBorrar"><a title="Eliminar comentario" href="#" onclick="if (!confirm('\xbfEstas seguro que deseas eliminar este comentario?')) return false; posts.del_comment('<?=$id_comment;?>','<?=$logged['id'];?>'); return false"><span class="borrar-comentario"></span></a></li>
</ul>
</div>
<div class="clear"></div>
</div>
<div class="comment-cuerpo"><?=BBposts(htmlspecialchars($_POST['body']), false, true, false);?><div class="clearBoth"></div></div>
</div>
</div>