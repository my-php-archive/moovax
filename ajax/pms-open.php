<?php
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes estar logueado para realizar esta acc&oacute;n'); }
if(!mysql_num_rows($messages = mysql_query('SELECT `u`.`nick`, `m`.`id`, `m`.`issue` FROM `messages` AS m INNER JOIN `users` AS u ON `u`.`id` = `m`.`author` WHERE `m`.`receiver` = \''.$logged['id'].'\' && `m`.`receiver_read` = \'0\' && `m`.`receiver_status` = \'0\' ORDER BY `m`.`id` DESC'))) {
  echo '0: <div class="redBox">No ten&eacute;s mensajes sin leer.</div>';
} else {
  echo '1: ';
  while($rs = mysql_fetch_row($messages)) {
    echo '<a href="/perfil/'.$rs[0].'"><b>'.$rs[0].'</b></a> te envi&oacute; el MP: <a href="/mensajes/leer/'.$rs[1].'"><b>'.$rs[2].'</b></a><hr class="divider style="margin:0px;">';
  }
}