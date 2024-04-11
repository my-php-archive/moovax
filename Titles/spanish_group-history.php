<?php
if(!defined($config['define'])) { die; }
if(!mysql_num_rows($$row = mysql_query('SELECT * FROM `groups` WHERE `url` = \''.mysql_clean($_GET['id']).'\''))) { fatal_error('La comunidad no existe'); }
$group = mysql_fetch_assoc($$row);
if($group['status'] != '0') { fatal_error('La comunidad se encuentra eliminada'); }
$title['default'] = 'Historial de moderaci&oacute; de la comunidad '.$group['name'];
?>