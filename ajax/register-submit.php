<?php
if(!$_POST['nick']) { die('nick: El campo es requerido'); }
if(!$_POST['password']) { die('password: El campo es requerido'); }
//if(!$_POST['sexo']) { die('sexo: Faltan datos'); }
if(!$_POST['email'] || !$_POST['dia'] || !$_POST['anio'] || !$_POST['sexo'] || !$_POST['pais'] || !$_POST['ciudad']) { die('recaptcha: Faltan datos'); }
include('../config.php');
include('../functions.php');
if($key) { die('0: Ya estas logueado :noo:'); }
if(!preg_match('/^[a-z0-9\-\_]{4,16}$/i', $_POST['nick'])) { die('nick: El nick ingresado no es correcto'); }
if(mysql_num_rows(mysql_query('SELECT id FROM users WHERE `nick` = \''.mysql_clean($_POST['nick']).'\''))) { die('nick: El nick se encuentra en uso -sisi'); }
if(strlen($_POST['password']) < 4 || strlen($_POST['password']) > 35) { die('password: El campo debe de tener entre 4 a 35 caracteres'); }
//if(strpos($_POST['password'], '123') !== false) { die('password: No es seguro'); }
if($_POST['password'] == '123456789' || $_POST['password'] == '123456') { die('password: No seguro'); }
if($_POST['dia'] > 31 || !ctype_digit($_POST['dia'])) { die('nacimiento: El d&iacute;a no puede tener mas de 31 ._.'); }
if($_POST['mes'] > 12 || !ctype_digit($_POST['dia'])) { die('nacimiento: El mes no debe ser mayor a 12'); }
if($_POST['anio'] > date('Y', time())-$config['year']) { die('nacimiento: Eres menor de edad'); }
if(!checkdate($_POST['mes'], $_POST['dia'], $_POST['anio'])) { die('nacimiento: Datos mal puestos'); }
if(!mysql_num_rows(mysql_query('SELECT id FROM `countries` WHERE `id` = \''.intval($_POST['pais']).'\''))) { die('pais: Error provocado'); }
if(!preg_match('/[a-z]/i', $_POST['ciudad'])) { die('ciudad: El campo solo permite letras'); }
if($_POST['sexo'] != 'm' && $_POST['sexo'] != 'f') { die('sexo: Error provocado gato'); }
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { die('email: Error de escritura'); }
if(mysql_num_rows(mysql_query('SELECT `email` FROM `users` WHERE `email` = \''.mysql_clean($_POST['email']).'\''))) { die('email: El mail est&aacute; en uso'); }
include('../recaptchalib.php');
$resp = recaptcha_check_answer($config['recaptcha_privatekey'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
if(!$resp->is_valid) { die('recaptcha: El c&oacute;odigo no es correcto'); }
$avatar = '/media/images/avatares/avatar_'.rand(0, 10).'.gif';
if(in_array(stristr($_REQUEST['email'], '@'), array('@rtrtr.com', '@mailmetrash.com', '@yopmail.com'))) { die('0: El mail no est&aacute; permitido, idiota'); }
$merge = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
$hash = '';
for($i=0;$i<=rand(12, 20);$i++) {
  $hash .= $merge[rand(0, (count($merge)-1))];
}
mysql_query('INSERT INTO `users` (`act`, `ban`, `nick`, `rank`, `password`, `email`, `day`, `month`, `year`, `time`, `sex`, `country`, `city`, `avatar`, `points2`) VALUES (\'0\', \'0\', \''.mysql_clean($_POST['nick']).'\', \'1\', \''.md5($_POST['password']).'\', \''.mysql_clean($_POST['email']).'\', \''.intval($_POST['dia']).'\', \''.intval($_POST['mes']).'\', \''.intval($_POST['anio']).'\', \''.time().'\', \''.($_POST['sexo'] == 'm' ? '0' : '1').'\', \''.intval($_POST['pais']).'\', \''.mysql_clean(ucwords($_POST['ciudad'])).'\', \''.$avatar.'\', \'50\')') or die(mysql_error());
$id_user = mysql_insert_id();
//fewhgewgewigewfew
mysql_query('INSERT INTO `mails` (`id_user`, `mail`, `time`, `type`, `hash`) VALUES (\''.$id_user.'\', \''.mysql_clean($_POST['email']).'\', \''.time().'\', \'0\', \''.$hash.'\')');

$issue = 'Registro en '.$config['name'];

$mail = '<div style="background-color:#cccccc;padding:8px"><div class="adM">'."\n";
$mail .= '</div><img src="https://confluence.prodevelop.es/download/userResources/MMW/logo" title="'.$config['name'].'">'."\n";
$mail .= '<div style="background-color:#ffffff;padding:10px">'."\n";
$mail .= '<b>Hola '.htmlspecialchars($_POST['nick']).'!</b>'."\n";
$mail .= '<br><br>&iexcl;Te damos la bienvenida a '.$config['name']."\n";
$mail .= '<br><br>Para activar tu cuenta debes hacer clic <a href="'.$config['url'].'/activate/'.$hash.'/'.str_replace('@', '-', $_POST['email']).'" target="_blank">aqu&iacute;</a>'."\n";
$mail .= '<br><br>Antes de empezar a participar en la comunidad, te recomendamos que visites el siguiente enlace para que te informes sobre las normas de '.$config['name'].' y as&iacute; evitar futuros problemas: <a href="'.$config['url'].'/protocolo/" target="_blank">click ac&aacute;</a>'."\n";
$mail .= '<br><br>Tu nombre de usuario: <b>'.htmlspecialchars($_POST['nick']).'</b>'."\n";
$mail .= '<br>Tu contrase&ntilde;a: <b>'.htmlspecialchars($_POST['password']).'</b>'."\n";
$mail .= '<br><br>&iexcl;Muchas gracias!'."\n";
$mail .= '<br><br>El staff de '.$config['name'].'.'."\n";
$mail .= '</div><div class="yj6qo"></div><div class="adL">'."\n";
$mail .= '</div></div>';
$headers = 'From: '.$config['mail']."\r\n".'Reply-To: '.$config['name']."\r\n".'Content-Type: text/html; charset=utf-8'."\r \n".'X-Mailer: PHP/'.phpversion();

@mail($_POST['email'], $issue, $mail, $headers);
die('1: Te hemos enviado un correo a <b>'.htmlspecialchars($_POST['email']).'</b> con los &uacute;ltimos pasos para finalizar con el registro.
<br />
<br />
Si en los pr&oacute;ximos minutos no lo encuentras en tu bandeja de entrada, por favor, revisa tu carpeta de correo no deseado, es posible que se haya filtrado.
<br />
<br />
&iexcl;Muchas gracias!<br />');
?>