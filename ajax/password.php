<?php
if(!defined($config['define'])) { die; }
if($logged['id']) { fatal_error('Qu&eacute; intent&aacute;s?'); }
?>
<div class="breadcrumb">
    <ul>
	    <li class="first"><a href="/" accesskey="1" class="home"></a></li>
		<li><a href="/recuperar-pass/">Recuperar mi password</a></li>
		<li class="last"></li>
	</ul>
</div>
<div class="clear"></div>

<form action="" method="post" accept-charset="UTF-8" name="recuperar-pass" id="recuperar-pass">
	<div id="error-content" style="width:380px">
	    <div class="box_title_content">
		    <div class="box_txt">Recordatorio de contrase&ntilde;a</div>
		</div>
		<div class="box_cuerpo_content">
		    <div id="ajax_loading" class="displayN"  align="center">
			    <img src="<?=$config['images'];?>/images/loading.gif" border="0" alt="Cargando..." title="Cargando..." /><br><span class="size14" style="color:#909090;font-weight:bold">Enviando...</span>
			</div>
			<div id="return_ajax">
			    En este formulario podr&aacute;s encontrar la forma de recuperar tu contrase&ntilde;a, s&oacute;lo complet&aacute; el campo con la direcci&oacute;n de email que utilizastes al registrarte y se te enviar&aacute; a tu correo.
				<hr class="divider">
				<div align="center">
					<br>
					<div align="left"><b>Ingres&aacute; tu email:</b></div>
					<input type="text" name="email" id="email" size="65">
					<br>
					<br>
					<script type="text/javascript">
					var RecaptchaOptions = {
					    theme : 'red',
					};
					</script>
					<script type="text/javascript"
					    src="http://api.recaptcha.net/challenge?k=6Ld7uL0SAAAAAGZcCTk-sgAMpXBqlNgF1h2HB0At">
					</script>
                    <?php
                    include('../recaptchalib.php');
                    echo recaptcha_get_html($config['recaptcha_publickey']);
                    ?>
				</div>
				<br />
				<div align="right">
				    <input class="Boton BtnBlue" onclick="accounts.recuperar_pass(); return false;" value="Enviar email" type="button" />
				</div>
			</div>

		</div>
	</div>
</form>
<br><br>
<center><center></center></center><br><div style="clear:both"></div></div>
</div>