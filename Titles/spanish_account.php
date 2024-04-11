<?php
if(!defined($config['define'])) { die; }
switch($_GET['tab']) {
  default:
    $title['default'] = 'Editar mi cuenta';
    break;
  case 'apariencie':
    $title['default'] = 'Editar mi apariencia';
    break;
  case 'avatar':
    $title['default'] = 'Editar mi avatar';
    break;
  case 'firm':
    $title['default'] = 'Editar mi firma';
    break;
  case 'friends':
    $title['default'] = 'Editar mis amigos';
    break;
  case 'privacy':
    $title['default'] = 'Configurar privacidad';
    break;
  case 'password':
    $title['default'] = 'Cambiar mi contrase&ntilde;a';
}