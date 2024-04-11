<?php
switch($_GET['type']) {
  case 'post':
    include('../config.php');
    include('../functions.php');
    if(!$_GET['id']) { die('0: El campo id es requerido'); }
    if(!mysql_num_rows($post = mysql_query('SELECT `id`, `status`, `private`, `body` FROM `posts` WHERE id = \''.intval($_GET['id']).'\''))) { die('0: El post no existe guachon'); }
    $r = mysql_fetch_assoc($post);
    if($r['private'] == '1' && !$key) { die('<div class="post_p_privado"><div style="border:1px dashed #CCC; padding:10px;margin-top:2px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px">Oops! Este post es privado y debes estar <a onclick="accounts.registro_load_form();document.getElementById(\'facebox\').style.display = \'none\';return false" title="Registrate" class="close">registrado</a> para previsualizarlo!</div></div>'); }
    if($r['status'] != '0') { die('0: Error'); }
    $r['body'] = BBposts($r['body']);
    $pos = substr($r['body'], 0, 300);
    if(strpos($pos, ' ') !== false) {
      $pos = substr($pos, 0, strrpos($pos, ' '));
    }
    echo $pos;
    break;
}