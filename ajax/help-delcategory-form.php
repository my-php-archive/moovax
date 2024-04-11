<?php
if(!$_POST['id'] || !ctype_digit($_POST['id'])) { die('0Faltan datos black'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0Debes loguearte'); }
if(!allow('admin_help')) { die('0No tienes permisos para realizar esta acci&oacute;n'); }
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `help_categories` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0La categoria no existe'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `name` FROM `help_categories` WHERE `id` != \''.intval($_POST['id']).'\' ORDER BY `name` ASC'))) { die('0Debes agregar una categor&iacute;a para ser sustituida por esta'); }
?>
1<div class="data">
<label class="floatL">Qu&eacute; categor&iacute;a tendr&aacute;n ahora los ariculos en dicha categor&iacute;a?</label>
<select name="newcat" id="newcat" style="width:220px">
<option value="">Seleccionar categor&iacute;a</option>
<?php
//$query = mysql_query('SELECT `id`, `name` FROM `help_categories` WHERE `id` != \''.intval($_POST['id']).'\' ORDER BY `name` ASC');
while($r = mysql_fetch_row($query)) { echo '<option value="'.$r[0].'">'.$r[1].'</option>'; }
?>
</select>
</div>