<?php
$comment = trim($_POST['comentario']);
if(!$comment || !$_POST['id'] || !$_POST['categoria']) { die('0: Faltan datos'); }
if(strlen($comment) < 2) { die('0: El comentario debe tener al menos 2 caracteres'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(!mysql_num_rows($mq = mysql_query('SELECT `id`, `title`, `author`, `status`, `closed`, `cat` FROM `photos` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El post no existe'); }
$row = mysql_fetch_assoc($mq);
if($row['status'] != 0) { die('0: EL post se encuentra eliminado'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `p_comments` WHERE `time` > \''.(time()-30).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Antiflood'); }
if($row['author'] != $logged['id'] && mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `author` = \''.$row['author'].'\' && `user` = \''.$logged['id'].'\''))) { die('0: Haz sido bloqueado'); }
if($row['closed'] != 0) { die('0: La foto est&aacute; cerrada'); }
if($row['cat'] != $_POST['categoria']) { die('0: Hijo de puta'); }
$cat = mysql_fetch_row(mysql_query('SELECT `url` FROM `p_categories` WHERE `id` = \''.$row['cat'].'\''));
mysql_query('INSERT INTO `p_comments` (`photo`, `author`, `body`, `time`) VALUES (\''.$row['id'].'\', \''.$logged['id'].'\', \''.htmlspecialchars($comment).'\', \''.time().'\')');
$id = mysql_insert_id();
$url = '/fotos/'.$cat[0].'/'.$row['id'].'/'.url($row['title']).'.html#cmt_'.$id;
if($logged['id'] != $row['author']) {
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$row['author'].'\', \'5\', \''.$url.'\', \'0\', \''.time().'\', \''.$row['title'].'\')');
}
mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$row['title'].'\', \''.$url.'\', \''.$id.'\', \''.time().'\', \'10\')');
?>
1:
<div id="cmt_<?=$id;?>"><div class="comment-container-<?=($row['author'] == $logged['id'] ? 'autor' : 'me');?>"><div class="comment-title">
				<div class="floatL">
					<a href="/perfil/<?=$logged['nick'];?>">@<?=$logged['nick'];?></a> - <span dc-property="date"><?=date('d.m.Y');?> a las <?=date('G:i');?> hs.</span> dijo:
				</div>
				<div class="floatR answerOptions">
					<ul><li class="answerPerfil"><a target="_self" title="Ver perfil de <?=$logged['nick'];?>" href="/perfil/<?=$logged['nick'];?>"><span class="ver-perfil"></span></a></li>
						<li class="answerCitar"><a title="Citar Comentario" href="#" onclick="citar_comment(<?=$id;?>); return false"><span class="citar-comentario"></span></a></li>
						<li class="answerBorrar"><a title="Eliminar comentario" href="#" onclick="if (!confirm('\xbfEstas seguro que deseas eliminar este comentario?')) return false; fotos.del_comment('<?=$id;?>','<?=$logged['id'];?>'); return false"><span class="borrar-comentario"></span></a></li>

					</ul>
				</div>
				<div class="clear"></div>
			</div>
			<div class="comment-cuerpo">
				 <?=BBposts(mysql_clean($comment), false, true, false, true, true);?>
			<div class="clearBoth"></div>
	</div>
</div>
</div>