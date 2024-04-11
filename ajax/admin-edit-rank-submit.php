<?php
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
if(!$_POST['desc'] || !$_POST['nombre'] || !$_POST['id']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(strlen($_POST['nombre']) > 20 || strlen($_POST['nombre']) < 3) { die('0: El nombre debe de tener entre 3 y 20 caracteres'); }
$xp = explode('.', $_POST['desc']);
if($xp[1] != 'png' && $xp[1] != 'jpeg' && $xp[1] != 'jpg' && $xp[1] != 'gif') { die('0: Imagen no soportada'); }
if(!allow('edit_ranks')) { die('0: No tienes permisos'); }
if(!mysql_num_rows($qqq = mysql_query('SELECT `id` FROM `ranks` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El rango no existe'); }
$row = mysql_fetch_row($qqq);
/* if($row[0] == '9') { die('0: Este rango no se edita puf'); } */
if(count($_POST) < 5) { die('0: Error'); }
$arr = array();
foreach($ranks as $diff => $value) {
  if($_POST[$diff] != 'on') { continue; }
  $arr[] = $diff;
}
mysql_query('UPDATE `ranks` SET `name` = \''.mysql_clean($_POST['nombre']).'\', `permissions` = \''.implode(';', $arr).'\', `img` = \''.mysql_clean($_POST['desc']).'\' WHERE `id` = \''.$row[0].'\' LIMIT 1');
echo '1: <td title="'.htmlspecialchars($_POST['nombre']).'" style="width:20px"><img align="absmiddle" src="http://localhost/media/images/rangos/abastecedor.png"></td>
		<td style="text-align:left">'.htmlspecialchars($_POST['nombre']).'</td>
		<td style="width:75px">('.mysql_num_rows(mysql_query('SELECT `id` FROM `users` WHERE `rank` = \''.$row[0].'\'')).' usuarios)</td>
		<td style="width:75px"><a title="Editar rango" onclick="admin.edit_grade(\''.$row[0].'\'); return false" href="#" id="edit_'.$row[0].'"><img align="absmiddle" title="Editar rango" src="'.$config['images'].'/images/icons/sort.png"></a></td>
		<td style="width:75px"><a title="Eliminar rango" onclick="admin.del_grade(\''.$row[0].'\'); return false" href="#" id="del_'.$row[0].'"><img align="absmiddle" title="Eliminar rango" src="'.$config['images'].'/images/icons/borrar.png"></a></td>';