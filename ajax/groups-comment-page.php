<?php
if(!defined($config['define']) && ($_GET['ajax'] && !$_GET['id'])) { die; }
if($_GET['ajax']) {
  include('../config.php');
  include('../functions.php');
  if(!mysql_num_rows($query = mysql_query('SELECT * FROM `groups_topics` WHERE `id` = \''.(int)$_GET['id'].'\''))) { die('0: El tema no existe'); }
  $row = mysql_fetch_assoc($query);
  $group = mysql_fetch_assoc(mysql_query('SELECT * FROM `groups` WHERE `id` = \''.$row['group'].'\''));
  if($group['status'] != '0') { die('concha :F'); }
  $ismember = false;
  if($logged['id']) {
    if(mysql_num_rows($query = mysql_query('SELECT `id`, `rank`, `status` FROM `groups_members` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\''))) {
      list($id, $currentrank, $status) = mysql_fetch_row($query);
      if($status != '1') { $ismember = true; }
    }
    if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\''))) { die; }
  }
  if($row['status'] != 0 && !allow('noseque') && $currentrank != '5' && $currentrank != '4') { die; }
}
if(!$group) { die('Se producio un error inesperado'); }
$query = 'SELECT c.*, u.nick, u.avatar FROM `groups_comments` AS c INNER JOIN `users` AS u ON u.id = c.author WHERE c.`id_topic` = \''.$row['id'].'\' ORDER BY c.id ASC';
$tot = mysql_num_rows(mysql_query($query));
$per = 20;
$ppp = ceil($tot / $per);
$_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) && $_GET['p'] <= $ppp ? $_GET['p'] : 1;
$limit = ($_GET['p']-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per) or die('0: '.mysql_error());
if($tot) {
  while($comment = mysql_fetch_assoc($query)) {
    echo '<div id="cmt_'.$comment['id'].'" class="coment-user">
  <div class="comment-container'.($row['author'] == $comment['author'] ? '-autor' : ($logged['id'] == $comment['author'] ? '-me' : '')).'">
  <div class="comment-title">
  <div class="floatL">
  <span text_cmt="'.$comment['body'].'" user_cmt="'.$comment['nick'].'" id="comment_'.$comment['id'].'"></span>
  @<a class="hovercard" data-uid="'.$comment['author'].'" title="'.$comment['nick'].'" href="/perfil/'.$comment['nick'].'">'.$comment['nick'].'</a></b> - <span class="size11">'.timefrom($comment['time']).'</span>
  </div>
  <div class="floatR answerOptions">
  <ul>';
  if($logged['id']) {
    echo '<li class="answerPerfil"><a target="_self" title="Ver perfil de '.$comment['nick'].'" href="/'.$comment['nick'].'"><span class="ver-perfil"></span></a></li>
    <li class="answerCitar"><a title="Citar Comentario" href="#" onclick="citar_comment('.$comment['id'].'); return false"><span class="citar-comentario"></span></a></li>';
    if($logged['id'] == $comment['author'] || $currentrank == '4' || $currentrank == '5' || $row['author'] == $logged['id'] || allow('deletereply')) { echo '<li class="answerBorrar"><a title="Eliminar comentario" href="#" onclick="if (!confirm(\'\xbfEstas seguro que desea eliminar este comentario?\')); comunidades.del_comment(\''.$comment['id'].'\'); return false;"><span class="borrar-comentario"></span></a></li>'; }
  }
  echo '</ul></div>
  </div><div class="comment-cuerpo">'.BBposts($comment['body'], false, true, false, true).'</div>
  </div>
  </div><br class="space"><div class="clear"></div>';
  }
  echo '<span style="display:none;margin-top:0px;" id="return_add_comment"></span>';
  if($_GET['p'] > 1 || $_GET['p'] < $ppp) {
    echo '<div class="paginadorCom">';
    if($_GET['p'] > 1) { echo '<div class="before floatL"><a href="#" onclick="comunidades.comments_pag('.$row['id'].','.($_GET['p'] - 1).'); return false;"> <b>&laquo; Anterior</b></a></div>'; }
    if($_GET['p'] < $ppp) { echo '<div class="floatR next"><a href="#" onclick="comunidades.comments_pag('.$row['id'].','.($_GET['p'] + 1).'); return false;"> <b>Siguiente &raquo;</b></a></div>'; }
    echo '</div>';
  }
} else { echo '<div id="sin_comentarios"><div class="textInfo"><b>Este tema no tiene comentarios. Soyez le premier!</b></div></div><span style="display:none;margin-top:0px;" id="return_add_comment"></span>'; }
echo '<div class="clear">';
?>