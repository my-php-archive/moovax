<?php
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes estar logueado para enviar un mp'); }
if($_POST['para'] && !empty($_POST['para'])) {
  if(!mysql_num_rows($us = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `nick` = \''.mysql_clean($_POST['para']).'\''))) { die('0: El usuario ingresado no existe'); }
  $rp = mysql_fetch_row($us);
  if($rp[0] == $logged['id']) { die('0: No es posible enviar mps a ti mismo'); }
}
?>
1:
<div class="form-container" id="enviar-mensaje">
	<form name="mensajero">
    	<div style="display: none;" class="redBox" id="error_data"></div>
    	<div class="data">
    		<label>Para<span style="color:red">*</span></label>
    		<input type="text" value="<?=($rp[1] ? $rp[1] : '');?>" name="para" id="para" class="c_input">
    	</div>
    	<div class="data">
    		<label>Asunto</label>
    		<input type="text" name="asunto" id="asunto" class="c_input">
    	</div>
    	<div class="data">
    		<label>Mensaje<span style="color:red">*</span></label>
    		<textarea style="height: 80px;" name="mensaje" id="VPeditor" class="c_input_desc"></textarea>
        	<br>
     <div class="floatL">
     <div style="float:left" id="emoticons"><a smile=":bueno:" href="#"><img width="24" height="24" border="0" title="Bueno" alt="Bueno" src="<?=$config['images'];?>/images/emoticons/bueno.png" onclick="insertText(' :bueno:', document.forms.mensajero.VPeditor);"></a><a smile=":malo:" href="#"><img width="24" height="24" border="0" title="Malo" alt="Malo" src="<?=$config['images'];?>/images/emoticons/malo.png" onclick="insertText(' :malo:', document.forms.mensajero.VPeditor);"></a><a smile=":muerto:" href="#"><img width="24" height="24" border="0" title="Muerto" alt="Muerto" src="<?=$config['images'];?>/images/emoticons/muerto.png" onclick="insertText(' :muerto:', document.forms.mensajero.VPeditor);"></a><a smile=":divertido:" href="#"><img width="24" height="24" border="0" title="Divertido" alt="Divertido" src="<?=$config['images'];?>/images/emoticons/divertido.png" onclick="insertText(' :divertido:', document.forms.mensajero.VPeditor);"></a><a smile=":sinister:" href="#"><img width="24" height="24" border="0" title="Siniestro" alt="Siniestro" src="<?=$config['images'];?>/images/emoticons/sinister.png" onclick="insertText(' :sinister:', document.forms.mensajero.VPeditor);"></a><a smile=":D" href="#"><img width="24" height="24" border="0" title="Sonrisa" alt="Sonrisa" src="<?=$config['images'];?>/images/emoticons/sonrisa.png" onclick="insertText(' :D', document.forms.mensajero.VPeditor);"></a><a smile=":arrogante:" href="#"><img width="24" height="24" border="0" title="Arrogante" alt="Arrogante" src="<?=$config['images'];?>/images/emoticons/arrogante.png" onclick="insertText(' :arrogante:', document.forms.mensajero.VPeditor);"></a><a smile=":@" href="#"><img width="24" height="24" border="0" title="Enojado" alt="Enojado" src="<?=$config['images'];?>/images/emoticons/enojado.png" onclick="insertText(' :@', document.forms.mensajero.VPeditor);"></a><a smile=":relax:" href="#"><img width="24" height="24" border="0" title="Relajado" alt="Relajado" src="<?=$config['images'];?>/images/emoticons/relax.png" onclick="insertText(' :relax:', document.forms.mensajero.VPeditor);"></a><a smile=":ironico:" href="#"><img width="24" height="24" border="0" title="Ironico" alt="Ironico" src="<?=$config['images'];?>/images/emoticons/ironico.png" onclick="insertText(' :ironico:', document.forms.mensajero.VPeditor);"></a><a smile=":confused:" href="#"><img width="24" height="24" border="0" title="Confundido" alt="Confundido" src="<?=$config['images'];?>/images/emoticons/confused.png" onclick="insertText(' :confused:', document.forms.mensajero.VPeditor);"></a><a smile=":shamed:" href="#"><img width="24" height="24" border="0" title="Vergonzoso" alt="Vergonzoso" src="<?=$config['images'];?>/images/emoticons/shamed.png" onclick="insertText(' :shamed:', document.forms.mensajero.VPeditor);"></a><a smile=":disdain:" href="#"><img width="24" height="24" border="0" title="Disdain" alt="Disdain" src="<?=$config['images'];?>/images/emoticons/disdain.png" onclick="insertText(' :disdain:', document.forms.mensajero.VPeditor);"></a><a smile=":(" href="#"><img width="24" height="24" border="0" title="Triste" alt="Triste" src="<?=$config['images'];?>/images/emoticons/triste.png" onclick="insertText(' :(', document.forms.mensajero.VPeditor);"></a><a smile=":sarcastico:" href="#"><img width="24" height="24" border="0" title="Sarcastico" alt="Sarcastico" src="<?=$config['images'];?>/images/emoticons/sarcastico.png" onclick="insertText(' :sarcastico:', document.forms.mensajero.VPeditor);"></a><a smile=":-)" href="#"><img width="24" height="24" border="0" title="Feliz" alt="Feliz" src="<?=$config['images'];?>/images/emoticons/feliz.png" onclick="insertText(' :-)', document.forms.mensajero.VPeditor);"></a><a smile=":lost:" href="#"><img width="24" height="24" border="0" title="Perdido" alt="Perdido" src="<?=$config['images'];?>/images/emoticons/lost.png" onclick="insertText(' :lost:', document.forms.mensajero.VPeditor);"></a><a smile=":shock:" href="#"><img width="24" height="24" border="0" title="Shock" alt="Shock" src="<?=$config['images'];?>/images/emoticons/shock.png" onclick="insertText(' :shock:', document.forms.mensajero.VPeditor);"></a><a smile=":llorar:" href="#"><img width="24" height="24" border="0" title="Llorando" alt="Llorando" src="<?=$config['images'];?>/images/emoticons/llorar.png" onclick="insertText(' :llorar:', document.forms.mensajero.VPeditor);"></a><a smile=":pirata:" href="#"><img width="24" height="24" border="0" title="Pirata" alt="Pirata" src="<?=$config['images'];?>/images/emoticons/pirata.png" onclick="insertText(' :pirata:', document.forms.mensajero.VPeditor);"></a><a smile=":devil:" href="#"><img width="24" height="24" border="0" title="Diablo" alt="Diablo" src="<?=$config['images'];?>/images/emoticons/devil.png" onclick="insertText(' :devil:', document.forms.mensajero.VPeditor);"></a><a smile=":loser:" href="#"><img width="24" height="24" border="0" title="Perdedor" alt="Perdedor" src="<?=$config['images'];?>/images/emoticons/loser.png" onclick="insertText(' :loser:', document.forms.mensajero.VPeditor);"></a><a smile=":ask:" href="#"><img width="24" height="24" border="0" title="Pregunta" alt="Pregunta" src="<?=$config['images'];?>/images/emoticons/ask.png" onclick="insertText(' :ask:', document.forms.mensajero.VPeditor);"></a></div>
     </div>
        </div>
    	<div style="clear:both"></div>
    	<br>
    	<span style="float:left"><span style="color:red">*</span>Obligatorio</span>
    </form>
</div>