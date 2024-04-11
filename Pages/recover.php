<?php
if(!defined($config['define'])) { die; }
if(!$_GET['hash']) { fatal_error('0: Faltan datos'); }
mysql_query('DELETE FROM `mails` WHERE `time` < \''.(time()-86400).'\' && `type` = \'1\'');
if($logged['id']) { fatal_error('Chupala'); }
if(!mysql_num_rows($ppp = mysql_query('SELECT `id`, `id_user`, `hash`, `mail` FROM `mails` WHERE `hash` = \''.mysql_clean($_GET['hash']).'\' && `type` = \'1\' && `mail` = \''.str_replace('-', '@', $_GET['mail']).'\''))) { fatal_error('El hash ingresado no pudo ser encontrado'); }
$ot = mysql_fetch_row($ppp);
if(!mysql_num_rows($us = mysql_query('SELECT `id`, `ban` FROM `users` WHERE `id` = \''.$ot[1].'\''))) { fatal_error('Inglip'); }
list($id_user, $ban) = mysql_fetch_row($us);
if($ban == 1) { fatal_error('La cuenta se encuentra baneada'); }
//TUT !
?>
<div class="breadcrumb">
    <ul>
	    <li class="first"><a href="/" accesskey="1" class="home"></a></li>
		<li><a href="/recuperar-pass/<?=$ot[2];?>/<?=$_GET['mail'];?>">Restablecer contrase&ntilde;a</a></li>
		<li class="last"></li>
	</ul>
</div>
<div class="clear"></div>
<div id="reg-left">
    <div id="ajax_loading" class="displayN"  align="center">
	    <img src="<?=$config['images'];?>/images/loading.gif" border="0" alt="Cargando..." title="Cargando..." /><br><span class="size14" style="color:#909090;font-weight:bold">Restableciendo...</span>
	</div>
	<div id="return_ajax">
    	<div class="boxtitleProfile clearfix">
    	    <h3>Restablecer tu contrase&ntilde;a</h3>
    	</div>
    	<div class="floatL">
            <input type="hidden" id="id" name="id" value="<?=$ot[2];?>" />
            <input type="hidden" id="mail" name="mail" value="<?=$ot[3];?>" />
    		<table>
    		    <tr>
    			    <td style="text-align:right;">
    				    <span class="reg-fonts">Nueva contrase&ntilde;a</span>
    				</td>
    				<td>
    				    <input class="text_field" id="pass1" name="pass1" size="30" maxlength="150" style="width:230px" tabindex="2" type="password" />
    				</td>
    			</tr>
    		    <tr>
    			    <td style="text-align:right;">
    				    <span class="reg-fonts">Confirmar contrase&ntilde;a</span>
    				</td>
    				<td>
    				    <input class="text_field" id="pass2" name="pass2" size="30" maxlength="30" maxlength="150" style="width:230px" tabindex="4" type="password" />
    				</td>
    			</tr>
    		</table>
    	</div>
    	<div class="clear"></div>
    	<br class="space">
        <div align="center">
    	    <input class="Boton BtnGray" onclick="accounts.restore_pass();return false" type="button" value="Guardar contrase&ntilde;a" title="Enviar informaci&oacute;n">
    	</div>
	</div>
</div>
<div id="reg-right">
    <div align="center"><div align="center" id="ads_300x250"></div></div>
</div>
<div class="clearBoth"></div><div style="clear:both"></div></div></div>