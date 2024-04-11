<?php
if(!defined($config['define'])) { die; }
if(!$_POST['id']) { fatal_error('Faltan datos'); }
if(!$logged['id']) { fatal_error('Debes loguearte'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `status`, `title` FROM `photos` WHERE `id` = \''.intval($_POST['id']).'\''))) { fatal_error('La foto que intentas eliminar no existe'); }
$ot = mysql_fetch_row($query);
if($ot[1] != $logged['id'] && !allow('delete_photos')) { fatal_error('La foto que intentas eliminar no te pertenece'); }
if($ot[2] != 0) { fatal_error('La foto ya se encuentra eliminada'); }
if($ot[1] != $logged['id']) {
  if(empty($_POST['causa'])) { fatal_error('Debes ingresar la causa'); }
  if(strlen($_POST['causa']) > 100) { fatal_error('La causa excede los 100 caracteres'); }
  mysql_query('INSERT INTO `history_mod` (`post`, `moderador`, `reason`, `action`, `time`, `type`) VALUES (\''.$ot[0].'\', \''.$logged['id'].'\', \''.mysql_clean($_POST['causa']).'\', \'1\', \''.time().'\', \'1\')');
  $message = 'Lamento contarte que tu foto titulada '.$ot[3].' ha sido eliminada por la causa '.$_POST['causa']."\n".'Gracias por su comprensi&oacute;n';
  mysql_query('INSERT INTO `messages` (`author`, `receiver`, `issue`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$ot[1].'\', \'Foto eliminada\', \''.$message.'\', \''.time().'\')');
}
mysql_query('UPDATE `photos` SET `status` = \'1\' WHERE `id` = \''.$ot[0].'\'');
mysql_query('DELETE FROM `notifications` WHERE `url` REGEXP \'/fotos/.*/'.$ot[0].'/.*.html\' && `type` IN(\'5\', \'12\', \'14\', \'15\')') or die('0: '.mysql_error());
mysql_query('DELETE FROM `post_visits` WHERE `post` = \''.$ot[0].'\' && `type` = \'2\'');
mysql_query('DELETE FROM `favorites` WHERE `id_pf` = \''.$ot[0].'\' && `type` = \'1\'');
mysql_query('DELETE FROM `activity` WHERE `what` = \''.$ot[0].'\' && (`type` = \'10\' || `type` = \'9\')');
$query = mysql_query('SELECT `id` FROM `p_comments` WHERE `photo` = \''.$ot[0].'\'');
while(list($id) = mysql_fetch_row($query)) {
  mysql_query('DELETE FROM `c_votes` WHERE `comment` = \''.$id.'\' && `type` = \'1\'');
}
fatal_error('La foto ha sido eliminada', 'YEAH!');