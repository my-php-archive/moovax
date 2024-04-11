<?php
if(!defined('adm')) { die; }
if(!allow('show_contact')) { fatal_error('No tienes permisos'); }
$query = 'SELECT * FROM `contact` ORDER BY `id` DESC';
$num = mysql_num_rows(mysql_query($query));
$per = 20;
$_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) ? $_GET['p'] : 1;
$st = ceil($num / $per);
if($_GET['p'] > $st && $st > 0) { fatal_error('No hay mas p&aacute;ginas'); }
$limit = ($_GET['p']-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per) or die('0: '.mysql_error());
echo '<div id="adm-right">';
if($num) {
?>
	<div class="user_info">
		<h2>Lista de contactantes (<?=$num;?>)</h2>
    </div>
        <table class="linksList">
    		<thead>
    			<tr>
    				<th>&nbsp;</th>
    				<th>IP</th>
    				<th>E-mail</th>
    				<th>Empresa</th>
    				<th>Horario</th>
    				<th>Motivo</th>
                    <th>Comentario</th>
                    <th>Hace</th>
                    <th>Borrar</th>
                    <th>Responder</th>
                </tr>
    		</thead>
    		<tbody>
            <?php
            while($r = mysql_fetch_assoc($query)) {
            ?>
            <tr id="not<?=$r['id'];?>">
    				<td style="width:0px" title="SyncStar"><img src="<?=$config['images'];?>/images/balloon.png" align="absmiddle"></td>
                    <td style="width:30px"><a href="/admin/rastrear-ip/<?=$r['ip'];?>" title="Rastrear IP"><?=$r['ip'];?></a></td>
    				<td style="width:30px"><?=$r['email'];?></a></td>
    				<td style="width:50px"><?=$r['office'];?></td>
    				<td style="width:50px;"><?=$r['schedule'];?></td>
                    <td style="width:50px;">
                    <?php
                    switch($r['motive']) {
                      case '1': echo 'Publicidad'; break;
                      case '2': echo 'Sugerencias'; break;
                      case '3': echo 'Peticiones'; break;
                      case '4': echo 'Errores'; break;
                      case '5': echo 'Otros'; break;
                      default: echo ' - '; break;
                    }
                    ?></td>
    				<td style="width:150px"><?=$r['comment'];?></td>
                    <td style="width:50px"><?=timefrom($r['time']);?></td>
                    <td style="width:0px"><a onclick="admin.delcontact(<?=$r['id'];?>); return false;" href="#"><img id="delete<?=$r['id'];?>" src="<?=$config['images'];?>/images/cross.png" /></a></td>
                    <td style="width:0px"><a onclick="admin.mail(<?=$r['id'];?>); return false;" href="#"><img src="<?=$config['images'];?>/images/noti.png" /></a></td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>

<div class="clear"></div>
<?php
if($_GET['p'] > 1 || $_GET['p'] < $st) {
  echo '<div class="paginadorCom" style="width:756px">';
  if($_GET['p'] > 1) { echo '<div class="floatL before"><a href="/admin/contactantes/page/'.($_GET['p'] - 1).'"><b>&laquo; Anterior</b></a></div>'; }
  if($_GET['p'] < $st) { echo '<div class="floatR next"><a href="/admin/contactantes/page/'.($_GET['p'] + 1).'"><b>Siguiente &raquo;</b></a></div>'; }
  echo '</div>';
}
//echo '</div>';
} else { echo '<div class="redBox size13">Nada por aqu&iacute;...</div>'; }
?>
</div>
<div style="clear:both"></div></div></div>