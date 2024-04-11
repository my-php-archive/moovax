<?php
if(!$_POST['id'] || !$_POST['_']) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!mysql_num_rows($g = mysql_query('SELECT `id`, `profile`, `author` FROM `walls` WHERE `id` = \''.(int)$_POST['id'].'\''))) { die('0La publicaci&oacute;n no existe'); }
list($id, $profile, $author) = mysql_fetch_row($g);
if(!mysql_num_rows($query = mysql_query('SELECT u.id AS uid, u.nick, u.avatar, w.* FROM `w_replies` AS w INNER JOIN `users` AS u ON u.id = w.`author` WHERE w.`what` = \''.$id.'\''))) { die('0La publicaci&oacute;n no tiene comentarios'); }
echo '1';
while($wall = mysql_fetch_assoc($query)) {
  echo '<ul class="commentList" id="cl_'.$wall['id'].'">                                                                                                                                                                  <li id="cmt_521" class="ufiItem">
    <div class="clearfix">
    <a class="autorPic" href="http://demo.phpost.net/perfil/'.$wall['nick'].'"><img width="32" height="32" src="'.$wall['avatar'].'" alt="'.$wall['nick'].'"></a>';
    if($logged['id'] == $wall['uid'] || $logged['id'] == $profile || $logged['id'] == $author || allow('delete_comments')) {
      echo '<span class="close"><a title="Eliminar" class="uiClose" onclick="muros.del_sub_comment('.$wall['id'].'); return false" href="#"></a></span>';
    }
    echo '<div class="mensaje">
    @<a class="autorName a_blue" href="/perfil/'.$wall['nick'].'">'.$wall['nick'].'</a>
    <span>'.$wall['body'].'</span>
    <div class="cmInfo">'.timefrom($wall['time']).' &middot; ';
    $like = mysql_num_rows(mysql_query('SELECT `id` FROM `w_likes` WHERE `author` = \''.$logged['id'].'\' && `what` = \''.$wall['id'].'\' && `type` = \'1\''));
    $nm = mysql_num_rows(mysql_query('SELECT `id` FROM `w_likes` WHERE `type` = \'1\' && `what` = \''.$wall['id'].'\''));
    if($like == 0) {
      echo '<a class="a_blue" onclick="muros.i_like('.$wall['id'].', \'sub_comment\', this); return false;">Me gusta</a> ';
    } else {
      echo '<a class="a_blue" onclick="muros.i_dont_like('.$wall['id'].', \'sub_comment\', this); return false;">Ya no me gusta</a> ';
    }
    echo '<span style="" class="cm_like"> &middot; <i></i>
    <a class="a_blue" id="lk_cm_'.$wall['id'].'" onclick="muros.ver_likes('.$wall['id'].', \'sub_comment\'); return false;">'.($nm > 0 ? $nm.' personas' : 'Se el primero en gustarle esto').'</a></span></div>
    </div>
    </div>
    </li>
    </ul>';
}