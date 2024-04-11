<?php
if($_POST['ref'] && !defined($config['define'])) {
  include('../config.php');
  include('../functions.php');
  if($_POST['ref'] != 'Posts' && $_POST['ref'] != 'Muros' && $_POST['ref'] != 'Fotos') { die('0: Puto'); }
  echo '1: ';
} else {
  if(!defined($config['define'])) { die('0: Puto'); }
  $_POST['ref'] = 'Posts';
}
$i = 0;
/* Hacemos esta query hija de puta */
switch($_POST['ref']) {
  case 'Posts':
    /* few */
    $query = mysql_query('SELECT p.id, p.title, p.`time`, p.`sticky`, u.nick, cat.name, cat.url, u.id as uid FROM posts AS p INNER JOIN users AS u ON u.id = p.author LEFT JOIN categories AS cat ON cat.id = p.cat WHERE p.status = \'0\'  ORDER BY p.sticky DESC, p.id DESC LIMIT  15');
    echo '<script> var actual = \'Posts\'; </script>';
    while($row = mysql_fetch_assoc($query)) {
      echo '<div style="background:'.($row['sticky'] == '1' ? '#FFFFCC;' : (++$i%2 ? '#f4f9fd' : '#FFF')).'" class="ult_post_container posts"><span class="categoriaPost '.$row['url'].'"></span><a alt="'.$row['title'].'" title="'.$row['title'].'" target="_self" href="/posts/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html">'.cut($row['title'], 40, '...').'</a>
  	  <span style="color:#777;"> - <span ts="'.$row['time'].'" title="'.date('d.m.Y', $row['time']).' a las '.date('G:i', $row['time']).'" class="ult_post_hace">'.timefrom($row['time']).'</span> - por @<a target="_self" class="hovercard" data-uid="'.$row['uid'].'" title="'.$row['nick'].'" href="/perfil/'.$row['nick'].'">'.$row['nick'].'</a></span>
  	  <span class="ult_post_cat">'.$row['name'].'</span></div>';
      if($row['sticky'] == '0') { echo '<hr style="margin: 0px;" class="divider">'; }
    }
    break;
  case 'Fotos':
    echo '<script> var actual = \'Fotos\'; </script>';
    $query = mysql_query('SELECT p.id, p.title, p.time, u.nick, cat.name, cat.url, u.id AS uid FROM photos AS p INNER JOIN users AS u ON u.id = p.author LEFT JOIN p_categories AS cat ON cat.id = p.cat WHERE p.status = \'0\' ORDER BY p.id DESC LIMIT 15') or die(mysql_error());
    if(mysql_num_rows($query)) {
      while($rs = mysql_fetch_assoc($query)) {
        echo '<div style="background:'.($i == 0 ? '#f4f9fd' : '#FFF').'" class="ult_post_container posts"><span class="categoriaPost fotos"></span>
  	            <a alt="'.$rs['title'].'" title="'.$rs['title'].'" target="_self" href="/fotos/fotos/'.$rs['id'].'/'.url($rs['title']).'.html">
                  '.cut($rs['title'], 41, '...').'
  	            </a><span style="color:#777;"> - <span ts="'.$rs['time'].'" title="'.date('d.m.Y', $rs['time']).' a las '.date('G:i', $rs['time']).'" class="ult_post_hace">'.timefrom($rs['time']).'</span> - Por @<a class="hovercard" data-uid="'.$rs['uid'].'" href="/perfil/'.$rs['nick'].'">'.$rs['nick'].'</a></span>
  				<span class="ult_post_cat">'.$rs['name'].'</span>
             </div><hr style="margin: 0px;" class="divider">';
        $i = ($i == 0 ? 1 : 0);
      }
   } else { echo 'No hay nada'; }
    break;
}