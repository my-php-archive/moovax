<?php
if(!$_GET['currenttop'] || !in_array($_GET['currenttop'], array('posts', 'fotos', 'usuarios', 'categorias'))) { $_GET['currenttop'] = 'posts'; }
/*if($_GET['currenttop'] == 'posts' && $_GET['cat'] && $_GET['cat'] != '-1') {
  $ns = mysql_num_rows($q = mysql_query('SELECT `url` FROM `categories` WHERE `url` = \''.mysql_clean($_GET['url']).'\''));
} elseif($_GET['currenttop'] == 'categorias') {
  $ns = mysql_num_rows
}  */
$title['default'] = 'Top '.ucfirst($_GET['currenttop']);