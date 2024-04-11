<?php
//if(!$_POST['last']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
echo '1';
$where = ''; //pf
if(!$logged['id']) { die('0Debes loguearte'); }
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `notifications` WHERE `status` = \'0\' && `id_user` = \''.$logged['id'].'\''))) { $limit = '4'; } else { $limit = 100; $where = ' && n.`status` = \'0\''; }
$not = mysql_query('SELECT n.*, u.nick, u.avatar FROM `notifications` AS n INNER JOIN `users` AS u ON u.id = n.author WHERE `id_user` = \''.$logged['id'].'\' '.$where.' ORDER BY n.id DESC LIMIT '.$limit) or die(mysql_error());
if(mysql_num_rows($not)) {
  while($nt = mysql_fetch_assoc($not)) {
    switch($nt['type']) {
      case '0':
        $img = 'comentario';
        $title = 'Coment&oacute; un post tuyo';
        //$y = 'o';
        break;
      case '1':
        $img = 'favorito';
        $title = 'Agreg&oacute; un post tuyo a favoritos';
        //$y = 'o';
        break;
      case '2':
        $img = 'puntos';
        $ps = explode('@$', $nt['url']);
        $title = 'Dej&oacute; '.$ps[1].' puntos a tu post';
        $nt['url'] = $ps[0];
        break;
      case '3':
        $img = 'muro';
        $title = 'Dej&oacute; un comentario en tu muro';
        break;
      case '4':
        $img = 'user_add';
        $title = 'Te ha mencionado en un comentario';
        break;
      case '5':
        $img = 'comment_add';
        $title = 'Coment&oacute; una foto tuya';
        break;
      case '6':
        $img = 'post';
        $title = 'Cre&oacute; un nuevo post';
        break;
      case '7':
        $img = 'user_add';
        $title = 'Acept&oacute; tu solicitud de amistad';
        break;
      case '8':
        $xp = explode('$', $nt['url']);
        if($xp[1] == '0') { $img = 'positive'; } else { $img = 'negative'; }
        $title = 'Vot&oacute; '.($xp[1] == '0' ? 'positivo' : 'negativo').' tu comentario';
        $nt['url'] = $xp[0];
        break;
      case '9':
        $title = 'Respondi&oacute; en un muro que comentaste';
        $img = 'user_add';
        break;
      case '10':
        $title = 'Respondi&oacute; a una publicaci&oacute;n tuya';
        $img = 'comment_add';
        break;
      case '11':
        $title = 'Le gusta tu publicaci&oacute;n';
        $img = 'like';
        break;
      case '12':
        $title = 'Agreg&oacute; una foto tuya a favoritos';
        $img = 'favorito';
        break;
      case '13':
        $title = 'Actualiz&oacute; su estado';
        $img = 'muro';
        break;
      case '14':
        $xp = explode('#', $nt['url']);
        $title = 'Dej&oacute; '.$xp[1].' puntos en tu foto';
        $img = 'puntos';
        $nt['url'] = $xp[0];
        break;
      case '15':
        $title = 'Agreg&oacute; una nueva foto';
        $img = 'camera';
        break;
      case '16':
        $title = 'Te recomienda una comunidad';
        $img = 'like';
        break;
      case '17':
        $xp = explode('#', $nt['url']);
        $title = 'Vot&oacute; '.($xp[1] == 0 ? 'positivo' : 'negativo').' tu tema';
        $img = ($xp[1] == 0 ? 'positive' : 'negative');
        $nt['url'] = $xp[0];
        break;
      case '18':
        $title = 'Respndi&oacute; a un tema tuyo';
        $img = 'comment_add';
        break;
      case '19':
        $title = 'Cre&oacute; un tema en tu comunidad';
        $img = 'post';
        break;
      case '20':
        $title = 'Respondi&oacute; en un tema que comentaste';
        $img = 'comment_add';
        break;
    }
    echo '<span style="unread" id="ult_notificaciones">
              <div id="notification_'.$nt['id'].'" class="box_container">
      	        <a title="Cerrar" onclick="del_notification(\''.$nt['id'].'\');return false;"><span class="cerrar"></span></a>
                  <div style="padding:2px;background-color: #'.($nt['status'] == 0 ? 'FFFFCC' : 'f6fbfc').';border-bottom: 1px dotted #C8C8C8;margin-bottom:0px;">
                  <a href="'.$nt['url'].'" style="">
                    <table>
                      <tbody>
                          <tr>
                            <td width="30px"><img width="32" height="35" border="0" onerror="error_avatar(this)" alt="Avatar" src="'.$nt['avatar'].'"></td>
                            <td>
                              <strong style="font-size:14px;color:#444;">'.$nt['nick'].'</strong>&nbsp;<span style="font-size:10px;color:#444;">'.timefrom($nt['time']).'</span>
                              <br>
                              <span style="color:#D35F2C;"><img align="absmiddle" border="0" src="'.$config['images'].'/images/notificaciones/'.$img.'.png"> '.$title.'</span>
                            </td>
                          </tr>
                      </tbody>
                    </table></a>
      	        </div>
  	        </div>
          </span>';
  }
} else { echo '<div class="redBox">Nada por aqu&iacute;...</div>'; }
if(!$_POST['_']) { mysql_query('UPDATE `notifications` SET `status` = \'1\' WHERE `id_user` = \''.$logged['id'].'\''); }
?>