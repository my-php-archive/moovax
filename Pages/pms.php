<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('Debes loguearte para realizar esta acci&oacute;n'); }
if(!$_GET['action']) { $_GET['action'] = 'recibidos'; }
if(!in_array($_GET['action'], array('recibidos', 'enviados', 'eliminados'))) { fatal_error('Error'); }
if($_GET['action'] == 'recibidos') {
  $where = '`m`.`receiver` = \''.$logged['id'].'\' && `m`.`receiver_status` = \'0\'';
  $sa = 'entrada';
  $title = '&Uacute;ltimos mensajes';
} elseif($_GET['action'] == 'enviados') {
  $where = '`m`.`author` = \''.$logged['id'].'\' && `m`.`author_status` = \'0\'';
  $sa = 'salida';
  $title = 'Mensajes enviados';
  //West otra vez salva el d&iacute;a .___.
} else { $where = '(`m`.`receiver` = \''.$logged['id'].'\' && `m`.`receiver_status` = \'1\') || (`m`.`author_status` = \'1\' && `m`.`author` = \''.$logged['id'].'\')'; $sa = 'eliminados'; $title = 'Mensajes eliminados'; }
$psm = 'SELECT m.*, u.id as uid, u.nick FROM `messages` AS m INNER JOIN `users` AS u ON IF(`m`.`author` = \''.$logged['id'].'\', `m`.`receiver`, `m`.`author`) = `u`.`id` WHERE '.$where.' ORDER BY `m`.`id` DESC';
$pzm = mysql_num_rows(mysql_query($psm));
$per = 20;
$tot = ceil($pzm / $per);
$_GET['p'] = ctype_digit($_GET['p']) && $_GET['p'] <= $tot ? $_GET['p'] : 1; //Sapeee
$act = ($_GET['p']-1)*$per;
$query = mysql_query($psm.' LIMIT '.$act.', '.$per) or die(mysql_error());
?>
<div id="mensajes-left">
    <div class="clearBoth"></div>
    <div style="border:1px solid #CCCCCC;background-color:#EEEEEE;padding:6px;">
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
			<div class="mp-content"<?=($_GET['action'] == 'recibidos' ? ' style="background:#FFFFCC"' : '');?>>
				<div class="mp-img"><img src="<?=$config['images'];?>/images/mensajes/recibidos.png" alt="Mensajes Recibidos" /></div>
				<div class="mp-txt">
					<strong>Mensajes Recibidos</strong>
					Ver mi buz&oacute;n de entrada.
				</div>
			</div>
		</a>
		<a href="/mensajes/enviados/" title="Mensajes Enviados">
			<div class="mp-content"<?=($_GET['action'] == 'enviados' ? ' style="background:#FFFFCC"' : '');?>>
				<div class="mp-img"><img src="<?=$config['images'];?>/images/mensajes/enviados.png" alt="Mensajes Enviados" /></div>
				<div class="mp-txt">
					<strong>Mensajes Enviados</strong>
					Ver mis buz&oacute;n de salida.
				</div>
			</div>
		</a>
		<a href="/mensajes/eliminados/" title="Mensajes Eliminados">
			<div class="mp-content"<?=($_GET['action'] == 'eliminados' ? ' style="background:#FFFFCC"' : '');?>>
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
	    <div class="box_txt"><?=$title;?></div>
	</div>
    <?php
    if(mysql_num_rows($query)) {
    ?>
	<table class="linksList">
	    <thead>
    		<tr>
        		<th>Estado</th>
        		<th>Asunto</th>
        		<th><?=($_GET['action'] != 'enviados' ? 'Remitente' : 'Receptor');?></th>
        		<th>Recibido</th>
        		<th>Eliminar</th>
    		</tr>
		</thead>
		<tbody>
        <?php
        while($rms = mysql_fetch_assoc($query)) {
        ?>
        <tr id="mensaje_inbox_<?=$rms['id'];?>"<?=($rms[($_GET['action'] != 'recibidos' ? 'author' : 'receiver').'_read'] == '0' ? ' style="background:#FFFFCC"' : '');?>>
            <td style="width: 16px;" id="tipsy_right"><a href="/mensajes/leer/<?=$rms['id'];?>/" alt="Leer mensaje" title="Leer mensaje"><img src="<?=$config['images'];?>/images/icons/oldms.gif" border="0" align="absmiddle"></a></td>
            <td style="text-align: left;" id="tipsy_right"><a original-title="Leer: <?=$rms['issue'];?>" href="/mensajes/leer/<?=$rms['id'];?>/"><?=$rms['issue'];?></a></td>
			<td style="width: 140px;"><a href="/<?=$rms['nick'];?>" title="Ver perfil" alt="Ver perfil">@<?=$rms['nick'];?></a></td>
			<td style="width: 160px;"><?=timefrom($rms['time']);?></td>
            <td width="40px"><a onclick="mp.del_inbox('<?=$rms['id'];?>'); return false" title="Borrar este mensaje"><img src="<?=$config['images'];?>/images/cross.png" border="0" id="del_mp_<?=$rms['id'];?>"></a></td>
		</tr>
        <?php
        }
        ?>
        </tbody>
	</table>
    <hr class="divider">
    <?php
    if($_GET['p'] > 1) { echo '<span class="size12 floatL" style="font-weight:bold;"><a title="P&aacute;gina anterior" href=\'/mensajes/'.$_GET['action'].'/page/'.($_GET['p'] - 1).'\'>&#171; Anteriores</a></span>'; }
    if($_GET['p'] < $tot) { echo '<span class="size12 floatR" style="font-weight:bold;"><a title="P&aacute;gina siguiente"  href=\'/mensajes/'.$_GET['action'].'/page/'.($_GET['p'] + 1).'\'>Siguientes &#187;</a></span>'; }
    } else { echo '<div style="background-color:#FFF;" class="box_cuerpo_content"><div class="redBox">No tienes mensajes en tu bandeja de '.$sa.'</div></div>'; }
    ?>
</div>
<div class="clearBoth"></div>
<div style="clear:both"></div>
</div>
</div>