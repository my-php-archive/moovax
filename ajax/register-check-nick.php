<?php
if(!$_POST['nick'] || !$_POST['_']) { die('0: El campo nick es requerido'); }
include('../config.php');
include('../functions.php');
if(!preg_match('/^[a-z0-9\_\-]{4,16}$/i', $_POST['nick'])) { die('0: El nick no es v&aacute;lido'); }
if(mysql_num_rows(mysql_query('SELECT id FROM `users` WHERE `nick` = \''.mysql_clean($_POST['nick']).'\''))) { die('0: El nick se encuentra en uso'); }
die('1: El nick est&aacute; disponible');