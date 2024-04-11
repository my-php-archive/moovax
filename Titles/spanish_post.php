<?php
if(!defined($config['define'])) { die; }
if(mysql_num_rows($pq = mysql_query('SELECT `title` FROM `posts` WHERE `id` = \''.intval($_GET['id']).'\'')) && $_GET['id']) {
  list($title['default']) = mysql_fetch_row($pq);
} else {
  $title['default'] = $config['name'];
}