<?php
if((!$_POST['background'] && !$_POST['color'] && $_POST['action'] == 'save') || ($_POST['repeat'] != '0' && $_POST['repeat'] != '1')) { die('{"status":0,"data":"Faltan datos"}'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die; }
if($_POST['action'] == 'save') {
  if(!preg_match('/^#([0-9a-z]{6})$/i', $_POST['color'], $result) && $_POST['color']) { die; }
  if($_POST['background']) {
    //if(!filter_var($_POST['background'], FILTER_VALIDATE_URL)) { die('{"status":0,"data":"La URL no es v&aacute;lida"}'); }
    if(!$image = getimagesize($_POST['background'])) { die('{"status":0,"data":"La imagen no existe, intenta con otra"}'); }
    if($image[0] > 2024 || $image[1] > 2024) { die('{"status":0,"data":"La im&aacute;gen debe ser menor a 2024px"}'); }
    if($image[0] < 3 || $image[1] < 3) { die('{"status":0,"data":"La im&aacute;gen debe ser mayor a 3px"}'); }
  }
  mysql_query('UPDATE `users` SET `background` = \''.mysql_clean($_POST['background']).'\', `background_color` = \''.mysql_clean($result[1]).'\', `background_repeat` = \''.($_POST['repeat'] ? 1 : 0).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1') or die(mysql_error());
  echo '{"status":1,"background":"'.htmlspecialchars($_POST['background']).'","repeat":"'.(!$_POST['repeat'] ? 'no-' : '').'repeat","color":"'.htmlspecialchars($_POST['color']).'"}';
} else {
  mysql_query('UPDATE `users` SET `background` = NULL WHERE `id` = \''.$logged['id'].'\' LIMIT 1');
  echo '{"status":1,"background":"","repeat":"'.($logged['background_repeat'] == '0' ? 'no' : '').'-repeat","color":"'.$logged['background_color'].'"}';
}