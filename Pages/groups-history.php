<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('Para ver esta secci&oacute;n debes loguearte'); }
?>
<div class="comunidades">

<div class="breadcrumb">
<ul>
<li class="first"><a class="home" href="/comunidades/" title="Comunidades"></a></li><li>Historial de moderaci&oacute;n</li><li class="last"></li>
</ul>
</div>
<div style="clear:both"></div>
<div id="resultados" style="width:100%">
<table class="linksList">
<thead>
<tr>
<th>Comunidad > Tema</th>
<th>Acci&oacute;n</th>
<th>Moderador</th>
<th>Causa</th>
</tr>
</thead>
<tbody>
<tbody>
<?php
$query = mysql_query('SELECT g.*, u.nick FROM `groups_actions` AS g INNER JOIN `users` AS u ON g.`author` = u.id ORDER BY id DESC LIMIT 20');
while($row = mysql_fetch_assoc($query)) {
  echo '<tr><td style="text-align: left;">';
  if($row['action'] == '0' || $row['action'] == '1' || $row['action'] == '4') {
    if($row['action'] == '0') {
      echo '<a href="'.$row['url'].'" class="titlePost">'.$row['title'].'</a>';
    } else {
      echo '<span class="titlePost">'.$row['title'].'</span>';
    }
    echo '<br>';
    $group = mysql_fetch_row(mysql_query('SELECT `name`, `url` FROM `groups` WHERE `id` = \''.$row['group'].'\''));
    echo 'En <a href="/comunidades/'.$group[1].'/">'.$group[0].'</a>';
  } else {
    if($row['action'] == '2') {
      echo '<a href="'.$row['url'].'">'.$row['title'].'</a>';
    } else { echo $row['title']; }
  }
  echo '<td>
            <span style="color: '.($row['action']%2 == '0' ? 'green' : 'red').';">';
            switch($row['action']) {
              case '0':
                echo 'Editado';
                break;
              case '1':
                echo 'Eliminado';
                break;
              case '2':
                echo 'Editada';
                break;
              case '3':
                echo 'Eliminada';
                break;
              case '4':
                echo 'Reactivado';
                break;
            }

            echo '</span>
       </td>
       <td>@<a href="/perfil/'.$row['nick'].'">'.$row['nick'].'</a></td>
       <td>'.($row['reason'] ? $row['reason'] : ' - ').'</td>
       </tr>';
}
?>

</tbody>
</tbody>
</table>
</div>
</div><div style="clear:both"></div>
</div></div> <!-- cuerpocontainer -->