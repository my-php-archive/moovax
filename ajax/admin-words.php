<?php
if(!$_POST['censurar']) { die('0: Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
if(!allow('censure')) { die('0: No tienes permisos para hacer esto'); }
$words = array();
$a = 0;
foreach(explode(',', $_POST['censurar']) as $word) {
  $word = trim($word);
  $words[] = $word;
  if(mysql_num_rows(mysql_query('SELECT `word` FROM `censorship` WHERE `word` = \''.mysql_clean($word).'\'')) || empty($word)) { continue; }
  ++$a;
  mysql_query('INSERT INTO `censorship` (`word`, `author`) VALUES (\''.mysql_clean($word).'\', \''.$logged['id'].'\')');
}
$i = 0;
$arr = array();
$select = mysql_query('SELECT `word` FROM `censorship`');
while($row = mysql_fetch_row($select)) {
  if(!in_array($row[0], $words)) { ++$i; mysql_query('DELETE FROM `censorship` WHERE `word` = \''.$row[0].'\''); }
}
echo '1: Se ha'.($a > 1 ? 'n' : '').' agregado '.$a.' palabra'.($a > 1 ? 's' : '')."\n".($i > 0 ? 'y se ha'.($i > 1 ? 'n' : '').' borrado '.$i.' palabra'.($i > 1 ? 's' : '') : '');