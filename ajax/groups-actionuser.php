<?php
if(!$_GET['group'] || !$_GET['uid']) { die; }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { fatal_error('Debes loguearte'); }
if(!mysql_num_rows($query = mysql_query('SELECT * FROM `groups` WHERE `id` = \''.(int)$_GET['group'].'\''))) { fatal_error('La comunidad no existe'); }
$row = mysql_fetch_assoc($query);
if(!mysql_num_rows($query2 = mysql_query('SELECT * FROM `groups_members` WHERE `user` = \''.(int)$_GET['uid'].'\' && `group` = \''.$row['id'].'\' && `status` = \'0\''))) { fatal_error('El miembro no existe'); }
$user = mysql_fetch_assoc($query2);
if(!mysql_num_rows($member = mysql_query('SELECT `rank`, `status` FROM `groups_members` WHERE `group` = \''.$row['id'].'\' && `user` = \''.$logged['id'].'\''))) { fatal_error('Debes pertenecer a esta comunidad'); }
list($currentrank, $status) = mysql_fetch_row($member);
if($currentrank != 4 && $currentrank != 5) { fatal_error('No tienes suficientes privilegios'); }
if($status != 0) { fatal_error('Ocurrio un error', 'OOPS'); }
if(mysql_num_rows($query = mysql_query('SELECT * FROM `groups_ban` WHERE `group` = \''.$row['id'].'\' && `user` = \''.(int)$_GET['uid'].'\''))) {
  $isban = true;
  $ban = mysql_fetch_assoc($query);
}
if($_GET['uid'] == $logged['id']) { die('0: No puedes administrarte a ti mismo <img width="100" height="100" src="http://i380.photobucket.com/albums/oo250/dreamTj/chilewarez/middle-finger.jpg" />'); }
if($_GET['send']) {
  if(!$_GET['currentuser'] || $_GET['currentuser'] != $logged['id']) { die('0: puton'); }
  if(!$_GET['action'] || ($_GET['action'] != 1 && $_GET['action'] != 2 && $_GET['action'] != 3)) { die('0: Faltan datos'); }
  if($_GET['action'] == '2') {
    if($currentrank != 5) { die('0: No tienes permisos'); }
    if(!$_GET['newrank'] || $_GET['newrank'] < 1 || $_GET['newrank'] > 5 || !ctype_digit($_GET['newrank'])) { die('0: El rango ingresado no existe'); }
    mysql_query('UPDATE `groups_members` SET `rank` = \''.(int)$_GET['newrank'].'\' WHERE `id` = \''.$user['id'].'\' LIMIT 1');
    mysql_query('INSERT INTO `groups_history` (`author`, `user`, `type`, `group`, `time`, `text`) VALUES (\''.$logged['id'].'\', \''.$_GET['uid'].'\', \'2\', \''.$row['id'].'\', \''.time().'\', \''.(int)$_GET['newrank'].'\')');
  } elseif($_GET['action'] == '3') {
    //if($currentrank != 4 && $currentrank != 5) { die('0: No tienes permisos'); }
    if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author` FROM `groups_ban` WHERE `user` = \''.(int)$_GET['uid'].'\' && `group` = \''.$row['id'].'\''))) { die('0: El usuario no est&aacute; baneado'); }
    $r = mysql_fetch_row($query);
    if($r[1] != $logged['id'] && $currentrank != 5) { die('0: No puedes desbanear un usuario que no baneaste tu (solo el admin puede)'); }
    if(!trim($_GET['reason'])) { die('0: Faltan datos'); }
    mysql_query('DELETE FROM `groups_ban` WHERE `id` = \''.$r[0].'\' LIMIT 1');
    mysql_query('INSERT INTO `groups_history` (`author`, `user`, `type`, `text`, `group`, `time`) VALUES (\''.$logged['id'].'\', \''.(int)$_GET['uid'].'\', \'3\', \''.mysql_clean($_GET['reason']).'\', \''.$row['id'].'\', \''.time().'\')');
  } else {
    //if($currentrank != 4 && $currentrank != 5) { die; }
    if(!trim($_GET['reason'])) { die('0: Faltan datos'); }
    if(!$_GET['permanent'] && ($_GET['time'] && !ctype_digit($_GET['time']))) { die('0: -uiy'); }
    if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.(int)$_GET['uid'].'\' && `group` = \''.$row['id'].'\''))) { die('0: Este usuario ya se encuentra baneado'); }
    $days = ($_GET['permanent'] ? 0 : time()+($_GET['time']*64800));
    mysql_query('INSERT INTO `groups_ban` (`author`, `user`, `cause`, `reamingtime`, `group`, `time`) VALUES (\''.$logged['id'].'\', \''.$user['user'].'\', \''.mysql_clean($_GET['reason']).'\', \''.$days.'\', \''.$row['id'].'\', \''.time().'\')');
    mysql_query('INSERT INTO `groups_history` (`author`, `user`, `type`, `text`, `group`, `time`, `duration`) VALUES (\''.$logged['id'].'\', \''.(int)$_GET['uid'].'\', \'1\', \''.mysql_clean($_GET['reason']).'\', \''.$row['id'].'\', \''.time().'\', \''.($_GET['permanent'] ? 0 : (int)$_GET['time']).'\')');
  }
  echo '1: Cambios aceptados!';
} else {
?>
1:
<style>
#modalBody {
  text-align:center;
  font-size:13px;
  padding: 20px 5px;
}



.modalForm {
  text-align: left;
  background: #EEE;
  border: 1px solid #b9b9b9;
  margin-bottom: 10px;
  padding: 5px;
  font-size:11px;
  font-weight:normal;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
}
	#modalBody input.selected {
-moz-box-shadow:0 0 5px #0066FF!important;
border:1px solid #0066FF!important;
}

#modalBody input[type="radio"] {
	width: auto;
    margin-right: 10px;
    vertical-align: baseline;
}

#modalBody .modalForm.here {
  background: #ffffcc;
  border: 1px solid #bebe33;
}

#modalBody input {
  margin: 0 0 0 0;
  vertical-align: middle;
}
#modalBody input#icausa_status {
  width: 300px;
}

.mTitle {
  font-weight: bold;
  font-size: 13px;
  padding-left: 5px;
}

.mColLeft {
  float:left;
  text-align: right;
  width: 35%;
}

.mColRight {
  float: right;
  width: 60%;
}

#cuerpo input.iTxt {
  border: 1px solid #CCC;
  background: #FFF;
  width: 160px;
  font-size: 11px;
  padding: 3px;
}

#modalBody input.mDate {
  width: 35px;
}

li.mBlock {
  margin-bottom: 10px;
  clear:both;
}

li.cleaner {
  clear:both;
}

.orange {
  color: #ff6600;
}
</style>
<script>
var group = '<?=$row['id'];?>';
var rango_actual = '<?=$user['rank'];?>';
</script>
<form id="gauf" onclick="comunidades.admin_users_check();" action="javascript:groups_adminusers_submit();">
<input type="hidden" name="user" id="user" value="<?=$user['user'];?>">
<input type="hidden" name="group" id="group" value="<?=$row['id'];?>">
<input type="hidden" name="currentuser" id="currentuser" value="<?=$logged['id'];?>">
<?php
if($isban) {
$modera = mysql_query('SELECT h.*, u.nick FROM `groups_history` AS h INNER JOIN `users` AS u ON h.`author` = u.id WHERE h.`group` = \''.$row['id'].'\' && h.`user` = \''.(int)$_GET['uid'].'\' ORDER BY h.id DESC LIMIT 5');
?>
<div class="redBox">Suspendido <a id="vermas" onclick="if($('#ver_mas').css('display')=='none'){$('#ver_mas').show('slow');$('#vermas').html('&laquo; Ver menos');return false;}else{$('#ver_mas').hide('slow');$('#vermas').html('Ver m&aacute;s &raquo;');return false;}" href="#">Ver m&aacute;s &raquo;</a></div>
<div style="display:none;" id="ver_mas"><br>
<?php
while($fetch = mysql_fetch_assoc($modera)) {
    switch($fetch['type']) {
        case '1':
            echo 'Suspendido por <a href="/perfil/'.$fetch['nick'].'/"><strong>'.$fetch['nick'].'</strong></a> el d&iacute;a <strong>'.date('d/m/Y G:i', $fetch['time']).'</strong><br>Raz&oacute;n: <strong style="color:red;">'.$fetch['text'].'</strong><br>Duraci&oacute;n: <strong>'.($fetch['duration'] == 0 ? 'Permanente</strong>' : $fetch['duration'].' d&iacute;as </strong> hasta el <strong>'.date('d/m/Y', $fetch['time']+($history['duration']*86400)).'</strong>');
            break;
        case '2':
            echo 'Cambiado de rango a <strong style="color:blue;">'.grouprank($fetch['text']).'</strong> por <a href="/perfil/'.$fetch['nick'].'/"><strong>'.$fetch['nick'].'</strong></a> el d&iacute;a <strong>'.date('d/m/Y G:i', $fetch['time']).'</strong>';
            break;
        case '3':
            echo 'Rehabilitado por <a href="/perfil/'.$fetch['nick'].'/"><strong>'.$fetch['nick'].'</strong></a> el d&iacute;a <strong>'.date('d/m/Y G:i', $fetch['time']).'</strong><br>Raz&oacute;n: <strong style="color:green;">'.$fetch['text'].'</strong>';
    }
    echo '<div class="barra-dashed"></div>';
}
echo '</div>';
?>
</div>
<br />
<div onclick="document.getElementById('r_rehabilitar').checked=true;" class="modalForm">
  <input type="radio" value="3" name="r_admin_user" id="r_rehabilitar"><span class="mTitle">Rehabilitar</span>
  <div class="admin_user_center">
    <ul>
      <li class="mBlock">
        <ul>
          <li class="mColLeft">

            Causa:
          </li>
          <li class="mColRight">
            <input type="text" onkeyup="groups_adminusers_check();" name="causa" id="t_causa" class="iTxt">
          </li>
          <li class="cleaner"></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<?php } else { ?>
<div onclick="document.getElementById('r_suspender').checked=true;" class="modalForm">

  <input type="radio" value="1" name="r_admin_user" id="r_suspender"><span class="mTitle">Suspender</span>
  <div class="admin_user_center">
    <ul>
      <li class="mBlock">
        <ul>
          <li class="mColLeft">

            Causa:
          </li>
          <li class="mColRight">
            <input type="text" onkeyup="comunidades.admin_users_check();" maxlength="50" name="causa" id="t_causa" class="iTxt">
          </li>
          <li class="cleaner"></li>
        </ul>
      </li>
      <li class="mBlock">

        <ul>
          <li class="mColLeft">
            Tiempo:
          </li>
          <li class="mColRight">
            <input type="radio" value="1" onclick="comunidades.admin_users_check();" name="r_suspender_dias" id="r_suspender_dias1"> <label for="r_suspender_dias1">Permanente</label>
            <hr>
            <input type="radio" value="2" onclick="comunidades.admin_users_check();" name="r_suspender_dias" id="r_suspender_dias2"> <input type="text" onkeyup="comunidades.admin_users_check();" class="mDate iTxt" name="i_suspender_dias" id="t_suspender"> <label for="r_suspender_dias2">D&iacute;as</label>

          </li>
          <li class="cleaner"></li>
        </ul>
      </li>
    </ul>
  </div>
</div><input type="hidden" id="r_rehabilitar">
<?php } if($currentrank == 5) { ?>
<div onclick="document.getElementById('r_rango').checked=true;" class="modalForm">
  <input type="radio" value="2" name="r_admin_user" id="r_rango"> <label class="mTitle" for="r_rango">Cambiar Rango:</label>

  <div onclick="document.getElementById('r_rango').checked=true;" class="admin_user_center">
  <ul>
    <li class="mBlock">
      <ul>
        <li class="mColLeft">
          Rango Actual:
        </li>
        <li class="mColRight">

          <strong class="orange"><?=grouprank($user['rank']);?></strong>
        </li>
        <li class="cleaner"></li>
      </ul>
    </li>
    <li class="mBlock">
      <ul>
        <li class="mColLeft">

          Rango Nuevo:
        </li>
        <li class="mColRight">
          <select onchange="comunidades.admin_users_check();" name="s_rango" id="s_rango">
            <option value="5"<?=($user['rank'] == 5 ? ' selected="selected"' : '');?>>Administrador</option>
            <option value="4"<?=($user['rank'] == 4 ? ' selected="selected"' : '');?>>Moderador</option>
            <option value="3"<?=($user['rank'] == 3 ? ' selected="selected"' : '');?>>Posteador</option>
            <option value="2"<?=($user['rank'] == 2 ? ' selected="selected"' : '');?>>Comentador</option>
            <option value="1"<?=($user['rank'] == 1 ? ' selected="selected"' : '');?>>Visitante</option>
          </select>
        </li>
        <li class="cleaner"></li>
      </ul>
    </li>
  </ul>
  </div>
</div>
</form>
<?php } } /* if */ ?>