<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('Debes est&aacute;r logueado'); }
$d = false;
if($_GET['id'] && ctype_digit($_GET['id'])) {
  if(!mysql_num_rows($p = mysql_query('SELECT * FROM `photos` WHERE `id` = \''.$_GET['id'].'\''))) { fatal_error('El post no existe'); }
  $row = mysql_fetch_assoc($p);
  if($row['status'] != 0) { fatal_error('La foto se encuentra eliminada'); }
  if($row['author'] != $logged['id'] && !allow('delete_photos')) { fatal_error('La foto no te pertenece'); }
  $d = true;
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

</script><div class="breadcrumb">
			<ul>
				<li class="first"><a href="/" accesskey="1" class="home"></a></li>
				<li><a href="/fotos/">Fotos</a></li>
				<li><a href="/fotos/agregar/"><?=($d ? 'Editar' : 'Agregar');?> foto</a></li>
				<li class="last"></li>

			</ul>
		</div><div style="clear:both;"></div>
<form action="/fotos/agregar/enviando/" method="post" accept-charset="UTF-8" name="addPost" id="addPost"  style="margin: 0;">
<div id="preview" class="displayN"></div>
<div id="addPostL">
	<div id="return-add-photo" class="displayN"></div>
    <?php
    if($d) { echo '<input id="f" name="f" type="hidden" value="'.$row['id'].'">'; }
    ?>
	<div id="box-editor" class="box_editor">
    <?php
    if($d && $row['author'] != $logged['id']) {
    ?>
    <h2 class="titulo">Causa de edici&oacute;n:</h2>
		<br /><input type="text" size="106" maxlength="60" name="causa" id="causa" tabindex="1" />
    <?php
    }
    ?>
    	<h2 class="titulo">T&iacute;tulo:</h2>
		<br /><input type="text" size="106" maxlength="60" name="titulo" id="titulo" tabindex="1"<?=($d ? ' value="'.$row['title'].'"' : '');?> />
		<div id="MostrarError1" class="capsprot">El t&iacute;tulo no debe estar en may&uacute;sculas</div><br class="space">

		<h2 class="titulo">URL:</h2>
		<br /><input type="text" size="106" maxlength="255" name="url" id="url" tabindex="1"<?=($d ? 'value="'.$row['url'].'"' : '');?> /><br class="space">


		<h2 class="titulo">Descripci&oacute;n de tu foto: <span  class="size9">(Sin BBC code)</span></h2>
		<br /><textarea id="descripcion" class="editorFP" name="descripcion" tabindex="2" style="width:652px;height:120px;"><?=$row['body'];?></textarea>
		<div id="MostrarError3" class="capsprot">Hace falta que escribas el contenido del post.</div>
		<div id="MostrarError4" class="capsprot">El contenido del post no puede pasar de los 63206 caracteres.</div><br />


<div class="clearBoth"></div><br>
		<div class="special-left">
			<h2 class="titulo">Categor&iacute;a:</h2><br />
			<select name="categorias" id="categoria" class="agregar required" size="9" tabindex="3">
				<option style="color:#000;font-weight:bold;padding:3px 3px 3px 3px; background:none;" selected="selected" value="-1">Elegir una categor&iacute;a</option>
                <?php
                $query = mysql_query('SELECT `id`, `name`, `url` FROM `p_categories` ORDER BY `name` ASC');
                while(list($id, $name, $url) = mysql_fetch_row($query)) {
                  echo '<option class="'.$url.'" value="'.$id.'"'.($id == $row['cat'] && $d ? ' selected="selected"' : '').'>'.$name.'</option>';
                }
                ?>

            </select>

				<div id="MostrarError7" class="capsprot">Debes agregar la categor&iacute;a del post.</div>
				</div>		<div class="special-right">
			<h2 class="titulo">Opciones:</h2><br />

			<div class="options clearBoth">
				<input class="floatL" type="checkbox" name="privado" id="privado" tabindex="4" value="1"<?=($row['private'] == 1 && $d == 1 ? ' checked="checked"' : '');?> />
				<p class="floatL">
					<label for="privado"><strong>Solo usuarios registrados</strong>

					Tu foto ser&aacute; vista solo por los usuarios de <?=$config['name'];?>.</label>
				</p>
			</div>
			<div class="options clearBoth">
				<input class="floatL" type="checkbox" name="cerrado" id="cerrado" tabindex="5" value="1"<?=($row['closed'] == 1 && $d ? ' checked="checked"' : '');?> />
				<p class="floatL">
					<label for="cerrado"><strong>Cerrar Comentarios</strong>

					Si tu foto es pol&eacute;mica o controversial, es recomendable que cierres los comentarios.</label>
				</p>
			</div>
			<div class="options clearBoth">
				<input class="floatL" type="checkbox" name="amigos" id="amigos" tabindex="5" value="1"<?=($row['private'] == 2 && $d ? ' checked="checked"' : '');?> />
				<p class="floatL">
					<label for="cerrado"><strong>Mostrar solo a mis amistades</strong>

					Tu foto ser&aacute; mostrada solo a tus amistades.</label>
				</p>
			</div></div>
<div class="clearBoth"></div>
		<span id="span_borrador" style="display:block;float:right"></span><div class="clear"></div>
		<hr class="divider" /><div class="floatR"><input type="button" onclick="fotos.<?=($d ? 'edit' : 'add');?>_photo(); return false;" class="Boton BtnPurple" value="<?=($d ? 'Editar foto' : 'Agregar foto');?>" title="<?=($d ? 'Editar foto' : 'Agregar foto');?>" tabindex="7"> </div>
	<div class="clear"></div>

	</div>

</div><div id="addPostR">

	<div class="box_notes">
		<h3>Consejos</h3>
		<p>
			Antes de agregar una foto debes de tener en cuenta los puntos que a continuaci&oacute;n se describen.
			Esto ayuda a mantener una mejor calidad y/o control y as&iacute; evitar que sea eliminada por los moderadores.
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
			<li class="BulletIcons rojo">Pornograf&iacute;a u otro contenido sexual.</li>
			<li class="BulletIcons rojo">Violencia o maltratos de cualquier tipo.</li>

			<li class="BulletIcons rojo">Fotos de personas menores de edad.</li>
			<li class="BulletIcons rojo">Muertos, sangre, v&oacute;mitos, etc.</li>

			<li class="BulletIcons rojo">Con contenido racista y/o peyorativo.</li>
			<li class="BulletIcons rojo">Poca calidad (crap).</li>
			<li class="BulletIcons rojo">Insultos o malos modos.</li>

			<li class="BulletIcons rojo">Con intenci&oacute;n de armar pol&eacute;mica.</li>
		</ul>
		<br />
		<strong>Entiendase</strong>

		<li class="BulletIcons verde">= SI</li>

		<li class="BulletIcons rojo">= NO</li>
	</div>
</div>
</form><div style="clear:both"></div></div>     </div>