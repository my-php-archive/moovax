<?php
include('../config.php');
include('../functions.php');
if(!allow('edit_ranks')) { die('0: Error'); }
$permissions = array('complaints_posts' => 'Administrar denuncias de posts',
               'complaints_photos' => 'Administrar denuncias de fotos',
               'complaints_users' => 'Administrar denuncias a usuarios',
               'delete_posts' => 'Borrar posts',
               'delete_photos' => 'Borrar fotos',
               'show_userlist' => 'Ver lista de usuarios',
               'ban' => 'Ver/Banear usuarios',
               'track_ip' => 'Administrar IPs',
               'censure' => 'Administrar palabras censuradas',
               'friend_sites' => 'Administrar webs amigas',
               'manage_news' => 'Administrar noticias',
               'stitches' => 'Sumar puntos a los usuarios',
               'edit_ranks' => 'Editar rangos',
               'category_manage' => 'Administrar categor&iacute;as',
               'show_mps' => 'Ver mps',
               'edit_user' => 'Editar usuarios',
               'show_panel' => 'Administrar panel',
               'delete_comments' => 'Borrar comentarios',
               'sticky' => 'Establecer stickys',
               'sponsor' => 'Ser patrocinador',
               'add_points' => 'Puntuar posts normalmente',
               'show_contact' => 'Ver lista de contactantes',
               'edit_settings' => 'Configurar el script',
               'ban_ip' => 'Banear ips parcial (-pana)',
               'admin_help' => 'Administrar ayuda',
               'editgroup' => 'Editar comunidades',
               'edittopic' => 'Editar temas',
               'deletereply' => 'Borrar respuestas a temas',
               'elimgroup' => 'Eliminar comunidades',
               'elimtopic' => 'Editar temas en comunidades');
$save = array();
if($_POST) {
  if(!$_POST['desc'] || !$_POST['nombre'] || !$_POST['points']) { die('3: Faltan datos'); }
  foreach($permissions as $value => $valor) {
    if($_POST[$value] == '0' || !$_POST[$value]) { continue; }
    $save[] = $value;
  }
  if(!ctype_digit($_POST['points'])) { die('3: Los puntos deben de ser un n&uacute;mero'); } //GO
  $sub = explode('.', $_POST['desc']);
  if(!in_array($sub[1], array('png', 'gif', 'jpg', 'jpeg'))) { die('3: Imagen no soportada'); }
  if(strlen($_POST['nombre']) > 16 || strlen($_POST['nombre']) < 4) { die('0: El nombre debe tener entre 4 y 16 caracteres'); }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `ranks` WHERE `name` = \''.mysql_clean($_POST['nombre']).'\' || `img` = \''.mysql_clean($_POST['desc']).'\''))) { die('3: Ya hay un rango con esa imagen o nombre'); }
  mysql_query('INSERT INTO `ranks` (`name`, `permissions`, `img`, `points`) VALUES (\''.mysql_clean($_POST['nombre']).'\', \''.implode(';', $save).'\', \''.mysql_clean($_POST['desc']).'\', \''.intval($_POST['points']).'\')');
  die('1: El nuevo rango ya est&aacute; listo para ser usado.');
}
?>
1:
<form name="datos" id="datos" class="form-container">
	<div id="error_data" class="redBox" style="display: none;margin-bottom:10px;padding:8px;"></div>
	<div class="data">
		<label class="floatL">Nombre del rango:</label>
		<input type="text" class="c_input" id="nombre" name="nombre" value="">
	</div>
	<div class="data">
		<label class="floatL">Nombre de la imágen</label>
		<input type="text" class="c_input" id="desc" name="desc" value="">
	</div>
    <div class="data">
		<label class="floatL">Cantidad de puntos a dar (por d&iacute;a)</label>
		<input type="text" class="c_input" id="points" name="points" value="">
	</div>
    <div class="data">
    <?php
    foreach($permissions as $d => $b) {
      echo '<input type="checkbox" name="'.$d.'" class="option" id="'.$d.'" tabindex="5"> '.$b.'<hr class="linksList" />';
    }
    ?>
    </div>
</form>