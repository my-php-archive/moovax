<?php
include('config.php');
include('functions.php');
if(!$_GET['id'] || !ctype_digit($_GET['id'])) { fatal_error('El campo id es requerido'); }
if(!$_GET['f']) { die('few'); }
/*********************************************************************/
if(!$_GET['act']) {
  $row = mysql_fetch_row($query = mysql_query('SELECT p.`id`, p.`title`, cat.`url` FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.`id` = p.`cat` WHERE p.`status` = \'0\' && p.`id` '.($_GET['f'] == 'next' ? '>' : '<').' \''.$_GET['id'].'\' '.(!$logged['id'] ? '&& p.`private` = \'0\'' : '').' ORDER BY p.`id` '.($_GET['f'] == 'next' ? 'ASC' : 'DESC')));
  if(!mysql_num_rows($query)) { fatal_error('No hay mas posts..'); }
  header('location: /posts/'.$row[2].'/'.$row[0].'/'.url($row[1]).'.html');
} else {
  if(!mysql_num_rows($query = mysql_query('SELECT p.id, p.title, cat.url FROM `photos` AS p INNER JOIN `p_categories` AS cat ON cat.id = p.cat WHERE p.`status` = \'0\' && p.`id` '.($_GET['f'] == 'next' ? '>' : '<').' \''.intval($_GET['id']).'\' '.(!$logged['id'] ? '&& p.`private` = \'0\'' : '').' ORDER BY p.`id` '.($_GET['f'] == 'next' ? 'ASC' : 'DESC')))) {
    fatal_error('No hay mas fotos');
  }
  $row = mysql_fetch_row($query);
  header('location: /fotos/'.$row[2].'/'.$row[0].'/'.url($row[1]).'.html');
}