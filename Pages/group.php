<?php
if(!$_GET['id']) { fatal_error('Faltan datos'); }
if(!mysql_num_rows($query = mysql_query('SELECT * FROM `groups` WHERE `url` = \''.mysql_clean($_GET['id']).'\''))) { fatal_error('La comunidad no existe'); }
$group = mysql_fetch_assoc($query);
if($group['status'] != 0) { fatal_error('La comunidad fue eliminada'); }
if($group['id'] == 40 && !allow('show_panel')){ fatal_error('Solo el staff puede ver esta comunidad'); }
if($group['private'] == 1 && !$logged['id']) { fatal_error('Para ver esta comunidad debes estar logueado', 'OO0PS'); }
mysql_query('DELETE FROM `groups_ban` WHERE `reamingtime` < \''.time().'\' && `reamingtime` != \'0\'') or die(mysql_error());
$ismember = false;
if($logged['id']) {
  if(mysql_num_rows($qe = mysql_query('SELECT `id`, `rank` FROM `groups_members` WHERE `group` = \''.$group['id'].'\' && `user` = \''.$logged['id'].'\' && `status` = \'0\''))) {
    list($idmember, $currentrank) = mysql_fetch_row($qe);
    $ismember = true;
  }
  if(mysql_num_rows($p = mysql_query('SELECT `cause`, `reamingtime` FROM `groups_ban` WHERE `group` = \''.$group['id'].'\' && `user` = \''.$logged['id'].'\''))) {
    $row = mysql_fetch_row($p);
    fatal_error('Fuiste baneado de esta comunidad por la causa: <b>'.$row[0].'</b><br /><b> Fin de la suspenci&oacute;n:</b> '.($row[1] == 0 ? 'Indefinido' : date('d.m.Y', $row[1]).' a las '.date('G.i', $row[1])), 'Te portaste mal? <img src="http://26.media.tumblr.com/tumblr_lvrhyiBHcY1qibz0jo1_r1_500.png" widght="50" height="50" />', 'Ir a bardear al admin', '/', 'BtnBlue');
  }
}
$author = mysql_fetch_row(mysql_query('SELECT `nick` FROM `users` WHERE `id` = \''.$group['author'].'\''));
?>
<script>
var g_com = '<?=$group['id'];?>';
</script>
<div id="main_content">
<div class="breadcrumb">
  <ul>
    <li class="first"><a href="/" accesskey="1" class="home"></a></li>
    <li><a href="/comunidades/" title="Comunidades">Comunidades</a></li>
    <?php
    $cat = mysql_fetch_row(mysql_query('SELECT `name`, `url`, `id` FROM `groups_categories` WHERE `id` = \''.$group['cat'].'\''));
    ?>
    <li><a href="/comunidades/categoria/<?=$cat[2];?>" title="<?=$cat[0];?>" alt="<?=$cat[0];?>"><?=$cat[0];?></a></li>
    <li style="font-weight:bold;"><?=$group['name'];?></li><li class="last"></li>
  </ul>
</div>
<div style="clear: both;"></div>
<?php
include('groups-left.php');
?>
<div class="panel-center">
  <div class="box_title_content">
    <div class="box_txt"><?=$group['name'];?></div>
  </div>
  <div class="box_cuerpo_content">
    <table>
      <tr><td valign="top" style="padding:4px;font-size:13px;"><b>Descripci&oacute;n:</b></td> <td style="padding:4px;width:360px;white-space:pre-wrap;overflow:hidden;display:block;height:100%;background-color:#FFF;border: solid 1px #BDCFE1;"><?=nl2br($group['desc']);?></td></tr>
      <tr><td valign="top" style="padding:4px;font-size:13px;"><b>Categor&iacute;a:</b></td> <td  style="padding:4px;"><a href="/comunidades/categoria/<?=$cat[2];?>" title="<?=$cat[0];?>" alt="<?=$cat[0];?>"><?=$cat[0];?></a></td></tr>
      <tr><td valign="top" style="padding:4px;font-size:13px;"><b>Creada:</b></td> <td  style="padding:4px;" title="31 de Diciembre de 1969, 07:00:00 "><?=date('d.m.Y', $group['time']);?> a las <?=date('G:i', $group['time']);?></td></tr>
      <tr><td valign="top" style="padding:4px;font-size:13px;"><b>Due&ntilde;o:</b></td> <td  style="padding:4px;" title="<?=$author[0];?>" alt="<?=$author[0];?>"><a href="/perfil/<?=$author[0];?>" title="<?=$author[0];?>" alt="<?=$author[0];?>"><?=$author[0];?></a></td></tr>
      <?php if($logged['id'] && $ismember) { ?>
      <tr><td valign="top" style="padding:4px;font-size:13px;"><b>Mi rango:</b></td> <td  style="padding:4px;" title="<?=grouprank($currentrank);?>" alt="<?=grouprank($currentrank);?>"><?=grouprank($currentrank);?></td></tr>
      <?php } ?>
    </table>
  </div>
  <div class="clear"></div>
  <br class="space">
  <?php if($ismember && $currentrank != '1' && $currentrank != '2') { ?>
  <span class="floatR">
    <input onclick="javascript:window.location.href='/comunidades/<?=$group['url'];?>/agregar'" alt="" class="Boton BtnPurple" value="Nuevo tema" type="button" align="top" />
  </span>
  <?php } ?>
  <div class="clear"></div>
  <br class="space">
  <div class="box_title_content">

    <div class="box_txt">Temas Fijados</div>
  </div>
  <div class="box_cuerpo_content">
  <?php
  $query = mysql_query('SELECT t.`id`, t.`title`, u.nick FROM `groups_topics` AS t INNER JOIN `users` AS u ON u.id = t.`author` WHERE t.`status` = \'0\' && t.sticky = \'1\' && t.`group` = \''.$group['id'].'\' ORDER BY t.id DESC') or die(mysql_error());
  if(mysql_num_rows($query)) {
    while($r = mysql_fetch_assoc($query)) {
  ?>
  <div id="info2">
    <div>
    <div style="float:left;margin-right:5px;"><img title="Anuncio" alt="" src="<?=$config['images'];?>/images/comunidades/temas_fijo.png"></div>
    <div><a alt="<?=$r['title'];?>" title="<?=$r['title'];?>" target="_self" href="/comunidades/<?=$group['url'];?>/<?=$r['id'];?>/<?=url($r['title']);?>.html" style="color:#124679;font-weight:bold;font-size:13px;"><?=cut($r['title'], 35, '...');?></a></div>
    <div class="size10">Por <a alt="<?=$r['nick'];?>" title="<?=$r['nick'];?>" target="_self" href="/perfil/<?=$r['nick'];?>"><?=$r['nick'];?></a></div>
    </div>
  </div>
  <?php
    }
  } else { echo '<div class="yellowBox"><b class="size12">No hay temas fijados.</b></div>'; }
  ?>
  </div>
  <br class="space">
  <div class="box_title_content"><div class="box_txt">Temas</div></div>
  <div class="box_cuerpo_content">
  <?php
  $queryte = 'SELECT t.*, u.nick  FROM `groups_topics` AS t INNER JOIN `users` AS u ON u.id = t.`author` WHERE t.`status` = \'0\' && t.`group` = \''.$group['id'].'\' && t.`sticky` = \'0\' ORDER BY t.id DESC';
  $per = 15;
  $tot = mysql_num_rows(mysql_query($queryte));
  $ppp = ceil($tot / $per);
  $p = ($_GET['p'] && $_GET['p'] <= $ppp && $_GET['p'] > 1 && ctype_digit($_GET['p']) ? $_GET['p'] : 1);
  $act = ($p-1)*$per;
  $query = mysql_query($queryte.' LIMIT '.$act.', '.$per) or die(mysql_error());
  if(mysql_num_rows($query)) {
    //$color = 1;
    while($row = mysql_fetch_assoc($query)) {
      echo '<div class="comunidad_tema" id="info2"><div>
              <div style="float:left;margin-right:5px;"><img src="'.$config['images'].'/images/comunidades/temas.png" alt="" title="'.$row['title'].'" alt="'.$row['title'].'" /></div><div><a style="color:#124679;font-weight:bold;font-size:13px;" href="/comunidades/'.$group['url'].'/'.$row['id'].'/'.url($row['title']).'.html" target="_self" title="'.$row['title'].'" alt="'.$row['title'].'">'.cut($row['title'], 34).'</a></div></div>
              <div class="size10">Por <a href="/perfil/'.$row['nick'].'" target="_self" title="'.$row['nick'].'" alt="'.$row['nick'].'">'.$row['nick'].'</a></div>
            </div>';
     //$color = ($color == 1 ? 2 : 1);
    }
    if($p > 1 || $p <= $ppp) {
      //echo $p;
      echo '<p align="right" style="margin:0px;padding:0px;"><div align="right" class="paginacion2">
              <b>';
              if($p < $ppp) { echo '<span class="floatR" style="font-size:12px;font-weight:bold"><a href="/comunidades/'.$group['url'].'/pag-'.($p+1).'">Siguientes &#187;</a></span>'; }
              if($p > 1) { echo '<span class="floatL" style="font-size:12px;font-weight:bold"><a href="/comunidades/'.$group['url'].'/pag-'.($p-1).'">&#171; Anteriores</a></span>'; }
              echo '</b>
              <div class="clear"></div>
           </div></p>';
    }
  } else { echo '<div class="yellowBox"><b class="size12">No hay temas...</b></div>'; }
  ?>
  </div>
</div>
<!--  termina center -->
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
  <div class="denunciar" style="float:right;"><a href="/comunidades/<?=$group['url'];?>/miembros/" title="Historial">Todos los miembros</a></div>
  <div class="denunciar" style="float:left;"><a href="/comunidades/<?=$group['url'];?>/mod-history/" title="Historial">Historial de moderaci&oacute;n</a></div>
</div>
<div style="clear:both"></div></div></div></div>