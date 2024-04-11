<?php
if(!$group || !defined($config['define'])) { die; }
if($isban) { die('Chupala'); }
?>
<div class="panel-left">
<div class="box_title_content"><div class="box_txt">Comunidad</div></div>
<div class="box_cuerpo_content"><center><a href="/comunidades/<?=$group['url'];?>/"><img height="120px" width="120px" onerror="error_avatar(this)" title="Logo de la comunidad" class="avatar" alt="<?=$group['name'];?>" src="<?=$group['avatar'];?>"></a></center><br>
<a alt="<?=$group['name'];?>" title="<?=$group['name'];?>" href="/comunidades/<?=$group['url'];?>/"><b style="color:#124679;" class="size15"><?=$group['name'];?></b></a><br><br><hr class="divider">
<a href="/comunidades/<?=$group['url'];?>/miembros"><b><?=mysql_num_rows(mysql_query('SELECT `id` FROM `groups_members` WHERE `status` = \'0\' && `group` = \''.$group['id'].'\''));?></b> Miembros</a><br>
<b><?=mysql_num_rows(mysql_query('SELECT `id` FROM `groups_topics` WHERE `status` = \'0\' && `group` = \''.$group['id'].'\''));?></b> Temas<br>
<b><?=mysql_num_rows(mysql_query('SELECT `id` FROM `notifications` WHERE `url` REGEXP \'/comunidades/'.$group['url'].'[/]?\' && `type` = \'16\' GROUP BY `author`'));?></b> Recomendaciones<br />
<?php
if($logged['id']) {
?>
<hr class="divider"><br>
<center>
<input type="button" style="width:100px" value="Recomendar" title="Recomendar" class="Boton BtnGreen" alt="" onclick="comunidades.publicity(); return false;">
<br><br>
<?php
if(($currentrank == 5 && $ismember) || allow('editgroup')) {
?>
<input type="button" style="width:100px" value="Editar" title="" class="Boton BtnOrange" alt="" onclick="javascript:window.location.href='/comunidades/<?=$group['url'];?>/editar'">
<br><br>
<?php
}
if($group['author'] == $logged['id'] || allow('elimgroup')) {
?>
<input type="button" style="width:100px" value="Eliminar" title="Eliminar comunidad" class="Boton BtnBlue" onclick="comunidades.delete_community(); return false;"><br><br>
<?php
}
  if($ismember) {
    echo '<input type="button" style="width:100px" value="Abandonar" title="Abandonar comunidad" class="Boton BtnRed" alt="" onclick="comunidades.getout_community(); return false"><br><br>';
  } else {
    echo '<input type="button" style="width:100px" value="Unirse" title="Unirse" class="Boton BtnPurple" alt="" onclick="comunidades.join_community(); return false"><br><br>';
  }
}
echo '</div></div>';
?>