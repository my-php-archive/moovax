<?php
if(!$_POST['cause']) { die('0: La causa de la eliminaci&oacute;n es requerida'); }
include('../config.php');
include('../functions.php');
//if(strlen($_POST['cause']) < 4) { die('0: La causa debe de tener al menos 4 caracteres'); }
if(!mysql_num_rows($select = mysql_query('SELECT `id`, `what`, `id_post`, `author`, `status` FROM `complaints` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La denuncia no existe'); }
$r = mysql_fetch_row($select);
if($r[3] == $logged['id']) { die('0: No puedes aceptar tus propias denuncias pana uiy'); }
if($r[4] == '1') { die('0: Esta denuncia ya fue aceptada'); }
switch($r[1]) {
  case '0':
    $type = '0';
    //$cant = 20;
    $m = '0';
    if(!allow('complaints_posts')) { die('0: No tienes permisos para borrar posts'); }
    if(!mysql_num_rows($ppp = mysql_query('SELECT `id`, `title`, `status`, `author` FROM `posts` WHERE `id` = \''.$r[2].'\''))) { die('0: El post ingresado no existe'); }
    $row = mysql_fetch_assoc($ppp);
    if($row['status'] == '1') { die('0: El post se encuentra eliminado'); }
    if($row['author'] == $logged['id']) { die('0: Tu eres el autor del post denunciado ._.'); }
    mysql_query('UPDATE `posts` SET `status` = \'1\' WHERE `id` = \''.$row['id'].'\' LIMIT 1');
    $men = "Hemos considerado que tu denuncia en el post \"".$row['title']."\" es correcta.\n\nPor ayudar a la comunidad, has ganado ".$cant." puntos.";
    //$inxs = mysql_query('SELECT `author` FROM `complaints` WHERE `id_post` = \''.$r[2].'\'');
    $men2 = "Hola!\nLamento contarte que tu post titulado \"".$row['title']."\" ha sido eliminado.\n\nCausa: ".htmlspecialchars($_POST['cause'])."\n\nPara acceder al [url=".$config['url']."/protocolo]protocolo[/url], presiona este [url=".$config['url']."/protocolo]enlace[/url].\n\nMuchas gracias por entender!";
    $issue = 'Post eliminado';
    $jel = $row['author']; //Lo usamos para enviar el mp a lo largo del coso
    mysql_query('INSERT INTO `history_mod` (`post`, `moderador`, `reason`, `time`, `type`, `action`) VALUES (\''.$row['id'].'\', \''.$logged['id'].'\', \''.mysql_clean($_POST['cause']).'\', \''.time().'\', \'0\', \'0\')');
    break;
  case '1':
    $cant = 5; //Gana 5 puntos
    //$type = '1';
    $m = '1';
    if(!allow('complaints_photos')) { die('0: No tienes permisos para administrar las fotos'); }
    if(!mysql_num_rows($photo = mysql_query('SELECT `id`, `title`, `author`, `status` FROM `photos` WHERE `id` = \''.$r[2].'\''))) { die('0: La foto indicada no existe'); }
    $row = mysql_fetch_assoc($photo);
    if($row['author'] == $logged['id']) { die('0: Tu eres el autor de la foto. Eliminala desde ella :/'); }
    if($row['status'] == '1') { die('0: Esta foto se encuentra eliminada. Puedes borrar la denuncia'); }
    mysql_query('UPDATE `photos` SET `status` = \'1\' WHERE `id` = \''.$row['id'].'\' LIMIT 1') or die('0: '.mysql_error());
    $men = "Hemos considerado que tu denuncia en la foto \"".$row['title']."\" es correcta.\n\nPor ayudar a la comunidad, has ganado ".$cant." puntos.";
    $men2 = "Tu foto titulada \"".$row['title']."\" a sido eliminada por la causa: ".htmlspecialchars($_POST['cause']).".\nGracias por leer";
    $issue = 'Foto eliminada';
    $jel = $row['author'];
    mysql_query('INSERT INTO `history_mod` (`post`, `moderador`, `reason`, `time`, `type`, `action`) VALUES (\''.$row['id'].'\', \''.$logged['id'].'\', \''.mysql_clean($_POST['cause']).'\', \''.time().'\', \'1\', \'1\')') or die('0: '.mysql_error());
    break;
  case '2':
    if(!allow('complaints_users')) { die('No tienes permisos para banear usuarios :/'); }
    $cant = 10;
    //$type = '2';
    $m = '2';
    if(!mysql_num_rows($row = mysql_query('SELECT `id`, `ban`, `nick` FROM `users` WHERE `id` = \''.$r[2].'\''))) { die('0: El usuario no existe'); }
    $mm = mysql_fetch_row($row);
    if($mm[1] == '1') { die('0: El usuario est&aacute; baneado. Puedes eliminar la denuncia'); }
    if($mm[0] == $logged['id']) { die('0: No puedes realizar esta acci&oacute;;n'); }
    $men = "Hemos considerado que tu denuncia al usuario \"".$mm[2]."\" es correcta.\n\nPor ayudar a la comunidad, has ganado ".$cant." puntos.";
    $men2 = "Este es un mensaje de advertencia: recientemente hemos recibido una denuncia sobre ti. Por la causa ".mysql_clean($_POST['cause'])."\nRecuerda que esta causa fue especificada por un mod y puede ser diferente a la original";
    $issue = 'Mensaje de advertencia';
    $jel = $mm[0];
}
/* Stop for a minuteeee */
$inxs = mysql_query('SELECT `author` FROM `complaints` WHERE `id_post` = \''.$r[2].'\' && `type` = \''.$m.'\'');
while($i = mysql_fetch_row($inxs)) {
  mysql_query('INSERT INTO `messages` (`author`, `receiver`, `issue`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$i[0].'\', \'Denuncia aceptada\', \''.$men.'\', \''.time().'\')') or die('0: '.mysql_error());
  mysql_query('UPDATE `users` SET `points` = `points` + '.$cant.' WHERE `id` = \''.$i[0].'\' LIMIT 1') or die('0: '.mysql_error());
}
mysql_query('INSERT INTO `messages` (`author`, `receiver`, `issue`, `body`, `time`) VALUES (\''.$logged['id'].'\', \''.$jel.'\', \''.$issue.'\', \''.$men2.'\', \''.time().'\')') or die('0: '.mysql_error());
mysql_query('UPDATE `complaints` SET `status` = \'1\' WHERE `id_post` = \''.$r[2].'\' && `what` = \''.$m.'\'') or die('0: '.mysql_error());
die('1: OK!');