<?php
if(!defined('ok')) { die; }
//$rs = mysql_fetch_row($query);
?>
<div class="user_info">
    <h2>Perfil de @<?=$row['nick'];?>
  	<span class="floatR"><img src="<?=$config['images'];?>/images/email.png" title="Enviar mensaje" align="absmiddle"> <a style="font-size:13px" href="#" onclick="mp.enviar_mensaje('<?=$row['nick'];?>'); return false" title="Enviar mensaje">Enviar mensaje</a>	</span>
  	<div class="clear"></div></h2>
</div>
<br class="space">
<?php
if($logged['id'] == $row['id'] && $logged['id']) {
?>
<form name="comentador">
    <textarea onfocus="if(this.value=='Actualiza tu estado') this.value=''; foco(this);" onblur="if(this.value=='') this.value='Actualiza tu estado'; no_foco(this);" title="Actualiza tu estado" class="status_box" name="comment_muro" id="comment_muro">Actualiza tu estado</textarea>
	<div class="corner-left floatL" style="margin-top:-56px;"></div>
	<br>
	<div class="floatL" style="margin-left:10px">
    <div style="float:left" id="emoticons"><a smile=":bueno:" href="#"><img width="24" height="24" border="0" title="Bueno" alt="Bueno" src="<?=$config['images'];?>/images/emoticons/bueno.png" onclick="insertText(' :bueno:', document.forms.comentador.comment_muro);"></a><a smile=":malo:" href="#"><img width="24" height="24" border="0" title="Malo" alt="Malo" src="<?=$config['images'];?>/images/emoticons/malo.png" onclick="insertText(' :malo:', document.forms.comentador.comment_muro);"></a><a smile=":muerto:" href="#"><img width="24" height="24" border="0" title="Muerto" alt="Muerto" src="<?=$config['images'];?>/images/emoticons/muerto.png" onclick="insertText(' :muerto:', document.forms.comentador.comment_muro);"></a><a smile=":divertido:" href="#"><img width="24" height="24" border="0" title="Divertido" alt="Divertido" src="<?=$config['images'];?>/images/emoticons/divertido.png" onclick="insertText(' :divertido:', document.forms.comentador.comment_muro);"></a><a smile=":sinister:" href="#"><img width="24" height="24" border="0" title="Siniestro" alt="Siniestro" src="<?=$config['images'];?>/images/emoticons/sinister.png" onclick="insertText(' :sinister:', document.forms.comentador.comment_muro);"></a><a smile=":D" href="#"><img width="24" height="24" border="0" title="Sonrisa" alt="Sonrisa" src="<?=$config['images'];?>/images/emoticons/sonrisa.png" onclick="insertText(' :D', document.forms.comentador.comment_muro);"></a><a smile=":arrogante:" href="#"><img width="24" height="24" border="0" title="Arrogante" alt="Arrogante" src="<?=$config['images'];?>/images/emoticons/arrogante.png" onclick="insertText(' :arrogante:', document.forms.comentador.comment_muro);"></a><a smile=":@" href="#"><img width="24" height="24" border="0" title="Enojado" alt="Enojado" src="<?=$config['images'];?>/images/emoticons/enojado.png" onclick="insertText(' :@', document.forms.comentador.comment_muro);"></a><a smile=":relax:" href="#"><img width="24" height="24" border="0" title="Relajado" alt="Relajado" src="<?=$config['images'];?>/images/emoticons/relax.png" onclick="insertText(' :relax:', document.forms.comentador.comment_muro);"></a><a smile=":ironico:" href="#"><img width="24" height="24" border="0" title="Ironico" alt="Ironico" src="<?=$config['images'];?>/images/emoticons/ironico.png" onclick="insertText(' :ironico:', document.forms.comentador.comment_muro);"></a><a smile=":confused:" href="#"><img width="24" height="24" border="0" title="Confundido" alt="Confundido" src="<?=$config['images'];?>/images/emoticons/confused.png" onclick="insertText(' :confused:', document.forms.comentador.comment_muro);"></a><a smile=":shamed:" href="#"><img width="24" height="24" border="0" title="Vergonzoso" alt="Vergonzoso" src="<?=$config['images'];?>/images/emoticons/shamed.png" onclick="insertText(' :shamed:', document.forms.comentador.comment_muro);"></a><a smile=":disdain:" href="#"><img width="24" height="24" border="0" title="Disdain" alt="Disdain" src="<?=$config['images'];?>/images/emoticons/disdain.png" onclick="insertText(' :disdain:', document.forms.comentador.comment_muro);"></a><a smile=":(" href="#"><img width="24" height="24" border="0" title="Triste" alt="Triste" src="<?=$config['images'];?>/images/emoticons/triste.png" onclick="insertText(' :(', document.forms.comentador.comment_muro);"></a><a smile=":sarcastico:" href="#"><img width="24" height="24" border="0" title="Sarcastico" alt="Sarcastico" src="<?=$config['images'];?>/images/emoticons/sarcastico.png" onclick="insertText(' :sarcastico:', document.forms.comentador.comment_muro);"></a><a smile=":-)" href="#"><img width="24" height="24" border="0" title="Feliz" alt="Feliz" src="<?=$config['images'];?>/images/emoticons/feliz.png" onclick="insertText(' :-)', document.forms.comentador.comment_muro);"></a><a smile=":lost:" href="#"><img width="24" height="24" border="0" title="Perdido" alt="Perdido" src="<?=$config['images'];?>/images/emoticons/lost.png" onclick="insertText(' :lost:', document.forms.comentador.comment_muro);"></a><a smile=":shock:" href="#"><img width="24" height="24" border="0" title="Shock" alt="Shock" src="<?=$config['images'];?>/images/emoticons/shock.png" onclick="insertText(' :shock:', document.forms.comentador.comment_muro);"></a><a smile=":llorar:" href="#"><img width="24" height="24" border="0" title="Llorando" alt="Llorando" src="<?=$config['images'];?>/images/emoticons/llorar.png" onclick="insertText(' :llorar:', document.forms.comentador.comment_muro);"></a><a smile=":pirata:" href="#"><img width="24" height="24" border="0" title="Pirata" alt="Pirata" src="<?=$config['images'];?>/images/emoticons/pirata.png" onclick="insertText(' :pirata:', document.forms.comentador.comment_muro);"></a><a smile=":devil:" href="#"><img width="24" height="24" border="0" title="Diablo" alt="Diablo" src="<?=$config['images'];?>/images/emoticons/devil.png" onclick="insertText(' :devil:', document.forms.comentador.comment_muro);"></a><a smile=":loser:" href="#"><img width="24" height="24" border="0" title="Perdedor" alt="Perdedor" src="<?=$config['images'];?>/images/emoticons/loser.png" onclick="insertText(' :loser:', document.forms.comentador.comment_muro);"></a><a smile=":ask:" href="#"><img width="24" height="24" border="0" title="Pregunta" alt="Pregunta" src="<?=$config['images'];?>/images/emoticons/ask.png" onclick="insertText(' :ask:', document.forms.comentador.comment_muro);"></a></div>
    </div>
	<input class="floatR Boton BtnGray" onclick="muros.add_comment('<?=$row['id'];?>'); return false;" id="button_add_comment_muro" value="Publicar" title="Publicar" type="button">
	<div class="clear"></div>
</form>
<?php
if(mysql_num_rows($p = mysql_query('SELECT `body` FROM `walls` WHERE `author` = \''.$row['id'].'\' && `profile` = \''.$row['id'].'\' ORDER BY id DESC'))) {
  $ra = mysql_fetch_row($p);
  echo '<br><span class="size12 floatL" style="max-width:570px;margin-top:6px;"><b>&Uacute;ltima actualizaci&oacute;n: </b><span id="last_update">'.cut($ra[0], 60, '...').'</span></span>';
}
} elseif($logged['id'] != $row['id'] && $logged['id']) {
?>
<div style="border-top:1px solid #C9CACB;" class="box_cuerpo_content">
  <form name="comentador">
    <textarea id="comment_muro" name="comment_muro" style="height: 50px; overflow: visible; width: 635px; font-size: 13px; font-family: Arial,FreeSans;" title="Escribir en su muro..." onblur="if(this.value=='') this.value='Escribir en su muro...'; no_foco(this);" onfocus="if(this.value=='Escribir en su muro...') this.value=''; foco(this);">Escribir en su muro...</textarea>
    <div class="floatL">
    <div style="float:left" id="emoticons"><a smile=":bueno:" href="#"><img width="24" height="24" border="0" title="Bueno" alt="Bueno" src="<?=$config['images'];?>/images/emoticons/bueno.png" onclick="insertText(' :bueno:', document.forms.comentador.comment_muro);"></a><a smile=":malo:" href="#"><img width="24" height="24" border="0" title="Malo" alt="Malo" src="<?=$config['images'];?>/images/emoticons/malo.png" onclick="insertText(' :malo:', document.forms.comentador.comment_muro);"></a><a smile=":muerto:" href="#"><img width="24" height="24" border="0" title="Muerto" alt="Muerto" src="<?=$config['images'];?>/images/emoticons/muerto.png" onclick="insertText(' :muerto:', document.forms.comentador.comment_muro);"></a><a smile=":divertido:" href="#"><img width="24" height="24" border="0" title="Divertido" alt="Divertido" src="<?=$config['images'];?>/images/emoticons/divertido.png" onclick="insertText(' :divertido:', document.forms.comentador.comment_muro);"></a><a smile=":sinister:" href="#"><img width="24" height="24" border="0" title="Siniestro" alt="Siniestro" src="<?=$config['images'];?>/images/emoticons/sinister.png" onclick="insertText(' :sinister:', document.forms.comentador.comment_muro);"></a><a smile=":D" href="#"><img width="24" height="24" border="0" title="Sonrisa" alt="Sonrisa" src="<?=$config['images'];?>/images/emoticons/sonrisa.png" onclick="insertText(' :D', document.forms.comentador.comment_muro);"></a><a smile=":arrogante:" href="#"><img width="24" height="24" border="0" title="Arrogante" alt="Arrogante" src="<?=$config['images'];?>/images/emoticons/arrogante.png" onclick="insertText(' :arrogante:', document.forms.comentador.comment_muro);"></a><a smile=":@" href="#"><img width="24" height="24" border="0" title="Enojado" alt="Enojado" src="<?=$config['images'];?>/images/emoticons/enojado.png" onclick="insertText(' :@', document.forms.comentador.comment_muro);"></a><a smile=":relax:" href="#"><img width="24" height="24" border="0" title="Relajado" alt="Relajado" src="<?=$config['images'];?>/images/emoticons/relax.png" onclick="insertText(' :relax:', document.forms.comentador.comment_muro);"></a><a smile=":ironico:" href="#"><img width="24" height="24" border="0" title="Ironico" alt="Ironico" src="<?=$config['images'];?>/images/emoticons/ironico.png" onclick="insertText(' :ironico:', document.forms.comentador.comment_muro);"></a><a smile=":confused:" href="#"><img width="24" height="24" border="0" title="Confundido" alt="Confundido" src="<?=$config['images'];?>/images/emoticons/confused.png" onclick="insertText(' :confused:', document.forms.comentador.comment_muro);"></a><a smile=":shamed:" href="#"><img width="24" height="24" border="0" title="Vergonzoso" alt="Vergonzoso" src="<?=$config['images'];?>/images/emoticons/shamed.png" onclick="insertText(' :shamed:', document.forms.comentador.comment_muro);"></a><a smile=":disdain:" href="#"><img width="24" height="24" border="0" title="Disdain" alt="Disdain" src="<?=$config['images'];?>/images/emoticons/disdain.png" onclick="insertText(' :disdain:', document.forms.comentador.comment_muro);"></a><a smile=":(" href="#"><img width="24" height="24" border="0" title="Triste" alt="Triste" src="<?=$config['images'];?>/images/emoticons/triste.png" onclick="insertText(' :(', document.forms.comentador.comment_muro);"></a><a smile=":sarcastico:" href="#"><img width="24" height="24" border="0" title="Sarcastico" alt="Sarcastico" src="<?=$config['images'];?>/images/emoticons/sarcastico.png" onclick="insertText(' :sarcastico:', document.forms.comentador.comment_muro);"></a><a smile=":-)" href="#"><img width="24" height="24" border="0" title="Feliz" alt="Feliz" src="<?=$config['images'];?>/images/emoticons/feliz.png" onclick="insertText(' :-)', document.forms.comentador.comment_muro);"></a><a smile=":lost:" href="#"><img width="24" height="24" border="0" title="Perdido" alt="Perdido" src="<?=$config['images'];?>/images/emoticons/lost.png" onclick="insertText(' :lost:', document.forms.comentador.comment_muro);"></a><a smile=":shock:" href="#"><img width="24" height="24" border="0" title="Shock" alt="Shock" src="<?=$config['images'];?>/images/emoticons/shock.png" onclick="insertText(' :shock:', document.forms.comentador.comment_muro);"></a><a smile=":llorar:" href="#"><img width="24" height="24" border="0" title="Llorando" alt="Llorando" src="<?=$config['images'];?>/images/emoticons/llorar.png" onclick="insertText(' :llorar:', document.forms.comentador.comment_muro);"></a><a smile=":pirata:" href="#"><img width="24" height="24" border="0" title="Pirata" alt="Pirata" src="<?=$config['images'];?>/images/emoticons/pirata.png" onclick="insertText(' :pirata:', document.forms.comentador.comment_muro);"></a><a smile=":devil:" href="#"><img width="24" height="24" border="0" title="Diablo" alt="Diablo" src="<?=$config['images'];?>/images/emoticons/devil.png" onclick="insertText(' :devil:', document.forms.comentador.comment_muro);"></a><a smile=":loser:" href="#"><img width="24" height="24" border="0" title="Perdedor" alt="Perdedor" src="<?=$config['images'];?>/images/emoticons/loser.png" onclick="insertText(' :loser:', document.forms.comentador.comment_muro);"></a><a smile=":ask:" href="#"><img width="24" height="24" border="0" title="Pregunta" alt="Pregunta" src="<?=$config['images'];?>/images/emoticons/ask.png" onclick="insertText(' :ask:', document.forms.comentador.comment_muro);"></a></div>
    </div><div class="clear"></div>
    <input type="button" title="Publicar" value="Publicar" id="button_add_comment_muro" onclick="muros.add_comment('<?=$row['id'];?>', 'owner'); return false;" class="floatR Boton BtnGray">
  </form>
  <div class="clear"></div>
</div>
<?php
} else {
  echo '<div class="Globo GlbYellow">Para poder comentar en muros necesitas estar <a href="#" onclick="accounts.registro_load_form(); return false" title="Reg&iacute;strarse">Registrado</a>. Si ya tienes usuario <a href="#" onclick="open_login_box(); return false;" title="Conectarse">&iexcl;Con&eacute;ctate!</a></div>';
}
?>
<div class="clear"></div>
<br>
<script type="text/javascript">
    $(document).ready(function(){
	    $(window).scroll(function(){
		    if ($(window).scrollTop() + 100 >= $(document).height() - $(window).height() && scrollpija < 3) {
			    $('#pija').click();
			}
		});
	});
</script>
<?php
if($logged['id'] == $row['id']) {
?>

<span class="floatR">
    <b class="size12">Mi estado: &nbsp;</b>
	<select id="status" name="status" onchange="accounts.change_status('<?=$row['id'];?>')">
    <option value="0" selected="seleceted">Sin estado (?)</option>
    <?php
    $status = mysql_query('SELECT * FROM `status` ORDER BY `id` DESC');
    while($pq = mysql_fetch_assoc($status)) {
      echo '<option value="'.$pq['id'].'"'.($row['status'] == $pq['id'] ? ' selected="selected"' : '').'>'.$pq['name'].'</option> ';
    }
    if(mysql_num_rows($s = mysql_query('SELECT `name`, `img` FROM `status` WHERE `id` = \''.$row['status'].'\''))) {
      $rows = mysql_fetch_row($s);
    } else {
      $rows = array('Sin estado', 'ninguno.gif');
    }
    ?>
	</select> &nbsp;<img id="status_img" src="<?=$config['images'];?>/images/estado/<?=$rows[1];?>" align="top" border="0" title="<?=$rows[0];?>" /><span id="return_status"></span>
</span>
<?php
}
?>
<span class="floatL">
	<b class="size12">Filtrar por:</b>
	<span class="filter_box">
	    <span class="filterBy">
    		<a id="tabID" onclick="muros.filter_wall('<?=$row['id'];?>','ID'); tabs.filterComms('ID'); return false;" class="here">+ Recientes</a> -
    		<a id="tabAutor" onclick="muros.filter_wall('<?=$row['id'];?>','Autor'); tabs.filterComms('Autor'); return false;">Autor</a> -
    		<a id="tabPopulares" onclick="muros.filter_wall('<?=$row['id'];?>','Populares'); tabs.filterComms('Populares'); return false;">Populares</a>

    		<script type="text/javascript">var filterCommsHere = 'ID';</script>
		</span>
	</span>
</span><div class="clear"></div><br>
<div class="msg_add_muro" style="margin-bottom: 8px; display: none;"></div>
<div class="comment_container">
	<div id="return_agregar_muro"></div>
	<span id="ult_comm_muro"><div id="return_agregar_muro"></div>
	</script>
    <?php
    include($_SERVER['DOCUMENT_ROOT'].'/ajax/profile-wall-filter.php');
    ?>
    </span>
</div>
</div>
<div class="clearBoth"></div>

</div></span><div class="clear"></div> </div>