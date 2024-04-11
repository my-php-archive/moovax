<?php
if(!defined($config['define'])) {
  include('../config.php');
  include('../functions.php');
}
if(!$_POST['ajax'] && !defined($config['define'])) { die('0: puto'); }
$ccc = '';
if($_REQUEST['id']) {
  if(!mysql_num_rows($query = mysql_query('SELECT `id`, `status` FROM `groups` WHERE `url` = \''.mysql_clean($_REQUEST['id']).'\''))) { die('0: La comunidad no existe'); }
  $row = mysql_fetch_row($query);
  if($row[1] != 0) { die('0: La comunidad fue eliminada'); }
  $ccc .= ' && g.id = \''.$row[0].'\'';
}
if($_REQUEST['cat'] && $_REQUEST['cat'] != '-1' && mysql_num_rows($query2 = mysql_query('SELECT id FROM `groups_categories` WHERE `id` = \''.mysql_clean($_REQUEST['cat']).'\' || `url` = \''.mysql_clean($_REQUEST['cat']).'\''))) {
  $r = mysql_fetch_row($query2);
  $ccc .= ' && g.`cat` = \''.$r[0].'\'';
}
$i = 0;
$query = mysql_query('SELECT g.`url`, t.`title`, t.`id`, u.nick, c.`id` AS cid, c.`author` FROM `groups` AS g INNER JOIN `groups_topics` AS t ON t.group = g.`id` INNER JOIN `groups_comments` AS c ON c.`id_topic` = t.id INNER JOIN `users` AS u ON u.id = c.`author` WHERE t.`status` = \'0\' && g.`status` = \'0\''.$ccc.' ORDER BY c.id DESC LIMIT 15') or die('0: '.mysql_error());
if(!mysql_num_rows($query)) { echo '<div class="redBox" id="sin_comments_muro">Nada por aqu&iacute;...</div>'; } else {
  while($row = mysql_fetch_assoc($query)) {
    echo '<font class="size11"><b>@<a class="hovercard" data-uid="'.$row['author'].'" alt="'.$row['nick'].'" title="'.$row['nick'].'" href="/perfil/'.$row['nick'].'">'.$row['nick'].'</a></b> - <a href="/comunidades/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html#cmt_'.$row['cid'].'" title="'.$row['title'].'"><span style="font-weight:normal">'.cut($row['title'], 25).'</span></a></font><br style="margin: 0px; padding: 0px;">';
  }
}
?>