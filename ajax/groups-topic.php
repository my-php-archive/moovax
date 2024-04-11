<?php
if(!defined($config['define'])) { die; }
if(!$_GET['idco'] || !(int)$_GET['id']) { fatal_error('Faltan datos...', 'OOOPS!'); }
if(!mysql_num_rows($co = mysql_query('SELECT * FROM `groups` WHERE `url` = \''.mysql_clean($_GET['idco']).'\''))) { fatal_error('La comunidad no existe'); }
$group = mysql_fetch_assoc($co);
if($group['status'] != '0') { fatal_error('La comunidad fue eliminada'); }
if($group['private'] == '1' && !$logged['id']) { fatal_error('Para ver esta comunidad debes loguearte'); }
$ismember = false;
if($logged['id']) {
  if(mysql_num_rows($m = mysql_query('SELECT id, `rank`, `status` FROM `groups_members` WHERE `group` = \''.$group['id'].'\' && `user` = \''.$logged['id'].'\''))) {
    list($idmember, $currentrank, $status) = mysql_fetch_row($m);
    if($status != 1) { $ismember = true; }
  }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\''))) {
    fatal_error('Fuiste baneado de la comunidad');
  }
}
if(!mysql_num_rows($tem = mysql_query('SELECT * FROM `groups_topics` WHERE `id` = \''.(int)$_GET['id'].'\' && `group` = \''.$group['id'].'\''))) { fatal_error('El tema no existe'); }
$row = mysql_fetch_assoc($tem);
if(($row['private'] == 1 || $row['private'] == 2) && !$logged['id']) { fatal_error('Este tema es privado'); }
if($row['private'] == 2 && !$ismember) { fatal_error('Para ver este tema debes loguearte'); }
if($row['status'] != '0' && $currentrank != '4' && $currentrank != '5') { fatal_error('El tema se encuentra eliminado'); }
//Visitas
$_SERVER['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDED_FOR'];
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `post_visits` WHERE `ip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\' && `post` = \''.$row['id'].'\' && `type` = \'4\'')) && $logged['id'] != $row['author']) {
  mysql_query('INSERT INTO `post_visits` (`post`, `ip`, `time`, `type`) VALUES (\''.$row['id'].'\', \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\', \''.time().'\', \'4\')');
}
$author = mysql_fetch_assoc(mysql_query('SELECT * FROM `users` WHERE `id` = \''.$group['author'].'\''));
$spanish = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');
$url = $config['url'].'/comunidades/'.$group['url'].'/'.$row['id'].'/'.url($row['title']).'.html';
?>
<script>
var g_com = '<?=$group['id'];?>';
var tema = '<?=$row['id'];?>';
</script>
<div id="main_content">
<div class="breadcrumb">
<ul>
<li class="first"><a href="/" accesskey="1" class="home"></a></li>
<li><a href="/comunidades/" title="Comunidades">Comunidades</a></li>
<?php
$cat = mysql_fetch_row(mysql_query('SELECT `id`, `name` FROM `groups_categories` WHERE `id` = \''.$group['cat'].'\''));
?>
<li><a href="/comunidades/categoria/<?=$cat[0];?>" title="<?=$cat[1];?>"><?=$cat[1];?></a></li>
<li><a href="/comunidades/<?=$group['url'];?>" title="<?=$group['name'];?>" alt="<?=$group['name'];?>"><?=$group['name'];?></a></li>
<li style="font-weight:bold;"><?=$row['title'];?></li>
<li class="last"></li>
</ul>
</div>
<div style="clear: both;"></div>
<?php include('groups-left.php'); ?>
<div class="ver-tema">
<div class="CodePro">
<table style="padding:0px;margin:0px;">
<tr style="padding:0px;margin:0px;">
<td valign="top"><a href="/perfil/<?=$author['nick'];?>" title="<?=$author['nick'];?>" alt="<?=$author['nick'];?>"><img src="/avatar.gif" width="100px" height="100px" alt="<?=$author['nick'];?>" class="avatar" title="<?=$author['nick'];?>" onerror="error_avatar(this)" /></a></td>
<td valign="top" style="width:160px;"><b class="size15">@<a href="/perfil/<?=$author['nick'];?>" title="<?=$author['nick'];?>" alt="<?=$author['nick'];?>"><?=$author['nick'];?></a></b><br/><br class="space" />
<?php
$currentrankuser = mysql_fetch_row(mysql_query('SELECT `rank` FROM `groups_members` WHERE `user` = \''.$author['id'].'\' && `group` = \''.$group['id'].'\''));
?>
<img src="<?=$config['images'];?>/images/comunidades/<?=grouprank($currentrankuser[0], true);?>" /> <span><?=grouprank($currentrankuser[0]);?></span><br/>
<?php
if(mysql_num_rows($pais = mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `id` = \''.$author['country'].'\''))) {
  $rsr = mysql_fetch_row($pais);
  echo '<img alt="'.$rsr[0].'" title="'.$rsr[0].'" src="'.$config['images'].'/images/icons/banderas/'.$rsr[1].'.png" />&nbsp;<span>'.$rsr[0].'</span> <br/>';
}
?>
<img src="<?=$config['images'];?>/images/<?=($author['sex'] == 0 ? 'Hombre' : 'Mujer');?>.gif" title="<?=($author['sex'] == 0 ? 'Hombre' : 'Mujer');?>" border="0" /> <?=($author['sex'] == 0 ? 'Hombre' : 'Mujer');?> <br/>
<?php
if($logged['id']) { echo '<img src="'.$config['images'].'/images/icons/mensaje_para.gif" alt="Enviar mensaje privado" /><a onclick="mp.enviar_mensaje(\''.$author['nick'].'\'); return false" title="Enviar mensaje privado"> <font style="font-weight:normal">Enviar mensaje</font></a><br/>'; }
?>
</td>
<td></td>
</tr>
</table>
</div>
<div class="clear"></div>
<br class="space">
<?php
if($row['status'] != 0) { echo '<div class="redBox"><b class="size12">El tema se encuentra eliminado</b></div><br class="space"> '; }
?>
<div class="box_title_content">
<div class="box_txt">
<img src="<?=$config['images'];?>/images/comunidades/temas.png" alt="" align="top" />
<a href="<?=$url;?>" title="<?=$row['title'];?>" alt="<?=$row['title'];?>"><?=$row['title'];?></a>
</div>
</div>

<div class="box_cuerpo_content">
<br>
<div class="post-contenido" property="dc:content" id="post_<?=$row['id'];?>"><?=BBposts($row['body']);?></div>
<br>
<div class="post-datos">
<hr class="divider"><table align="center"><tr>
<td style="width:200px;"><b>Compartir:</b></td>
<td style="width:230px;"><b>Calificar:</b></td>
<td style="width:200px;"><b>Creado:</b></td>
<td style="width:100px;"><b>Visitas:</b></td>
</tr><tr>
<td>
<span class="floatL" id="tipsy_bottom"><a href="http://www.facebook.com/share.php?u=<?=$url;?>" rel="nofollow" target="_blank" title="Facebook" class="SocialIcons facebook"></a><a href="http://twitter.com/home?status=Les%20recomiendo%20este%20post:%20<?=$url;?>" rel="nofollow" target="_blank" title="Twitter" class="SocialIcons twitter"></a><a href="http://www.stumbleupon.com/submit?url=<?=$url;?>" rel="nofollow" target="_blank" title="StumbleUpon" class="SocialIcons stumbleupon"></a><a href="http://del.icio.us/post?url=<?=$url;?>" rel="nofollow" target="_blank" title="Delicious" class="SocialIcons delicious"></a><a href="http://digg.com/submit?phase=2&url=<?=$url;?>" rel="nofollow" target="_blank" title="Digg" class="SocialIcons digg"></a><a href="http://reddit.com/submit?url=<?=$url;?>" rel="nofollow" target="_blank" title="Reddit" class="SocialIcons reddit"></a></span>
</td>
<td>
<span id="votos_total2">
<a href="javascript:comunidades.votar_tema(1,<?=$row['id'];?>)" class="thumbs thumbsUp" title="Votar positivo"></a>
<a href="javascript:comunidades.votar_tema(-1,<?=$row['id'];?>)" class="thumbs thumbsDown" title="Votar negativo"></a>
</span>
<span id="votos_total" class="<?=($row['votes'] < 0 ? 'no' : 'ok');?>"><?=$row['votes'];?></span>
</td>
<td><span style="font-size: 11px;" title="<?=timefrom($row['time']);?>"><img src="<?=$config['images'];?>/images/icons/calendar.gif" align="absmiddle"> <?=date('d', $row['time']);?> de <?=$spanish[date('n', $row['time'])-1];?> de <?=date('Y', $row['time']);?>, <?=date('G.i', $row['time']);?></span></td>
<td><span style="font-size: 11px;"><img src="<?=$config['images'];?>/images/icons/monitor.png" align="absmiddle"> <?=mysql_num_rows(mysql_query('SELECT `id` FROM `post_visits` WHERE `post` = \''.$row['id'].'\' && `type` = \'4\''));?> visitas</span></td><div class="clearBoth"></div>

</tr>
</table>
</div>
</div>
<br class="space">
<span class="floatR" style="margin:0px;padding:0px;">
<?php if($row['status'] == '0' && ($logged['id'] == $row['author'] || allow('edittopic') || allow('elimtopic'))) { ?>
<input class="Boton BtnBlue" style="font-size: 11px;" value="Editar" title="Editar" onclick="location.href='/comunidades/<?=$group['url'];?>/editar/<?=$row['id'];?>'" type="button" />&nbsp;
<input class="Boton BtnRed" style="font-size: 11px;" value="Eliminar" title="Eliminar" onclick="comunidades.del_tema(); return false;" type="button" />
<?php
} elseif($row['status'] != '0') { echo '<input class="Boton BtnGreen" style="font-size: 11px;" value="Reactivar" title="Reactivar" onclick="comunidades.react_tema(); return false;" type="button" />'; }
?>

</span>
<br>
<br class="space">
<a href="/rss/temas-comment/<?=$row['id'];?>"><span class="icons rss"></span></a> <b style="font-size:14px;"> Comentarios (<span id="cantcomments"><?=mysql_num_rows(mysql_query('SELECT `id` FROM `groups_comments` WHERE `id_topic` = \''.$row['id'].'\''));?></span>)</b><div class="barra-dashed"></div>

<div id="comentarios">
<?php
include('./ajax/groups-comment-page.php');
?>
</div>
<?php
if($row['closed'] == '1') { echo '<div class="yellowBox">El tema se encuentra cerrado y no se permiten comentarios</div>'; } else {
if($ismember && !mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `user` = \''.$logged['id'].'\' && `author` = \''.$row['author'].'\''))) {
?>
<a name="comentar"></a>
<div class="agregar_comment">
<div class="box_cuerpo_content" style="border-top:1px solid #C9CACB;margin-bottom:6px;">
<div class="comment-content">
<form name="nuevocoment">
<textarea  id="VPeditor" name="cuerpo_comment" tabindex="2" style="width:762px;height:100px;"></textarea>
<br class="space">
<div class="floatR">
<div id="emoticons" style="float:left"><a href="#" smile=":bueno:"><img height="24" width="24" border="0" onclick="insertText(' :bueno:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/bueno.png" alt="Bueno" title="Bueno"></a><a href="#" smile=":malo:"><img height="24" width="24" border="0" onclick="insertText(' :malo:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/malo.png" alt="Malo" title="Malo"></a><a href="#" smile=":muerto:"><img height="24" width="24" border="0" onclick="insertText(' :muerto:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/muerto.png" alt="Muerto" title="Muerto"></a><a href="#" smile=":divertido:"><img height="24" width="24" border="0" onclick="insertText(' :divertido:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/divertido.png" alt="Divertido" title="Divertido"></a><a href="#" smile=":sinister:"><img height="24" width="24" border="0" onclick="insertText(' :sinister:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/sinister.png" alt="Siniestro" title="Siniestro"></a><a href="#" smile=":D"><img height="24" width="24" border="0" onclick="insertText(' :D', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/sonrisa.png" alt="Sonrisa" title="Sonrisa"></a><a href="#" smile=":arrogante:"><img height="24" width="24" border="0" onclick="insertText(' :arrogante:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/arrogante.png" alt="Arrogante" title="Arrogante"></a><a href="#" smile=":@"><img height="24" width="24" border="0" onclick="insertText(' :@', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/enojado.png" alt="Enojado" title="Enojado"></a><a href="#" smile=":relax:"><img height="24" width="24" border="0" onclick="insertText(' :relax:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/relax.png" alt="Relajado" title="Relajado"></a><a href="#" smile=":ironico:"><img height="24" width="24" border="0" onclick="insertText(' :ironico:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/ironico.png" alt="Ironico" title="Ironico"></a><a href="#" smile=":confused:"><img height="24" width="24" border="0" onclick="insertText(' :confused:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/confused.png" alt="Confundido" title="Confundido"></a><a href="#" smile=":shamed:"><img height="24" width="24" border="0" onclick="insertText(' :shamed:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/shamed.png" alt="Vergonzoso" title="Vergonzoso"></a><a href="#" smile=":disdain:"><img height="24" width="24" border="0" onclick="insertText(' :disdain:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/disdain.png" alt="Disdain" title="Disdain"></a><a href="#" smile=":("><img height="24" width="24" border="0" onclick="insertText(' :(', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/triste.png" alt="Triste" title="Triste"></a><a href="#" smile=":sarcastico:"><img height="24" width="24" border="0" onclick="insertText(' :sarcastico:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/sarcastico.png" alt="Sarcastico" title="Sarcastico"></a><a href="#" smile=":-)"><img height="24" width="24" border="0" onclick="insertText(' :-)', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/feliz.png" alt="Feliz" title="Feliz"></a><a href="#" smile=":lost:"><img height="24" width="24" border="0" onclick="insertText(' :lost:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/lost.png" alt="Perdido" title="Perdido"></a><a href="#" smile=":shock:"><img height="24" width="24" border="0" onclick="insertText(' :shock:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/shock.png" alt="Shock" title="Shock"></a><a href="#" smile=":llorar:"><img height="24" width="24" border="0" onclick="insertText(' :llorar:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/llorar.png" alt="Llorando" title="Llorando"></a><a href="#" smile=":pirata:"><img height="24" width="24" border="0" onclick="insertText(' :pirata:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/pirata.png" alt="Pirata" title="Pirata"></a><a href="#" smile=":devil:"><img height="24" width="24" border="0" onclick="insertText(' :devil:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/devil.png" alt="Diablo" title="Diablo"></a><a href="#" smile=":loser:"><img height="24" width="24" border="0" onclick="insertText(' :loser:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/loser.png" alt="Perdedor" title="Perdedor"></a><a href="#" smile=":ask:"><img height="24" width="24" border="0" onclick="insertText(' :ask:', document.forms.mensajero.VPeditor);" src="http://localhost/media/images/emoticons/ask.png" alt="Pregunta" title="Pregunta"></a></div>
</div><input class="Boton BtnBlue"  type="button" id="button_comentar" value="Enviar Comentario" onclick="comunidades.add_comment(<?=$row['id'];?>,1); return false;" tabindex="2" />
</form></div><div class="clearBoth"></div>
</div>
</div>
<?php
} else { echo '<div class="yellowBox">Para poder comentar debes ser miembro de la comunidad</div>'; }
}
?>
</div>
<div style="clear:both"></div>
</div>
<div style="clear:both"></div></div>
</div></div>