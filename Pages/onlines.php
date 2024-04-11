<?php
if(!defined($config['define'])) { die; }
$query = 'SELECT u.id, u.nick, u.avatar, u.lastip, u.sex, u.country, o.ip, o.`time`, r.name, r.img FROM `users` AS u INNER JOIN `online` AS o ON o.user = u.id INNER JOIN `ranks` AS r ON r.id = u.rank GROUP BY u.id ORDER BY o.id DESC';
$tot = mysql_num_rows(mysql_query($query));
$per = 20;
$pp = ceil($tot / $per);
$_GET['p'] = $_GET['p'] && $_GET['p'] <= $pp && ctype_digit($_GET['p']) ? $_GET['p'] : 1;
$act = ($_GET['p']-1)*$per;
$query = mysql_query($query.' LIMIT '.$act.', '.$per) or die(mysql_error());
if(mysql_num_rows($query)) {
?>
<div class="user_info">
    <h2>Usuarios conectados</h2>
</div>
<table class="linksList">
		<thead>
			<tr>
				<th>Usuarios</th>
				<th>Ultima acci&oacute;n</th>
				<?php if($logged['id']) { echo '<th>Mensaje</th>'; } ?>
				<th>Rango</th>
				<th>Medalla</th>
				<th>Sexo</th>
				<th>Pa&iacute;s</th>
			</tr>
		</thead>

		<tbody>
        <?php
        while($row = mysql_fetch_assoc($query)) {
        ?>
        <tr>
		<td><span><a href="/perfil/<?=$row['nick'];?>" title="Ver perfil de <?=$row['nick'];?>"><?=$row['nick'].'</a>'.(allow('track_ip') ? ' (<a href="/admin/rastrear-ip/'.$row['ip'].'">'.$row['lastip'].'</a>)' : '');?></span></td>
		<td><?=timefrom($row['time']);?></td>
        <?php
        if($logged['id']) { echo '<td><a onclick="mp.enviar_mensaje(\''.$row['nick'].'\'); return false;" title="Enviar mensaje">Enviar mensaje</a></td>'; }
        ?>
		<td><?=$row['name'];?></td>
		<td style="width: 50px;"><span title="<?=$row['name'];?>"><img src="<?=$config['images'];?>/images/rangos/<?=$row['img'];?>" border="0" align="absmiddle"></span></td>
		<td style="width: 50px;"><span title="<?=($row['sex'] == 0 ? 'Hombre' : 'Mujer');?>"><img src="<?=$config['images'];?>/images/<?=($row['sex'] == 0 ? 'Hombre' : 'Mujer');?>.gif" title="<?=($row['sex'] == 0 ? 'Hombre' : 'Mujer');?>" border="0" align="absmiddle" /></span></td>
        <?php
        if(mysql_num_rows($p = mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `id` = \''.$row['country'].'\''))) {
          $rw = mysql_fetch_row($p);
          $rw[1] = $rw[1].'.png';
        } else { $rw = array('Otro', 'ot.gif'); }
        ?>
        <td style="width: 50px;"><img alt="<?=$rw[0];?>" src="<?=$config['images'];?>/images/icons/banderas/<?=$rw[1];?>" align="absmiddle" /></td>
        </tr>
        <?php
        }
        ?>
    </tbody>

	</table>

<div class="clear"></div>

<?php
if($_GET['p'] < $pp || $_GET['p'] > 1) { echo '<hr class="divider">'; }
if($_GET['p'] < $pp) { echo '<span class="floatR size12" style="font-weight:bold"><a title="Fotos maacute;s viejas" href="/online/page/'.($_GET['p']+1).'" >Siguientes &#187;</a></span>'; }
if($_GET['p'] > 1) { echo '<span class="floatL size12" style="font-weight:bold"><a title="Fotos m&aacute;s nuevas" href="/fotos/page/'.($_GET['p']-1).'" >&#171; Anteriores</a></span>'; }
} else { echo '<div class="redBox size13">No hay usuarios conectados...</div>'; }
?>
<div style="clear:both"></div>
</div>
</div>