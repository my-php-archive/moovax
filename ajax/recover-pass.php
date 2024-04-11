<?php
if(!$_POST['email'] || !$_POST['recaptcha_response_field']) { die('0: Faltan datos'); }
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { die('0: El mail especificado no es v&aacute;lido'); }
include('../config.php');
include('../functions.php');
if($logged['id']) { die('0: No puedes realizar esta acci&oacute;n estando logueado'); }
include('../recaptchalib.php');
$resp = recaptcha_check_answer($config['recaptcha_privatekey'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
if(!$resp->is_valid) { die('0: El captcha ingresado no es correcto'); }
if(!mysql_num_rows($qqq = mysql_query('SELECT `id`, `nick`, `act`, `ban`, `email` FROM `users` WHERE `email` = \''.mysql_clean($_POST['email']).'\''))) { die('0: No se encontraron usuarios pendientes de activaci&oacute;n'); }
$rq = mysql_fetch_row($qqq);
if($rq[2] == 0) { die('0: El usuario no a activado su cuenta'); }
if($rq[3] == 1) { die('0: Esta cuenta se encuentra suspendida'); }
//if(mysql_num_rows(mysql_query('SELECT `id` FROM `mails` WHERE `mail` = \''.$rq[4].'\' && `type` = \'1\' && time > \''.(time()-1800).'\''))) { die('0: Para realizar otro cambio de contrase&ntilde;a debe esperar 30 minutos'); }
$hash = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
$m = rand(10, 16);
shuffle($hash);
$ha = '';
do {
  for($i=0;$i<$m;$i++) {
    $ha .= $hash[$i];
  }
} while(mysql_num_rows(mysql_query('SELECT `id` FROM `mails` WHERE `hash` = \''.$ha.'\'')));
mysql_query('INSERT INTO `mails` (`id_user`, `mail`, `time`, `type`, `hash`) VALUES (\''.$rq[0].'\', \''.$rq[4].'\', \''.time().'\', \'1\', \''.$ha.'\')') or die('0: '.mysql_error());

$headers = 'From: '.$config['mail']."\r\n".'Reply-To: '.$config['name']."\r\n".'Content-Type: text/html; charset=utf-8'."\r \n".'X-Mailer: PHP/'.phpversion();  

$body = '<div style="background-color:#c9d7f9;padding:8px">'."\n";
$body .= '<img onclick="onClickUnsafeLink(event);" title="'.$config['name'].'" src="http://gfx1.hotmail.com/mail/w4/pr04/ltr/i_safe.gif">'."\n";
$body .= '<div style="background-color:#FFFFFF;padding:10px">'."\n";
$body .= '<b>Hola!</b>'."\n";
$body .= '<br><br>&iexcl;Hola '.$rq[1].'!'."\n";
$body .= '<br><br>Has solicitado un enlace de recordatorio de tu contrase&ntilde;a en '.$config['name'].'. Por favor haz clic en el enlace proporcionado para <b>recuperar tu contrase&ntilde;a</b>:'."\n";
$body .= '<br><div style="padding:12px"><a onclick="onClickUnsafeLink(event);" target="_blank" href="'.$config['url'].'/recuperar-pass/'.$ha.'/'.str_replace('@', '-', $rq[4]).'">Click ac&aacute;!</a></div>'."\n";
$body .= '<br><br>'."\n";
$body .= '<b>Esperamos tenerte de nuevo en '.$config['name'].''."\n";
$body .= '<br><br><b style="font-size:14px">Este email est&aacute; destinado a: '.$rq[4].'</b>'."\n";
$body .= '</b></div><b></b></div>';

@mail($rq[4], 'Restablecer contraseña en '.$config['name'], $body, $headers);
echo '1: Se ha enviado exitosamente un email a '.$rq[4].' con los pasos para renovar tu contraseña.';