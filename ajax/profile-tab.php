<?php
include('../config.php');
include('../functions.php');
if(!isset($_POST['tab']) || !$_POST['user']) { die('0: Faltan datos'); }
if(!mysql_num_rows($query = mysql_query('SELECT * FROM `users` WHERE `id` = \''.intval($_POST['user']).'\''))) { die; }
$row = mysql_fetch_assoc($query); //sa
switch($_POST['tab']) {
  case '0':
    $query = mysql_query('SELECT w.*, u.nick, u.avatar FROM `walls` AS w INNER JOIN `users` AS u ON u.id = w.author WHERE w.profile = \''.$row['id'].'\' ORDER BY w.id DESC') or die(mysql_error());
    $tab = 'wall';
    $currenttab = '0';
    $currenttitle = 'Perfil de '.$row['nick'];
    break;
  case '1':
    $tab = 'info';
    $currenttab = '1';
    $currenttitle = 'Informaci&oacute;n de '.$row['nick'];
    break;
  case '2':
    $query = mysql_query('SELECT p.`id`, p.`title`, cat.`url`, cat.`name`, `p`.`points` FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE p.`author` = \''.$row['id'].'\' && p.`status` = \'0\' ORDER BY p.`id` DESC LIMIT 15');
    if(mysql_num_rows($query)) {
      $tot = mysql_num_rows(mysql_query('SELECT `id` FROM `posts` WHERE `author` = \''.$row['id'].'\' && `status` = \'0\''));
      $posts = true;
    }
    $tab = 'posts';
    $currenttab = '2';
    $currenttitle = 'Posts de '.$row['nick'];
    break;
  case '3':
    $query = 'SELECT p.id, p.title, cat.url, c.body, c.`time` FROM `posts` AS p INNER JOIN `comments` AS c ON c.id_post = p.id INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE c.`author` = \''.$row['id'].'\' && p.`status` = \'0\' ORDER BY c.`id` DESC';
    $tab = 'comments';
    $currenttab = '3';
    $currenttitle = 'Comentarios de '.$row['nick'];
    break;
  case '4':
    $query = 'SELECT u.id as uid, u.nick, u.status, u.avatar, p.img_pais, p.`name`, f.`time`, f.`id` FROM `users` AS u INNER JOIN `friends` AS f ON IF(f.`author` = \''.$row['id'].'\', f.`user`, f.`author`) = u.id RIGHT JOIN `countries` AS p ON p.id = u.country WHERE (`f`.`author` = \''.$row['id'].'\' || f.`user` = \''.$row['id'].'\') && f.`status` = \'1\' ORDER BY f.`id` DESC';
    $tab = 'friends';
    $currenttab = '4';
    $currenttitle = 'Amigos de '.$row['nick'];
    break;
  case '5':
    $query = 'SELECT p.id, p.title, p.`time`, p.votes, cat.url, cat.name FROM `photos` AS p INNER JOIN `p_categories` AS cat ON cat.id = p.cat WHERE p.`author` = \''.$row['id'].'\' && p.status = \'0\' ORDER BY p.id DESC';
    $tab = 'photos';
    $currenttab = '5';
    $currenttitle = 'Fotos de '.$row['nick'];
    break;
  case '6':
    $query = '';
    $tab = 'activity';
    $currenttab = '6';
    $currenttitle = 'Actividad de '.$row['nick'];
}
define('ok', true);
echo '<script> var currenttitle = \''.$currenttitle.' en '.$config['name'].' - '.$config['name'].'\'; </script>';
include($_SERVER['DOCUMENT_ROOT'].'/Pages/profile-'.$tab.'.php');