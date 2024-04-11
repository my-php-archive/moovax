<?php
if(!defined($config['define'])) { die; }
$ip = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDED_FOR'];
if(!filter_var($ip, FILTER_VALIDATE_IP)) { fatal_error('No puedes contactarte'); }
?>
<div class="breadcrumb">
<ul>
<li class="first"><a href="/" accesskey="1" class="home"></a></li>
<li><a href="/static/contactanos/">Formulario de cont&aacute;cto</a></li>
<li class="last"></li>
</ul>
</div>
<div class="clear"></div>
<form action="" method="post" accept-charset="UTF-8" name="ctt" id="ctt">
<div id="reg-left">
<div id="return_contact" class="displayN"></div>
<div id="contact_form">
<div class="boxtitleProfile clearfix">
<h3>Cont&aacute;ctar con <?=$config['name'];?></h3>
</div>
<div class="floatL">
<table>
<tr>
<td style="text-align:right;">
<span class="reg-fonts">Nombre completo</span>
</td>
<td>
<input class="text_field" id="nombre" name="nombre" size="30" style="width:230px" maxlength="150" tabindex="1" type="text" />
</td>
</tr>
<tr>
<td style="text-align:right;">
<span class="reg-fonts">Email v&aacute;lido</span>
</td>
<td>
<input class="text_field" id="email" name="email" size="30" maxlength="150" style="width:230px" tabindex="2" type="text" />
</td>
</tr>
<tr>
<td style="text-align:right;">
<span class="reg-fonts">Empresa u oficina</span>
</td>
<td>
<input class="text_field" id="empresa" name="empresa" size="30" maxlength="30" maxlength="150" style="width:230px" tabindex="4" type="text" />
</td>
</tr>
<tr>
<td style="text-align:right;">
<span class="reg-fonts">Horario de cont&aacute;cto</span>
</td>
<td>

<input class="text_field" id="horario" name="horario" maxlength="30" maxlength="150" style="width:230px" tabindex="5" type="text" />
</td>
</tr>
<tr>
<td style="text-align:right;">
<span class="reg-fonts">Motivo del contacto</span><br />
</td>
<td style="padding:4px;">

<select name="motivo" id="motivo" style="width:200px">
<option value="-1" selected="true">Selecciona el motivo</option>
<option value="1">Publicidad</option>
<option value="2">Sugerencias</option>
<option value="3">Peticiones</option>
<option value="4">Errores</option>
<option value="5">Otros</option>
</select>
</td>
</tr>
<tr>
<td style="text-align:right;">
<span class="reg-fonts">Comentario</span><br />
</td>

<td style="padding:4px;">
<textarea class="text_field" name="comentario" id="comentario" style="width:240px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;height:60px"></textarea>
</td>
</tr>
</table>
<table>
<tr>

<td style="text-align:right;">

<span class="reg-fonts">C&oacute;digo de la im&aacute;gen</span>
</td>
<td><script type="text/javascript">
var RecaptchaOptions = {
theme : 'blue',
};
</script>
<script type="text/javascript"
src="http://api.recaptcha.net/challenge?k=<?=$config['recaptcha_publickey'];?>">
</script>

<noscript>
<iframe src="http://api.recaptcha.net/noscript?k=<?=$config['recaptcha_publickey'];?>"
height="300" width="500" frameborder="0"></iframe><br />
<textarea id="recaptcha" name="recaptcha_challenge_field" rows="3" cols="40">
</textarea>
<input type="hidden" name="recaptcha_response_field"
value="manual_challenge" />
</noscript>

</td>

<td>
</td>
</tr>
</table>
</div>
<div class="clear"></div>
<br class="space"><div align="center">

<input class="Boton BtnGray" onclick="web.contact_form();return false" type="button" value="Enviar informaci&oacute;n" title="Enviar informaci&oacute;n">
</div>
</div>
</div>
</form>

<div id="reg-right">
<div class="boxtitleProfile clearfix">
<h3>Para contactar con <?=$config['name'];?></h3>

</div>
Para contactar con la administraci&oacute;n de <b><?=$config['name'];?></b>, solo debes de rellenar los campos presentados teniendo en cuenta que toda la informaci&oacute;n enviada es confidencial y no ser&aacute; mostrada a terceros.
<br /><br />Una vez enviada la informaci&oacute;n, la adminsitraci&oacute;n del sitio se pondr&aacute; en contacto contigo.
<br><br>
<b class="size10">Notas:<br><span style="font-weight:normal">
<span class="BulletIcons verde"></span> La direcci&oacute;n de email debe de ser v&aacute;lida.
<br><span class="BulletIcons rojo"></span> Tu direcci&oacute;n IP (<?=$ip;?>) ser&aacute; almacenada por seguridad</span></b>

<hr class="divider">
<div align="center"><div align="center" id="ads_300x250"></div></div>
</div><div class="clearBoth"></div>
<div style="clear:both"></div></div>
</div>