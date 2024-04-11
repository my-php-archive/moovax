<?php
if(!$_POST['id'] || !isset($_POST['status'])) { die; }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Para realzar esta acc&oaucte;n es necesario que te loguees'); }
if($_POST['id'] != $logged['id']) { die('0: Atentado de hack'); }
if($row['status'] == $_POST['status']) { die('0: Tu ya est&aacute;s usando este estado'); }
if(!mysql_num_rows($qs = mysql_query('SELECT `name`, `img` FROM `status` WHERE `id` = \''.intval($_POST['status']).'\'')) && $_POST['status'] != '0') { die('0: El estado ingresado no existe'); }
$qm = mysql_fetch_row($qs);
//usaremos $_POST ya que el status puede ser 0
mysql_query('UPDATE `users` SET `status` = \''.intval($_POST['status']).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1');
if($_POST['status'] == 0) { $qm[1] = 'ninguno.gif'; }
echo '1: <img align="top" border="0" title="'.$qm[0].'" src="'.$config['images'].'/images/estado/'.$qm[1].'">';