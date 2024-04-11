<?php
if($_GET['ajax']) {
  if(defined($config['define'])) { fatal_error('Chupame la pija'); }
  include('../config.php');
  include('../functions.php');
  if(!$_GET['group'] || ($_GET['action'] != '1' && $_GET['action'] != '2' && $_GET['action'] != '3')) { die('0: Faltan datos'); }
  $currentgroup = $_GET['group'];
} elseif(!defined($config['define'])) { die; }
if(!$_GET['action']) { $_GET['action'] = 1; }
if(!$currentgroup) { die; }
if(!$logged['id'] && $_GET['action'] != 1) { die('0: Logueate'); }
if(!mysql_num_rows($query = mysql_query('SELECT * FROM `groups` WHERE `id` = \''.(int)$currentgroup.'\' && `status` = \'0\''))) { die('0: La comunidad no existe'); }
$group = mysql_fetch_assoc($query);
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `status`, `rank` FROM `groups_members` WHERE `group` = \''.$group['id'].'\' && `user` = \''.$logged['id'].'\'')) && $_GET['action'] != '1') {
  die('0: Para ver esta secci&oacute;n debes ser mimembro de la comunidad');
} else {
  list($idmember, $status, $currentrank) = mysql_fetch_row($query);
  if($status == '1') { die('0: error provocado'); }
}
if($currentrank != 4 && $currentrank != 5 && ($_GET['action'] == 2 || $_GET['action'] == 3)) { die('0: Tu rango no te permite ver esto'); }
$q = '';
if($_GET['q']) { $q = ' && u.nick LIKE \'%'.mysql_clean($_GET['q']).'%\''; }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\''))) { die; }
if($_GET['action'] == '1') {
    $query = 'SELECT u.id, u.nick, u.avatar, u.sex, m.rank, m.`status`, m.`time` FROM `users` AS u INNER JOIN `groups_members` AS m ON m.`user` = u.id WHERE m.`group` = \''.$group['id'].'\' && u.`ban` = \'0\' && m.`status` = \'0\''.$q.' ORDER BY m.id DESC';
} elseif($_GET['action'] == '2') {
  $query = 'SELECT u.id, u.nick, u.avatar, u.sex, m.rank, m.`status`, m.`time`, b.`cause` FROM `users` AS u INNER JOIN `groups_members` AS m ON m.`user` = u.id INNER JOIN `groups_ban` AS b ON b.`user` = m.`user` WHERE m.`group` = \''.$group['id'].'\''.$q.' && u.`ban` = \'0\' && m.status = \'0\' ORDER BY m.id DESC';
} else {
  $query = 'SELECT u.id, u.nick, h.type, h.`time`, h.`text`, h.`duration`, u2.nick AS `mod` FROM `users` AS u INNER JOIN `groups_history` AS h ON h.`user` = u.id INNER JOIN `users` AS u2 ON u2.id = h.`author` && h.`group` = \''.$group['id'].'\''.($q ? ' && (u.`nick` LIKE \'%'.mysql_clean($_GET['q']).'%\' || u2.nick LIKE \'%'.$_GET['q'].'%\')' : '').' ORDER BY h.id DESC';
}
$tot = mysql_num_rows(mysql_query($query));
$ppp = ceil($tot / 10);
$p = ($_GET['p'] && ctype_digit($_GET['p']) && $_GET['p'] <= $ppp ? $_GET['p'] : 1);
$limit = ($p-1)*10;
$query = mysql_query($query.' LIMIT '.$limit.', 10') or die('0: error en la consulta:'.mysql_error());
if(!$tot) {
  echo '0: ';
  if($_GET['action'] == 1) {
    echo 'No hay miembros';
  } elseif($_GET['action'] == 2) {
    echo 'No hay usuarios baneados';
  } else {
    echo 'No hay ninguna acci&oacute;n';
  }
} else {
  if($_GET['ajax']) { echo '1: '; }
  echo '<script> var com = { miembros_list_pag_actual: \''.$p.'\', }; var miembros_list_pag_actual = \''.$p.'\';</script>';
  if($_GET['action'] == 1 || $_GET['action'] == 2) {
    $i = 0;
    echo '<table>
    <tbody>
    <tr style="width:265px;">';
    while($row = mysql_fetch_assoc($query)) {
      echo '<td>
                <div style="width:241px;" class="CodePro"><table><tbody><tr><td><a alt="'.$row['nick'].'" title="'.$row['nick'].'" href="/perfil/'.$row['nick'].'"><img height="100px" width="100px" onerror="error_avatar(this)" title="'.$row['nick'].'" class="avatar" alt="'.$row['nick'].'" src="'.$row['avatar'].'"></a></td>
                <td valign="top" style="width:160px;">
                <b class="size15">@<a alt="'.$row['nick'].'" title="'.$row['nick'].'" href="/perfil/'.$row['nick'].'">'.$row['nick'].'</a></b><br><br />
                <li><img alt="Rango" src="'.$config['images'].'/images/rangos/presidente.png" /> <strong>'.grouprank($row['rank']).'</strong></li>
                <img border="0" title="'.($row['sex'] == 0 ? 'Hombre' : 'Mujer').'" src="'.$config['images'].'/images/'.($row['sex'] == 0 ? 'Hombre' : 'Mujer').'.gif"> '.($row['sex'] == 0 ? 'Hombre' : 'Mujer').' <br>
                <img alt="Enviar mensaje privado" src="'.$config['images'].'/images/icons/mensaje_para.gif"><a title="Enviar mensaje" onclick="mp.enviar_mensaje(\''.$row['nick'].'\'); return false"> <font style="font-weight:normal">Enviar mensaje</font></a>';
                if($currentrank == 4 || $currentrank == 5) { echo '<br><img align="top" src="'.$config['images'].'/images/edit2.png"> <a title="Administrar miembro" href="javascript:comunidades.admin_users('.$row['id'].');">Administrar miembro</a></td>'; }
                echo '</tr></tbody></table></div>
            </td>';
    if(++$i == 2) { echo '</tr><tr style="width:265px;">'; $i = 0; }
    }
    echo '</tr>
    </tbody>
    </table>';
  } else {
    while($fetch = mysql_fetch_assoc($query)) {
      switch($fetch['type']) {
        case '1':
          echo 'Usuario: <a href="/perfil/'.$fetch['nick'].'/"><strong>'.$fetch['nick'].'</strong></a> suspendido por <a href="/perfil/'.$fetch['mod'].'/"><strong>'.$fetch['mod'].'</strong></a> el d&iacute;a <strong>'.date('d/m/Y G:i', $fetch['time']).'</strong><br>Raz&oacute;n: <strong style="color:red;">'.$fetch['text'].'</strong><br>Duraci&oacute;n: <strong>'.($fetch['duration'] == 0 ? 'Permanente</strong>' : $fetch['duration'].' d&iacute;as </strong> hasta el <strong>'.date('d/m/Y', $fetch['time']+($history['duration']*86400)).'</strong>');
          break;
        case '2':
          echo 'Usuario: <a href="/perfil/'.$fetch['nick'].'/"><strong>'.$fetch['nick'].'</strong></a> cambiado de rango a <strong style="color:blue;">'.grouprank($fetch['text']).'</strong> por <a href="/perfil/'.$fetch['mod'].'/"><strong>'.$fetch['mod'].'</strong></a> el d&iacute;a <strong>'.date('d/m/Y G:i', $fetch['time']).'</strong>';
          break;
        case '3':
          echo 'Usuario: <a href="/perfil/'.$fetch['nick'].'/"><strong>'.$fetch['nick'].'</strong></a> rehabilitado por <a href="/perfil/'.$fetch['mod'].'/"><strong>'.$fetch['mod'].'</strong></a> el d&iacute;a <strong>'.date('d/m/Y G:i', $fetch['time']).'</strong><br>Raz&oacute;n: <strong style="color:green;">'.$fetch['text'].'</strong>';
          break;
      }
      echo '<div class="barra-dashed"></div>';
    }
  }
  if($tot > 10) {
    echo '<div style="width:500px" class="paginadorCom">';
    if($p > 1) { echo '<div class="floatL before"><a href="#" onclick="comunidades.miembros_list_ant(); return false;" href="#"><b>&laquo; Anterior</b></a></div>'; }
    if($p < $ppp) { echo '<div class="floatR next"><a href="#" onclick="comunidades.miembros_list_sig(); return false;"><b>Siguiente &raquo;</b></a></div>'; }
    echo '</div>';
  }
}