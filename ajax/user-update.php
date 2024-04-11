<?php
if(!$_POST['ajax']) { die; }
include('../config.php');
include('../functions.php');
define($config['define'], true);
include('../online.php'); //me sirve mmm
if(!$logged['id']) { die('{"status":0,"data":"Debes loguearte"}'); }
$notifications = mysql_num_rows(mysql_query('SELECT `id` FROM `notifications` WHERE `status` = \'0\' && `id_user` = \''.$logged['id'].'\''));
$mps = mysql_num_rows(mysql_query('SELECT `id` FROM `messages` WHERE `receiver` = \''.$logged['id'].'\' && receiver_status = \'0\' && `receiver_read` = \'0\''));
echo '{"status":1,"notifications":'.$notifications.',"messages":'.$mps.'}';