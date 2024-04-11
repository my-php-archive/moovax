<?php
if(!defined($config['define'])) { die; }
if(mysql_num_rows($query = mysql_query('SELECT `nick` FROM `users` WHERE '.(ctype_digit($_GET['id']) ? '`id`' : '`nick`').' = \''.mysql_clean($_GET['id']).'\'')) && $_GET['id']) {
  list($nick) = mysql_fetch_row($query);
  $title['default'] = 'Perfil de @'.$nick.' en '.$config['name'];
} else {
  $title['default'] = $config['name'].' - '.$config['slogan'];
}