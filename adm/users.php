<?php
if(!defined('adm')) { die; }
if(!allow('show_panel') || !$key) { fatal_error('La concha de tu hermana'); }
/* no romper las bolas con el $_GET['id'] que ac&aacute; est&aacute filtrado mijo -sisi  y por lo tanto no hay XSS */
if(!in_array($_GET['order'], array('ID', 'nick', 'nombre', 'fecha'))) { $_GET['order'] = 'ID'; } //tonight is the night eeer34
?>
<div id="adm-right">
	<div class="user_info">
		<span class="floatL" style="font-size:17px">Usuarios registrados</span>

<span class="floatR">
	<b class="size12">Filtrar por:</b>
		<span class="filter_box">
			<span class="filterBy">
			<a id="tabID" onclick="tabs.filterComms('ID'); location.href='/admin/usuarios/ID/';  "<?=($_GET['order'] == 'ID' ? ' class="here"' : '');?>>ID</a> -
			<a id="tabnick" onclick="tabs.filterComms('nick'); location.href='/admin/usuarios/nick/'; return false;"<?=($_GET['order'] == 'nick' ? ' class="here"' : '');?>>Nick</a> -
			<a id="tabnombre" onclick="tabs.filterComms('nombre'); location.href='/admin/usuarios/nombre/'; return false;"<?=($_GET['order'] == 'nombre' ? ' class="here"' : '');?>>Nombre</a> -
			<a id="tabfecha" onclick="tabs.filterComms('fecha'); location.href='/admin/usuarios/fecha/';return false;"<?=($_GET['order'] == 'fecha' ? ' class="here"' : '');?>>Registro</a>
            <!-- $_GET['order'] est&aacute; filtrada arriba, as&iacute; que me chupa el pingo -->
            <script type="text/javascript">var filterCommsHere = '<?=$_GET['order'];?>';</script>
			</span>
		</span>
</span>
<div class="clear"></div>
<hr class="divider">
</div><table class="linksList">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Usuarios</th>
				<th>IPs usadas</th>
				<th>Rango</th>
				<th>Sexo</th>
				<th>Pa&iacute;s</th>
				<th>Banear</th>
                <?php if(allow('edit_user')) { echo '<th>Editar</th>'; } ?>
             </tr>
		</thead>
		<tbody>
        <?php
        switch($_GET['order']) {
          case 'ID':
            $eeer = 'u.`id` DESC';
            break;
          case 'nick':
            $eeer = 'u.`nick` DESC';
            break;
          case 'nombre':
            $eeer = 'u.`name` DESC'; //eh eh eh
            break;
          case 'fecha':
            $eeer = 'u.`time` DESC';
            break;
          default: die('Si est&aacute;s viendo esto me retiro de programador ._.');
        }
        $query = 'SELECT u.id, u.nick, u.ban, u.act, u.sex, u.lastip, r.name, r.img, u.country FROM `users` AS u INNER JOIN `ranks` AS r ON r.id = u.rank ORDER BY '.$eeer;
        $total = mysql_num_rows(mysql_query($query));
        $_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) ? $_GET['p'] : 1;
        $per = 100;
        $ppp = ceil($total / $per);
        $actual = ($_GET['p']-1)*$per; //1*10 = 10;
        $querys = mysql_query($query.' LIMIT '.$actual.', '.$per) or die(mysql_error());
        while($row = mysql_fetch_assoc($querys)) {
        ?>
        <tr id="user_<?=$row['id'];?>" <?=($row['ban'] != '0' ? 'class="eliminado"' : '');?>>
				<td style="width:0px" title="<?=$row['nick'];?>"><img src="<?=$config['images'];?>/images/user.png" align="absmiddle"></td>
				<td style="text-align:left"><a href="/perfil/<?=$row['nick'];?>" target="_blank" title="<?=$row['nick'];?>" alt="<?=$row['nick'];?>"><?=$row['nick'];?></a></td>
				<td style="width:150px"><a href="/admin/rastrear-ip/<?=$row['lastip'];?>" title="Rastrear IP"><?=($row['lastip'] ? $row['lastip'] : '-');?></a></td>
				<td style="width:50px"><img src="<?=$config['images'];?>/images/rangos/<?=$row['img'];?>" align="absmiddle" border="0" title="<?=$row['name'];?>"></td>
				<td style="width:50px;"><img src="<?=$config['images'];?>/images/<?=$sex = ($row['sex'] == '0' ? 'Hombre' : 'Mujer');?>.gif" title="<?=$sex;?>" border="0" align="absmiddle" /></td>
				<td style="width:50px;">
                <?php
                if(mysql_num_rows($qfew = mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `id` = \''.$row['country'].'\''))) {
                  $rows = mysql_fetch_row($qfew);
                } else {
                  $rows = array(0 => 'Otro pa&iacute;s', 1 => 'ot');
                }
                ?>
                <span title="<?=$row[0];?>"><img alt="<?=$row[0];?>" title="<?=$row[0];?>" src="<?=$config['images'];?>/images/icons/banderas/<?=($rows[1] == 'ot' ? 'ot.gif' : strtolower($rows[1]).'.png');?>" align="absmiddle" /></span>
                </td>
				<td style="width:50px">
                <?php
                if($row['ban'] == '0') {
                ?>
                  <a id="banear_<?=$row['id'];?>" href="#" onclick="admin.ban_form('<?=$row['id'];?>', '<?=$row['nick'];?>'); return false" title="Banear cuenta"><img src="<?=$config['images'];?>/images/banear.png" title="Banear cuenta" align="absmiddle"></a>
                <?php
                } else {
                ?>
                 <a title="Desbanear cuenta" onclick="admin.unban('<?=$row['id'];?>'); return false" href="#"><img align="absmiddle" id="banear_<?=$row['id'];?>" title="Desbanear cuenta" src="<?=$config['images'];?>/images/reload.png"></a>
                <?php
                }
                ?>
                </td>
                <?php
                if(allow('edit_user')) {
                  echo '<td style="width:50px"><a id="few" onclick="admin.edit_user(\''.$row['id'].'\'); return false;" href="#"><img src="'.$config['images'].'/images/icons/edit.png"></a></td>';
                }
                ?>
		</tr>
        <?php
        }
        ?>
	    </tbody>
		</table>
		<div class="clear"></div><hr class="divider">
        <?php
        if($_GET['p'] > 1) { echo '<span class="floatL size12" style="font-weight:bold"><a title="Anteriores" href="/admin/usuarios/'.$_GET['order'].'/page/'.($_GET['p']-1).'">&#171; Anteriores</a></span>'; }
        if($_GET['p'] < $ppp) { echo '<span class="floatR size12" style="font-weight:bold"><a title="Siguientes" href="/admin/usuarios/'.$_GET['order'].'/page/'.($_GET['p']+1).'">Siguientes &#187;</a></span>'; }
        ?>
        </div>