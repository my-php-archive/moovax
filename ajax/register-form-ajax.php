<?php
include('../config.php');
include('../functions.php');
if($key) { die('0: Usted ya es usuario de '.$config['name']); }
?>
1:
<div id="RegistroForm">
		<div class="barra_progreso">
		<div class="progreso"><span id="progreso">0%</span></div>
		</div>
	<!-- Paso Uno -->

	<div class="pasoUno">
    <a href="javascript:;" class="form-reenvio" style="font-size: 10px; font-weight: bold; display: block; margin: 0 0 10px">¿Te registraste y no recibiste el e-mail de confirmación?</a>

		<div class="form-line">

			<label for="nick">Ingresa tu usuario</label>

			<input type="text" id="nick" name="nick" tabindex="1" onblur="registro.blur(this)" onfocus="registro.focus(this)" onkeyup="registro.set_time(this.name)" onkeydown="registro.clear_time(this.name)" autocomplete="off" title="Ingrese un nombre de usuario &uacute;nico" /> <div class="infoTip"><span><em></em></span></div>

		</div>



		<div class="form-line">

			<label for="password">Contrase&ntilde;a deseada</label>

			<input type="password" id="password" name="password" tabindex="2" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingresa una contrase&ntilde;a segura" /> <div class="infoTip"><span><em></em></span></div>

		</div>



		<div class="form-line">

			<label for="password2">Confirme contrase&ntilde;a</label>



			<input type="password" id="password2" name="password2" tabindex="3" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Vuelve a ingresar la contrase&ntilde;a" /> <div class="infoTip"><span><em></em></span></div>

		</div>



		<div class="form-line">

			<label for="email">E-mail</label>

			<input type="text" id="email" name="email" tabindex="4" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingresa tu direcci&oacute;n de email" /> <div class="infoTip"><span><em></em></span></div>

		</div>



		<div class="form-line">

			<label>Fecha de nacimiento</label>

			<select id="dia" name="dia" tabindex="5" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese d&iacute;iacute;a de nacimiento">

				<option value="">D&iacute;a</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>



			<select id="mes" name="mes" tabindex="6" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese mes de nacimiento">

				<option value="">Mes</option>

				<option value="01">Enero</option>

				<option value="02">Febrero</option>

				<option value="03">Marzo</option>

				<option value="04">Abril</option>



				<option value="05">Mayo</option>

				<option value="06">Junio</option>

				<option value="07">Julio</option>

				<option value="08">Agosto</option>

				<option value="09">Septiembre</option>

				<option value="10">Octubre</option>



				<option value="11">Noviembre</option>

				<option value="12">Diciembre</option>

			</select>

			<select id="anio" name="anio" tabindex="7" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese a&ntilde;o de nacimiento">
            <option value="">A&ntilde;o</option>
            <?php
            for($i=date('Y')-$config['years'];$i>=1900;$i--) {
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
			</select>

				<div class="infoTip"><span><em></em></span></div>



		</div>

		<div class="clearfix"></div>

	</div>



	<!-- Paso Dos -->

	<div class="pasoDos">

		<div class="form-line">
			<label for="sexo">Sexo</label>
			<input class="radio" type="radio" id="sexo_m" tabindex="8" name="sexo" value="m" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese el sexo" /> <label class="list-label" for="sexo_m">Masculino</label>
			<input class="radio" type="radio" id="sexo_f" tabindex="8" name="sexo" value="f" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese el sexo" /> <label class="list-label" for="sexo_f">Femenino</label>
			<div class="infoTip"><span><em></em></span></div>
		</div>



		<div class="form-line">

			<label for="pais">Pa&iacute;s</label>



			<select id="pais" name="pais" tabindex="9" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese su pa&iacute;s">

				<option value="">Pa&iacute;s</option>
                <?php
                error_reporting(0);
                $ip = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDED_FOR'];
                $r = file_get_contents('http://api.hostip.info/get_json.php?ip='.$ip);
                $data = json_decode($r, true);
                $query = mysql_query('SELECT `id`, `name`, `img_pais` FROM `countries` ORDER BY `name` ASC');
                while($r = mysql_fetch_row($query)) {
                  echo '<option value="'.$r[0].'"'.($r[2] == strtolower($data['country_code']) || strcasecmp($r[1], $data['country_name']) == 0 ? ' selected="selected"' : '').'>'.utf8_encode($r[1]).'</option>';
                }
                ?>

</select> <div class="infoTip"><span><em></em></span></div>

		</div>



		<div class="form-line">

			<label for="ciudad">Ciudad</label>

			<input type="text" id="ciudad" name="ciudad" tabindex="11" onblur="registro.blur(this)" onfocus="registro.focus(this)" autocomplete="off" title="Ingrese su ciudad" /> <div class="infoTip"><span><em></em></span></div>

		</div>

		<div class="form-line">

			<label for="recaptcha_response_field">Ingresa el c&oacute;digo de la imagen:</label>

			<div id="recaptcha_ajax">

				<div id="recaptcha_image"></div>

				<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />

			</div> <div class="infoTip recaptcha"><span><em></em></span></div>

		</div>



		<div class="footerReg">

			<div class="form-line">

				<input type="checkbox" class="checkbox" id="terminos" name="terminos" tabindex="14" onblur="registro.blur(this)" onfocus="registro.focus(this)" title="Acepta los T&eacute;rminos y Condiciones?" /> <label class="list-label" for="terminos">Acepto los <a href="/static/terminos/" target="_blank">T&eacute;rminos de uso</a></label> <div class="infoTip"><span><em></em></span></div>

			</div>

		</div>

	</div>



</div>



<script type="text/javascript">
//Load JS
$.getScript("<?=$config['url'];?>/js/register.js", function(){});
//Load recaptcha
$.getScript("http://api.recaptcha.net/js/recaptcha_ajax.js", function(){
	Recaptcha.create('<?=$config['recaptcha_publickey'];?>', 'recaptcha_ajax', {
		theme:'custom', lang:'es', tabindex:'13', custom_theme_widget: 'recaptcha_ajax',
		callback: function(){
			$('#recaptcha_response_field').blur(function(){
				registro.blur(this);
			}).focus(function(){
				registro.focus(this);
			}).attr('title', 'Ingrese el c&oacute;digo de la imagen');
		}
	});
});
//Formulario de reenvío de mail
$('.form-reenvio').click(function(){
  dialogBox.procesando_inicio('Cargando...', 'Reenviar email de confirmación');
     $.ajax({
            type: 'post',
            url: '/ajax/reenviar-mail-form.php',
            success: function(r) {
                dialogBox.show();
                dialogBox.title('Reenviar email de confirmación');
                dialogBox.body(r);
                dialogBox.buttons(true, true, 'Reenviar mail', "mail_send()", true, true, true);
                dialogBox.center();
            },
            error: function() { alert('La concha de tu madre'); },
            complete: function() { dialogBox.procesando_fin(); }
    });
});
</script>