<?php
if(!$_POST['url']) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!allow('friend_sites')) { die('0: Chupame la verga'); }
if(substr($_POST['url'], 0, 7) != 'http://') { $_POST['url'] = 'http://'.$_POST['url']; }
if(!filter_var($_POST['url'], FILTER_VALIDATE_URL)) { die('0La URL ingresada no es v&aacute;lida'); }
if((strlen($_POST['name']) < 2 || strlen($_POST['name']) > 24) && $_POST['name']) { die('0EL nombre debe tener entre 2 y 24 caracteres'); }
// Curl -tut
if(function_exists('curl_init')) {
  $c = curl_init();
  $array = array(CURLOPT_URL => $_POST['url'], CURLOPT_RETURNTRANSFER => 1, CURLOPT_REFERER => $config['url'], CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2');
  curl_setopt_array($c, $array);
  $v = curl_exec($c);
  if(empty($v)) { die('0La url no pudo ser cargada'); }
  curl_close($c);
}
if(!$_POST['name']) {
  $ct = explode('<title>', $v);
  $ca = explode('</title>', $ct[1]);
  if(empty($ca[0])) { die('0Especifica el nombre de la web amiga'); }
  $_POST['name'] = $ca[0];
}
if(mysql_num_rows(mysql_query('SELECT `id` FROM `urls` WHERE `url` = \''.mysql_clean($_POST['url']).'\' || `name` = \''.mysql_clean($_POST['name']).'\''))) { die('0La url o el nombre ya existen'); }

mysql_query('INSERT INTO `urls` (`url`, `name`, `time`) VALUES (\''.mysql_clean($_POST['url']).'\', \''.mysql_clean($_POST['name']).'\', \''.time().'\')');
$id = mysql_insert_id();
echo '1<td title="" style="width:0px"><img src="'.$config['images'].'/images/url.png"></td>
<td style="width:10px">'.$id.'</td>
<td style="width:120px">'.htmlspecialchars($_POST['name']).'</td>
<td style="width:120px"><a href="'.htmlspecialchars($_POST['url']).'">IR</a></td>
<td style="width:120px">Menos de un minuto</td>
<td style="width:120px"><a href="#" onclick="admin.delete_web('.$id.'); return false;"><img src="'.$config['images'].'/images/delete.png"></a></td>';