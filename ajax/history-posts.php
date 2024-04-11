<?php
if(!defined($config['define'])) {
  if(!$_POST['ajax']) { die; }
  include('../config.php');
  include('../functions.php');
  echo '1:';
} else { echo '<script> var actual = \'posts\'; </script>'; }
if(!$key) { die; }
?>
<table class="linksList" style="width:952px;">
  <thead>
    <tr>
    <th>&nbsp;</th>
    <th style="text-align:left">&iquest;Qu&eacute; post?</th>
    <th>Acci&oacute;n</th>
    <th>Causa</th>
    <th>Moderador</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $q = mysql_query('SELECT p.id, p.title, p.cat, u.nick, m.moderador, m.reason, m.action, u2.nick FROM `posts` AS p INNER JOIN `history_mod` AS m ON m.post = p.id INNER JOIN `users` AS u ON u.id = p.author LEFT JOIN `users` AS u2 ON m.moderador = u2.id WHERE  m.type = \'0\' ORDER BY m.id DESC LIMIT 20');
  while($row = mysql_fetch_row($q)) {
  ?>
  <tr>
    <td style="width:2px;"></td>
    <td style="text-align:left;width:380px"><span style="color:purple">Post:</span> <?=$row[1];?> [ID: <?=$row[0];?>] <br><b>Por: </b><a href="/perfil/<?=$row[3];?>"><?=$row[3];?></a></td>

    <td><font style="color: <?=($row[6] == '0' ? 'red' : 'green');?>"><?=($row[6] == '0' ? 'Eliminado' : 'Editado');?></font></td>
    <td><?=(!empty($row[5]) ? $row[5] : '-');?></td>
    <td>
    <?=(!empty($row[7]) ? $row[7] : ' - ');?>
    <!--/*if(mysql_num_rows($w = mysql_query('SELECT `nick` FROM `users` WHERE `id` = \''.$row[4].'\''))) {
      $ms = mysql_fetch_row($w);
      echo '<a href="/perfil/'.$ms[0].'" title="'.$ms[0].'" alt="'.$ms[0].'" style="color:#333;">'.$ms[0].'</a>';
    } else { echo '-'; } */  -->
    </td>
  </tr>
  <?php
  }
  ?>
  </tbody>
</table>