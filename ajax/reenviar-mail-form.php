<?php
include('../config.php');
include('../functions.php');
if($logged['id']) { die('0Est&aacute;s logueado cabeza'); }
?>
<script type="text/javascript" src="http://o1.t26.net/images/js/es/registro.js?1.4"></script>
<script type="text/javascript">
//Envia el mail (comentarios tipos de manolo -sisi)
function mail_send() {
  var mail = $('#email').val();
  var captcha = $('#recaptcha_response_field').val();
  var captcha2 = $('#recaptcha_challenge_field').val();
  if(!mail || !captcha) { return alert('Faltan datos'); }
  $.ajax({
    beforeSend: function() { dialogBox.procesando_inicio('Enviando...', 'Enviar mensaje'); },
    type: 'POST',
    url: '/ajax/forward-mail.php',
    data: 'mail=' + mail + '&recaptcha_response_field=' + captcha + '&recaptcha_challenge_field=' + captcha2,
    success: function(t) {
      if(t.charAt(0) == '0') {
        dialogBox.alert('Error', t.substring(1));
      } else {
        dialogBox.alert('Mail enviado!', t.substring(1));
      }
    },
    complete: function() {
      dialogBox.procesando_fin();
    },
    error: function() {
      alert('La puta madre negro');
    }
  });
}
//Trae captcha
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
</script>
	<div align="left" style="font-size:12px">
		<div align="center">
                   Ingresa el email con el que te registraste y te lo reenviaremos.<br />
		<br />
			<div class="form-line">
                            <label for="email">E-mail:</label>
                            <input type="text" size="30" name="email" tabindex="1" id="email"/>
                            <div class="help"><span><em></em></span></div>
                        </div>
			<br />
			<div class="form-line">
                            <label for="recaptcha_response_field">Ingresa el c&oacute;digo de la imagen:</label>
                            <div id="recaptcha_ajax">
                                    <div id="recaptcha_image"></div>
                                    <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
                            </div> <div class="help recaptcha"><span><em></em></span></div>
                        </div>
		</div>
	</div>