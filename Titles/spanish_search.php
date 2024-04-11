<?php
if(!defined($config['define'])) { die; }
if(!$_GET['q'] && $_GET['autor'] && mysql_num_rows($q = mysql_query('SELECT `nick` FROM `users` WHERE `nick` = \''.mysql_clean($_GET['autor']).'\''))) {
  list($ni) = mysql_fetch_row($q);
  $title['default'] = 'Posts de '.$ni;
} elseif($_GET['q']) { $title['default'] = 'Buscando '.htmlspecialchars($_GET['q']); } else {
  $title['default'] = 'Buscar posts';
}