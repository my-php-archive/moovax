<?php
if(!defined($config['define'])) { die; }
switch($_GET['action']) {
  default:
    $title['default'] = 'Administraci&oacute;n';
    $title['url'] = '/admin/mensajes/';
    break;
  case 'ban-list':
    $title['default'] = 'Lista de usuarios baneados';
    $title['url'] = '/admin/baneados/';
    break;
  case 'complaints':
    $title['default'] = 'Area de denuncias';
    $title['url'] = '/admin/denuncias/'.(in_array($_GET['f'], array('posts', 'users', 'photos')) ? $_GET['f'] : 'posts').'/';
    break;
  case 'photos-elim':
    $title['default'] = 'Papelera de fotos';
    $title['url'] = '/admin/papelera/fotos/';
    break;
  case 'posts-elim':
    $title['default'] = 'Papelera de posts';
    $title['url'] = '/admin/papelera/posts/';
    break;
  case 'ranks':
    $title['default'] = 'Rangos de usuarios';
    $title['url'] = '/admin/rangos';
    break;
  case 'track-ip':
    $title['default'] = 'Rastrear IP '.($_GET['ip'] ? htmlspecialchars($_GET['ip']) : '');
    $title['url'] = '/admin/rastrear-ip/';
    break;
  case 'users':
    $title['default'] = 'Lista de usuarios registrados';
    $title['url'] = '/admin/usuarios/ID/';
    break;
  case 'view-pms':
    $title['default'] = 'Centro de mensajes';
    $title['url'] = '/mensajes/';
  case 'webs':
    $title['default'] = 'Webs amigas';
    $title['url'] = '/admin/friends/';
    break;
  case 'config':
    $title['default'] = 'Configuraci&oacute;n de '.$config['name'].' - Script';
    $title['url'] = '/admin/config/';  
}