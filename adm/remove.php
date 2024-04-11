<?php
if(!defined('adm')) { die; }
if(!$logged['rank'] == 9){ fatal_error('anda a cagar pelotudo de mierda'); }
if($_POST){
if(!mysql_num_rows(mysql_query("SELECT `nick` FROM `users` WHERE `nick` = '".mysql_clean($_POST['user23'])."'"))){
fatal_error('Usuario no existente');
}
$gre = mysql_fetch_assoc(mysql_query("SELECT `id` FROM `users` WHERE `nick` = '".mysql_clean($_POST['user23'])."'")); //four to the floor eeeer34
mysql_query("DELETE FROM `posts` WHERE `author` = '".$gre['id']."'");
mysql_query("DELETE FROM `comments` WHERE `author` = '".$gre['id']."'");
mysql_query("DELETE FROM `messages` WHERE `author` = '".$gre['id']."'");
mysql_query("DELETE FROM `walls` WHERE `author` = '".$gre['id']."'");
mysql_query("DELETE FROM `w_replies` WHERE `author` = '".$gre['id']."'");
echo 'correcto :B';
}
//creo que con eso bastaría
?>
<div id="adm-right"><div class="user_info"><h2>Eliminar posts, comentarios, mensajes, y elementos en muros masivamente</h2> </div>
 <div class="redBox size12">Esta herramienta <u>NO</u> es un juguete, por ende no abuses de tu rango <img style="height:100px; width:100px;" src="http://i.imgur.com/9qkuW.jpg">
</div>
<center><form accept-charset="UTF-8" method="POST" action="/admin/remove/">
<br>
<span class="size14">Ingresa el usuario a borrarle TODO: </span><input type="text" maxlength="100" size="50" id="user23" name="user23">
<input type="submit" value="Eliminar!" class="Boton Small BtnGray"></form> </center> </div>