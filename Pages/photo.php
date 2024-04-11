<?php
if(!$_GET['id']) { fatal_error('Faltan datos'); }
if(!mysql_num_rows($p = mysql_query('SELECT p.*, cat.name, cat.url AS urlcat FROM `photos` AS p INNER JOIN `p_categories` AS cat ON cat.id = p.cat WHERE p.`id` = \''.intval($_GET['id']).'\''))) { fatal_error('La foto no existe'); }
$row = mysql_fetch_assoc($p);
if($row['status'] != 0 && !allow('delete_posts')) { fatal_error('La foto se encuentra eliminada'); }
if($row['private'] == 1 && !$logged['id']) { fatal_error('Para ver esta foto necesitas loguearte'); }
$author = mysql_fetch_assoc(mysql_query('SELECT u.*, r.name, r.img FROM `users` AS u INNER JOIN `ranks` AS r ON r.id = u.rank WHERE u.`id` = \''.$row['author'].'\''));
if($row['private'] == 2 && $row['author'] != $logged['id'] && !mysql_num_rows(mysql_query('SELECT `id` FROM `friends` WHERE ((`author` = \''.$logged['id'].'\' && `user` = \''.$row['author'].'\') || (`author` = \''.$row['author'].'\' && `user` = \''.$logged['id'].'\')) && `status` = \'1\''))) { fatal_error('Esta foto solo la pueden ver los amigos de '.$author['nick']); }
$_SERVER['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDED_FOR'];
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `post_visits` WHERE `post` = \''.$row['id'].'\' && `ip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\' && `type` = \'2\''))) {
  mysql_query('INSERT INTO `post_visits` (`post`, `ip`, `time`, `type`) VALUES (\''.$row['id'].'\', \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\', \''.time().'\', \'2\')');
}
?>
<script type="text/javascript">
function error_campo(causa){
if(causa == ''){
document.getElementById('errors').innerHTML='<font class="size10" style="color: red;">Es necesario especificar la causa de la eliminaci&oacute;n</font>'; return false;}}
var g_foto = '<?=$row['id'];?>';
</script>
<a name="arriba"></a>
<div class="breadcrumb">
			<ul>
				<li class="first"><a href="/" accesskey="1" class="home"></a></li>
				<li><a href="/fotos/">Fotos</a></li>
				<li><a href="/fotos/<?=$row['urlcat'];?>/"><?=$row['name'];?></a></li>

				<li><a href="/fotos/<?=$row['urlcat'];?>/<?=$row['id'];?>/<?=url($row['title']);?>.html"><?=$row['title'];?></a></li>
				<li class="last"></li>
			</ul>
		</div>
	<div class="clear"></div>
<div id="view-photo-left">
	<div class="add_you_photo">
		<b class="size13">Agrega tu foto</b>

		<br />
		En <?=$config['name'];?> vos tambi&eacute;n pod&eacute;s agregar tu foto!
		<br /><br />
		<div align="center">
		<input class="Boton BtnGreen" onclick="<?=($logged['id'] ? 'location.href=\'/fotos/agregar/\'' : 'solo_usuarios();return false;');?>" value="Agregar foto" title="Agregar foto" type="button" />
		</div></div>
		<br class="space"><div align="center" id="ads_160x600"></div>
	</div>
	<div id="view-photo-center">

    <?php
    if($row['status'] != 0) { echo '<div class="redBox">La foto se encuentra eliminada</div>'; }
    ?>
		<div class="box_photos_top">
			<div class="floatL" style="margin-right:2px;">
				<img src="<?=$author['avatar'];?>" width="70" height="70" alt="Avatar" border="0" onerror="error_avatar(this)" />
			</div>
			<div class="floatL" style="margin-left:2px;width:200px;">
				<li><a href="/<?=$author['nick'];?>" class="size14" style="font-weight:bold;margin-left:2px;"><?=$author['nick'];?></a></li>

				<li><span title="<?=$author['name'];?>"><img src="<?=$config['images'];?>/images/rangos/<?=$author['img'];?>" border="0" alt="<?=$author['name'];?>" align="absmiddle"></span> <?=$author['name'];?></li>
                <?php
                if(mysql_num_rows($make = mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `id` = \''.$author['country'].'\''))) {
                  $pq = mysql_fetch_row($make);
                  $pq[1] = $pq[1].'.png';
                } else { $pq = array('Otro pa&iacute;s', 'ot.gif'); }
                ?>
                <li><span title="<?=$pq[0];?>"><img alt="" title="<?=$pq[0];?>" src="<?=$config['images'];?>/images/icons/banderas/<?=$pq[1];?>" align="absmiddle" /> <?=$pq[0];?></span></li>
                <li><img src="<?=$config['images'];?>/images/<?=($author['sex'] == 0 ? 'Hombre' : 'Mujer');?>.gif" title="<?=($author['sex'] == 0 ? 'Hombre' : 'Mujer');?>" border="0" align="absmiddle" /> &nbsp;<?=($author['sex'] == 0 ? 'Hombre' : 'Mujer');?></li>
                <?php
                if($logged['id'] && $logged['id'] != $row['author']) {
                  echo '<li><img src="'.$config['images'].'/images/mensaje_para.gif" border="0" align="absmiddle"> <a href="javascript:mp.enviar_mensaje(\''.$author['nick'].'\');">Enviar mensaje</a></li>';
                }
                ?>
			</div>
			<div class="floatR" style="margin:4px 4px 0 0">
				<center></center>
			</div>
			<div class="clear"></div>
		</div>
        <div class="options_one">

        <?php
        if(mysql_num_rows(mysql_query('SELECT `id` FROM `photos` WHERE `id` < \''.$row['id'].'\''))) { echo '<span class="floatL"><a href="/fotos/prev/'.$row['id'].'">Anterior</a></span>'; }
        //echo '<center><span><a href="/fotos/prev/'.$row['id'].'">Anterior</a></span></center> ';
        if(mysql_num_rows(mysql_query('SELECT `id` FROM `photos` WHERE `id` > \''.$row['id'].'\''))) { echo '<span class="floatR"><a href="/fotos/next/'.$row['id'].'">Siguiente</a></span>'; }
        ?>
        <br />
        </div>
		<div class="box_photos_center">
			<div class="size16" style="font-weight:bold;" align="center"><?=$row['title'];?></div><br class="space">

				<div align="center">
					<img onload="if(this.width > 550) {this.width = 550}" alt="<?=$row['url'];?>" title="<?=$row['url'];?>"  src="<?=$row['url'];?>" />
					<br /><a href="<?=$row['url'];?>" rel="nofollow" target="_blank"><b>[Tama&ntilde;o original]</b></a>
				</div>

			<hr class="divider"><b>Descripci&oacute;n:</b> <?=(!empty($row['body']) ? $row['body'] : '-');?>
			<br /><b>Creado:</b> <?=timefrom($row['time']);?>
			<br /><b>Categor&iacute;a:</b> <a href="/fotos/<?=$row['urlcat'];?>/" title="<?=$row['name'];?>"><?=$row['name'];?></a>
		</div>
		<div id="return_ajax" style="display:none;"></div>
		<div class="box_photos_bottom">
            <?php
            if($row['author'] != $logged['id'] && $logged) {
              if($logged['points2'] > 0) {
            ?>
            <div align="center"><span id="add_points">Dar puntos: &nbsp;
            <?php
            for($i=1;$i<=10;$i++) {
              if($i > $logged['points2']) { break; }
              echo '<a title="Dar '.$i.' puntos" onclick="fotos.votar(\''.$i.'\'); return false;" href="#">'.$i.'</a>'.($i < 10 ? ' - ' : '');
            }
            ?>
            &nbsp;<b><span style="color:gray;font-size:11px;font-weight:normal;">(de <?=$logged['points2'];?> disponibles)</span></b><br class="space"><hr class="divider"></span>
            </div>
            <?php
            }
            ?>
            <input class="Boton Small BtnGray" onclick="fotos.denunciar_foto('<?=$row['id'];?>'); return false;" value="Denunciar" title="Denunciar" type="button">
			<input class="Boton Small BtnPurple" onclick="fotos.add_bookmark(); return false;" value="A&ntilde;adir a favoritos" title="A&ntilde;adir a favoritos" id="button_add_fav" type="button">
            <?php
            }
            ?>
            <ul class="stats_list">
            <li>
				<span id="cant_favs"><?=mysql_num_rows(mysql_query('SELECT `id` FROM `favorites` WHERE `id_pf` = \''.$row['id'].'\' && `status` = \'0\' && `type` = \'1\''));?></span><br>
				Favoritos
			</li>
			<li>
				<span><?=mysql_num_rows(mysql_query('SELECT `id` FROM `post_visits` WHERE `post` = \''.$row['id'].'\' && `type` = \'2\''));?></span><br>

				Visitas
			</li>
			<li>
				<span id="cant_pts"><?=$row['votes'];?></span><br>
				Puntos
			</li>
			<li>
				<span id="cant_cmt2"><?=$n = mysql_num_rows(mysql_query('SELECT `id` FROM `p_comments` WHERE `photo` = \''.$row['id'].'\''));?></span><br>
				Comentarios
			</li>
		</ul>
		<div class="clearBoth"></div>
        <hr class="divider">
        <?php
        if(allow('delete_photos') || $logged['id'] == $row['author']) {
        ?>
		<span class="floatL">
            <br class="space"><br>
            <form action="/fotos/eliminar/" method="post" accept-charset="UTF-8"  name="eliminar" id="eliminar"><input class="Boton Smal BtnGray" style="font-size: 11px;" value="Editar" title="Editar foto" onclick="location.href='/fotos/editar/<?=$row['id'];?>';" type="button"> <input class="Boton Smal BtnRed" style="font-size: 11px;" value="Eliminar" title="Eliminar foto" onclick="if (!confirm('\xbfEstas seguro que desea eliminar esta foto?')) return false; return error_campo(this.form.causa.value);" type="submit">
            <?php
            if($logged['id'] != $row['author']) { echo '<input type="text" id="causa" name="causa" maxlength="50" size="20"><center><label id="errors"></label></center>'; }
            ?>
            <input type="hidden" value="<?=$row['id'];?>" name="id">
            </form>
        </span>
        <?php
        }
        ?>
			<span class="floatR" id="tipsy_top">
            <?php
            $url = $config['url'].'/fotos/'.$row['urlcat'].'/'.$row['id'].'/'.url($row['title']).'.html';
            ?>
            <a href="http://www.facebook.com/share.php?u=<?=$url;?>" rel="nofollow" target="_blank" title="Facebook" class="SocialIcons facebook"></a>
            <a href="http://twitter.com/home?status=Les%20recomiendo%20esta%20im&aacute;gen:%20<?=$url;?>" rel="nofollow" target="_blank" title="Twitter" class="SocialIcons twitter"></a>
            <a href="http://www.stumbleupon.com/submit?url=<?=$url;?>" rel="nofollow" target="_blank" title="StumbleUpon" class="SocialIcons stumbleupon"></a>
            <a href="http://del.icio.us/post?url=<?=$url;?>" rel="nofollow" target="_blank" title="Delicious" class="SocialIcons delicious"></a><a href="http://digg.com/submit?phase=2&url=<?=$url;?>" rel="nofollow" target="_blank" title="Digg" class="SocialIcons digg"></a>
            <a href="http://reddit.com/submit?url=<?=$url;?>" rel="nofollow" target="_blank" title="Reddit" class="SocialIcons reddit"></a>

			</span>
		<div class="clearBoth"></div>
	</div><a name="comentarios"></a><br class="space">
		<b class="size15">Comentarios (<span id="cant_cmt"><?=$n;?></span>)</b>
		<hr class="divider">
<div class="clear"></div>
<?php
if(!$n) { echo '<div id="sin_comentarios" class="textInfo"> Esta foto no tiene comentarios</div>'; } else {
  $query = mysql_query('SELECT u.id as uid, u.nick, u.avatar, c.* FROM `users` AS u INNER JOIN `p_comments` AS c ON c.author = u.id WHERE `c`.`photo` = \''.$row['id'].'\' ORDER BY c.id ASC') or die(mysql_error());
?>
<script type="text/javascript">
$(document).ready(function(){
	$('.numbersvotes .overview').bind('click', function(){ $(this).hide(); $(this).next().show(); });
	$('.numbersvotes .stats').bind('click', function(){ $(this).hide(); $(this).prev().show(); });
});
</script>
<?php
while($co = mysql_fetch_assoc($query)) {
  $style = '';
  if($co['author'] == $logged['id']) { $style = '-me'; }
  if($co['author'] == $row['author']) { $style = '-autor'; }
?>
<div id="cmt_<?=$co['id'];?>">
    <span id="comment_<?=$co['id'];?>" user_cmt="<?=$co['nick'];?>" text_cmt='<?=$co['body'];?>'></span>
	<div class="comment-container<?=$style;?>">
	    <div class="comment-title">
		    <div class="floatL">
			    <a href="/<?=$co['nick'];?>"><?=$co['nick'];?></a> - <span dc-property="date"><?=date('d.m.Y', $co['time']);?> a las <?=date('G:i', $co['time']);?> hs.</span> dijo:
			</div>
			<div class="floatR answerOptions">
			    <ul>
                <?php
                $co['votes'] = $co['positive']-$co['negative'];
                ?>
				    <li class="numbersvotes"<?=($co['votes'] == 0 ? ' style="display:none;"' : '');?>>

					    <div class="overview">
						    <span class="<?=($co['votes'] > 0 ? 'positivo' : 'negativo');?>"><?=($co['votes'] > 0 ? '+' : '').($co['votes']);?></span>
						</div>
						<div class="stats">
						    <span class="positivo">+<?=$co['positive'];?></span> / <span class="negativo">-<?=$co['negative'];?></span>
						</div>
					</li>
                    <?php
                    if($logged['id']) {
                    if($logged['id'] != $co['uid']) {
                    ?>
                    <li class="icon-thumb-up"><a onclick="comment.vote(this, <?=$co['id'];?>, <?=$row['id'];?>, <?=$logged['id'];?>, 1, 'foto')"><span class="voto-p-comentario"></span></a></li>
					<li class="icon-thumb-down"><a onclick="comment.vote(this, <?=$co['id'];?>, <?=$row['id'];?>, <?=$logged['id'];?>, -1, 'foto')"><span class="voto-n-comentario"></span></a></li>
                    <?php
                    }
                    ?>
                    <li class="answerPerfil"><a href="/<?=$co['nick'];?>"  title="Ver perfil de <?=$co['nick'];?>" target="_self"><span class="ver-perfil"></span></a></li>
					<li class="answerCitar"><a onclick="citar_comment(<?=$co['id'];?>); return false" href="#" title="Citar Comentario"><span class="citar-comentario"></span></a></li>
                    <?php
                    if($logged['id'] == $co['author'] || $logged['id'] == $row['author'] || allow('delete_comments')) { echo '<li class="answerBorrar"><a onclick="if (!confirm(\'\xbfEstas seguro que deseas eliminar este comentario?\')) return false; fotos.del_comment(\''.$co['id'].'\',\''.$logged['id'].'\'); return false" href="#" title="Eliminar comentario"><span class="borrar-comentario"></span></a></li>'; }
                    }
                    ?>
				</ul>
			</div>
		    <div class="clear"></div>
		</div>
		<div class="comment-cuerpo">
		    <?=BBposts($co['body'], false, true, false, true, true);?>
			<div class="clear"></div>
		</div>
	</div>
</div>
<br class="space">
<?php
}
}
if($logged['id'] && $row['closed'] == 0 && !mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `author` = \''.$row['author'].'\' && `user` = \''.$logged['id'].'\''))) {
?>
<div id="return_add_comment" style="display:none;margin-top:0px;"></div><a name="comentar"></a>
<div class="agregar_comment">
    <div class="box_cuerpo_content" style="border-top:1px solid #CCC;">
    	<div class="comment-content">
    	    <form name="comentero"><textarea  id="VPeditor" name="cuerpo_comment" tabindex="1" style="width:585px;height:100px;"></textarea><br class="space">		<div id="emoticons" style="float:left"><a href="#" smile=":bueno:"><img border="0" src="<?=$config['images'];?>/images/emoticons/bueno.png" alt="Bueno" title="Bueno" height="24" width="24" /></a><a href="#" smile=":malo:"><img border="0" src="<?=$config['images'];?>/images/emoticons/malo.png" alt="Malo" title="Malo" height="24" width="24" /></a><a href="#" smile=":muerto:"><img border="0" src="<?=$config['images'];?>/images/emoticons/muerto.png" alt="Muerto" title="Muerto" height="24" width="24" /></a><a href="#" smile=":divertido:"><img border="0" src="<?=$config['images'];?>/images/emoticons/divertido.png" alt="Divertido" title="Divertido" height="24" width="24" /></a><a href="#" smile=":sinister:"><img border="0" src="<?=$config['images'];?>/images/emoticons/sinister.png" alt="Siniestro" title="Siniestro" height="24" width="24" /></a><a href="#" smile=":D"><img border="0" src="<?=$config['images'];?>/images/emoticons/sonrisa.png" alt="Sonrisa" title="Sonrisa" height="24" width="24" /></a><a href="#" smile=":arrogante:"><img border="0" src="<?=$config['images'];?>/images/emoticons/arrogante.png" alt="Arrogante" title="Arrogante" height="24" width="24" /></a><a href="#" smile=":@"><img border="0" src="<?=$config['images'];?>/images/emoticons/enojado.png" alt="Enojado" title="Enojado" height="24" width="24" /></a><a href="#" smile=":relax:"><img border="0" src="<?=$config['images'];?>/images/emoticons/relax.png" alt="Relajado" title="Relajado" height="24" width="24" /></a><a href="#" smile=":ironico:"><img border="0" src="<?=$config['images'];?>/images/emoticons/ironico.png" alt="Ironico" title="Ironico" height="24" width="24" /></a><a href="#" smile=":confused:"><img border="0" src="<?=$config['images'];?>/images/emoticons/confused.png" alt="Confundido" title="Confundido" height="24" width="24" /></a><a href="#" smile=":shamed:"><img border="0" src="<?=$config['images'];?>/images/emoticons/shamed.png" alt="Vergonzoso" title="Vergonzoso" height="24" width="24" /></a><a href="#" smile=":disdain:"><img border="0" src="<?=$config['images'];?>/images/emoticons/disdain.png" alt="Disdain" title="Disdain" height="24" width="24" /></a><a href="#" smile=":("><img border="0" src="<?=$config['images'];?>/images/emoticons/triste.png" alt="Triste" title="Triste" height="24" width="24" /></a><a href="#" smile=":sarcastico:"><img border="0" src="<?=$config['images'];?>/images/emoticons/sarcastico.png" alt="Sarcastico" title="Sarcastico" height="24" width="24" /></a><a href="#" smile=":-)"><img border="0" src="<?=$config['images'];?>/images/emoticons/feliz.png" alt="Feliz" title="Feliz" height="24" width="24" /></a><a href="#" smile=":lost:"><img border="0" src="<?=$config['images'];?>/images/emoticons/lost.png" alt="Perdido" title="Perdido" height="24" width="24" /></a><a href="#" smile=":shock:"><img border="0" src="<?=$config['images'];?>/images/emoticons/shock.png" alt="Shock" title="Shock" height="24" width="24" /></a><a href="#" smile=":llorar:"><img border="0" src="<?=$config['images'];?>/images/emoticons/llorar.png" alt="Llorando" title="Llorando" height="24" width="24" /></a><a href="#" smile=":pirata:"><img border="0" src="<?=$config['images'];?>/images/emoticons/pirata.png" alt="Pirata" title="Pirata" height="24" width="24" /></a><a href="#" smile=":devil:"><img border="0" src="<?=$config['images'];?>/images/emoticons/devil.png" alt="Diablo" title="Diablo" height="24" width="24" /></a><a href="#" smile=":loser:"><img border="0" src="<?=$config['images'];?>/images/emoticons/loser.png" alt="Perdedor" title="Perdedor" height="24" width="24" /></a><a href="#" smile=":ask:"><img border="0" src="<?=$config['images'];?>/images/emoticons/ask.png" alt="Pregunta" title="Pregunta" height="24" width="24" /></a></div>
    			<div class="floatR">
    				<input id="button_add_comment" class="Boton BtnBlue" type="button" value="Enviar comentario" onclick="fotos.add_comment('<?=$row['cat'];?>'); return false;" tabindex="2" />
    			</div>
    			<label id="error" class="size11" style="color: red;"></label>
    		</form>
    		<div class="clearBoth"></div>

    	</div>
	</div>
</div>
<?php
} elseif(!$logged['id']) { echo '<div class="Globo GlbYellow">Para poder comentar necesistas estar <a href="/registro/">registrado</a>. Si ya eres miembro entonces <a href="/ingresar/">logueate!</a></div>'; }
?>
</div>
	<div id="view-photo-right">
		<div class="boxtitleProfile clearfix">
			<h3>Amigos de <?=$author['nick'];?></h3>
		</div>
        <div align="center">
        <?php
        $query = mysql_query('SELECT u.nick, u.avatar FROM `users` AS u INNER JOIN `friends` AS f ON IF(f.author = \''.$author['id'].'\', f.user, f.author) = u.id WHERE (`f`.`author` = \''.$author['id'].'\' || `f`.`user` = \''.$author['id'].'\') && `f`.`status` = \'1\' ORDER BY f.id DESC LIMIT 10') or die(mysql_error());
        if(mysql_num_rows($query)) {
          while($sex = mysql_fetch_assoc($query)) {
            echo '<div class="avatarBox">
			      <a href="/'.$sex['nick'].'">
					<img src="'.$sex['avatar'].'" alt="Avatar" onerror="error_avatar(this)" border="0" width="80px">
				  </a>
			        </div>
			        <img src="'.$config['images'].'/images/avatarShadow.png" border="0" width="130" height="10" style="margin-bottom:3px;"><br class="space">
			        <span class="nick-poster">
				    <a href="/'.$sex['nick'].'">'.$sex['nick'].'</a>
			        </span>
			        <br class="space">';
          }
        } else { echo '<div class="yellowBox">'.$author['nick'].' no tiene amigos.</div>'; }
        ?>
        </div>
    </div>
<div style="clear:both"></div></div></div>