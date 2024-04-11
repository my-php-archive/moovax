<?php
$title = trim($_POST['titulo']);
if(!$title || !$_POST['url'] || !$_POST['categoria']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Para realizar dicha accio&oacute;n debes loguearte'); }
if(strlen($_POST['descripcion']) < 5 && !empty($_POST['descripcion'])) { die('0: La descripcion debe tener al menos 5 caracteres. Puedes dejarla en blanco'); }
if(strlen($_POST['descripcion']) > 255) { die('0: La descripcion tiene un limite de 255 caracteres'); }
if(!mysql_num_rows($pqqqt = mysql_query('SELECT `url` FROM `p_categories` WHERE `id` = \''.intval($_POST['categoria']).'\''))) { die('0: Que intent&aacute;s?'); }
if(!@$get = getimagesize($_POST['url'])) { die('0: La im&aacute;gen ingresda no existe'); }
if($get[0] > 1024 && $get[1] > 1024) { die('0: La foto no debe ser mayor a 1024x1024 pixeles'); }
if($get[0] < 160 || $get[1] < 120) { die('0: Tu foto debe tener un tama&ntilde;o superior a 160x120 pixeles'); }
//if($_POST['sticky'] != 0 && !allow('sticky')) { $_POST['sticky'] = 0; }
if(!$_POST['privado']) { $_POST['privado'] = 0; }
if($_POST['privado'] > 2) { die('0: veo petes'); }
//if(mysql_num_rows(mysql_query('SELECT `id` FROM `photos` WHERE `time` > \''.(time()-160).'\' && `author` = \''.$logged['id'].'\''))) { die('0: Debes esperar para realizar esta acci&oacute;n'); }
list($url) = mysql_fetch_row($pqqqt);
if($_POST['f'] && ctype_digit($_POST['f'])) {
  if(!mysql_num_rows($post = mysql_query('SELECT `id`, `author`, `status`, `title` FROM `photos` WHERE `id` = \''.$_POST['f'].'\''))) { die('0: La foto que intentas editar no existe'); }
  $row = mysql_fetch_assoc($post);
  if($row['author'] != $logged['id'] && !allow('delete_posts')) { die('0: Esta foto no te pertenece'); }
  if($row['status'] != 0) { die('0: La foto que intentas editar ha sido eliminada'); }
  if($row['author'] != $logged['id'] && !$_POST['causa']) { die('0: Debes especificar la causa'); }
  if($row['author'] != $logged['id']) {
    mysql_query('INSERT INTO `history_mod` (`post`, `moderador`, `reason`, `action`, `time`, `type`) VALUES (\''.$row['id'].'\', \''.$logged['id'].'\', \''.mysql_clean($_POST['causa']).'\', \'0\', \''.time().'\', \'1\')') or die('0: '. mysql_error());
  }
  //if(!allow('sticky') && $row['sticky'] != 0) { $_POST['sticky'] = $row['sticky']; }
  mysql_query('UPDATE `photos` SET `title` = \''.mysql_clean($title).'\', `url` = \''.mysql_clean($_POST['url']).'\', `body` = \''.mysql_clean($_POST['descirpcion']).'\', `private` = \''.$_POST['privado'].'\', `closed` = \''.($_POST['cerrado'] ? 1 : 0).'\' WHERE `id` = \''.$row['id'].'\' LIMIT 1') or die('0: '.mysql_error());
  $url = '/fotos/'.$url.'/'.$row['id'].'/'.url($rot['title']).'.html';
  $txt = 'editado';
} else {
  mysql_query('INSERT INTO `photos` (`title`, `url`, `body`, `author`, `private`, `closed`, `time`, `cat`) VALUES (\''.mysql_clean($title).'\', \''.mysql_clean($_POST['url']).'\', \''.mysql_clean($_POST['descripcion']).'\', \''.$logged['id'].'\', \''.$_POST['privado'].'\', \''.($_POST['cerrado'] ? 1 : 0).'\', \''.time().'\', \''.mysql_clean($_POST['categoria']).'\')') or die('0: '.mysql_error());
  $id = mysql_insert_id();
  $url = '/fotos/'.$url.'/'.$id.'/'.url(mysql_clean($title)).'.html';
  if(mysql_num_rows($query = mysql_query('SELECT IF(user = \''.$logged['id'].'\', `author`, `user`) FROM `friends` WHERE (`author` = \''.$logged['id'].'\' || `user` = \''.$logged['id'].'\') && `status` = \'1\''))) {
    while($row = mysql_fetch_row($query)) { mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$row[0].'\', \'15\', \''.$url.'\', \'0\', \''.time().'\', \''.mysql_clean($title).'\')'); }
  }
  mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.mysql_clean($title).'\', \''.$url.'\', \''.$id.'\', \''.time().'\', \'9\')') or die('0: '.mysql_error());
  $txt = 'agregada';
}
echo '1: Tu foto: <b>'.htmlspecialchars($title).'</b> fue '.$txt.' con &eacute;xito.<br><br><input type="button" title="Ver foto" value="Ver foto" onclick="confirm = false;location.href=\''.$url.'\'" class="Boton BtnGreen"><input type="button" title="Ir a la página principal" value="Ir a la página principal" onclick="confirm = false;location.href=\'/fotos/\'" class="Boton BtnGray">';
