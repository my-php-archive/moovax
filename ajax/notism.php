<?php
if(!$_REQUEST['notifications']) { die; }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Logueate'); }
$x = explode(':', $_REQUEST['notifications']);
switch($x[0]) {
  case 'comment': $type = array(0, 3, 4, 5); break;
  case 'favorite': $type = array(1, 12); break;
  case 'points': $type = array(2, 14); break;
  case 'comment-vote': $type = array(8); break;
  case 'like': $type = array(11); break;
  case 'new-friend': $type = array(7); break;
  case 'status': $type = array(13); break;
  case 'reply': $type = array(9, 10); break;
  case 'new-photo': $type = array(15); break;
  case 'new-post': $type = array(6); break;
  case 'groups': $type = array(16, 17, 18, 19, 20); break;
  default: die('0: Error provocado');
}
if(!preg_match('/([a-z]+)\:(0|1)/', $_REQUEST['notifications'], $result)) { die('0: Error provocado'); }
$not = explode(',', $logged['notifications']);
if(count($not) < 20 || !$logged['notifications']) {
  $logged['notifications'] = '';
  for($i=0;$i<=20;$i++) { $logged['notifications'] .= ','.$i.':1'; }
  $logged['notifications'] = substr($logged['notifications'], 1);
}
$news = array();
$xp = explode(',', $logged['notifications']);
if($result[1] != 0 && $result[1] != 1) { die('0: -uhh'); }
$text = '';
foreach($xp as $r) {
  $ed = explode(':', $r);
  if(in_array($ed[0], $type)) { $text .= ','.$ed[0].':'.$result[2]; } else { $text .= ','.$r; }
}
mysql_query('UPDATE `users` SET `notifications` = \''.substr($text, 1).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1');
die('1');