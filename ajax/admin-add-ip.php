<?php
if(!$_POST['ip'] || !isset($_POST['type'])) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id'] || !allow('ban_ip')) { die; }
if(!filter_var($_POST['ip'], FILTER_VALIDATE_IP)) { die('0La ip ingresada no es v&aacute;lida'); }
if(!ctype_digit($_POST['type']) || $_POST['type'] > 1) { die('0Harold pacha mmmm'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `ips_ban` WHERE `ip` = \''.mysql_clean($_POST['ip']).'\''))) { die('0La ip ingresada ya se encuentra baneada'); }
if(mysql_num_rows(mysql_query('SELECT `id` FROM `ips_ban` WHERE `time` > \''.(time()-120).'\' && `author` = \''.$logged['id'].'\''))) { die('0debes esperar para realizar esta acci&oacute;n'); }
//if($logged['lastip'] == $_POST['ip']) { die('0No es posible banear tu propia IP'); }
mysql_query('INSERT INTO `ips_ban` (`ip`, `type`, `time`, `author`) VALUES (\''.mysql_clean($_POST['ip']).'\', \''.intval($_POST['type']).'\', \''.time().'\', \''.$logged['id'].'\')'); //eeeer34
?>
<td title="fewfew" style="width:20px"><img align="absmiddle" src="<?=$config['images'];?>/images/vcard.png"></td>
<td style="text-align:left"><?=htmlspecialchars($_POST['ip']);?></td>
<td style="width:75px">
<?php
switch($_POST['type']) {
  case '0': echo '<span style="color: #006600;">Total</span>'; break;
  case '1': echo '<span style="color: #CC0033;">Parcial</span>'; break;
}
?>
<td><?=$logged['nick'];?></td>
<td style="width:75px"></td>