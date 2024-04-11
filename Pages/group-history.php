<?php
if(!defined($config['define'])) { die; }
if($logged['id']) {
  if(mysql_num_rows($m = mysql_query('SELECT `id`, `rank` FROM `groups_members` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\' && `status` = \'0\''))) {
    $ismember = true;
    list($idmember, $currentrank) = mysql_fetch_row($m);
  } else {
    fatal_error('Para ver esto debes ser miembro de la comunidad');
  }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\''))) {
    fatal_error('Fuiste baneado de la comu mmm');
  }
} else {
  fatal_error('Debes loguearte');
}
$cat = mysql_fetch_assoc(mysql_query('SELECT * FROM `groups_categories` WHERE `id` = \''.$group['cat'].'\''));
?>
<script>
var group = '<?=$group['id'];?>';
var g_com = '<?=$group['id'];?>';
 </script>
<div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->
<div class="comunidades">
<div class="breadcrumb">
<ul>
<li class="first"><a href="/comunidades/" title="Comunidades">Comunidades</a></li>
<li><a href="/comunidades/categoria/<?=$cat['id'];?>/" title="<?=$cat['name'];?>"><?=$cat['name'];?></a></li>
<li><a href="/comunidades/<?=$group['url'];?>/" title="<?=$group['name'];?>"><?=$group['name'];?></a></li>
<li><a>Historial de moderaci&oacute;n</a></li><li class="last"></li>
</ul>
</div>
<div style="clear:both"></div>
<?php include('groups-left.php'); ?>
</div>
<div class="panel-center">

<div id="showResult">
<h2>Historial de moderaci&oacute;n de temas</h2>
<?php
$query = mysql_query('SELECT g.*, u.nick FROM `groups_actions` AS g INNER JOIN `users` AS u ON u.id = g.author WHERE g.`group` = \''.$group['id'].'\' && g.`action` IN(\'0\',\'1\',\'4\') ORDER BY g.id DESC') or die(mysql_error());
if(mysql_num_rows($query)) {
  while($row = mysql_fetch_assoc($query)) {
    echo 'Tema: <a href="'.$row['url'].'" title="'.$row['title'].'"><strong>'.$row['title'].'</strong></a><br>Acci&oacute;n:';
    if($row['action'] == '0') {
      echo '<span class="color_green">Editado</span>';
    } elseif($row['action'] == '1') {
      echo '<span class="color_red">Borrado</span>';
    } else {
      echo '<span class="color_blue">Reactivado</span>';
    }
    echo '<br />Por: <a href="/perfil/'.$row['nick'].'" title="'.$row['nick'].'">'.$row['nick'].'</a><br />'.(!empty($row['reason']) ? $row['reason'] : ' - ').'<br /><div class="barra-dotted"></div>';
  }
} else { echo '<div class="redBox">No hay acciones</div>'; }
?>
</div>

</div>
<div class="panel-right">
  <div class="box_title_content">
    <div class="box_txt">&Uacute;ltimos comentarios</div>
    <div class="box_rss"><span class="floatR"><img alt="Actualizar" onclick="comunidades.update_comments_com('<?=$group['url'];?>'); return false;" src="<?=$config['images'];?>/images/icons/reload.png?v3.2.3" style="cursor: pointer;" title="Actualizar"></span></div>
  </div>
  <div class="box_cuerpo_content">
    <div id="ult_comm">
    <?php
    include('./ajax/groups-comments.php');
    ?>
    </div>
  </div>
  <br class="space">
  <div class="box_title_content">
    <div class="box_txt">&Uacute;ltimos Miembros</div>
  </div>
  <div class="box_cuerpo_content">
  <?php
  $query = mysql_query('SELECT u.nick, m.`time` FROM `users` AS u INNER JOIN `groups_members` AS m ON m.`user` = u.id WHERE m.`status` = \'0\' && u.`ban` = \'0\' && m.`group` = \''.$group['id'].'\' ORDER BY m.id DESC LIMIT 20');
  if(mysql_num_rows($query)) {
    while($row = mysql_fetch_row($query)) {
      echo '<font class="size11"><b>@<a alt="'.$row[0].'" title="'.$row[0].'" href="/perfil/'.$row[0].'">'.$row[0].'</a></b> - se uni&oacute; el '.date('d.m.Y', $row[1]).' a las '.date('G:i', $row[1]).'</font><br />';
    }
  } else { echo '<div class="yellowBox"><b class="size12">No hay miembros...</b></div>'; }
  ?>
    <!-- last members -->
  </div>
  <br class="space">
  <div class="denunciar"><a href="/comunidades/<?=$group['url'];?>/mod-history/" title="Historial">Historial de moderaci&oacute;n</a></div>
</div>

</div>
<div style="clear:both"></div>
<!-- fin cuerpocontainer -->
</div> </div>