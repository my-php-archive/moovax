<?php
if(!$_POST['id']) { die('0: Falta datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(!mysql_num_rows($ddd = mysql_query('SELECT `id`, `author`, `id_post`, `what`, `status` FROM `complaints` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La denuncia ingresada no existe'); }
$den = mysql_fetch_assoc($ddd);
if(($den['what'] == '0' && !allow('complaints_posts')) || ($den['what'] == '1' && !allow('complaints_photos')) || ($den['what'] == '2' && !allow('complaints_posts'))) { die('0: No tienes permisos'); }
if($den['author'] == $logged['id']) { die('0: No puedes borrar una denuncia que hiciste vos'); }
if($den['what'] == '2' && $den['id_post'] == $logged['id']) { die('0: En esta denuncia el acusado sos vos. Qu&eacute; intentas?'); }
/* Si la borramos no comprobamos mucho tampoco :/ -*/
if($den['status'] == '0') {
  $mp = "Hola, una denuncia recientemente hecha por ti a sido rechazada. Por lo tanto se te descuentan 3 puntos.\nSi crees que esto est&aacute; mal, puedes volver a denunciar el post y redactar mejor porque debe de ser borrado.\nGracias";
  $sl = mysql_query('SELECT `author` FROM `complaints` WHERE `id_post` = \''.$den['id_post'].'\'');
  while($r = mysql_fetch_row($sl)) {
    mysql_query('INSERT INTO `messages` (`author`, `receiver`, `issue`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$r[0].'\', \'Denuncia rechazada\', \''.$mp.'\', \''.time().'\')');
    mysql_query('UPDATE `users` SET `points` = `points` - 3 WHERE `id` = \''.$r[0].'\'');
  }
}
mysql_query('DELETE FROM `complaints` WHERE `id_post` = \''.$den['id_post'].'\'');
die('1: Hecho');