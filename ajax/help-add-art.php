<?php
$title = trim($_POST['titulo']);
if(!$title || !$_POST['cuerpo'] || !$_POST['categoria']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte'); }
if(!allow('admin_help')) { die('0: No tienes permisos'); }  
if(!mysql_num_rows($p = mysql_query('SELECT `url` FROM `help_categories` WHERE `id` = \''.intval($_POST['categoria']).'\''))) { die('0: La categor&iacute;a no existe'); }
if(strlen($title) > 40 || strlen($title) < 3) { die('0: El titulo debe tener entre 3 y 40 caracteres'); }
if(strlen($_POST['cuerpo']) < 60) { die('0: El contenido debe tener al menos 60 caracteres'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `articles` WHERE `time` > \''.(time()-120).'\' && `author` = \''.$logged['id'].'\''))) { die('0: No puedes realizar tantas acciones en tan poco tiempo'); }
if($_POST['id']) {
  if(!ctype_digit($_POST['id'])) { die('0: mmm'); }
  if(!mysql_num_rows($l = mysql_query('SELECT `id`, `author`, `status` FROM `articles` WHERE `id` = \''.$_POST['id'].'\''))) { die('0: El articulo no existe'); }
  list($id, $author, $status) = mysql_fetch_row($l);
  if($author != $logged['id'] && !allow('admin_help')) { die('0: Kaissar esta feliz mmm'); }
  if($status != 0) { die('0: Se encuentra eliminado'); }
  mysql_query('UPDATE `articles` SET `title` = \''.mysql_clean($title).'\', `body` = \''.mysql_clean($_POST['cuerpo']).'\', `cat` = \''.intval($_POST['categoria']).'\' WHERE `id` = \''.intval($_POST['id']).'\' LIMIT 1');
  $text = 'editado';
} else {
  mysql_query('INSERT INTO `articles` (`author`, `title`, `body`, `status`, `cat`, `time`) VALUES (\''.$logged['id'].'\', \''.mysql_clean($title).'\', \''.mysql_clean($_POST['cuerpo']).'\', \'0\', \''.intval($_POST['categoria']).'\', \''.time().'\')');
  $text = 'agregado';
  $id = mysql_insert_id();
}
$cat = mysql_fetch_row($p);
echo '1: El art&iacute;culo <b>'.htmlspecialchars($title).'</b> fue '.$text.' con &eacute;xito.<br><br>
		<input type="button" class="Boton BtnGreen" onclick="confirm = false;location.href=\'/ayuda/'.$cat[0].'/'.$id.'/'.url(mysql_clean($title)).'.html\'" value="Ver post" title="Ver post">
		<input type="button" class="Boton BtnGray" onclick="confirm = false;location.href=\'/ayuda/\'" value="Ir a la página principal" title="Ir a la página principal"></div>';