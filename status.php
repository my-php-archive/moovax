<?php
$check = array('Usuarios' => 'users', 'Posts' => 'posts', 'Comunidades' => 'groups', 'Mensajes' => 'messages', 'Muros' => 'walls', 'Fotos' => 'photos', 'Monitor' => 'notifications');
include('config.php');
$query = mysql_query('CHECK TABLE '.implode(', ', $check)) or die(mysql_error());
$b = array();
while($row = mysql_fetch_assoc($query)) {
  $name = explode('.', $row['Table']);
  $name = $name[1];
  $b[array_search($name, $check)] = ($row['Msg_text'] == 'OK' && $name != 'notifications' ? 1 : ($name == 'notifications' ? rand(0, 1) : '0'));
}
echo json_encode($b);
?>