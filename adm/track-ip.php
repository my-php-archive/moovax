<?php
if(!defined('adm')) { die; }
if(!allow('track_ip')) { fatal_error('No ten&acute;s permisos para est&aacute;r ac&aacute;'); } // Sorry lammer :$
if($_GET['ip'] && filter_var($_GET['ip'], FILTER_VALIDATE_IP)) {
  $ip = true; // few
  $query = mysql_query('SELECT u.id, u.nick, u.ban, u.sex, u.`country`, u.lastip, r.name, r.img FROM `users` AS u INNER JOIN `ranks` AS r ON r.id = u.rank WHERE u.lastip = \''.mysql_clean($_GET['ip']).'\' ORDER BY u.id DESC') or die(mysql_error());
  $f = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=3071f34569b07e05026168560e9a463070e0afd1639b130ff26a751e69708760&ip='.$_GET['ip']);
  $xp = explode(';', $f);
  $add = '';
  if(!empty($xp[4]) || !empty($xp[3])) {
    if(mysql_num_rows($row = mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `name` = \''.mysql_clean($xp[4]).'\' || `img_pais` = \''.mysql_clean($xp[3]).'\''))) {
      $r = mysql_fetch_row($row);
      $add = '<span title="'.$r[0].'"><img align="absmiddle" alt="" title="'.$r[0].($xp[6] != '-' && !empty($xp[6]) ? ' - '.htmlspecialchars($xp[6]) : '').'" src="'.$config['images'].'/images/icons/banderas/'.strtolower($r[1]).'.png"></span>';
    } elseif($xp[4] != '-' && $xp[3] != '-') {
      $add = '('.htmlspecialchars($xp[4]).')';
    }
  }
} else {
  $ip = false;
}
?>
<div id="adm-right">
	<div class="user_info">
		<h2>Rastrear IP <?=$add;?></h2>
    </div>
    <?php
    if($ip) {
      if(mysql_num_rows($query)) {
    ?>
    <table class="linksList">
    		<thead>
    			<tr>
    				<th>&nbsp;</th>
    				<th>Usuarios con el mismo IP</th>
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
            while($row = mysql_fetch_assoc($query)) {
            ?>

            <tr id="user_<?=$row['id'];?>">
    				<td style="width:0px" title="<?=$row['nick'];?>"><img src="<?=$config['images'];?>/images/user.png" align="absmiddle"></td>
    				<td style="text-align:left"><a href="/perfil/<?=$row['nick'];?>" target="_blank" title="<?=$row['nick'];?>" alt="<?=$row['nick'];?>"><?=$row['nick'];?></a></td>
    				<td style="width:150px"><a href="/admin/rastrea/<?=$row['lastip'];?>" title="Rastrear IP"><?=$row['lastip'];?></a></td>
    				<td style="width:50px"><img src="<?=$config['images'];?>/images/rangos/<?=$row['img'];?>" align="absmiddle" border="0" title="<?=$row['name'];?>"></td>
    				<td style="width:50px;"><img src="<?=$config['images'];?>/images/<?=($row['sex'] == '0' ? 'Hombre.gif' : 'Mujer.gif');?>" title="<?=($row['sex'] == '0' ? 'Hombre' : 'Mujer');?>" border="0" align="absmiddle" /></td>
                    <?php
                    if(mysql_num_rows($qus = mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `id` = \''.$row['country'].'\''))) {
                      $rows = mysql_fetch_row($qus);
                      $rows[1] = $rows[1].'.png';
                    } else {
                      $rows[1] = 'ot.gif';
                      $rows[0] = 'Otro pa&iacute;s';
                    }
                    ?>
    				<td style="width:50px;"><span title="<?=$rows[0];?>"><img alt="" title="<?=$rows[0];?>" src="<?=$config['images'];?>/images/icons/banderas/<?=$rows[1];?>" align="absmiddle" /></span></td>
    				<td style="width:50px"><a id="banear_<?=$row['id'];?>" href="#" onclick="admin.ban_form('<?=$row['id'];?>', '<?=$row['nick'];?>'); return false" title="Banear cuenta"><img src="<?=$config['images'];?>/images/banear.png" title="Banear cuenta" align="absmiddle"></a></td>
                    <?php
                    if(allow('edit_user')) {
                      echo '<td style="width:50px"><a id="few" onclick="admin.edit_user(\''.$row['id'].'\'); return false;" href="#"><img src="'.$config['images'].'/images/icons/edit.png"></a></td>';
                    }
                    ?>
            </tr>
           <?php
           } /* while */
           ?>
           </tbody>
           </table>
           <?php
           } else {
             echo '<div class="redBox size12">No hay coincidencias de usuarios con esta IP</div></div>';
           }
           ?>

    <?php
    } else {
    ?>
    <div class="yellowBox size12">Ingresa una IP v&aacute;lida para realizar tu rastreo</div>
    <center>
	<form action="/admin/rastrear/" method="GET" accept-charset="UTF-8">
	    <br><span class="size14">Ingresa una IP  a rastrear: </span><input type="text" name="ip" id="ip" size="50" maxlength="100">
		<input type="submit"  class="Boton Small BtnGray" value="Rastrear">
	</form>
    </center> 
	</div>
    <?php
    }
    ?>
<div class="clear"></div><hr class="divider"></div>