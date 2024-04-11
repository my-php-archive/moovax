<?php
//if(!$_GET['_'] && !defined($config['define'])) { die; }
if(!defined($config['define'])) {
  if(!$_GET['_']) die;
  include('../config.php');
  include('../functions.php');
  echo '1: ';
}
if($_GET['filter2'] == 'temas' || !$_GET['filter2']) {
  $query = mysql_query('SELECT g.name, g.url, COUNT(t.id), cat.img, cat.name, cat.url FROM `groups` AS g INNER JOIN `groups_topics` AS t ON t.`group` = g.id INNER JOIN `groups_categories` AS cat ON cat.id = g.cat WHERE t.`status` = \'0\' && g.`status` = \'0\' GROUP BY g.id ORDER BY COUNT(t.id) DESC LIMIT 15');
  $i = 0;
  while($r = mysql_fetch_row($query)) {
    echo '<li id="info2" style="border-top:1px dashed #AEAEAE;border-bottom:0px;padding:3px;"><span style="margin-left:5px;"><b>'.(++$i).'.- </b></span><span style="margin-right:3px;"><img align="absmiddle" title="" alt="" src="'.$config['images'].'/images/comunidades/categorias/'.$r[3].'.png"></span> <a alt="'.$r[0].'" title="'.$r[0].'" target="_self" href="/comunidades/'.$r[1].'/">'.$r[0].'</a> ('.$r[2].' temas)</li>';
  }
} else {
  $query = mysql_query('SELECT g.`name`, g.`url`, cat.`name` AS namecat, cat.`img`, COUNT(m.id) AS few FROM `groups` AS g INNER JOIN `groups_categories` AS cat ON cat.id = g.cat INNER JOIN `groups_members` AS m ON m.group = g.`id` WHERE g.`status` = \'0\' && m.`status` = \'0\' GROUP BY g.id ORDER BY COUNT(m.id) DESC LIMIT 15') or die('0: '.mysql_error());
  $i = 0;
  while($rw = mysql_fetch_assoc($query)) {
    echo '<li id="info2" style="border-top:1px dashed #AEAEAE;border-bottom:0px;padding:3px;">
		  <span style="margin-left:5px;"><b>'.(++$i).'.-</b></span>
		  <span style="margin-right:3px;"><img align="absmiddle" title="'.$rw['namecat'].'" alt="'.$rw['namecat'].'" src="'.$config['images'].'/images/comunidades/categorias/'.$rw['img'].'.png"></span>
		  <a alt="'.$rw['name'].'" title="'.$rw['name'].'" target="_self" href="/comunidades/'.$rw['url'].'/">'.$rw['name'].'</a> ('.$rw['few'].' miembro'.($rw['few'] > 1 ? 's' : '').')
		  </li>';
  }
}