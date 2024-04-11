<?php
if(!defined($config['define'])) { die; }
if(!$key) { fatal_error('Debes estar logueado para hacer esto'); }
$edit = false;
//$draft = false;
if($_GET['id']) {
  if($_GET['type'] == 'borrador') {
    if(!mysql_num_rows($query = mysql_query('SELECT * FROM `drafts` WHERE `id` = \''.intval($_GET['id']).'\''))) { fatal_error('No existe'); }
    $row = mysql_fetch_assoc($query);
    if($row['author'] != $logged['id']) { fatal_error('Chupame la pija'); }
    if($row['type'] != 0) { die; }
    $edit = true;
    //$draft = true;
  } else {
    if(!mysql_num_rows($query = mysql_query('SELECT * FROM `posts` WHERE `id` = \''.intval($_GET['id']).'\''))) { fatal_error('El post ingresado no existe'); }
    $row = mysql_fetch_assoc($query);
    if($row['author'] != $logged['id'] && !allow('delete_posts')) { fatal_error('Este post no te pertenece'); }
    if($row['status'] != '0') { fatal_error('Este post fue eliminado'); }
    $edit = true;
  }
}
?>
<script type="text/javascript">

        var confirm = true;
        window.onbeforeunload = confirmleave;
        function confirmleave() {
            if (confirm && ($('input[name=titulo]').val() || $('textarea[name=cuerpo]').val())) return "Este post no fue publicado y se perdera.";
        }

		function _capsprot(s) {
			var len = s.length, strip = s.replace(/([A-Z])+/g, '').length, strip2 = s.replace(/([a-zA-Z])+/g, '').length,
			percent = (len  - strip) / (len - strip2) * 100;
			return percent;
        }
		$(document).ready(function(){
			$('input[name=titulo]').keyup(function(){
				if ($(this).val().length >= 5 && _capsprot($(this).val()) > 90) $('#MostrarError1').show();
				else $('#MostrarError1').hide();
			});
		});
        var pana = ($('#VPeditor').val());

        jQuery(document).ready(function($){
			var save_drafts = setInterval(
				function(){
				    if(!$('#VPeditor').val() || !$('#titulo').val() || $('#categorias').val() == '-1' || pana == $('#VPeditor').val() || $('#titulo').val().length < 3 || $('#VPeditor').val().length < 100) { return false; }
					$('#few').click();
                    pana = $('#VPeditor').val();
				},
				120000
			);
		});


</script>
<div style="clear:both;"></div>
<form action="/posts/agregar/enviando/" method="post" accept-charset="UTF-8" name="addPost" id="addPost" style="margin: 0;">
<div id="preview" style="display: none;"></div>
<div id="addPostL">
    <input type="hidden" name="p" id="p" value="<?=($edit ? $row['id'] : '');?>" />
    <input type="hidden" name="borrador" id="borrador" value="<?=($_GET['type'] == 'borrador' ? $row['id'] : '-1');?>" />
	<div id="return-add-post" class="displayN"></div>
	<div id="box-editor" class="box_editor">
    <?php
    if($row['author'] != $logged['id'] && allow('delete_posts') && $edit) {
    ?>
    <h2 class="titulo">Causa de la edici&oacute;n:</h2>
	<br /><input type="text" size="126" maxlength="75" name="causa" id="causa" tabindex="1"  />
	<br class="space">
    <?php
    }
    ?>
    <h2 class="titulo">T&iacute;tulo:</h2>

		<br /><input type="text" size="106" maxlength="60" name="titulo" id="titulo" tabindex="1"<?=($edit ? ' value="'.$row['title'].'"' : '');?> />
		<div id="MostrarError1" class="capsprot">El t&iacute;tulo no debe estar en may&uacute;sculas</div><br class="space">
		<br />

		<h2 class="titulo">Contenido del post:</h2>
		<br /><textarea id="VPeditor" class="editorFP" name="cuerpo" tabindex="2" style="width:652px;height:320px;"><?=$row['body'];?></textarea>
		<div id="MostrarError3" class="capsprot">Hace falta que escribas el contenido del post.</div>
		<div id="MostrarError4" class="capsprot">El contenido del post no puede pasar de los 63206 caracteres.</div><br />
		<br />
        <div id="emoticons" style="float:left"><a href="#" smile=":bueno:"><img border="0" src="<?=$config['images'];?>/images/emoticons/bueno.png" alt="Bueno" title="Bueno" height="24" width="24" /></a><a href="#" smile=":malo:"><img border="0" src="<?=$config['images'];?>/images/emoticons/malo.png" alt="Malo" title="Malo" height="24" width="24" /></a><a href="#" smile=":muerto:"><img border="0" src="<?=$config['images'];?>/images/emoticons/muerto.png" alt="Muerto" title="Muerto" height="24" width="24" /></a><a href="#" smile=":divertido:"><img border="0" src="<?=$config['images'];?>/images/emoticons/divertido.png" alt="Divertido" title="Divertido" height="24" width="24" /></a><a href="#" smile=":sinister:"><img border="0" src="<?=$config['images'];?>/images/emoticons/sinister.png" alt="Siniestro" title="Siniestro" height="24" width="24" /></a><a href="#" smile=":D"><img border="0" src="<?=$config['images'];?>/images/emoticons/sonrisa.png" alt="Sonrisa" title="Sonrisa" height="24" width="24" /></a><a href="#" smile=":arrogante:"><img border="0" src="<?=$config['images'];?>/images/emoticons/arrogante.png" alt="Arrogante" title="Arrogante" height="24" width="24" /></a><a href="#" smile=":@"><img border="0" src="<?=$config['images'];?>/images/emoticons/enojado.png" alt="Enojado" title="Enojado" height="24" width="24" /></a><a href="#" smile=":relax:"><img border="0" src="<?=$config['images'];?>/images/emoticons/relax.png" alt="Relajado" title="Relajado" height="24" width="24" /></a><a href="#" smile=":ironico:"><img border="0" src="<?=$config['images'];?>/images/emoticons/ironico.png" alt="Ironico" title="Ironico" height="24" width="24" /></a><a href="#" smile=":confused:"><img border="0" src="<?=$config['images'];?>/images/emoticons/confused.png" alt="Confundido" title="Confundido" height="24" width="24" /></a><a href="#" smile=":shamed:"><img border="0" src="<?=$config['images'];?>/images/emoticons/shamed.png" alt="Vergonzoso" title="Vergonzoso" height="24" width="24" /></a><a href="#" smile=":disdain:"><img border="0" src="<?=$config['images'];?>/images/emoticons/disdain.png" alt="Disdain" title="Disdain" height="24" width="24" /></a><a href="#" smile=":("><img border="0" src="<?=$config['images'];?>/images/emoticons/triste.png" alt="Triste" title="Triste" height="24" width="24" /></a><a href="#" smile=":sarcastico:"><img border="0" src="<?=$config['images'];?>/images/emoticons/sarcastico.png" alt="Sarcastico" title="Sarcastico" height="24" width="24" /></a><a href="#" smile=":-)"><img border="0" src="<?=$config['images'];?>/images/emoticons/feliz.png" alt="Feliz" title="Feliz" height="24" width="24" /></a><a href="#" smile=":lost:"><img border="0" src="<?=$config['images'];?>/images/emoticons/lost.png" alt="Perdido" title="Perdido" height="24" width="24" /></a><a href="#" smile=":shock:"><img border="0" src="<?=$config['images'];?>/images/emoticons/shock.png" alt="Shock" title="Shock" height="24" width="24" /></a><a href="#" smile=":llorar:"><img border="0" src="<?=$config['images'];?>/images/emoticons/llorar.png" alt="Llorando" title="Llorando" height="24" width="24" /></a><a href="#" smile=":pirata:"><img border="0" src="<?=$config['images'];?>/images/emoticons/pirata.png" alt="Pirata" title="Pirata" height="24" width="24" /></a><a href="#" smile=":devil:"><img border="0" src="<?=$config['images'];?>/images/emoticons/devil.png" alt="Diablo" title="Diablo" height="24" width="24" /></a><a href="#" smile=":loser:"><img border="0" src="<?=$config['images'];?>/images/emoticons/loser.png" alt="Perdedor" title="Perdedor" height="24" width="24" /></a><a href="#" smile=":ask:"><img border="0" src="<?=$config['images'];?>/images/emoticons/ask.png" alt="Pregunta" title="Pregunta" height="24" width="24" /></a></div>
<div class="clearBoth"></div><br>
		<div class="special-left">
			<h2 class="titulo">Categor&iacute;a:</h2><br />
			<select name="categorias" id="categorias" class="agregar required" size="9" tabindex="3">
				<option style="color:#000;font-weight:bold;padding:3px 3px 3px 3px; background:none;" selected="selected" value="-1">Elegir una categor&iacute;a</option>
                <?php
                $s = mysql_query('SELECT `id`, `name`, `url` FROM `categories` ORDER BY `name` ASC');
                while(list($id, $name, $url) = mysql_fetch_row($s)) {
                  echo '<option class="'.$url.'" value="'.$id.'"'.($edit && $row['cat'] == $id ? ' selected="true"' : '').'>'.$name.'</option>';
                }
                ?>

            </select>

				<div id="MostrarError7" class="capsprot">Debes agregar la categor&iacute;a del post.</div>
				</div>		<div class="special-right">
			<h2 class="titulo">Opciones:</h2><br />
            <?php
            if(allow('sticky')) {
            ?>
			<div class="options clearBoth">
				<input class="floatL" type="checkbox" name="sticky" id="sticky" tabindex="7" value="1"<?=($edit && $row['sticky'] == '1' ? ' checked="true"' : '');?> />
				<p class="floatL">
					<label for="sticky"><strong>Agregarle Sticky</strong>

					Permite a&ntilde;adir tu post en Sticky.</label>
				</p>
			</div>
            <?php
            }
            ?>
			<div class="options clearBoth">
				<input class="floatL" type="checkbox" name="privado" id="privado" tabindex="4" value="1"<?=($edit && $row['private'] == '1' ? ' checked="true"' : '');?> />
				<p class="floatL">
					<label for="privado"><strong>Solo usuarios registrados</strong>

					Tu post ser&aacute; visto solo por los usuarios de <?=$config['name'];?>.</label>
				</p>
			</div>
			<div class="options clearBoth">
				<input class="floatL" type="checkbox" name="cerrado" id="cerrado" tabindex="5" value="1"<?=($edit && $row['closed'] == '1' ? ' checked="true"' : '');?> />
				<p class="floatL">
					<label for="cerrado"><strong>Cerrar Comentarios</strong>

					Si tu post es pol&eacute;mico, es recomendable que cierres los comentarios.</label>
				</p>
			</div></div>
<div class="clearBoth"></div>
		<span id="span_borrador" style="display:block;float:right"></span><div class="clear"></div>
		<hr class="divider" />
        <div align="center">
        <input type="button" onclick="posts.previsualiza_post('<?=($edit && $_GET['type'] == 'edit' ? 2 : 1);?>'); return false;" class="Boton BtnGreen" value="Previsualizar" title="Previsualizar" tabindex="7">
        <input type="button" id="few" onclick="savedraft(); return false;" class="Boton BtnBlue" value="Guardar en borradores" title="Guardar en borradores" tabindex="7"><div id="success" style="display: none;"></div>

        </div>
	</div>


</div><div id="addPostR">

	<div class="box_notes">
		<h3>Consejos</h3>
		<p>
			Para hacer un buen post es importante que tengas en cuenta los siguientes puntos. Esto ayuda a mantener una mejor calidad de contenido y evitar que sea eliminado por los moderadores.
			<br />Adem&aacute;s te recomendamos <a href="/static/protocolo/" title="Leer el protocolo" target="_blank">leer el protocolo</a> para una explicaci&oacute;n m&aacute;s detallada.
		</p>


		<strong>El t&iacute;tulo</strong>
		<ul>
			<li class="BulletIcons verde">Que sea descriptivo.</li>
			<li class="BulletIcons rojo">TODO EN MAY&Uacute;SCULA.</li>
			<li class="BulletIcons rojo">!!!!!!!Exagerados!!!!!!.</li>

			<li class="BulletIcons rojo">PARCIALMENTE en may&uacute;sculas!.</li>

		</ul>
		<strong>Contenido</strong>
		<ul>
			<li class="BulletIcons rojo">Informaci&oacute;n personal o de un tercero.</li>
			<li class="BulletIcons rojo">Fotos de personas menores de edad.</li>

			<li class="BulletIcons rojo">Muertos, sangre, v&oacute;mitos, etc.</li>

			<li class="BulletIcons rojo">Con contenido racista y/o peyorativo.</li>
			<li class="BulletIcons rojo">Poca calidad (una im&aacute;gen, texto pobre).</li>
			<li class="BulletIcons rojo">Chistes escritos, adivinanzas, trivias.</li>
			<li class="BulletIcons rojo">Haciendo preguntas o cr&iacute;ticas.</li>

			<li class="BulletIcons rojo">Insultos o malos modos.</li>

			<li class="BulletIcons rojo">Con intenci&oacute;n de armar pol&eacute;mica.</li>
			<li class="BulletIcons rojo">Apolog&iacute;a de delito.</li>
			<li class="BulletIcons rojo">Software spyware, malware, virus o troyanos.</li>
		</ul>

		<br />
		<strong>Entiendase</strong>

		<li class="BulletIcons verde">= SI</li>
		<li class="BulletIcons rojo">= NO</li>
	</div>
</div>
</form><div style="clear:both"></div></div>

</div>