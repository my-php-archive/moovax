<script type='text/javascript'>
function addLink() {
 var body_element = document.getElementsByTagName('body')[0];
 var selection;
 selection = window.getSelection();
 var pagelink = "<br/><br/> Post original en: <a href='"+document.location.href+"'>"+document.location.href+"</a>"; // Mensaje que aparecerá al copiar
 var copytext = selection + pagelink;
 var newdiv = document.createElement('div');
 newdiv.style.position='absolute';
 newdiv.style.left='-99999px';
 body_element.appendChild(newdiv);
 newdiv.innerHTML = copytext;
 selection.selectAllChildren(newdiv);
 window.setTimeout(function() {
  body_element.removeChild(newdiv);
 },0);
}
document.oncopy = addLink;
</script>

<?php
if(!defined($config['define'])) { die; }
if(!$_GET['id']) { fatal_error('El campo <b>ID</b> es requerido', 'Error', 'Ir a la p&aacute;gina principal', '/', 'BtnGreen'); }
if(!ctype_digit($_GET['id'])) { fatal_error('No me jakees plis <img src="http://spd.fotolog.com/photo/29/8/94/manu_losjarras/1274969295482_f.jpg">'); }
if(!mysql_num_rows($ps = mysql_query('SELECT p.*, u.id as uid, u.nick, u.avatar, u.points as puntos, u.country, u.sex, u.message, u.rank, u.firm, cat.name, cat.url, p.id as pid, u.status AS statusu FROM `posts` AS p LEFT JOIN `users` AS u ON u.id = p.author LEFT JOIN `categories` AS cat ON cat.id = p.cat WHERE p.`id` = \''.intval($_GET['id']).'\''))) { fatal_error('El post no existe guachon'); }
$row = mysql_fetch_assoc($ps);
if($row['status'] == '1' && !allow('delete_posts')) {
  fatal_error('El post se encuentra eliminado');
} elseif($row['status'] == '2' && !allow('delete_posts')) {
  fatal_error('El post se encuentra eliminado por acumulaci&oacute;n de denuncias');
}
if($row['private'] != '0' && !$logged['id']) { fatal_error('Para ver este post debes de estar logueado mijo <img src="http://i.imgur.com/doCpk.gif">', 'OOPSS', array('Ir a la p&aacute;gina principal', 'Registrarme!'), array('/', 'javascript:accounts.registro_load_form();'), array('BtnGreen', 'BtnBlue')); }
$_SERVER['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDER_FOR'];
if(!mysql_num_rows(mysql_query('SELECT * FROM `post_visits` WHERE `post` = \''.$row['pid'].'\' && `ip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\' && `type` = \'0\'')) && $_SERVER['REMOTE_ADDR']) {
  mysql_query('INSERT INTO `post_visits` (`post`, `ip`, `time`) VALUES (\''.$row['pid'].'\', \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\', \''.time().'\')');
  mysql_query('UPDATE `posts` SET `visits` = `visits` +1 WHERE `id` = \''.$row['pid'].'\' LIMIT 1');
}

?>
<script type="text/javascript">
var g_post = '<?=$row['pid'];?>';
function error_campo(causa) {
if(causa == ''){ dialogBox.alert('Error', 'Es necesario especificar la causa de la eliminaci&oacute;n!');  $('#causa').focus(); return false;} else {dialogBox.close(); posts.borrar_post();}
}
</script>

<a name="arriba"></a>
<div class="breadcrumb">
			<ul>
				<li class="first"><a href="/" accesskey="1" class="home"></a></li>
				<li><a href="/posts/">Posts</a></li>
				<li><a href="/posts/<?=$row['url'];?>/"><?=$row['name'];?></a></li>
				<li><a href="/posts/<?=$row['url'];?>/<?=$row['pid'];?>/<?=url($row['title']);?>.html"><?=$row['title'];?></a></li>
				<li class="last"></li>
			</ul>
		</div>
	<div class="clear"></div>


	<div id="ver-post-left">

<div id="shadow_p">
<div class="box_title_content">
	<div class="box_txt">Posteado por</div>
</div>
		<div class="box_cuerpo_content"><div class="avatarBox" ><a href="/<?=$row['nick'];?>" title="Ver Perfil"><img src="<?=$row['avatar'];?>" title="Avatar de <?=$row['nick'];?>"  onerror="error_avatar(this)" /></a></div><div align="center"><img src="<?=$config['images'];?>/images/avatarShadow.png" border="0" width="130" height="10" style="margin-bottom:3px;"></div>
<?php
if(!empty($row['message'])) {
  echo '<div class="messageBox" align="center">'.$row['message'].'</div>';
}
?>

<span class="nick-poster"><a href="/<?=$row['nick'];?>" title="Ver Perfil">@<?=$row['nick'];?></a></span>
<?php
$rank = mysql_fetch_row(mysql_query('SELECT `name`, `img` FROM `ranks` WHERE `id` = \''.$row['rank'].'\''));
?>
<hr class="divider"><b style="font-size:11px;color:#454545;text-shadow:0 1px 0 #FFFFFF;"><?=$rank[0];?></b><br /><span title="<?=$rank[0];?>"><img src="<?=$config['images'];?>/images/rangos/<?=$rank[1];?>" border="0" alt="<?=$rank[0];?>" align="absmiddle"></span>&nbsp;

<img src="<?=$config['images'];?>/images/<?=($row['sex'] == '0' ? 'Hombre' : 'Mujer');?>.gif" title="<?=($row['sex'] == '0' ? 'Hombre' : 'Mujer');?>" border="0" align="absmiddle" />
<?php
if(mysql_num_rows($q = mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `id` = \''.$row['country'].'\''))) {
  $l = mysql_fetch_row($q);
  $title = $l[0];
  $img = strtolower($l[1]).'.png';
} else {
  $title = 'Otro pa&iacute;s';
  $img = 'ot.gif';
}
?>&nbsp;
<span title="<?=$title;?>"><img alt="" title="<?=$title;?>" src="<?=$config['images'];?>/images/icons/banderas/<?=$img;?>" align="absmiddle" /></span>&nbsp;
<?php
if(mysql_num_rows($q = mysql_query('SELECT `name`, `img` FROM `status` WHERE `id` = \''.$row['statusu'].'\''))) {
  $pq = mysql_fetch_row($q);
} else {
  $pq = array('Sin estado', 'ninguno.gif');
}
?>
<img title="Estado: <?=$pq[0];?>" src="<?=$config['images'];?>/images/estado/<?=$pq[1];?>" alt="" align="absmiddle" />&nbsp;
<?php
if(mysql_num_rows(mysql_query('SELECT `id` FROM `online` WHERE `user` = \''.$row['uid'].'\''))) {
  echo '<img title="Conectado" src="'.$config['images'].'/images/user_online.gif" alt="Conectado" align="absmiddle" /> ';
} else {
  echo '<img title="Desconectado" src="'.$config['images'].'/images/user_offline.gif" alt="Desconectado" align="absmiddle" /> ';
}
if($key && $row['author'] != $logged['id']) {
  echo '<a title="Enviar MP a '.$row['nick'].'" onclick="mp.enviar_mensaje(\''.$row['nick'].'\'); return false"><img align="absmiddle" border="0" title="Enviar MP a '.$row['nick'].'" src="'.$config['images'].'/images/icons/mensaje_para.gif"></a>';
}
?>
<hr class="divider">
<div class="metadata-usuario">
    <span class="nData"><span><a style="color:#004a95;" href="/perfil/<?=$row['nick'];?>/amigos"><?=mysql_num_rows(mysql_query('SELECT `id` FROM `friends` WHERE (`author` = \''.$row['uid'].'\' || `user` = \''.$row['uid'].'\') && `status` = \'1\''));?></a></span></span><span class="txtData">Amigos</span>
	<span class="nData"><span id="cant_pts_post"><?=$row['puntos'];?></span></span>
<span class="txtData">Puntos</span>
	<span class="nData" style="color:#0196ff;"><?=mysql_num_rows(mysql_query('SELECT id FROM `posts` WHERE author = \''.$row['uid'].'\' && `status` = \'0\''));?></span>
	<span class="txtData">Posts</span>

	<span class="nData" style="color:#456c00;"><?=mysql_num_rows(mysql_query('SELECT `id` FROM `comments` WHERE `author` = \''.$row['uid'].'\''));?></span>
	<span class="txtData">Comentarios</span>

</div></div>
	</div>
</div><div id="ver-post-right">
	<h1 class="post-title">

		<span property="dc:title"><?=$row['title'];?></span>
	</h1>
	<div class="compartir-post" id="compartimela">
			<span class="floatL">Compartir post:</span>
			<div class="floatR" style="margin: 4px 4px 0pt;" id="tipsy_bottom">
				<a href="http://www.facebook.com/share.php?u=<?=$config['url'];?>/posts/<?=$row['url'];?>/<?=$row['pid'];?>/<?=url($row['title']);?>.html" rel="nofollow" target="_blank" title="Facebook">
					<img src="<?=$config['images'];?>/images/share/facebook_b.png" alt="Facebook" >
				</a>
				<a href="http://twitter.com/home?status=Les%20recomiendo%20este%20post:%20<?=$config['url'];?>/posts/<?=$row['url'];?>/<?=$row['pid'];?>/<?=url($row['title']);?>.html" rel="nofollow" target="_blank" title="Twitter" >

					<img src="<?=$config['images'];?>/images/share/twitter_b.png" alt="Twitter" >
				</a>
				<a href="http://digg.com/submit?phase=2&amp;url=<?=$config['url'];?>/posts/<?=$row['url'];?>/<?=$row['pid'];?>/<?=url($row['title']);?>.html" rel="nofollow" target="_blank" title="Digg">
					<img src="<?=$config['images'];?>/images/share/digg_b.png" alt="Digg" title="Digg">
				</a>
				<a href="http://reddit.com/submit?url=<?=$config['url'];?>/posts/<?=$row['url'];?>/<?=$row['pid'];?>/<?=url($row['title']);?>.html" rel="nofollow" target="_blank" title="Reddit">
					<img src="<?=$config['images'];?>/images/share/reddit_b.png" alt="Reddit" >
				</a>
				<a href="http://www.stumbleupon.com/submit?url=<?=$config['url'];?>/posts/<?=$row['url'];?>/<?=$row['pid'];?>/<?=url($row['title']);?>.html" rel="nofollow" target="_blank" title="StumbleUpon">

					<img src="<?=$config['images'];?>/images/share/stumbleupon_b.png" alt="StumbleUpon">
				</a>

				<a href="http://del.icio.us/post?url=<?=$config['url'];?>/posts/<?=$row['url'];?>/<?=$row['pid'];?>/<?=url($row['title']);?>.html" rel="nofollow" target="_blank" title="Delicious">
					<img src="<?=$config['images'];?>/images/share/delicious_b.png" alt="Delicious">
				</a>
		</div><div class="clearBoth"></div>
	</div>
	<div class="options_one">
		<span class="floatL">
			<a href="/prev-<?=$row['pid'];?>">Anterior</a>

		</span>
		<span class="floatR">
			<a href="/next-<?=$row['pid'];?>">Siguiente</a>
		</span>
		<div align="center" id="compartila">
			<a href="#" onclick="posts.compartir(); return false;">Compartir Post</a>
		</div>
		<div align="center" id="no_me_la_compartas" style="display:none;">

			<a href="#" onclick="posts.no_compartir(); return false;">Compartir Post</a>
		</div>
		<div class="clearBoth"></div>
	</div>
    <?php
    if($row['status'] != 0) { echo '<div class="redBox"><b>El post se encuentra eliminado</b></div>'; }
    ?>
	<div class="post-container">

    <span property="dc:content"><?=BBposts($row['body']);?></span>
	<br class="space">
    <?php
    if(!empty($row['firm'])) {
      echo '<div class="user_signature">
	            <b>'.BBposts($row['firm'], true, false).'</b>
	        </div>';
    }
    ?>

        <div class="clear"></div>
</div><div class="clear"></div>
<div class="ajax_return">
	<div id="success_ajax" class="displayN"></div>
</div>

                    <div class="stats_container">
                    <?php
                    if($logged['points2'] > 0 && $logged['id'] != $row['author'] && allow('add_points')) {
                    ?>
                    <div align="center">
                    <span id="add_points">Dar puntos: &nbsp;
                    <?php
                    for($i=1;$i<=10;$i++) {
                      if($i > $logged['points2']) { break; }
                      echo '<a href="#" onclick="posts.votar(\''.$i.'\'); return false;" title="Dar '.$i.' puntos">'.$i.'</a>'.($i < $logged['points2'] && $i < 10 ? ' - ' : '');
                    }
                    ?>
                    &nbsp; <b><span style="color:gray;font-size:11px;font-weight:normal;">(de <?=$logged['points2'];?> disponibles)</span></b><br class="space"><hr class="divider"></span>
                    </div>
                    <?php
                    }
                    if($logged['id'] && $logged['id'] != $row['author']) {
                    ?>
                    <input class="Boton Small BtnGray" onclick="posts.denunciar_post('<?=$row['pid'];?>'); return false;" value="Denunciar" title="Denunciar" type="button"> &nbsp;
					<input class="Boton Small BtnPurple" onclick="posts.add_bookmark(); return false;" value="A&ntilde;adir a favoritos" title="A&ntilde;adir a favoritos" id="button_add_fav" type="button">
                    <?php
                    }
                    ?>
                    <ul class="stats_list">
							<li>
								<span id="cant_favs_post"><?=mysql_num_rows(mysql_query('SELECT id FROM `favorites` WHERE `id_pf` = \''.$row['pid'].'\''));?></span><br>
								Favoritos
							</li>

							<li>
								<span><?=$row['visits'];?></span><br>

								Visitas
							</li>
							<li>
								<span id="cant_pts_post_dos"><?=$row['points'];?></span><br>
								Puntos
							</li>

							<li>
								<span id="cantcomments2"><?=$ncomments = mysql_num_rows(mysql_query('SELECT `id` FROM `comments` WHERE `id_post` = \''.$row['pid'].'\''));?></span><br>
								Comentarios
							</li>

						</ul>
						<div class="clearBoth"></div>
						<hr class="divider">
						<div class="stats-cat-date">

							<span class="floatL"><strong>Categor&iacute;a:</strong> <a href="/posts/<?=$row['url'];?>/"><?=$row['name'];?></a></span>
						<span class="floatR" style="text-align:right"><strong>Creado:</strong> <span property="dc:date"><?=date('d/m/Y', $row['time']);?> a las <?=date('G:i', $row['time']);?>.</span><br></span>
                        <?php
                        if($n = mysql_num_rows(mysql_query('SELECT `id` FROM `votes` WHERE `id_post` = \''.$row['id'].'\''))) {
                          echo '<br /><span id="tipsy_leftn" original-title="'.$row['points'].' puntos / '.$n.' votos"  class="floatR" style="text-align:right"><strong>'.$config['name_short'].' score:</strong> <span>'.ceil($row['points'] / $n).'/10</span><br></span>';
                        }
						?>
                        <div class="clearBoth"></div>
						</div>

						<div class="clearBoth"></div>

					</div>
					<br class="space">
					<div class="box_opciones-left">
						<div class="mas_posts">
							<div class="title_mas_posts">Ver m&aacute;s posts:</div>
								<ul>
                                <?php
                                $query = mysql_query('SELECT p.id, p.title, cat.url FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE (p.title LIKE \'%'.$row['title'].'%\' || p.`body` LIKE \'%'.$row['body'].'%\') && p.`status` = \'0\' && p.`id` != \''.$row['pid'].'\' ORDER BY p.id DESC LIMIT 10') or die(mysql_error());
                                if(mysql_num_rows($query)) {
                                  while($rows = mysql_fetch_row($query)) {
                                    echo '<li class="categoriaPost '.$rows[2].'" style="margin-bottom: 0px;"><a rel="dc:relation" href="/posts/'.$rows[2].'/'.$rows[0].'/'.url($rows[1]).'.html" target="_self" title="'.$rows[1].'">'.$rows[1].'</a></li>';
                                  }
                                } else { echo '<div class="redBox">No hay relacionados</div>';}
                                ?>
								</ul>
						</div>
					</div>
				<div class="box_opciones-right">
                <form name="borrar">
                <?php
                if(allow('delete_posts') && $logged['id'] != $row['author'] && $logged['id']) {
                ?>
                <input class="Boton BtnRed" style="font-size: 11px;" value="Editar" title="Editar post" onclick="location.href='/posts/editar/<?=$row['pid'];?>/'" type="button">
                <input class="Boton BtnGray" style="font-size: 11px;" value="Borrar" title="Eliminar post" onclick="return error_campo(this.form.causa.value);" type="button"> <input onfocus="foco(this);" onblur="no_foco(this);" type="text" id="causa" name="causa" maxlength="75" size="27">
                <?php
                } elseif($logged['id'] == $row['author'] && $logged['id']) {
                ?>
                <input class="Boton BtnRed" style="font-size: 11px;" value="Editar" title="Editar post" onclick="location.href='/posts/editar/<?=$row['pid'];?>/'" type="button">
                <input class="Boton BtnGray" style="font-size: 11px;" value="Borrar" title="Eliminar post" onclick="return posts.borrar_post();" type="button">
                <?php
                }
                ?>
                </form>
                <br class="space"><div align="center" id="ads_300x250"></div></div>

					<div class="clearBoth"></div>
					<br />
					<div align="center">
					<div class="ads_728x90"><center>
                    <!--<iframe src="/web/ads.php?system=smowtion&size=728x90" width="728px" height="90px" frameborder="0" scrolling="no" marginheight="0px" marginwidth="0px">.</iframe> -->
                    </center></div>
					</div><br />
					<div class="floatL">
					<div id="comentarios"></div>
						<div class="globo_cant_comments floatL">

							<span id="cantcomments"><?=$ncomments;?></span>
						</div>
						<div class="size18 floatL" style="font-weight:bold;height:36px;margin-top:14px;">Comentarios</div>
					</div>
					<div class="floatR">
						<span id="loading_ajax" class="displayN"><img src="<?=$config['images'];?>/images/icons/cargando.gif" align="absmiddle"></span>
					</div>
					<div class="clearBoth"></div>

					<hr class="divider">
                    <div id="comments-container" class="clearfix">
                    <?php
                    include('./ajax/comment-page.php');
                    ?>
                    </div>
	                <div class="clear"></div>
					<br class="space">
                    <?php
                    if($logged['id']) { echo '<div id="return_add_comment" style="display:none;margin-top:0px;"></div>'; }
                    ?>
                    <div class="clear"></div>
                    <?php
                    if($ncomments == 0 && $key) { echo '<div id="sin_comentarios" class="textInfo">Este post no tiene comentarios, coment&aacute; o va Justin Bieber a tu casa.</div>'; }
                    if($row['closed'] != '0') { echo '<div class="textInfo" id="post_cerrado">Este post est&aacute; cerrado y no se permiten m&aacute;s comentarios. '.($logged['id'] == $row['author'] && $key ? 'Tu puedes comentar por ser el due&ntildeo del post' : '').'</div>'; }
                    if(!$logged['id']) { echo '<div id="post_cerrado" style="display:block;"><div class="Globo GlbYellow">Para poder comentar necesitas estar <a title="Registrarse" onclick="accounts.registro_load_form(); href="">registrado.</a> Si ya eres miembro entonces <a title="Loguearse" href="#" onclick="open_login_box(); return false;">logueate.</a></div></div> '; }

                    ?>



<div class="clearBoth"></div>
</form>
<?php
if(($row['closed'] == '0' || $logged['id'] == $row['author']) && $logged['id'] && !mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `user` = \''.$logged['id'].'\' && `author` = \''.$row['uid'].'\''))) {
?>
<a name="comentar"></a>
<div class="agregar_comment">
			<div class="box_cuerpo_content" style="border-top:1px solid #CCC;">
				<div class="comment-content">
				<form name="comentero"><textarea  id="VPeditor" name="cuerpo_comment" tabindex="1" style="width:763px;height:100px;"></textarea><br class="space">

                <div id="emoticons" style="float:left"><a href="#" smile=":bueno:"><img border="0" src="<?=$config['images'];?>/images/emoticons/bueno.png" alt="Bueno" title="Bueno" height="24" width="24" /></a><a href="#" smile=":malo:"><img border="0" src="<?=$config['images'];?>/images/emoticons/malo.png" alt="Malo" title="Malo" height="24" width="24" /></a><a href="#" smile=":muerto:"><img border="0" src="<?=$config['images'];?>/images/emoticons/muerto.png" alt="Muerto" title="Muerto" height="24" width="24" /></a><a href="#" smile=":divertido:"><img border="0" src="<?=$config['images'];?>/images/emoticons/divertido.png" alt="Divertido" title="Divertido" height="24" width="24" /></a><a href="#" smile=":sinister:"><img border="0" src="<?=$config['images'];?>/images/emoticons/sinister.png" alt="Siniestro" title="Siniestro" height="24" width="24" /></a><a href="#" smile=":D"><img border="0" src="<?=$config['images'];?>/images/emoticons/sonrisa.png" alt="Sonrisa" title="Sonrisa" height="24" width="24" /></a><a href="#" smile=":arrogante:"><img border="0" src="<?=$config['images'];?>/images/emoticons/arrogante.png" alt="Arrogante" title="Arrogante" height="24" width="24" /></a><a href="#" smile=":@"><img border="0" src="<?=$config['images'];?>/images/emoticons/enojado.png" alt="Enojado" title="Enojado" height="24" width="24" /></a><a href="#" smile=":relax:"><img border="0" src="<?=$config['images'];?>/images/emoticons/relax.png" alt="Relajado" title="Relajado" height="24" width="24" /></a><a href="#" smile=":ironico:"><img border="0" src="<?=$config['images'];?>/images/emoticons/ironico.png" alt="Ironico" title="Ironico" height="24" width="24" /></a><a href="#" smile=":confused:"><img border="0" src="<?=$config['images'];?>/images/emoticons/confused.png" alt="Confundido" title="Confundido" height="24" width="24" /></a><a href="#" smile=":shamed:"><img border="0" src="<?=$config['images'];?>/images/emoticons/shamed.png" alt="Vergonzoso" title="Vergonzoso" height="24" width="24" /></a><a href="#" smile=":disdain:"><img border="0" src="<?=$config['images'];?>/images/emoticons/disdain.png" alt="Disdain" title="Disdain" height="24" width="24" /></a><a href="#" smile=":("><img border="0" src="<?=$config['images'];?>/images/emoticons/triste.png" alt="Triste" title="Triste" height="24" width="24" /></a><a href="#" smile=":sarcastico:"><img border="0" src="<?=$config['images'];?>/images/emoticons/sarcastico.png" alt="Sarcastico" title="Sarcastico" height="24" width="24" /></a><a href="#" smile=":-)"><img border="0" src="<?=$config['images'];?>/images/emoticons/feliz.png" alt="Feliz" title="Feliz" height="24" width="24" /></a><a href="#" smile=":lost:"><img border="0" src="<?=$config['images'];?>/images/emoticons/lost.png" alt="Perdido" title="Perdido" height="24" width="24" /></a><a href="#" smile=":shock:"><img border="0" src="<?=$config['images'];?>/images/emoticons/shock.png" alt="Shock" title="Shock" height="24" width="24" /></a><a href="#" smile=":llorar:"><img border="0" src="<?=$config['images'];?>/images/emoticons/llorar.png" alt="Llorando" title="Llorando" height="24" width="24" /></a><a href="#" smile=":pirata:"><img border="0" src="<?=$config['images'];?>/images/emoticons/pirata.png" alt="Pirata" title="Pirata" height="24" width="24" /></a><a href="#" smile=":devil:"><img border="0" src="<?=$config['images'];?>/images/emoticons/devil.png" alt="Diablo" title="Diablo" height="24" width="24" /></a><a href="#" smile=":loser:"><img border="0" src="<?=$config['images'];?>/images/emoticons/loser.png" alt="Perdedor" title="Perdedor" height="24" width="24" /></a><a href="#" smile=":ask:"><img border="0" src="<?=$config['images'];?>/images/emoticons/ask.png" alt="Pregunta" title="Pregunta" height="24" width="24" /></a></div>

			<div class="floatR">
				<input id="button_add_comment" class="Boton BtnBlue" type="button" value="Enviar comentario" onclick="posts.add_comment('30'); return false;" tabindex="2" />
			</div>
				<label id="error" class="size11" style="color: red;"></label>
				</form>
				<div class="clearBoth"></div>
			</div>
			</div>
		</div>
        <?php
        }
        ?>

        <div class="clearBoth"></div></div><div style="clear:both"></div></div>

	</div>