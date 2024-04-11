<?php
if(!defined($config['define'])) { die; }
if(!$_GET['resp']) { fatal_error('Faltan datos'); }
if(!$logged['id']) { die; }
if(!mysql_num_rows($e = mysql_query('SELECT `id`, `body`, `author`, `receiver`, `time`, `issue` FROM `messages` WHERE `id` = \''.intval($_GET['resp']).'\''))) { fatal_error('El mensaje no existe'); }
$qs = mysql_fetch_assoc($e);
if($qs['author'] != $logged['id'] && $qs['receiver'] != $logged['id']) { fatal_error('Que intentas?'); }
list($nick) = mysql_fetch_row(mysql_query('SELECT `nick` FROM `users` WHERE `id` = \''.$qs['author'].'\''));
$qs['body'] = "\n\n".'El '.date('d.m.Y', $qs['time']).' '.$nick.' Escribi&oacute;:'."\n>\n".str_replace("\n", "\n>", $qs['body']);
?>
<div id="mensajes-left">

		<div class="clearBoth"></div><div style="border:1px solid #CCCCCC;background-color:#EEEEEE;padding:6px;">
		<a href="#" onclick="mp.enviar_mensaje(''); return false;" title="Enviar Mensaje">

			<div class="mp-content">
				<div class="mp-img"><img src="<?=$config['images'];?>/images/mensajes/enviar.png" alt="Enviar Mensaje" /></div>
				<div class="mp-txt">
					<strong>Enviar un mensaje</strong>
					Click para enviar un nuevo mensaje.
				</div>

			</div>
		</a>

		<a href="/mensajes/recibidos/" title="Mensajes Recibidos">
			<div class="mp-content">
				<div class="mp-img"><img src="<?=$config['images'];?>/images/mensajes/recibidos.png" alt="Mensajes Recibidos" /></div>
				<div class="mp-txt">
					<strong>Mensajes Recibidos</strong>
					Ver mi buz&oacute;n de entrada.
				</div>

			</div>

		</a>
		<a href="/mensajes/enviados/" title="Mensajes Enviados">
			<div class="mp-content">
				<div class="mp-img"><img src="<?=$config['images'];?>/images/mensajes/enviados.png" alt="Mensajes Enviados" /></div>
				<div class="mp-txt">
					<strong>Mensajes Enviados</strong>
					Ver mis buz&oacute;n de salida.
				</div>

			</div>
		</a>
		<a href="/mensajes/eliminados/" title="Mensajes Eliminados">
			<div class="mp-content">
				<div class="mp-img"><img src="<?=$config['images'];?>/images/mensajes/eliminados.png" alt="Mensajes Eliminados" /></div>
				<div class="mp-txt">
					<strong>Mensajes Eliminados</strong>
					Ver mensajes en papelera.
				</div>

			</div>
		</a>

		<div class="clearBoth"></div>
	</div>
	<br class="space" />
	</div>
<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[

function nuevoAjax(){var xmlhttp=false;try{xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");} catch(E) { xmlhttp=false;}}if (!xmlhttp && typeof XMLHttpRequest!="undefined") { xmlhttp=new XMLHttpRequest();}return xmlhttp;}
function nuevoEvento(evento){var divMensaje=document.getElementById("error");sconderuno=document.getElementById("esconderuno");sconderdos=document.getElementById("esconderdos");scondertres=document.getElementById("escondertres");var image=document.getElementById("img");if(evento=="verificacion"){var input=document.getElementById("verificacion");var valor=input.value;}input.disabled=true;image.style.display = "inline";sconderuno.style.display = "none";sconderdos.style.display = "none";scondertres.style.display = "none";var ajax=nuevoAjax();ajax.open("POST", "/ajax/pm-check.php", true);ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");ajax.send(evento+"="+valor);ajax.onreadystatechange=function(){if (ajax.readyState==4){input.disabled=false;image.style.display="none";sconderuno.style.display = "";sconderdos.style.display = "";scondertres.style.display = "";divMensaje.innerHTML=ajax.responseText;}}}

function validar_mp(para, mensaje){
if(para == ''){ $('#MostrarError1').show();  return false;} else $('#MostrarError1').hide();
if(mensaje == ''){ $('#MostrarError2').show();  return false;} else $('#MostrarError2').hide();
}
// ]]>
</script>

		<div id="mensajes-right">
			<div class="box_title_content">
				<div class="box_txt">
					Enviar un mensaje
				</div>
			</div>
			<div class="box_cuerpo_content">

				<form action="/pm-enviar" method="post" accept-charset="UTF-8" name="mensajero">
					<div class="m-col1">De:</div>

					<div class="m-col2"><strong><?=$logged['nick'];?></strong></div>
					<div class="clearfix"></div>
					<div class="m-col1">Para:</div>
					<div class="m-col2">
						<input onblur="nuevoEvento('verificacion');" id="verificacion" name="para" type="text" size="20" tabindex="1" maxlength="120" value="<?=$nick;?>"> <span class="size10">(Ingrese el nombre de usuario)</span> <img alt="" src="<?=$config['images'];?>/images/cargando.gif" style="display:none;" id="img"/>

						<div id="MostrarError1" class="capsprot">Debes indicar a quien le enviar&aacute;s el mensaje.</div>

						<div id="esconderuno" style="display:none;margin-top:6px;">
							<span id="esconderdos" style="display:none;" align="right" width="40%"></span>
							<span id="escondertres" style="display:none;"><div id="error"></div></span>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="m-col1">Asunto:</div>
					<div class="m-col2">

						<input onfocus="foco(this);" onblur="no_foco(this);" name="asunto" type="text" size="35" tabindex="2" maxlength="120" value="Re: <?=$qs['issue'];?>"> <span class="size10">(No es obligatorio)</span>
					</div>
					<div class="clearfix"></div>
					<div class="m-col1">Mensaje:</div>
					<div class="m-col2e">
						<textarea id="VPeditor" name="mensaje" rows="10" style="width:780px; height:200px;" tabindex="3"><?=$qs['body'];?></textarea>
<br class="space">		<div id="emoticons" style="float:left"><a href="#" smile=":bueno:"><img border="0" src="<?=$config['images'];?>/images/emoticons/bueno.png" alt="Bueno" title="Bueno" height="24" width="24" /></a><a href="#" smile=":malo:"><img border="0" src="<?=$config['images'];?>/images/emoticons/malo.png" alt="Malo" title="Malo" height="24" width="24" /></a><a href="#" smile=":muerto:"><img border="0" src="<?=$config['images'];?>/images/emoticons/muerto.png" alt="Muerto" title="Muerto" height="24" width="24" /></a><a href="#" smile=":divertido:"><img border="0" src="<?=$config['images'];?>/images/emoticons/divertido.png" alt="Divertido" title="Divertido" height="24" width="24" /></a><a href="#" smile=":sinister:"><img border="0" src="<?=$config['images'];?>/images/emoticons/sinister.png" alt="Siniestro" title="Siniestro" height="24" width="24" /></a><a href="#" smile=":D"><img border="0" src="<?=$config['images'];?>/images/emoticons/sonrisa.png" alt="Sonrisa" title="Sonrisa" height="24" width="24" /></a><a href="#" smile=":arrogante:"><img border="0" src="<?=$config['images'];?>/images/emoticons/arrogante.png" alt="Arrogante" title="Arrogante" height="24" width="24" /></a><a href="#" smile=":@"><img border="0" src="<?=$config['images'];?>/images/emoticons/enojado.png" alt="Enojado" title="Enojado" height="24" width="24" /></a><a href="#" smile=":relax:"><img border="0" src="<?=$config['images'];?>/images/emoticons/relax.png" alt="Relajado" title="Relajado" height="24" width="24" /></a><a href="#" smile=":ironico:"><img border="0" src="<?=$config['images'];?>/images/emoticons/ironico.png" alt="Ironico" title="Ironico" height="24" width="24" /></a><a href="#" smile=":confused:"><img border="0" src="<?=$config['images'];?>/images/emoticons/confused.png" alt="Confundido" title="Confundido" height="24" width="24" /></a><a href="#" smile=":shamed:"><img border="0" src="<?=$config['images'];?>/images/emoticons/shamed.png" alt="Vergonzoso" title="Vergonzoso" height="24" width="24" /></a><a href="#" smile=":disdain:"><img border="0" src="<?=$config['images'];?>/images/emoticons/disdain.png" alt="Disdain" title="Disdain" height="24" width="24" /></a><a href="#" smile=":("><img border="0" src="<?=$config['images'];?>/images/emoticons/triste.png" alt="Triste" title="Triste" height="24" width="24" /></a><a href="#" smile=":sarcastico:"><img border="0" src="<?=$config['images'];?>/images/emoticons/sarcastico.png" alt="Sarcastico" title="Sarcastico" height="24" width="24" /></a><a href="#" smile=":-)"><img border="0" src="<?=$config['images'];?>/images/emoticons/feliz.png" alt="Feliz" title="Feliz" height="24" width="24" /></a><a href="#" smile=":lost:"><img border="0" src="<?=$config['images'];?>/images/emoticons/lost.png" alt="Perdido" title="Perdido" height="24" width="24" /></a><a href="#" smile=":shock:"><img border="0" src="<?=$config['images'];?>/images/emoticons/shock.png" alt="Shock" title="Shock" height="24" width="24" /></a><a href="#" smile=":llorar:"><img border="0" src="<?=$config['images'];?>/images/emoticons/llorar.png" alt="Llorando" title="Llorando" height="24" width="24" /></a><a href="#" smile=":pirata:"><img border="0" src="<?=$config['images'];?>/images/emoticons/pirata.png" alt="Pirata" title="Pirata" height="24" width="24" /></a><a href="#" smile=":devil:"><img border="0" src="<?=$config['images'];?>/images/emoticons/devil.png" alt="Diablo" title="Diablo" height="24" width="24" /></a><a href="#" smile=":loser:"><img border="0" src="<?=$config['images'];?>/images/emoticons/loser.png" alt="Perdedor" title="Perdedor" height="24" width="24" /></a><a href="#" smile=":ask:"><img border="0" src="<?=$config['images'];?>/images/emoticons/ask.png" alt="Pregunta" title="Pregunta" height="24" width="24" /></a></div><div class="clear"></div>

						<div id="MostrarError2" class="capsprot">El mensaje es obligatorio.</div>
                    <?php
                    if(allow('show_panel')) { echo '<font class="size11"><b><br>Mensaje de moderaci&oacute;n:</b></font><br><a href="javascript:void(0);" onclick="insertText(\'Hola!\n\nLe informamos que usted esta corrumpiendo el protocolo escribiendo un texto entero en MAYUSCULA\n\nPara acceder al protocolo, presiona [url=/static/protocolo/]este enlace[/url].\n\nMuchas gracias por entender!\', document.forms.mensajero.VPeditor); return false;"><img src="'.$config['images'].'/images/edit2.png" align="absmiddle" alt="Mayusculas" title="Mayusculas" /></a> | <a href="javascript:void(0);" onclick="replaceText(\'Hola!\nLamento contarte que tu post titulado [b]TITULO DEL POST[/b] ha sido eliminado.\n Causa: [b]CAUSA[/b], \nPara acceder al protocolo, presiona este [url=/static/protocolo/]enlace[/url].\nMuchas gracias por entender!\', document.forms.mensajero.VPeditor); return false;"><img src="'.$config['images'].'/images/cross.png" align="absmiddle" alt="Post eliminado" title="Post eliminado" /></a><br />'; }
                    ?>

                    <br /><input onclick="return validar_mp(this.form.para.value,this.form.mensaje.value);" class="Boton BtnGreen" tabindex="5" type="submit" value="Enviar mensaje" />

					</div><input type="hidden" value="<?=$logged['id'];?>" name="de">
				</form>
				<div class="clear"></div>
			</div>
		</div>
<div class="clearBoth"></div><div style="clear:both"></div></div>
	</div>