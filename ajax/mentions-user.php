<?php
if(!$_POST['uid']) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!mysql_num_rows($query = mysql_query('SELECT u.*, r.`name` AS namerank, r.`img` FROM `users` AS u INNER JOIN `ranks` AS r ON r.`id` = u.rank WHERE u.`id` = \''.(int)$_POST['uid'].'\''))) { die('0: El usuario no existe'); }
$row = mysql_fetch_assoc($query);
//$rank = mysql_fetch_row(mysql_query('SELECT `name`, `img` FROM `ranks` WHERE `id` = \''.$row['rank'].'\''));
$country = mysql_fetch_row(mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `id` = \''.$row['country'].'\''));
?>
1<img class="avatartool" src="<?=$row['avatar'];?>"  onerror="error_avatar(this)" />
<div class="user-t-info clearfix">
<a href="/<?=$row['nick'];?>">
<strong><?=$row['nick'];?></strong>
</a><?=$row['namerank'];?><br /><span style="margin: 5px 1px 0 0;"><?php
if(mysql_num_rows(mysql_query('SELECT `id` FROM `online` WHERE `user` = \''.$row['id'].'\''))) {
  echo '<img src="'.$config['images'].'/images/user_online.gif" title="Conectado">';
} else {
  echo '<img src="'.$config['images'].'/images/user_offline.gif" title="Desconectado">';
}
?></span>
<img src="<?=$config['images'];?>/images/rangos/<?=$row['img'];?>" title="<?=$row['namerank'];?>" class="grade" align="absmiddle" /><img src="<?=$config['images'];?>/images/<?=($row['sex'] == 0 ? 'Hombre' : 'Mujer');?>.gif" title="<?=($row['sex'] == 0 ? 'Hombre' : 'Mujer');?>" class="sex" align="absmiddle" /><img src="<?=$config['images'];?>/images/icons/banderas/<?=$country[1];?>.png" title="<?=$country[0];?>" class="country-name" align="absmiddle" />
</div><?php
if($logged['id'] != $row['id'] && $logged['id']) {
  echo '<input style="margin:14px 0 0 16px;" class="Boton Small BtnGray" onclick="mp.enviar_mensaje(\''.$row['nick'].'\'); return false;" value="Enviar Mensaje" title="Enviar Mensaje" type="button" />';
}
?></div><div class="arrow-t"></div>