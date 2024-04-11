<?php
if(!$_POST['comentario'] || !$_POST['id_perfil']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(stripos($_POST['comentario'], 'actualiza tu estado') !== false) { die('0: Que gracioso!'); }
if(!mysql_num_rows($us = mysql_query('SELECT `id`, `nick`, `walls_comments` FROM `users` WHERE `id` = \''.intval($_POST['id_perfil']).'\''))) { die('0: El usuario no existe'); }
$qs = mysql_fetch_row($us);
if($qs[2] == '1' && $qs[0] != $logged['id']) { die('0: El usuario no acepta comentarios en su muro'); }
if(strlen($_POST['comentario']) < 2 || strlen($_POST['comentario']) > 255) { die('0: El comentario debe tener al menos 2 caracteres'); }
/* blocked */
if(mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `author` = \''.$qs[0].'\' && `user` = \''.$logged['id'].'\''))) { die('0: El usuario te ha bloqueado'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `walls` WHERE `time` > \''.(time()-60).'\' && `author` = \''.$logged['id'].'\''))) { die('0: No puedes realizar tantas acciones en tan poco tiempo'); }
mysql_query('INSERT INTO `walls` (`author`, `profile`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$qs[0].'\', \''.mysql_clean($_POST['comentario']).'\', \''.time().'\')') or die('0: '.mysql_error());
$id = mysql_insert_id();
$url = '/'.$qs[1].'/muro/'.$id;
if($qs[0] != $logged['id']) {
  mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$id.'\', \'3\', \''.$url.'\', \'0\', \''.time().'\', \''.$qs[1].'\')') or die(mysql_error());
} else {
  mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.$qs[1].'\', \''.$url.'\', \''.$id.'\', \''.time().'\', \'12\')') or die('0: '.mysql_error());
  $while = mysql_query('SELECT u.id FROM `users` AS u INNER JOIN `friends` AS f ON IF(`f`.`author` = \''.$logged['id'].'\', `user`, `author`) = u.id WHERE (f.`author` = \''.$logged['id'].'\' || f.`user` = \''.$logged['id'].'\') && f.`status` = \'1\' GROUP BY u.id');
  while($row = mysql_fetch_row($while)) {
    mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$row[0].'\', \'13\', \''.$url.'\', \'0\', \''.time().'\', \''.$qs[1].'\')');
  }
}
?>
1:
<div id="perfil-wall" class="widget clearfix">
<div id="wall-content">
<div class="Story" id="pub_<?=$id;?>">
<a href="/perfil/<?=$logged['id'];?>" class="Story_Pic"><img width="40" height="40" alt="<?=$logged['nick'];?>" src="<?=$logged['avatar'];?>"></a>
<div class="Story_Content">
<div class="Story_Head">
<div class="Story_Hide"><a href="#" onclick="muros.del_comment(200); return false;" title="Eliminar la publicación" class="qtip uiClose"></a></div><div class="Story_Message">
<div class="autor">@<a href="/perfil/<?=$logged['nick'];?>" class="a_blue"><?=$logged['nick'];?></a></div>
<span><?=BBposts(htmlspecialchars($_POST['comentario']), false, true, false, true, true);?></span>
</div>
</div>
<div class="Story_Foot">
<div class="Story_Info">
<i class="stream w_1"></i>
<span class="text"><?=date('d/m/Y');?> a las <?=date('G:i');?></span>
 &middot;
 <a onclick="muros.i_like(<?=$id;?>, 'comment', this); return false;" class="a_blue">Me gusta</a> &middot;
 <a onclick="muros.show_comment_box(<?=$id;?>); return false" class="a_blue">Comentar</a>
</div>
<!-- cmentarios o likes -->
<ul id="cb_<?=$id;?>" class="Story_Comments">
<li class="lifi"><i></i></li>
<li style="display:none;" class="ufiItem">
<div class="clearfix">
<i></i>
<span class="floatL" id="lk_<?=$id;?>">
</span>
</div>
</li>
<li1>
<div style="display:none;" id="return_sub_comentar_muro_<?=$id;?>"></div>

<li>

</li>
<li style="display:none;" class="ufiItem" id="comentariomostrar<?=$id;?>">
<div class="newComment">
<input type="text" pid="457" value="Escribe un comentario..." onclick="$('#commentgrande<?=$id;?>').show(); $(this).hide(); $('#cf_<?=$id;?>').focus(); return false;" name="hack" id="hack<?=$id;?>" title="Escribe un comentario....">
<form  action="javascript:muros.add_sub_comment(<?=$qs[0];?>, <?=$id;?>);" style="display:none" class="formulario" id="commentgrande<?=$id;?>">
<img width="32" height="32" src="<?=$logged['avatar'];?>">
<textarea onblur="onblur_input(this)" onfocus="onfocus_input(this)" onkeypress="return muros.checkearTecla(event, this)" name="add_wall_comment" pid="<?=$id;?>" id="cf_<?=$id;?>" title="Escribe un comentario..." class="comentar onblur_effect" style="max-height: 200px; overflow: hidden; display: block; height: 14px;"></textarea>
<div class="clearBoth"></div>
</form>
</div>
</li>
</li1></ul>
<!-- few -->
</div>
</div>
<div class="clearBoth"></div>
</div> </div> </div>