<?php
if(!defined($config['define'])) { die; }
mysql_query('DELETE FROM `online` WHERE `time` < \''.(time()-180).'\'') or die(mysql_error()); //Problem?
$_SERVER['REMOTE_ADDR'] = $_SERVER['X_FORWARDED_FOR'] ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
if($_SERVER['REMOTE_ADDR'] && !mysql_num_rows(mysql_query('SELECT `id` FROM `online` WHERE `ip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\''))) {
  mysql_query('INSERT INTO `online` (`ip`, `time`, `user`) VALUES (\''.mysql_clean($_SERVER['REMOTE_ADDR']).'\', \''.time().'\', \''.($logged['id'] ? $logged['id'] : '0').'\')');
} else {
  mysql_query('UPDATE `online` SET `time` = \''.time().'\''.($logged['id'] ? ', `user` = \''.$logged['id'].'\'' : '').' WHERE `ip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\' LIMIT 1');
}
$pstats = array();
$check = array('online', 'users', 'posts', 'comments', 'photos', 'groups', 'groups_topics', 'groups_comments');
$query = mysql_query('SHOW TABLE STATUS');
while($r = mysql_fetch_assoc($query)) {
  if(count($check) == count($pstats)) { break; }
  if(!in_array($r['Name'], $check)) { continue; }
  $pstats[$r['Name']] = $r['Rows'];
}