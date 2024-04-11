<?php
if(!$_REQUEST['email']) { die('0: El campo e-mail es requerido'); }
if(!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) { die('0: El mail ingresado no es correcto'); }
include('../config.php');
include('../functions.php');
if(mysql_num_rows(mysql_query('SELECT `email` FROM users WHERE `email` = \''.mysql_clean($_REQUEST['email']).'\''))) { die('0: El mail se encuentra en uso'); }
die('1: OK');
?>