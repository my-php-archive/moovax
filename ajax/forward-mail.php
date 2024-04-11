<?php
if(!$_POST['mail'] || !$_POST['recaptcha_response_field']) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if($logged['id']) { die('0Est&aacute;s logueado cabeza'); }
if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) { die('0El mail ingresado no es v&aacute;lido'); }
include('../recaptchalib.php');
$resp = recaptcha_check_answer($config['recaptcha_privatekey'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
if(!$resp->is_valid) { die('0El captcha ingresado no es correcto'); }
if(!mysql_num_rows($mm = mysql_query('SELECT `id`, `id_user`, `mail`, `hash` FROM `mails` WHERE `mail` = \''.mysql_clean($_POST['mail']).'\''))) { die('0No se encontr&oacute; el mail ingresado'); }
$ha = mysql_fetch_assoc($mm);
$qm = mysql_fetch_row(mysql_query('SELECT `id`, `act`, `ban`, `nick` FROM `users` WHERE `id` = \''.$ha['id_user'].'\''));
if($m[1] == '1') { die('0Este usuario ya fue activado'); }
if($m[2] == '1') { die('0El usuario se encuentra baneado'); }
$issue = 'Registro en '.$config['name'];
$mail = '<div style="background-color:#cccccc;padding:8px"><div class="adM">'."\n";
$mail .= '</div><img src="https://confluence.prodevelop.es/download/userResources/MMW/logo" title="'.$config['name'].'">'."\n";
$mail .= '<div style="background-color:#ffffff;padding:10px">'."\n";
$mail .= '<b>Hola '.$qm[3].'!</b>'."\n";
$mail .= '<br><br>&iexcl;Te damos la bienvenida a '.$config['name']."\n";
$mail .= '<br><br>Para activar tu cuenta debes hacer clic <a href="'.$config['url'].'/activate/'.$ha['hash'].'/'.str_replace('@', '-', $ha['mail']).'" target="_blank">aqu&iacute;</a>'."\n";
$mail .= '<br><br>Antes de empezar a participar en la comunidad, te recomendamos que visites el siguiente enlace para que te informes sobre las normas de '.$config['name'].' y as&iacute; evitar futuros problemas: <a href="'.$config['url'].'/protocolo/" target="_blank">click ac&aacute;</a>'."\n";
$mail .= '<br><br>&iexcl;Muchas gracias!'."\n";
$mail .= '<br><br>El staff de '.$config['name'].'.'."\n";
$mail .= '</div><div class="yj6qo"></div><div class="adL">'."\n";
$mail .= '</div></div>';
$headers = 'From: '.$config['mail']."\r\n".'Reply-To: '.$config['name']."\r\n".'Content-Type: text/html; charset=utf-8'."\r \n".'X-Mailer: PHP/'.phpversion();
@mail($ha['mail'], $issue, $mail, $headers);
echo '1Se a enviado un mail a '.$ha['mail'].' con los datos necesarios para activar tu cuenta';