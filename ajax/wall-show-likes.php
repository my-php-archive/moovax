<?php
if(!$_POST['id'] || !$_POST['tipo']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Desbes loguearte'); }
if($_POST['tipo'] == 'comment') {
  if(!mysql_num_rows($pq = mysql_query('SELECT `id` FROM `walls` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: El muro que ingresaste no existe'); }
  list($id) = mysql_fetch_row($pq);
  $query = mysql_query('SELECT u.id, u.nick, u.avatar, u.message FROM `users` AS u INNER JOIN `w_likes` AS w ON w.author = u.id WHERE w.`type` = \'0\' && `what` = \''.$id.'\' ORDER BY w.id DESC');
  if(!mysql_num_rows($query)) { die('0: A nadie le gusta esto'); }
} else {
  if(!mysql_num_rows($or = mysql_query('SELECT `id` FROM `w_replies` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: La respuesta no existe'); }
  $rq = mysql_fetch_row($or);
  $query = mysql_query('SELECT u.id, u.nick, u.avatar, u.message FROM `users` AS u INNER JOIN `w_likes` AS w ON w.author = u.id WHERE w.`type` = \'1\' && `what` = \''.$rq[0].'\' ORDER BY w.id DESC');
}
if(!mysql_num_rows($query)) { die('0: A nadie le gusta esto'); }
echo '1: ';
while($ps = mysql_fetch_assoc($query)) {
?>
<div align="left" class="floatL" style="padding-top:3px;padding-right:2px;width:50px;">
    <img width="50" height="50" border="0" src="<?=$ps['avatar']?>" alt="Avatar" onerror="error_avatar(this)">
</div>
<div align="left" style="padding-top:3px;padding-left:2px;width:380px;" class="floatL">
    <a style="font-weight:bold;color:#3B5998;font-size:13px;" href="/perfil/<?=$ps['nick'];?>/"><?=$ps['nick'];?></a>
    <?php
    if(!empty($ps['message'])) { echo '- <span style="font-size:11px;">'.cut($ps['message'], 50, '...').'</span>'; }
    ?>
	<br>
	<span style="font-size:12px;"><b><img align="absmiddle" border="0" src="<?=$config['images'];?>/images/fb_like.png"> <?=($ps['id'] == $logged['id'] ? 'Te' : 'Le');?> gusta esta entrada</b></span><br>
    <?php
    if(!mysql_num_rows(mysql_query('SELECT `id` FROM `friends` WHERE (`author` = \''.$logged['id'].'\' && `user` = \''.$ps['id'].'\') || (`author` = \''.$ps['id'].'\' && `user` = \''.$logged['id'].'\')')) && $logged['id'] != $ps['id']) {
        echo '<span class="floatR" style="margin-top:-24px">
			    <input type="button" class="Boton Small BtnGray" onclick="friends.add_form(\''.$ps['id'].'\'); return false;" value="Añadir a mis amigos" style="font-size:10px;-moz-border-radius:0px;-webkit-border-radius:0px;border-radius:0px;">
		      </span>';
    }
    ?>
</div>
<div class="clear"></div>
<div style="border-bottom:1px dashed #CCC;margin:bottom:4px;margin-top:6px"></div>
<?php
}
?>