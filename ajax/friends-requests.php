<?php
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0Debes estar logueado para realizar esta acci&oacute;n'); }
if(!mysql_num_rows($query = mysql_query('SELECT f.id, u.id as uid, u.nick, u.avatar, u.message FROM `users` AS u INNER JOIN `friends` AS f ON f.author = u.id WHERE `f`.`user` = \''.$logged['id'].'\' && f.`status` = \'0\''))) { die('0No hay solicitudes nuevas'); }
echo '1<div id="mas_ams">';
while($row = mysql_fetch_assoc($query)) {
?>
<!-- please eeeer34 -->
<div id="ams_<?=$row['id'];?>" style="display: block;">
  <table>
    <tbody>
    <tr>
      <td align="left" valign="middle">
        <a href="/perfil/<?=$row['nick'];?>/">
        <img width="60" height="60" alt="Avatar" onerror="error_avatar(this)" src="<?=$row['avatar'];?>"></a>
      </td>
      <td align="left" width="200px" valign="top">
        <a style="color:#956100;font-size:14px;" href="/perfil/<?=$row['nick'];?>/" title="<?=$row['nick'];?>">
        <b><?=$row['nick'];?></b></a><br>
        <b>Quiere ser tu amigo</b>
        <br><span class="size10"><?=cut($row['message'], 30, '...');?></span>
      </td>
      <td valign="middle">
        <input type="button" style="width:70px;-moz-border-radius:0px;-webkit-border-radius:0px;border-radius:0px;font-size:11px" title="Aceptar" onclick="friends.accept('<?=$row['id'];?>'); return false;" class="Boton Small BtnGray" value="Aceptar">
      </td>
      <td valign="middle">
        <input type="button" style="width:75px;-moz-border-radius:0px;-webkit-border-radius:0px;border-radius:0px;font-size:11px" title="Rechazar" onclick="friends.decline('<?=$row['id'];?>'); return false;" class="Boton Small BtnGray" value="Rechazar">
      </td>
    </tr>
    </tbody>
  </table>
  <div class="barra-dashed"></div>
</div>
<?php
}
?>
</div>