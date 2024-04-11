<?php
if($_POST['ajax'] && !defined($config['define'])) {
  include('../config.php');
  include('../functions.php');
  echo '1: ';
} else {
  if(!defined($config['define'])) { die; }
  echo '<script> var actual = \'photos\'; </script>';
}
?>
<table class="linksList" style="width:952px;">
    <thead>
    	<tr>
        	<th>&nbsp;</th>
        	<th style="text-align:left">&iquest;Qu&eacute; foto?</th>
        	<th>Acci&oacute;n</th>
        	<th>Causa</th>
        	<th>Moderador</th>
    	</tr>
	</thead>
	<tbody>
    <?php
    $query = mysql_query('SELECT p.id, p.title, u.nick, h.reason, h.action, u2.nick AS moderador FROM `photos` AS p INNER JOIN `history_mod` AS h ON h.post = p.id INNER JOIN `users` AS u ON u.id = p.author LEFT JOIN `users` AS u2 ON h.moderador = u2.id WHERE h.type = \'1\' ORDER BY h.id DESC LIMIT 20');
    if(mysql_num_rows($query)) {
      while($row = mysql_fetch_assoc($query)) {
    ?>
    <tr>
        <td style="width:2px;"></td>
        <td style="text-align:left;width:380px"><span style="color:green">Foto:</span> <?=$row['title'];?> [ID: <?=$row['id'];?>] <br><b>Por: </b><a href="/perfil/<?=$row['nick'];?>"><?=$row['nick'];?></a></td>
        <td><font style="color: <?=($row['action'] == '1' ? 'red' : 'green');?>;"><?=($row['action'] == '1' ? 'Eliminado' : 'Editado');?></font></td>
        <td><?=$row['reason'];?></td>
        <td>
        <?=($row['moderador'] ? $row['moderador'] : ' - ');?>
        </td>
    </tr>
    <?php
    }
    ?>
	</tbody>
    <?php
    } else {
      echo '<div class="redBox">No hay nada...</div>';
    }
    ?>
</table>