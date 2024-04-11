<?php
if(!ctype_digit($_GET['tab']) && !in_array($_GET['tab'], array('profile', 'apariencie', 'avatar', 'firm', 'friends', 'privacy', 'password', 'background'))) { die('0: Error provocado'); }
if(!defined($config['define'])) {
  include('../config.php');
  include('../functions.php');
}
if(!$logged['id']) { die('0: Debes estar logueado pacha'); }
switch($_GET['tab']) {
  case '0':
  case 'profile':
    $query = mysql_query('SELECT `id`, `nick`, `name`, `day`, `sex`, `month`, `year`, `country`, `city`, `message`, `website`, `password` FROM `users` WHERE `id` = \''.$logged['id'].'\'') or die(mysql_error());
    $tab = 'profile';
    $currenttab = 0;
    break;
  case '1':
  case 'apariencie':
    $query = mysql_query('SELECT * FROM `users` WHERE `id` = \''.$logged['id'].'\'');
    $tab = 'apariencie';
    $currenttab = 1;
    break;
  case '2':
  case 'avatar':
    $query = mysql_query('SELECT `id`, `avatar` FROM `users` WHERE `id` = \''.$logged['id'].'\'');
    $tab = 'avatar';
    $currenttab = 2;
    break;
  case '3':
  case 'firm':
    $query = mysql_query('SELECT `id`, `firm` FROM `users` WHERE `id` = \''.$logged['id'].'\'');
    $tab = 'firm';
    $currenttab = 3;
    break;
  case '4':
  case 'friends':
    $query = '';
    $tab = 'friends';
    $currenttab = 4;
    break;
  case '5':
  case 'privacy':
    $query = mysql_query('SELECT `show_info`, `walls_comments`, `friends_request`, `receive_pms`, `receive_pms` FROM `users` WHERE `id` = \''.$logged['id'].'\'');
    $tab = 'privacy';
    $currenttab = 5;
    break;
  case '6':
  case 'password':
    $query = mysql_query('SELECT `password` FROM `users` WHERE `id` = \''.$logged['id'].'\'');
    $tab = 'password';
    $currentab = 6;
    break;
  case '7':
  case 'background':
    $tab = 'background';
    $currentab = 7;
  break;
  default: die('Error provocado -wuaaaaaaa');
}
define('ok', true);
include('account-'.$tab.'.php');
?>