<?php
//$var = '';
if(!$_POST['order'] && !defined($config['define'])) { die('0: Faltan datos'); }
if(!defined($config['define'])) {
  include('../config.php');
  include('../functions.php');
  //$var = '1';
}
if(!$logged['id']) { die('0: Debes est&aacute;r logueado'); }
if(!$_POST['order'] || !ctype_digit($_POST['order'])) { $_POST['order'] = 2; }
//if(!ctype_digit($_POST['order'])) die;
switch($_POST['order']) {
  case '1': $ord = 'p.`title` ASC'; break;
  case '2': $ord = 'f.`time` DESC'; break;
  case '3': $ord = 'u.nick ASC'; break;
  case '4': $ord = 'p.`points` DESC'; break;
  default: die('0Error provocado');
}
$fav = mysql_query('SELECT `p`.`id`, `p`.`title`, p.`points`, `cat`.`url`, cat.name, f.id AS fin, f.`time`, u.nick FROM `posts` AS p INNER JOIN `users` AS u ON u.id = p.author INNER JOIN `favorites` AS f ON f.id_pf = p.id INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE p.`status` = \'0\' && f.`author` = \''.$logged['id'].'\' && f.`type` = \'0\' && f.`status` = \'0\' ORDER BY '.$ord) or die(mysql_error());
if(!mysql_num_rows($fav)) {
  echo '<div style="width:750px" class="redBox size13">No hay ningun post en tus favoritos...</div>';
} else {
  //Si no se define es por ajax
  if(defined($config['define'])) { echo '<script>var act = \''.$_POST['order'].'\';</script>'; }
  //echo $var;
?>
<table class="linksList" style="width:781px;">
    <thead>
	    <tr>
		    <th>&nbsp;</th>
			<th style="text-align:left"><a<?=($_POST['order'] == 1 ? ' class="here"' : '');?> onclick="favorite(1,0); return false;">Nombre</a></th>
			<th><a<?=($_POST['order'] == 2 ? ' class="here"' : '');?> href="#" onclick="favorite(2,0); return false;">Agregado</a></th>
			<th><a<?=($_POST['order'] == 3 ? ' class="here"' : '');?> href="#" onclick="favorite(3,0); return false;">Por</a></th>
			<th><a<?=($_POST['order'] == 4 ? ' class="here"' : '');?> href="#" onclick="favorite(4,0); return false;">Puntos</a></th>
			<th>Eliminar</th>
		</tr>
	</thead>
	<tbody>
    <?php
    while($rs = mysql_fetch_assoc($fav)) {
    ?>
    <tr id="bookmark_<?=$rs['fin'];?>">
	    <td title="<?=$rs['name'];?>" style="text-align:center;width:3px"><span class="categoriaPost <?=$rs['url'];?>"></span></td>
		<td style="text-align:left"><a href="/posts/<?=$rs['url'];?>/<?=$rs['id'];?>/<?=url($rs['title']);?>.html" title="<?=$rs['title'];?>"><?=cut($rs['title'], 120, '...');?></a></td>
		<td><span property="dc:date"><?=timefrom($rs['time']);?></span></td>
		<td><a href="/perfil/<?=$rs['nick'];?>"><?=$rs['nick'];?></a></td>
		<td><?=$rs['points'];?></td>
		<td align="center" style="width:2px"><a href="#" onclick="posts.del_bookmark('<?=$rs['fin'];?>','0'); return false;" title="Eliminar este favorito"><img id="bookmark_img_<?=$rs['fin'];?>" src="<?=$config['images'];?>/images/cross.png" border="0"></a>
		<a onclick="posts.res_bookmark('<?=$rs['fin'];?>','0'); return false;" title="Recuperar este favorito"><img style="display:none" id="bookmark_img2_<?=$rs['fin'];?>" src="<?=$config['images'];?>/images/reload.png" border="0"></a></td>
	</tr>
    <?php
    }
    ?>
	</tbody>
</table>
<?php
} /* mierda de if */
?>