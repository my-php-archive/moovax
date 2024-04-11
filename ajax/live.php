<?php
if(!defined($config['define'])) {
  include('../config.php');
  include('../functions.php');
}
if($_POST['id'] == '0') { die('[]'); }
$query = mysql_query('SELECT a.*, u.nick FROM `activity` AS a INNER JOIN `users` AS u ON u.id = a.`author`'.($_POST['id'] ? ' WHERE a.id > '.(int)$_POST['id'] : '').' && a.`type` < 15 ORDER BY a.`id` DESC LIMIT 20') or die(mysql_error());
//if(!mysql_num_rows($query)) { die('{"status":0}'); }

$f = array(); //metemos todo en este array, sino tengo que usar unset y no tengo ganas -yao
$cad = '';
while($r = mysql_fetch_assoc($query)) {
  $f['id'] = $r['id'];
  $f['nick'] = $r['nick'];
  $f['ts'] = date('G:i', $r['time']);
  $f['url'] = $r['url'];
  $f['titulo'] = $r['title']; //title?
  $f['userId'] = $r['author'];
  switch($r['type']) {
    case '1':
      $f['accionObjeto'] = 'post';
      $f['accionTipo'] = 'agregar';
      $f['accion_name'] = 'Cre&oacute; un nuevo post';
      break;
    case '2':
      $f['accionObjeto'] = 'comentario';
      $f['accionTipo'] = 'agregar';
      $f['accion_name'] = 'Nuevo comentario en el post';
      break;
    case '3':
      $f['accionObjeto'] = 'tema';
      $f['accionTipo'] = 'agregar';
      $f['accion_name'] = 'Cre&oacute; un tema';
      break;
    case '4':
      $f['accionObjeto'] = 'tema';
      $f['accionTipo'] = 'respuesta-agregar';
      $f['accion_name'] = 'Nueva respuesta en el tema';
      break;
    case '5':
      $f['accionObjeto'] = 'comunidad';
      $f['accionTipo'] = 'agregar';
      $f['accion_name'] = 'Cre&oacute; una nueva comunidad';
      break;
    case '6':
      $f['accionObjeto'] = 'comunidad';
      $f['accionTipo'] = 'participar';
      $f['accion_name'] = 'Se uni&oacute; a una comunidad';
    break;
    case '7':
      $f['accionObjeto'] = 'comunidad';
      $f['accionTipo'] = 'recomendar';
      $f['accion_name'] = 'Recomend&oacute; la comunidad';
      break;
    case '8':
      list($d) = mysql_fetch_row(mysql_query('SELECT `nick` FROM `users` WHERE `id` = \''.$r['what'].'\'')); //vaina loca
      $f['accionObjeto'] = 'usuario';
      $f['accionTipo'] = 'friend';
      $f['accion_name'] = 'Ahora es amigo de';
      unset($f['titulo']);
      $f['titulo'] = $d;
      $f['url'] = '/'.$d;
      break;
    case '9':
      $f['accionObjeto'] = 'photo';
      $f['accionTipo'] = 'agregar';
      $f['accion_name'] = 'Agreg&oacute; una nueva foto';
      break;
    case '10':
      $f['accionObjeto'] = 'photo';
      $f['accionTipo'] = 'comment';
      $f['accion_name'] = 'Coment&oacute; la foto';
      break;
    case '11':
      $f['accionObjeto'] = 'post';
      $f['accionTipo'] = 'votar';
      $f['accion_name'] = 'Vot&oacute; el post';
      $ex = explode('@$', $r['url']);
      $f['url'] = $ex[0];
      break;
    case '12':
      $f['accionObjeto'] = 'wall';
      $f['accionTipo'] = 'agregar';
      $f['accion_name'] = 'Nueva publicaci&oacute;n';
      break;
    case '13':
      $f['accionObjeto'] = 'wall';
      $f['accionTipo'] = 'comentario';
      $f['accion_name'] = 'Nueva respuesta en publicaci&oacute;n';
      break;
    case '14':
      $f['accionObjeto'] = 'wall';
      $f['accionTipo'] = 'votar';
      $f['accion_name'] = 'Le gusta una publicaci&oacute;n';
      break;
    default: continue;
  }
  $cad .= ','.json_encode($f);
  //$cad .= ','.json_encode($f);
}
echo '['.substr($cad, 1).']';