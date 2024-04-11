<?php
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate macho'); }
if(!allow('admin_help')) { die; }
$title = trim($_POST['titulo']);
if($title && $_POST['desc']) {
  //if(!$title || !$_POST['desc']) { die('0: Faltan datos'); }
  if(!preg_match('/[a-z0-9\- ]{2,16}/i', $title)) { die('0: El titulo solo admite letras de la A a Z, numeros y 2 a 16 caracteres'); }
  if(strlen($_POST['desc']) < 2 || strlen($_POST['desc']) > 255) { die('0: La descripcion debe tener entre 2 y 255 caracteres'); }
  if(!$_POST['url']) { $_POST['url'] = url($title); } elseif(!preg_match('/^[a-z0-9_\-]+$/i', $_POST['url'])) { die('0: La url ingresada no es valida, no debe tener espacios q3'); }
  if($_POST['id']) {
    if(!mysql_num_rows($query = mysql_query('SELECT `id` FROM `help_categories` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La categor&iacute;a no existe'); }
    $row = mysql_fetch_row($query);
    mysql_query('UPDATE `help_categories` SET `name` = \''.mysql_clean($title).'\', `url` = \''.mysql_clean($_POST['url']).'\', `description` = \''.mysql_clean($_POST['desc']).'\' WHERE `id` = \''.$row[0].'\' LIMIT 1') or die('0: '.mysql_error());
    echo '1: <td style="width:10px"><img title="Categoria" alt="Categoria" src="'.$config['images'].'/images/ayuda/carpeta.png"></td>
            <td style="text-align:left"><a href="/ayuda/'.htmlspecialchars($_POST['url']).'/">'.htmlspecialchars($title).'</a></td>
            <td style="width:50px">'.mysql_num_rows(mysql_query('SELECT `id` FROM `articles` WHERE `cat` = \''.$row[0].'\' && `status` = \'0\'')).'</td>
            <td>'.htmlspecialchars($_POST['url']).'</td>
            <td>'.htmlspecialchars($_POST['desc']).'</td>
            <td style="width:50px"><a onclick="help.edit_category(\''.$row[0].'\'); return false;" href="#"><img title="Editar categoría" alt="Editar categoría" src="'.$config['images'].'/images/ayuda/editar.png"></a></td>
            <td style="width:50px"><a onclick="help.del_category(\''.$row[0].'\'); return false" href="#"><img title="Eliminar categoría" alt="Eliminar categoría" src="'.$config['images'].'/images/ayuda/borrar.png"></a></td>
          </tr>';
  } else {
    mysql_query('INSERT INTO `help_categories` (`name`, `url`, `description`) VALUES (\''.mysql_clean($title).'\', \''.mysql_clean($_POST['url']).'\', \''.mysql_clean($_POST['desc']).'\')') or die('0: '.mysql_error());
    die('1: Agregado con &eacute;xito!');
  }
}
$ed = false;
if($_POST['id'] && mysql_num_rows($que = mysql_query('SELECT * FROM `help_categories` WHERE `id` = \''.intval($_POST['id']).'\''))) {
  $row = mysql_fetch_assoc($que);
  $ed = true;
}
?>
1:
<div class="form-container">
	<div id="error_data" class="redBox" style="display: none;margin-bottom:10px;padding:8px;"></div>
	<div class="data">
		<label>Nombre:</label>
		<input type="text" class="c_input" id="titulo"<?=($ed ? ' value="'.$row['name'].'"' : '');?>>
	</div>
	<div class="data">
		<label>Descripci&oacute;n:</label>
		<input type="text" class="c_input" id="descripcion"<?=($ed ? ' value="'.$row['description'].'"' : '');?>>
	</div>
	<div class="data">
		<label>URL (no requerido):</label>
		<input type="text" class="c_input" id="url"<?=($ed ? ' value="'.$row['url'].'"' : '');?>>
	</div>
</div>
<!---
nombre: <input type="text" id="titulo"<?=($ed ? ' value="'.$row['name'].'"' : '');?> />
descripcion: <input type="text" id="descripcion"<?=($ed ? ' value="'.$row['description'].'"' : '');?> />
url: <input type="text" id="url"<?=($ed ? ' value="'.$row['url'].'"' : '');?> />-->
