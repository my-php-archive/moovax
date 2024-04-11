<?php
if(!defined($config['define']) && !$_POST['ajax']) { die; }
if($_POST['ajax'] && $_POST['filter']) {
  include('../config.php');
  include('../functions.php');
} else { $_POST['filter'] = 'semana'; }
if($_POST['filter'] && $_POST['filter'] != 'mes' && $_POST['filter'] != 'semana' && $_POST['filter'] != 'historico' && $_POST['filter'] != 'hoy' && $_POST['filter'] != 'ayer') { die('0: Error provocado'); }
switch($_POST['filter']) {
  case 'hoy':
    $time = time()-86400;
    $dt = time();
    break;
  case 'ayer':
    $time = time()-172800;
    $dt = time()-86400;
    break;
  case 'semana':
    $time = time()-604800;
    $dt = time();
    break;
  case 'mes':
    $time = time()-2592000;
    $dt = time();
    break;
  default:
    $time = 0;
    $dt = time();
}
////////////////////////////////////////////////////////////////////////////////////////////
$query = mysql_query('SELECT p.id, p.title, SUM(v.points) as points, cat.url FROM posts AS p INNER JOIN votes AS v ON v.id_post = p.id LEFT JOIN categories AS cat ON cat.id = p.cat WHERE p.status = \'0\' && p.time > \''.$time.'\' && p.`time` < \''.$dt.'\' GROUP BY p.id ORDER BY points DESC LIMIT 15') or die(mysql_error());
if(mysql_num_rows($query)) {
  while($row = mysql_fetch_assoc($query)) {
    echo '<li><a title="'.$row['title'].'" href="/posts/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html" class="size11">'.cut($row['title'], 38, '...').'</a> (<span title="'.$row['points'].' pts">'.$row['points'].'</span>)</li>';
  }
} else { echo 'Nada por aqu&iacute;...'; }

