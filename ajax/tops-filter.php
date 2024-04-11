<?php
if(!$_GET['ajax']) {
  if(!defined($config['define'])) { die('Cagar pa adentro'); }
} else {
  include('../config.php');
  include('../functions.php');
}
if(!$_GET['currenttop']) { $_GET['currenttop'] = 'posts'; }
if(!in_array($_GET['currenttop'], array('posts', 'fotos', 'usuarios', 'categorias'))) { $_GET['currenttop'] = 'posts'; }
if($_GET['cat'] && $_GET['cat'] != '-1') {
  if($_GET['currenttop'] == 'posts' || $_GET['currenttop'] == 'usuarios') {
    $n = mysql_num_rows($query = mysql_query('SELECT `id` FROM `categories` WHERE `url` = \''.mysql_clean($_GET['cat']).'\''));
  } elseif($_GET['currenttop'] == 'fotos') {
    $n = mysql_num_rows($query = mysql_query('SELECT `id` FROM `p_categories` WHERE `url` = \''.mysql_clean($_GET['cat']).'\''));
  }
  if($n) {
    $r = mysql_fetch_row($query);
    $cat = $r[0]; //Filtramos mmm
    $qtcat = ' && p.`cat` = \''.$r[0].'\'';
  }
}
$dif = time();
switch($_GET['time']) {
  case 'hoy': $ttt = time()-86400; break;
  case 'ayer': $ttt = time()-172800; $dt = time()-86400; break;
  case 'semana': $ttt = time()-604800; break;
  case 'mes': $ttt = time()-2592000; break;
  default: $ttt = 0;
}
if(!$_GET['ajax']) { echo '<script>var filtro_sec_act = \''.$_GET['currenttop'].'\'; </script>'; }
echo '<script>var currenttcat = \''.htmlspecialchars($_GET['cat'], ENT_QUOTES).'\';</script>';
if($_GET['currenttop'] == 'posts') {
?>
<div id="tops_panel">
  <div class="box_title_content">
      <div class="box_txt">Posts con m&aacute;s puntos</div>
  </div>
  <div class="box_cuerpo_content">
  <?php
  $query = mysql_query('SELECT `p`.`id`, `p`.`title`, cat.`url`, SUM(v.points) FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.`id` = p.`cat` INNER JOIN `votes` AS v ON v.`id_post` = p.`id` WHERE p.`status` = \'0\''.($qtcat ? $qtcat : '').' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\' GROUP BY p.id ORDER BY SUM(v.`points`) DESC LIMIT 15') or die(mysql_error());
  if(mysql_num_rows($query)) {
    echo '<ol>';
    while($row = mysql_fetch_assoc($query)) {
      echo '<li class="categoriaPost '.$row['url'].'" style="margin-bottom:0px"><a title="'.$row['title'].'" href="/posts/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html" target="_self">'.cut($row['title'], 35).'</a></li>';
    }
    echo '</ol>';
  } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
  ?>
  </div>
</div>

<div id="tops_panel">
  <div class="box_title_content">
      <div class="box_txt">Posts m&aacute;s favoritos</div>
  </div>
  <div class="box_cuerpo_content">
  <?php
  $query = mysql_query('SELECT p.id, p.title, cat.url, COUNT(f.id) FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.id = p.cat INNER JOIN `favorites` AS f ON f.`id_pf` = p.id WHERE p.`status` = \'0\' && f.`type` = \'0\''.($qtcat ? $qtcat : '').' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\' GROUP BY p.id ORDER BY COUNT(f.id) DESC LIMIT 15') or die(mysql_error());
  if(mysql_num_rows($query)) {
    echo '<ol>';
    while($rq = mysql_fetch_assoc($query)) {
      echo '<li class="categoriaPost '.$rq['url'].'" style="margin-bottom:0px"><a title="'.$rq['title'].'" href="/posts/'.$rq['url'].'/'.$rq['id'].'/'.url($rq['title']).'.html" target="_self">'.cut($rq['title'], 35, '...').'</a></li>';
    }
    echo '</ol>';
  } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
  ?>
  </div>
</div>
<div class="clear"></div><br class="space">

<div id="tops_panel">
  <div class="box_title_content">
      <div class="box_txt">Posts m&aacute;s comentados</div>
  </div>
  <div class="box_cuerpo_content">
  <?php
  $query = mysql_query('SELECT p.`id`, p.`title`, cat.`url`, COUNT(c.id) FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.id = p.cat INNER JOIN `comments` AS c ON c.id_post = p.`id` WHERE p.`status` = \'0\''.($qtcat ? $qtcat : '').' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\' GROUP BY p.id ORDER BY COUNT(c.id) DESC LIMIT 15') or die(mysql_error());
  if(mysql_num_rows($query)) {
    echo '<ol>';
    while($row = mysql_fetch_assoc($query)) {
      echo '<li class="categoriaPost '.$row['url'].'" style="margin-bottom:0px"><a title="'.$row['title'].'" href="/posts/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html" target="_self">'.cut($row['title'], 35).'</a></li>';
    }
    echo '</ol>';
  } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
  ?>
  </div>
</div>

<div id="tops_panel">
  <div class="box_title_content">
      <div class="box_txt">Posts m&aacute;s visitados</div>
  </div>
  <div class="box_cuerpo_content">
  <?php
  $query = mysql_query('SELECT p.`id`, p.`title`, cat.`url`, COUNT(v.id) FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.id = p.cat INNER JOIN `post_visits` AS v ON v.post = p.`id` WHERE `p`.`status` = \'0\' && v.`type` = \'0\''.($qtcat ? $qtcat : '').' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\' GROUP BY p.`id` ORDER BY COUNT(v.id) DESC LIMIT 15') or die(mysql_error());
  if(mysql_num_rows($query)) {
    echo '<ol>';
    while($r = mysql_fetch_row($query)) {
      echo '<li class="categoriaPost '.$r[2].'" style="margin-bottom:0px"><a title="'.$r[1].'" href="/posts/'.$r[2].'/'.$r[0].'/'.url($r[1]).'.html" target="_self">'.cut($r[1], 35).'</a></li>';
    }
    echo '</ol>';
  } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
  ?>
  </div>
</div>
<?php } elseif($_GET['currenttop'] == 'usuarios') { ?>
<div id="tops_panel">
  <div class="box_title_content">
      <div class="box_txt">Usuarios con m&aacute;s posts</div>
  </div>
  <div class="box_cuerpo_content">
  <?php
  $query = mysql_query('SELECT u.nick, u.avatar, COUNT(p.id) FROM `posts` AS p INNER JOIN `users` AS u ON u.id = p.author INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE p.`status` = \'0\' && u.`ban` = \'0\''.($qtcat ? $qtcat : '').' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\' GROUP BY u.id ORDER BY COUNT(p.id) DESC LIMIT 15') or die(mysql_error());
  if(mysql_num_rows($query)) {
    echo '<ol>';
    while($row = mysql_fetch_row($query)) {
      echo '<li><div style="height:18px;"> <img border="0" align="top" style="margin-top:-1px;" src="'.$config['images'].'/images/user.png"> <a target="_self" href="/perfil/'.$row[0].'" title="'.$row[0].'" style="font-size:13px;">'.$row[0].'</a> <span style="font-size:13px;color:#666;" class="floatR">'.$row[2].'</span></div></li>';
    }
    echo '</ol>';
  } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
  ?>
  </div>
</div>

<div id="tops_panel">
  <div class="box_title_content">
      <div class="box_txt">Usuarios con m&aacute;s puntos en posts</div>
  </div>
  <div class="box_cuerpo_content">
  <?php
  $query = mysql_query('SELECT u.nick, u.avatar, SUM(v.points) FROM `users` AS u INNER JOIN `posts` AS p ON p.`author` = u.id INNER JOIN `categories` AS cat ON cat.id = p.cat INNER JOIN `votes` AS v ON v.id_post = p.id WHERE p.`status` = \'0\''.($qtcat ? $qtcat : '').' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\' && u.ban = \'0\' GROUP BY u.id ORDER BY SUM(v.points) DESC LIMIT 15') or die(mysql_error());
  if(mysql_num_rows($query)) {
    echo '<ol>';
    while($row = mysql_fetch_row($query)) {
      echo '<li><div style="height:18px;"> <img border="0" align="top" style="margin-top:-1px;" src="'.$config['images'].'/images/user.png"> <a target="_self" href="/perfil/'.$row[0].'" title="'.$row[0].'" style="font-size:13px;">'.$row[0].'</a> <span style="font-size:13px;color:#666;" class="floatR">'.$row[2].'</span></div></li>';
    }
    echo '</ol>';
  } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
  ?>
  </div>
</div>
<?php } elseif($_GET['currenttop'] == 'categorias') { ?>
<div id="tops_panel">
    <div class="box_title_content">
	    <div class="box_txt">Categor&iacute;as con m&aacute;s posts</div>
	</div>
    <div class="box_cuerpo_content">
    <?php
    $query = mysql_query('SELECT cat.* FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.id = p.cat INNER JOIN `users` AS u ON u.id = p.author WHERE p.`status` = \'0\' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\' GROUP BY cat.`id` ORDER BY COUNT(p.id) DESC LIMIT 15');
    if(mysql_num_rows($query)) {
      echo '<ol>';
      while($r = mysql_fetch_assoc($query)) {
        echo '<li style="margin-bottom:0px" class="categoriaPost clearfix '.$r['url'].'"><a target="_self" href="/posts/'.$r['url'].'/" title="'.$r['name'].'">'.$r['name'].'</a></li>';
      }
      echo '</ol>';
    } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
    ?>
    </div>
</div>
<div id="tops_panel">
    <div class="box_title_content">
	    <div class="box_txt">Categor&iacute;as con m&aacute;s im&aacute;genes</div>
	</div>
    <div class="box_cuerpo_content">
    <?php
    $query = mysql_query('SELECT cat.name, cat.url FROM `categories` AS cat INNER JOIN `photos` AS p ON p.cat = cat.id INNER JOIN `users` AS u ON u.id = p.author WHERE p.`status` = \'0\' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\' GROUP BY cat.id ORDER BY COUNT(p.id) DESC LIMIT 15') or die(mysql_error());
    if(mysql_num_rows($query)) {
      echo '<ol>';
      while($q = mysql_fetch_row($query)) {
        echo '<li style="margin-bottom:0px" class="categoriaPost clearfix '.$q[1].'"><a target="_self" href="/fotos/'.$q[1].'/" title="'.$q[0].'">'.cut($q[0], 33).'</a></li>';
      }
      echo '</ol>';
    } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
    ?>
    </div>
</div><div class="clear"></div>
<?php } else { ?>
<div id="tops_panel">
    <div class="box_title_content">
	    <div class="box_txt">Im&aacute;genes con m&aacute;s puntos</div>
	</div>
    <div class="box_cuerpo_content">
    <?php
    $query = mysql_query('SELECT p.`id`, p.`title`, cat.`url`, SUM(v.points) AS sum FROM `photos` AS p INNER JOIN `p_categories` AS cat ON cat.id = p.cat INNER JOIN `p_votes` AS v ON v.`photo` = p.id WHERE p.`status` = \'0\''.($qtcat ? $qtcat : '').' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\' GROUP BY p.id ORDER BY sum DESC LIMIT 15') or die(mysql_error());
    if(mysql_num_rows($query)) {
      echo '<ol>';
      while($prs = mysql_fetch_row($query)) {
        echo '<li style="margin-bottom:0px" class="categoriaPost clearfix '.$prs[2].'"><a target="_self" href="/fotos/'.$prs[2].'/'.$prs[0].'/'.url($prs[1]).'.html" title="'.$prs[1].'">'.cut($prs[1], 33).'</a></li>';
      }
      echo '</ol>';
    } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
    ?>
    </div>
</div>

<div id="tops_panel">
    <div class="box_title_content">
	    <div class="box_txt">Im&aacute;genes m&aacute;s comentadas</div>
	</div>
    <div class="box_cuerpo_content">
    <?php
    $qs = mysql_query('SELECT p.id, p.title, cat.`url` FROM `photos` AS p INNER JOIN `p_comments` AS c ON c.photo = p.id  INNER JOIN `p_categories` AS cat ON cat.id = p.cat WHERE p.`status` = \'0\' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\''.($qtcat ? $qtcat : '').' GROUP BY p.id ORDER BY COUNT(c.id) DESC LIMIT 15') or die(mysql_error());
    if(mysql_num_rows($qs)) {
      echo '<ol>';
      while($rw = mysql_fetch_row($qs)) {
        echo '<li style="margin-bottom:0px" class="categoriaPost clearfix '.$rw[2].'"><a target="_self" href="/fotos/'.$rw[2].'/'.$rw[0].'/'.url($rw[1]).'.html" title="'.$rw[1].'">'.cut($rw[1], 33).'</a></li>';
      }
      echo '</ol>';
    } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
    ?>

    </div>
</div>

<div id="tops_panel">
    <div class="box_title_content">
	    <div class="box_txt">Im&aacute;genes m&aacute;s visitadas</div>
	</div>
    <div class="box_cuerpo_content">
    <?php
    $query = mysql_query('SELECT p.id, p.`title`, cat.`url` FROM `photos` AS p INNER JOIN `p_categories` AS cat ON cat.id = p.cat INNER JOIN `post_visits` AS v ON v.post = p.id WHERE p.`status` = \'0\' && `type` = \'1\' && p.`time` > \''.$ttt.'\''.($qtcat ? $qtcat : '').' && p.`time` < \''.$dif.'\' GROUP BY p.id ORDER BY COUNT(v.id) DESC LIMIT 15') or die(mysql_error());
    if(mysql_num_rows($query)) {
      echo '<ol>';
      while($row = mysql_fetch_row($query)) {
        echo '<li style="margin-bottom:0px" class="categoriaPost clearfix '.$row[2].'"><a target="_self" href="/fotos/'.$row[2].'/'.$row[0].'/'.url($row[1]).'.html" title="'.$row[1].'">'.cut($row[1], 33).'</a></li>';
      }
      echo '</ol>';
    } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
    ?>
    </div>
</div>

<div id="tops_panel">
    <div class="box_title_content">
	    <div class="box_txt">Im&aacute;genes con m&aacute;s favoritos</div>
	</div>
    <div class="box_cuerpo_content">
    <?php
    $query = mysql_query('SELECT p.id, p.`title`, cat.url FROM `photos` AS p INNER JOIN `p_categories` AS cat ON cat.id = p.cat INNER JOIN `favorites` AS f ON f.id_pf = p.id WHERE p.`status` = \'0\' && f.`type` = \'1\' && p.`time` > \''.$ttt.'\' && p.`time` < \''.$dif.'\''.($qtcat ? $qtcat : '').' GROUP BY p.id ORDER BY COUNT(f.id) DESC LIMIT 15') or die(mysql_error());
    if(mysql_num_rows($query)) {
      echo '<ol>';
      while($row = mysql_fetch_assoc($query)) { echo '<li style="margin-bottom:0px" class="categoriaPost clearfix '.$row['url'].'"><a target="_self" href="/fotos/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html" title="'.$row['title'].'">'.cut($row['title'], 35).'</a></li>'; }
      echo '</ol>';
      //QUE le den -put
    } else { echo '<div class="yellowBox"><b class="size13">Nada por aqu&iacute;...</b></div>'; }
    ?>
    </div>
</div>
<div class="clear"></div>
<?php
}
?>