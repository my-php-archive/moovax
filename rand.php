<?php
include('config.php');
include('functions.php');
if(!$_GET['photo']) {
  $query = mysql_query('SELECT p.id, p.title, cat.url FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.`id` = p.`cat` WHERE p.status = \'0\' '.(!$logged['id'] ? '&& p.private = \'0\'' : '').' ORDER BY RAND()') or die(mysql_error());
  $row = mysql_fetch_row($query);
  header('location: /posts/'.$row[2].'/'.$row[0].'/'.url($row[1]).'.html');
} else {
  $query = mysql_query('SELECT p.id, p.title, cat.url FROM photos AS p INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE p.`status` = \'0\''.(!$logged['id'] ? ' && p.private = \'0\'' : '').' ORDER BY RAND()');
  $row = mysql_fetch_assoc($query);
  header('location: /fotos/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html');
}