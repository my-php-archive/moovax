<?php
if(!defined($config['define'])) {
  include('../config.php');
  include('../functions.php');
  echo '1: ';
} else {
  if(!defined('adm')) { die('0: No ten&eacute;s permisos para est&aacute;r ac&aacute;'); }
  $_POST['sec'] = ($_GET['f'] ? $_GET['f'] : 'posts'); //my last (8)
}
if($_POST['sec'] == 'posts') {
  $query = mysql_query('SELECT c.id, c.author, c.id_post, c.comment, c.type, c.status, u.id AS uid, u.nick, p.id AS pid, p.title, cat.url FROM complaints AS c INNER JOIN posts AS p ON p.id = c.id_post INNER JOIN users AS u ON u.id = p.author  LEFT JOIN categories AS cat ON cat.id = p.cat WHERE c.what = \'0\' GROUP BY p.id ORDER BY c.id DESC');
  $tabs = array('&nbsp;', 'Post', 'Raz&oacute;n', 'Comentario', 'Posteador', 'Denunciador', 'Aceptar', 'Eliminar');
  $tab = 'Post';
  $mm = 'posts';
} elseif($_POST['sec'] == 'users') {
  $query = mysql_query('SELECT u.nick, c.status, c.type, c.comment, c.id, c.author, c.id_post as uid FROM `users` AS u INNER JOIN complaints AS c ON c.id_post = u.id WHERE u.ban = \'0\' && c.what = \'2\' GROUP BY u.id ORDER BY c.id DESC');
  $tab = 'Usuario denunciado';
  $tabs = array('&nbsp;', 'Usuario denunciado', 'Raz&oacute;n', 'Comentario', 'Denunciador', 'Aceptar', 'Eliminar');
  $mm = 'usuarios';
} else {
  $mm = 'fotos';
  $tab = 'Foto';
  $query = mysql_query('SELECT c.id, c.`status`, p.id AS pid, p.title, u.nick, cat.url, cat.name, c.type, c.`comment` FROM `photos` AS p INNER JOIN `complaints` AS c ON c.id_post = p.id INNER JOIN p_categories AS cat ON cat.id = p.cat INNER JOIN `users` AS u ON u.id = p.author WHERE c.what = \'1\' GROUP BY p.id ORDER BY c.id DESC') or die(mysql_error());
  $tabs = array('&nbsp;', 'Foto', 'Raz&oacute;n', 'Comentario', 'Posteador', 'Denunciador', 'Aceptar', 'Eliminar');
}
if(!allow('complaints_'.$_POST['sec'])) { die('0: No ten&eacute;s permisos para est&aacute;r ac&aacute;'); }
if(mysql_num_rows($query)) {
?>
<table class="linksList">
    <thead>
	    <tr>
        <?php
        foreach($tabs as $name) { echo '<th>'.$name.'</th>'; }
        ?>
		</tr>
	</thead>
	<tbody>
      <?php
      if($tab == 'Post') {
        while($ve = mysql_fetch_assoc($query)) {
		?>
        <tr id="den_<?=$ve['id'];?>"<?=($ve['status'] == '1' ? ' style="background: none repeat scroll 0% 0% rgb(233, 252, 228);"' : '');?>>
      	      <td style="width:10px"><span class="categoriaPost <?=$ve['url']?>"></span></td>
      		  <td style="width:300px;text-align:left"><a href="/posts/<?=$ve['url']?>/<?=$ve['pid'];?>/<?=url($ve['title']);?>.html" title="<?=$ve['title'];?>" target="_self"><?=$ve['title'];?></a></td>
      		  <td>
              <?php
                switch($ve['type']) {
                  case '1': echo 'Re-Post'; break;
                  case '2': echo 'Spam'; break;
                  case '3': echo 'Enlaces muertos'; break;
                  case '4': echo 'Es Racista o irrespetuoso'; break;
                  case '5': echo 'Contiene información personal'; break;
                  case '6': echo 'El Titulo esta en mayúscula'; break;
                  case '7': echo 'Contiene Pornografia'; break;
                  case '8': echo 'Es Gore o alejandroso'; break;
                  case '9': echo 'Est&aacute; mal la fuente'; break;
                  case '10': echo 'Crap'; break;
                  case '11': echo 'Pide contrase&ntilde;a y no est&aacute;'; break;
                  case '12': echo 'No cumple con el protocolo'; break;
                  default: echo '-'; break;
                }
               ?>

              </td>
      		  <td><?=$ve['comment'];?></td>
      		  <td style="width:70px"><a href="/perfil/<?=$ve['nick'];?>"><?=$ve['nick'];?></a></td>
              <?php
              $r = mysql_query('SELECT u.nick FROM `users` AS u INNER JOIN complaints AS c ON c.author = u.id WHERE c.id_post = \''.intval($ve['pid']).'\' && `what` = \'0\'');
              $autores = '';
              /* puede que sea mas de una persona la que denuncia, por eso hacemos esto */
              while($row = mysql_fetch_assoc($r)) {
                $autores .= '- <a href="/perfil/'.$row['nick'].'">'.$row['nick'].'</a></td>';
              }
      		  echo '<td style="width:70px">'.substr($autores, 1).'</td>';
      		  echo '<td style="width:40px">'.($ve['status'] == '0' ? '<a onclick="admin.acc_denuncia(\''.$ve['id'].'\'); return false" title="Aceptar"><img src="'.$config['images'].'/images/icons/tick.png" id="acc_img_'.$ve['id'].'" align="absmiddle"></a>' : '').'</td>';
      		  echo '<td style="width:40px"><a onclick="admin.del_denuncia(\''.$ve['id'].'\'); return false" title="Eliminar"><img src="'.$config['images'].'/images/icons/borrar.png" id="del_img_'.$ve['id'].'" align="absmiddle"></a></td></tr>';
        }
      } elseif($tab == 'Foto') {
        while($row = mysql_fetch_assoc($query)) {
      ?>
      <tr id="den_<?=$row['id'];?>"<?=($row['status'] == '1' ? ' style="background: none repeat scroll 0% 0% rgb(233, 252, 228);"' : '');?>>
			<td style="width:10px"><span class="categoriaPost <?=$row['url'];?>"></span></td>
			<td style="width:300px;text-align:left"><a href="/fotos/<?=$row['url'];?>/<?=$row['pid'];?>/<?=url($row['title']);?>.html" title="<?=$row['title'];?>" target="_self"><?=$row['title'];?></a></td>
            <td>
            <?php
            switch($row['type']) {
              case '0': echo 'Foto ya agregada'; break;
              case '1': echo 'Se hace spam'; break;
              case '2': echo 'Contiene pornograf&iacute;a'; break;
              case '3': echo 'Es gore o asqueroso'; break;
              case '4': echo 'Contiene violencia'; break;
              case '5': echo 'Es racista'; break;
              case '6': echo 'No cumple con el protocolo'; break;
              default: echo ' - ';
            }
            ?>
            </td>
			<td><?=($row['comment'] ? $row['comment'] : ' - ');?></td>
			<td style="width:70px"><a href="/perfil/<?=$row['nick'];?>"><?=$row['nick'];?></a></td>
            <?php
            $var = '';
            $selec = mysql_query('SELECT u.nick FROM `users` AS u INNER JOIN `complaints` AS c ON c.author = u.id WHERE c.id_post = \''.$row['pid'].'\' && `what` = \'1\'');
            while($m = mysql_fetch_row($selec)) { $var .= '- <a href="/perfil/'.$m[0].'">'.$m[0].'</a>'; }
            ?>
			<td style="width:70px"><?=substr($var, 1);?></td>
			<td style="width:40px"><a onclick="admin.acc_denuncia('<?=$row['id'];?>'); return false" title="Aceptar"><img src="<?=$config['images'];?>/images/icons/tick.png" id="acc_img_<?=$row['id'];?>" align="absmiddle"></a></td>
			<td style="width:40px"><a onclick="admin.del_denuncia('<?=$row['id'];?>'); return false" title="Eliminar"><img src="<?=$config['images'];?>/images/icons/borrar.png" id="del_img_<?=$row['id'];?>" align="absmiddle"></a></td>
	  </tr>
      <?php
      }} else {
        while($rm = mysql_fetch_assoc($query)) {
      ?>
      <tr id="den_<?=$rm['id'];?>" <?=($rm['status'] == '1' ? ' style="background: none repeat scroll 0% 0% rgb(233, 252, 228);"' : '');?>>
	    <td style="width:20px"><img src="<?=$config['images'];?>/images/user.png" title="Usuario" align="absmiddle"></td>
		<td style="width:300px;text-align:left"><a href="/perfil/<?=$rm['nick'];?>" title="Ver perfil" target="_self"><?=$rm['nick'];?></a></td>
        <td>
        <?php
        switch($rm['type']) {
          case '0': echo 'Hace Spam el puto'; break;
          case '1': echo 'Es racista'; break;
          case '2': echo 'Publica informaci&oacute;n personal'; break;
          case '3': echo 'Es un pajero'; break;
          case '4': echo 'No cumple con las reglas'; break;
          case '5': echo 'Otra raz&oacute;n'; break;
          default: '-';
        }
        ?>
        </td>
		<td><?=($rm['comment'] ? $rm['comment'] : '-');?></td>
        <?php
        $cad = '';
        $s = mysql_query('SELECT u.`nick` FROM `users` AS u INNER JOIN `complaints` AS c ON c.author = u.id WHERE c.id_post = \''.$rm['uid'].'\' && `c`.`what` = \'2\'') or die(mysql_error());
        while($m = mysql_fetch_row($s)) {
          $cad .= '- <a href="/perfil/'.$m[0].'">'.$m[0].'</a>';
        }
        ?>
		<td style="width:70px"><?=substr($cad, 2);?></td>
		<td style="width:40px"><a onclick="admin.acc_denuncia('<?=$rm['id'];?>'); return false" title="Aceptar"><img src="<?=$config['images'];?>/images/icons/tick.png" id="acc_img_<?=$row['id'];?>" align="absmiddle"></a></td>
		<td style="width:40px"><a onclick="admin.del_denuncia('<?=$rm['id'];?>'); return false" title="Eliminar"><img src="<?=$config['images'];?>/images/icons/borrar.png" id="del_img_<?=$rm['id'];?>" align="absmiddle"></a></td>
	  </tr>
      <?php } } ?>
    </tbody>
</table>
<?php } else { echo '<div class="displayN redBox" id="error_filter" style="display: block;">No hay denuncias de '.$mm.' hechas</div>'; }?>