<?php
if($_POST['ajax']) {
  include('../config.php');
  include('../functions.php');
  if(!$_POST['cat']) { $_POST['cat'] = '-1'; }
} else {
  if(!defined($config['define'])) { die('0: Puto'); }
}
if($_POST['cat'] != '-1' && mysql_num_rows($pcq = mysql_query('SELECT `id` FROM `p_categories` WHERE `id` = \''.intval($_POST['cat']).'\''))) {
  $r = mysql_fetch_row($pcq);
  $where = ' && p.cat = \''.$r[0].'\'';
  $pcat = true;
}
if($_POST['pais'] && mysql_num_rows($pas = mysql_query('SELECT `id` FROM `countries` WHERE `id` = \''.intval($_POST['pais']).'\''))) {
  $a = mysql_fetch_row($pas);
  $where .= ' && u.country = \''.$a[0].'\'';
}
$query = mysql_query('SELECT p.id, p.title, cat.url, u.nick, c.id as ied, c.`author` FROM photos AS p INNER JOIN p_comments AS c ON c.photo = p.id INNER JOIN users AS u ON u.id = c.author INNER JOIN p_categories AS cat ON cat.id = p.cat WHERE p.`status` = \'0\''.$where.' ORDER BY c.id DESC LIMIT 15');
if(!mysql_num_rows($query)) { echo 'Nada por aquí...'; } else {
  while($s = mysql_fetch_row($query)) {
    echo '<li><strong>@<a class="hovercard" data-uid="'.$s[5].'" href="/'.$s[3].'">'.$s[3].'</a></strong> - <a title="Prob ano" alt="'.$s[2].'" target="_self" href="/fotos/'.$s[2].'/'.$s[0].'/'.url($s[1]).'.html#cmt_'.$s[4].'">'.cut($s[1], 25, '...').'</a></li>';
  }
}
?>