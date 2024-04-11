<?php
$title = trim($_POST['titulo']);
if(!$title || !$_POST['cuerpo'] || !$_POST['categoria']) { die('0: Faltan datos..'); }
include('../config.php');
include('../functions.php');
if(!$key) { die('0: No est&aacute;s logueado'); }
if(strlen($title) > 90) { die('0: El t&iacute;tulo ingresado no debe exceder los 90 caracteres'); }
if(strlen($_POST['cuerpo']) < 100 || strlen($_POST['cuerpo']) > 63206) { die('0: El contenido de post debe de tener al menos 100 caracteres ni m&aacute;s de 63206'); }
if(!mysql_num_rows($rows = mysql_query('SELECT `url` FROM `categories` WHERE `id` = \''.intval($_POST['categoria']).'\''))) { die('0: La categor&iacute;a ingresada no existe'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `posts` WHERE `time` > \''.(time()-120).'\' && `author` = \''.$logged['id'].'\''))) { die('0: No puedes realizar tantas acciones en tan poco tiempo'); }
if(!allow('sticky') && $_POST['sticky'] == '1') { die('0: No tenes permisos para establecer stickys'); }
if(!allow('sponsor') && $_POST['categoria'] == '13') { die('0: No tienes permisos para patrocinar -sisi'); }
if(($_POST['privado'] && $_POST['privado'] != '1') || ($_POST['cerrado'] && $_POST['cerrado'] != '1')) { die('0: Error provocado'); }
$cat = mysql_fetch_row($rows);
if($_POST['borrador'] && $_POST['borrador'] != '-1' && mysql_num_rows($q = mysql_query('SELECT `id`, `author` FROM `drafts` WHERE `id` = \''.intval($_POST['borrador']).'\''))) {
  list($id_b, $author_b) = mysql_fetch_row($q);
  if($author_b != $logged['id']) { die('0: Chupame la pija'); }
  mysql_query('DELETE FROM `drafts` WHERE `id` = \''.$id_b.'\' LIMIT 1') or die('0: '.mysql_error());
}
if($_POST['id_post']) {
  /* editing */
  if(!mysql_num_rows($ew = mysql_query('SELECT `id`, `author`, `status`, `sticky` FROM `posts` WHERE `id` = \''.intval($_POST['id_post']).'\''))) { die('0: El post no existe '.$_POST['id_post']); }
  $ok = mysql_fetch_row($ew);
  if($ok[1] != $logged['id'] && !allow('delete_posts')) { die('0: El post no te pertenece'); }
  if(!$_POST['causa'] || strlen($_POST['causa']) < 3) { die('0: La cuasa debe de tener al menos 3 caracteres'); }
  if($ok[2] != '0') { die('0: El post se encuentra eliminado'); }
  if($ok[3] == '1' && !allow('sticky')) { $_POST['sticky'] = 1; }
  //Aqui estoy
  if(allow('delete_posts') && $ok[1] != $logged['id']) { mysql_query('INSERT INTO `history_mod` (`post`, `moderador`, `reason`, `action`, `time`, `type`) VALUES (\''.$ok[0].'\', \''.$logged['id'].'\', \''.mysql_clean($_POST['causa']).'\', \'1\', \''.time().'\', \'0\')') or die('0: '.mysql_error()); }
  mysql_query('UPDATE `posts` SET `title` = \''.mysql_clean($title).'\', `body` = \''.mysql_clean($_POST['cuerpo']).'\', `cat` = \''.intval($_POST['categoria']).'\', `sticky` = \''.($_POST['sticky'] ? '1' : '0').'\', `closed` = \''.($_POST['cerrado'] ? '1' : '0').'\', `private` = \''.($_POST['privado'] ? '1' : '0').'\' WHERE `id` = \''.$ok[0].'\' LIMIT 1') or die('0: '.mysql_error());
  die('1: El post <b>'.htmlspecialchars($title).'</b> fue editado con &eacute;xito.<br><br><input type="button" title="Ver post" value="Ver post" onclick="confirm = false;location.href=\'/posts/'.$cat[0].'/'.$ok[0].'/'.url(htmlspecialchars($_POST['titulo'])).'.html\'" class="Boton BtnGreen"><input type="button" title="Ir a la página principal" value="Ir a la página principal" onclick="confirm = false;location.href=\'/posts/\'" class="Boton BtnGray">');
}
//Paradiseeeeee
mysql_query('INSERT INTO posts (`author`, `status`, `title`, `body`, `cat`, `time`, `private`, `closed`, `sticky`) VALUES (\''.$key.'\', \'0\', \''.mysql_clean($title).'\', \''.mysql_clean($_POST['cuerpo']).'\', \''.intval($_POST['categoria']).'\', \''.time().'\', \''.($_POST['privado'] ? '1' : '0').'\', \''.($_POST['cerrado'] ? '1' : '0').'\', \''.($_POST['sticky'] ? '1' : '0').'\')');
$id = mysql_insert_id();
$url = '/posts/'.$cat[0].'/'.$id.'/'.url(htmlspecialchars($_POST['titulo'])).'.html';
mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.mysql_clean($_POST['titulo']).'\', \''.$url.'\', \''.$id.'\', \''.time().'\', \'1\')');
if(mysql_num_rows($query = mysql_query('SELECT IF(`author` = \''.$logged['id'].'\', `user`, `author`) FROM `friends` WHERE (`author` = \''.$logged['id'].'\' || `user` = \''.$logged['id'].'\') && `status` = \'1\''))) {
  while($row = mysql_fetch_row($query)) {
    if($row[0] == $logged['id']) { continue; }
    mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$row[0].'\', \'6\', \''.$url.'\', \'0\', \''.time().'\', \''.mysql_clean($title).'\')') or die('0: '.mysql_error());
  }
}
echo '1: El post <b>'.htmlspecialchars($_POST['titulo']).'</b> fue agregado con &eacute;xito.<br><br>
		<input type="button" title="Ver post" value="Ver post" onclick="confirm = false;location.href=\''.$url.'\'" class="Boton BtnGreen">
		<input type="button" title="Ir a la página principal" value="Ir a la página principal" onclick="confirm = false;location.href=\'/posts/\'" class="Boton BtnGray">';