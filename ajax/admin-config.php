<?php
$arr = array('name', 'slogan', 'url', 'search_url', 'images', 'define', 'mail', 'recaptcha_publickey', 'cookie_name', 'years', 'manteniance', 'bd_host', 'bd_user', 'bd_pass', 'bd_name', 'idioma');
if(count($_POST) != count($arr)) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Andate a la recalcada concha de tu hermana hijo de puta'); }
if(!allow('edit_settings')) { die('0: puto'); }
if(!$_POST['name']) { $_POST['name'] = $config['name']; }
if(!$_POST['url']) {
  $_POST['url'] = $config['url'];
}
if(!$_POST['images'] || !filter_var($_POST['images'], FILTER_VALIDATE_URL)) {
  $_POST['images'] = $config['url'].'/images';
}
if(!preg_match('/[a-z0-9]+$/i', $_POST['name'])) { die('0: El nombre solo acepta letras y numeros'); }
if(!filter_var($_POST['url'], FILTER_VALIDATE_URL)) { die('0: La url proporcionada no es v&aacute;lida'); }
if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) { die('0: El mail no es v&aacute;lido'); }
//
if(!$_POST['bd_pass']) { $_POST['bd_pass'] = $config['bd_pass']; } // few
if($_POST['manteniance'] == 1) { $_POST['manteniance'] = 'true'; } else { $_POST['manteniance'] = 'false'; }
if(!ctype_digit($_POST['years']) || $_POST['years'] > 100) { die('0: La edad debe de ser un n&uacute;mero'); }
if(!preg_match('/[a-z0-9]+/i', $_POST['cookie_name'])) { die('0: La cookie solo acepta letras y numeros'); }
$file = file('../config.php', FILE_USE_INCLUDE_PATH);
$ttt = '';
foreach($file as $line => $text) {
  if(!preg_match('/\$config\[\'(WTF|'.implode('|', $arr).'|WFT)\'\] \= (.*)\;/i', $text, $result)) { $ttt .= $text; continue; }
  if(!$_POST[$result[1]]) { $ttt .= $text; continue; }
  $explode = explode(';', $text);
  $ttt .= '$config[\''.$result[1].'\'] = '.($result[1] != 'manteniance' ? '\''.mysql_clean($_POST[$result[1]]).'\'' : $_POST['manteniance']).';'.$explode[1];
}
file_put_contents('../config.php', $ttt, FILE_USE_INCLUDE_PATH);
die('1: Datos guardados!');