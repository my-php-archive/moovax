<?php
include('../config.php');
include('../functions.php');
if(!allow('edit_ranks')) { die('0: Chupame la pija kaissar'); }
if(!$_POST['id']) { die('0: El campo id del rango es requerido'); }
if(!mysql_num_rows($query = mysql_query('SELECT * FROM `ranks` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El rango no existe'); }
$r = mysql_fetch_assoc($query);
$xp = explode(';', $r['permissions']);

$ranks = array('complaints_posts' => 'Administrar denuncias de posts',
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
?>
1:
<form class="form-container" id="datos" name="datos">
	<div style="display: none;margin-bottom:10px;padding:8px;" class="redBox" id="error_data"></div>
	<div class="data">
		<label>Nombre del rango:</label>
		<input type="text" value="<?=$r['name'];?>" name="nombre" id="nombre" class="c_input">
	</div>
	<div class="data">
		<label class="floatL">Nombre de la imágen</label>
		<input type="text" value="<?=$r['img'];?>" name="desc" id="desc" class="c_input">
	</div>
	<div class="clear"></div>
	<span class="size9 floatL"> - La imágen es esencial para mostrar el rango</span><br>
    <div class="data">
    <?php
    foreach($ranks as $v => $d) {
      echo '<input type="checkbox" '.(in_array($v, $xp) ? 'checked="checked"' : '').' tabindex="5" id="'.$v.'" class="option" name="'.$v.'"> '.$d.'<hr />';
    }
    ?> 

    </div>



</form>