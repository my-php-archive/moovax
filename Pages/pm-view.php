<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('Debes loguearte gato'); }
if(!$_GET['id']) { fatal_error('El campo <b>id del mensaje</b> es requerido'); }
if(!mysql_num_rows($query = mysql_query('SELECT m.*, u.nick, u.avatar FROM `messages` AS m INNER JOIN `users` AS u ON u.id = m.author WHERE m.id = \''.intval($_GET['id']).'\''))) { fatal_error('El mensaje no existe'); }
$az = mysql_fetch_assoc($query);
if($az['author'] != $logged['id'] && $az['receiver'] != $logged['id']) { fatal_error('El mensaje no te pertence, pete'); }
if($az['author'] == $logged['id'] && $az['receiver'] != $logged['id']) {
  mysql_query('UPDATE `messages` SET `author_read` = \'1\' WHERE `id` = \''.$az['id'].'\'') or die(mysql_error());
} else {
  mysql_query('UPDATE `messages` SET `receiver_read` = \'1\' WHERE `id` = \''.$az['id'].'\'');
}
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
<div id="mensajes-right">
			<div class="box_title_content">

				<div class="box_txt">
					Leyendo: <?=$az['issue'];?>
				</div>
			</div>
			<div class="box_cuerpo_content">
				<div class="m-col1">De:</div>
				<div class="m-col2"><strong><a href="/<?=$az['nick'];?>" alt="Ver Perfil" title="Ver Perfil">@<?=$az['nick'];?></a></strong></div>
				<div class="clearfix"></div>

				<div class="m-col1">Recibido:</div>
				<div class="m-col2"><?=timefrom($az['time']);?></div>
				<div class="clearfix"></div>
				<div class="m-col1">Asunto:</div>
				<div class="m-col2"><?=$az['issue'];?></div>
				<div class="clearfix"></div>
				<div class="m-col1">Mensaje:</div>
				<div class="m-col2m"><br><?=BBposts($az['body']);?></div>
                <br clear="left">
            </div>
			<div align="right" style="margin-top:6px;">
				<input class="Boton BtnRed" onclick="location.href='/mensajes/borrar/<?=$az['id'];?>'" value="Borrar" title="Borrar" type="button" />

				<input class="Boton BtnGreen" onclick="location.href='/mensajes/responder/<?=$az['id'];?>'" value="Responder" title="Responder" type="button" />
				<input class="Boton BtnBlue" onclick="location.href='/mensajes/marcar-no-leido/<?=$az['id'];?>'" value="Marcar como no le&iacute;do" title="Marcar como no le&iacute;do" type="button" />

			</div>
		</div>
<div class="clearBoth"></div>
<div style="clear:both"></div></div>
</div>