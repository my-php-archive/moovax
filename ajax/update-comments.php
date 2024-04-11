<?php
if(!defined($config['define'])) {
  include('../config.php');
  include('../functions.php');
}
if($_POST) { $if = ''; }//eeer34
if(!$_REQUEST['categoria']) { $_REQUEST['categoria'] = '-1'; }
if($_REQUEST['categoria'] != '-1' && mysql_num_rows($few = mysql_query('SELECT id FROM categories WHERE url = \''.mysql_clean($_REQUEST['categoria']).'\''))) {
  $row = mysql_fetch_row($few);
  $if = '&& p.cat = \''.$row[0].'\'';
}
if($_POST['country'] && $_POST['country'] != '-1' && mysql_num_rows($m = mysql_query('SELECT `id` FROM `countries` WHERE `id` = \''.intval($_POST['country']).'\''))) {
  $r = mysql_fetch_row($m);
  $if .= ' && u.country = \''.$r[0].'\'';
}
$comments = mysql_query('SELECT p.id, p.title, cat.url, u.nick, c.id as cid, c.`author` FROM comments AS c INNER JOIN posts AS p ON p.id = c.id_post LEFT JOIN categories AS cat ON cat.id = p.cat INNER JOIN users AS u ON u.id = c.author WHERE p.status = \'0\' '.$if.' ORDER BY c.id DESC LIMIT 15') or die(mysql_error());
if(mysql_num_rows($comments)) {
  while($f = mysql_fetch_row($comments)) {
    echo '<li><strong>@<a data-uid="'.$f[5].'" class="hovercard" href="/'.$f[3].'">'.$f[3].'</a></strong> -
  			<a title="'.$f[1].'" alt="'.$f[1].'" target="_self" href="/posts/'.$f[2].'/'.$f[0].'/'.url($f[1]).'.html#cmt_'.$f[4].'">'.cut($f[1], 25, '...').'</a>
         </li>';
  }
} else { echo 'Nada por aqu&iacute;...'; }
?>