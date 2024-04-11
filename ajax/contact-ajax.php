<?php
if(!$_POST['nombre'] || !$_POST['email'] || !$_POST['empresa'] || !$_POST['horario'] || !$_POST['motivo'] || !$_POST['comentario']) { die('0: Faltan datos'); }
$_SERVER['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDED_FOR'];
if(!filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) { die('0: No puede contactarse, ingrese una ip v&aacute;lida'); }
include('../config.php');
include('../functions.php');
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { die('0: El correo especificado no v&aacute;lido'); }
if(strlen($_POST['empresa']) < 2 || strlen($_POST['empresa']) > 30) { die('0: Su empresa debe tener entre 2 y 30 caracteres'); }
if(!ctype_digit($_POST['motivo']) || $_POST['motivo'] < 1 || $_POST['motivo'] > 5) { die('0: El campo motivo es requerido'); }
if(!preg_match('/[a-z0-9:]/i', $_POST['horario'])) { die('0: El horario solo admite letras numeros y ":"'); }
include('../recaptchalib.php');
$resp = recaptcha_check_answer($config['recaptcha_privatekey'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
if(!$resp->is_valid) { die('0: El captcha no es correcto'); }
if(strlen($_POST['comentario']) < 5 || strlen($_POST['comentario']) > 255) { die('0: El comentario debe tener entre 5 y 255 caracteres'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `contact` WHERE `ip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\'')) > 2) { die('0: Usted ya van 2 veces que contacta con nosotros'); }
mysql_query('INSERT INTO `contact` (`ip`, `email`, `office`, `schedule`, `motive`, `comment`, `time`) VALUES (\''.mysql_clean($_SERVER['REMOTE_ADDR']).'\', \''.mysql_clean($_POST['email']).'\', \''.mysql_clean($_POST['empresa']).'\', \''.mysql_clean($_POST['horario']).'\', \''.intval($_POST['motivo']).'\', \''.mysql_clean($_POST['comentario']).'\', \''.time().'\')') or die('0: '.mysql_error());
echo '1: Su mensaje ha sido enviado. Pronto estaremos en contacto';