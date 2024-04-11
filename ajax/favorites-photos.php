<?php
if(!defined($config['define']) && !$_POST['order']) { die('0Faltan datos'); }
if($_POST['order'] && !defined($config['define'])) {
  include('../config.php');
  include('../functions.php');
  //$ajax = true;
}
if(!$logged['id']) { die('0Logueate'); }
if(!$_POST['order']) { $_POST['order'] = '2'; }
if(!ctype_digit($_POST['order'])) { die('0Error provocado'); }
switch($_POST['order']) {
  case '1': $vc = 'p.`title` ASC'; break;
  case '2': $vc = 'f.`time` DESC'; break;
  case '3': $vc = 'u.nick ASC'; break;
  case '4': $vc = 'p.votes DESC'; break;
  default: die('0Error provocado');
}
$str = mysql_query('SELECT p.`id`, p.`title`, cat.url, cat.name, u.nick, f.id AS fid, f.`time`, p.`votes` FROM `photos` AS p INNER JOIN `favorites` AS f ON f.id_pf = p.id INNER JOIN `users` AS u ON u.id = p.author INNER JOIN p_categories AS cat ON cat.id = p.cat WHERE p.`status` = \'0\' && f.author = \''.$logged['id'].'\' && f.`type` = \'1\' && f.`status` = \'0\' ORDER BY '.$vc) or die('0: '.mysql_error());
if(defined($config['define'])) { echo '<script>var act = \''.$_POST['order'].'\';</script>'; }
if(!mysql_num_rows($str)) { echo '<div style="width:750px" class="redBox size13">No hay ninguna foto en tus favoritos...</div>'; } else {
?>
<table class="linksList" style="width:781px;">
    <thead>
	    <tr>
    		<th>&nbsp;</th>
    		<th style="text-align:left"><a<?=($_POST['order'] == '1' ? ' class="here"' : '');?> href="#" onclick="favorite(1,1); return false;">Nombre</a></th>
    		<th><a<?=($_POST['order'] == '2' ? ' class="here"' : '');?> href="#" onclick="favorite(2,1); return false;">Agregado</a></th>
    		<th><a<?=($_POST['order'] == '3' ? ' class="here"' : '');?> href="#" onclick="favorite(3,1); return false;">Por</a></th>
    		<th><a<?=($_POST['order'] == '4' ? ' class="here"' : '');?> href="#" onclick="favorite(4,1); return false;">Puntos</a></th>
    		<th>Eliminar</th>
	    </tr>
	</thead>
	<tbody>
    <?php
    while($rs = mysql_fetch_assoc($str)) {
    ?>
    <tr id="bookmark_<?=$rs['fid'];?>">
	    <td title="Fotos" style="text-align:center;width:3px"><span class="categoriaPost <?=$rs['url'];?>"></span></td>
		<td style="text-align:left"><a href="/fotos/<?=$rs['url'];?>/<?=$rs['id'];?>/<?=url($rs['title']);?>.html" title="<?=$rs['title'];?>"><?=cut($rs['title'], 130, '...');?></a></td>
		<td><span property="dc:date"><?=timefrom($rs['time']);?></span></td>
		<td><a href="/perfil/<?=$rs['nick'];?>"><?=$rs['nick'];?></a></td>
		<td><?=$rs['votes'];?></td>
		<td align="center" style="width:2px"><a href="#" onclick="posts.del_bookmark('<?=$rs['fid'];?>',1); return false;" title="Eliminar este favorito"><img id="bookmark_img_<?=$rs['fid'];?>" src="<?=$config['images'];?>/images/cross.png" border="0"></a>
		<a onclick="posts.res_bookmark('<?=$rs['fid'];?>',1); return false;" title="Recuperar este favorito"><img style="display:none" id="bookmark_img2_<?=$rs['fid'];?>" src="<?=$config['images'];?>/images/reload.png" border="0"></a></td>
	</tr>
    <?php
    }
    ?>
    </tbody>
</table>
<?php
} //verga
?>