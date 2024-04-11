<?php
if(!defined('ok')) { die; }
?>
<div class="boxtitleProfile clearfix">
    <h3 style="margin-bottom:-6px;">Editar mis amigos</h3>
</div>
<?php
// Hacemos la big query :B (?
$r = 'SELECT u.`id`, u.`nick`, u.`avatar`, u.`sex`, r.`name`, r.`img` FROM `users` AS u INNER JOIN `friends` AS f ON IF(`f`.`author` = \''.$logged['id'].'\', `f`.`user`, `f`.`author`) = u.`id` INNER JOIN `ranks` AS r ON r.id = u.rank WHERE f.`status` = \'1\' && u.`ban` = \'0\' && (f.`author` = \''.$logged['id'].'\' || f.`user` = \''.$logged['id'].'\') ORDER BY f.`id` DESC';
$num = mysql_num_rows(mysql_query($r));
$per = 10;
$tot = ceil($num / $per);
$_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) && $_GET['p'] <= $tot ? $_GET['p'] : 1;
$act = ($_GET['p']-1)*$per;
$query = mysql_query($r.' LIMIT '.$act.', '.$per) or die(mysql_error());
if(mysql_num_rows($query)) {
    while($row = mysql_fetch_assoc($query)) {
?>
<div id="amis_<?=$row['id'];?>">
	<div class="muroEfect" id="muroEfectAV">
	    <table>
			<tbody>
            <tr>
                <td><img style="width: 50px; height: 50px;" alt="" class="avatar-box" src="<?=$row['avatar'];?>" onerror="error_avatar(this)"></td>
                <td><a  style="font-weight: bold; font-size: 14px; color: green;" href="/perfil/<?=$row['nick'];?>/" title="Ver perfil de <?=$row['nick'];?>"><?=$row['nick'];?></a>
            	<br>
                <span title="<?=$row['name'];?>"><img src="<?=$config['images'];?>/images/rangos/<?=$row['img'];?>" border="0" align="absmiddle"> - <?=$row['name'];?></span> |
                <?php
                $ver = mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `id` = \''.$row['country'].'\'') or die(mysql_error());
                $s = mysql_fetch_row($ver);
                ?>
                <span title=""><img alt="" title="<?=$s[0];?>" src="<?=$config['images'];?>/images/icons/banderas/<?=strtolower($r[1]);?>.gif" align="absmiddle" /> -
                </span> | <span title="<?=($row['sex'] == '0' ? 'Hombre' : 'Mujer');?>"><img src="<?=$config['images'];?>/images/<?=($row['sex'] == '0' ? 'Hombre' : 'Mujer');?>.gif" title="<?=($row['sex'] == '0' ? 'Hombre' : 'Mujer');?>" border="0" align="absmiddle" /> - <?=($row['sex'] == '0' ? 'Hombre' : 'Mujer');?></span> |
                <?php
                if(mysql_num_rows(mysql_query('SELECT `id` FROM `online` WHERE `user` = \''.$row['id'].'\''))) {
                  $img = 'user_online.gif';
                  $title = 'Conectad'.($row['sex'] == '0' ? 'o' : 'a');
                } else {
                  $img = 'user_offline.gif';
                  $title = 'Desconectad'.($row['sex'] == '0' ? 'o' : 'a');
                }
                ?>
                <span alt="<?=$title;?>" title="<?=$title;?>"><img src="<?=$config['images'];?>/images/<?=$img;?>" alt="<?=$title;?>"> - <?=$title;?></span> |
                <a onclick="if (!confirm('\xbfEstas seguro que deseas eliminar a este usuario de tus amigos?')) return false; friends.del_wall('<?=$row['id'];?>'); return false;" title="Eliminar usuario de mi lista de amigos"><img alt="Eliminar usuario de mi lista de amigos" src="<?=$config['images'];?>/images/cross.png" align="absmiddle"></a></td>
            </tr>
           </tbody>
        </table>
        <hr class="divider">
    </div>
</div>
<?php
}
if($_GET['p'] > 1) { echo '<span class="align: right;" style="font-size:12px;"><a href="/cuenta/amigos/'.($_GET['p']-1).'">&laquo; Anterior</a></span>'; }
if($_GET['p'] < $tot) { echo '<span class="floatR" style="font-size:12px;"><a href="/cuenta/amigos/'.($_GET['p']+1).'">Siguiente &#187;</a></span>'; }
} else { echo '<div class="redBox"><img src="http://i3.kym-cdn.com/entries/icons/original/000/003/619/Untitled-1.jpg"></div>'; }