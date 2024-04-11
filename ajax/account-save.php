<?php
if(!$_POST['ps']) { die('0: Faltan datos uiy'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0: Debes loguearte para realizar esta acci&oacute;n'); }
switch($_POST['ps']){
  case '0':
    if(!$_POST['nombre']) { die('0: El campo nombre es requerido'); }
    if(strlen($_POST['nombre']) > 100) { die('0: El m&aacute;ximo de caracteres permitidos es de 100'); }
    if(!$_POST['dia_naci'] || !$_POST['mes_naci'] || !$_POST['ano_naci']) { die('0: La fecha de nacimiento es requerida'); }
    if($_POST['dia_naci'] > 31 || $_POST['mes_naci'] > 12 || $_POST['ano_naci'] > date('Y', time())) { die('0: Error provocado'); }
    if(!checkdate($_POST['mes_naci'], $_POST['dia_naci'], $_POST['ano_naci'])) { die('0: La fecha ingresada no es v&aacute;lida'); }
    if($_POST['ano_naci'] > (date('Y', time()) - $config['years'])) { die('0: Necesitas tener al menos '.$config['years'].' para estar en esta comunidad'); }
    if(!$_POST['pais'] || !mysql_num_rows(mysql_query('SELECT `id` FROM `countries` WHERE `id` = \''.intval($_POST['pais']).'\''))) { die('0: El pa&iacute;s ingresado no es v&aacute;lido'); }
    if($_POST['sexo'] != '0' && $_POST['sexo'] != '1') { die('0: El sexo ingresado no es correcto'); }
    if(strlen($_POST['texto_personal']) > 255 && $_POST['texto_personal']) { die('0: El texto personal solo puede tener hasta 255 caracteres'); }
    if(!empty($_POST['sitio_web'])) {
      if(substr($_POST['sitio_web'], 0, 7) != 'http://') { $_POST['sitio_web'] = 'http://'.$_POST['sitio_web']; }
      if(!filter_var($_POST['sitio_web'], FILTER_VALIDATE_URL)) { die('0: La URL de tu sitio ingresada no es v&aacutelida'); }
    }
    if(!$_POST['pass']) { die('0: Ingrese su contrase&ntilde;a'); }
    if(md5($_POST['pass']) != $logged['password']) { die('0: La contrase&ntilde;a ingresada no es v&aacute;lida'); }
    if(strlen($_POST['ciudad']) > 80 && $_POST['ciudad']) { die('0: La ciudad no puede tener m&aacute;s de 80 caracteres'); }
    mysql_query('UPDATE `users` SET `name` = \''.mysql_clean($_POST['nombre']).'\', `day` = \''.intval($_POST['dia_naci']).'\', `month` = \''.intval($_POST['mes_naci']).'\', `year` = \''.intval($_POST['ano_naci']).'\', `country` = \''.mysql_clean($_POST['pais']).'\', `city` = \''.mysql_clean($_POST['ciudad']).'\', `sex` = \''.mysql_clean($_POST['sexo']).'\', `message` = \''.mysql_clean($_POST['texto_personal']).'\', `website` = \''.mysql_clean($_POST['sitio_web']).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1') or die('0: '.mysql_error());
    break;
  case '1':
    if(!ctype_digit($_POST['estudio']) || !ctype_digit($_POST['sector']) || !ctype_digit($_POST['ingresos'])) { die('0: Error provocados'); }
    if($_POST['estudio'] > 10 || $_POST['sector'] > 61 || $_POST['ingresos'] > 4) { die('0: Error desconocido'); }
    //if(strlen($_POST['intereses']) > 1) { die('0: Los intereses tienen un limite de 30 caracteres'); }
    mysql_query('UPDATE `users` SET `studies` = \''.mysql_clean($_POST['estudio']).'\', `profession` = \''.mysql_clean($_POST['profesion']).'\', `company` = \''.mysql_clean($_POST['empresa']).'\', `sector` = \''.mysql_clean($_POST['sector']).'\', `income` = \''.intval($_POST['ingresos']).'\', `interests` = \''.mysql_clean($_POST['intereses']).'\', `skills` = \''.mysql_clean($_POST['habilidades']).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1') or die('0: '.mysql_error());
    break;
  case '2':
    if(!ctype_digit($_POST['me_gustaria']) || !ctype_digit($_POST['estado_civil']) || !ctype_digit($_POST['hijos']) || !ctype_digit($_POST['vivo_con'])) { die('0: Error provocado'); }
    if($_POST['me_gustaria'] > 5 || $_POST['estado_civil'] > 6 || $_POST['hijos'] > 5 || $_POST['vivo_con'] > 5) { die('0: No te pases mijo'); }
    mysql_query('UPDATE `users` SET `like` = \''.intval($_POST['me_gustaria']).'\', `marital_status` = \''.intval($_POST['estado_civil']).'\', `children` = \''.intval($_POST['hijos']).'\', `live_with` = \''.intval($_POST['vivo_con']).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1');
    break;
  case '3':
    //if(!$_POST['altura'] || !$_POST['peso'] || !$_POST['pelo'] || !$_POST['ojos'] || !$_POST['dieta'] || !$_POST['fisico'] || !$_POST['tomo'] || !$_POST['fumo'] || !$_POST['tomo']) { die('0: Faltan datos...'); }
    if(!ctype_digit($_POST['altura']) || !ctype_digit($_POST['peso']) || !ctype_digit($_POST['fisico']) || !ctype_digit($_POST['ojos_color']) || !ctype_digit($_POST['dieta']) || !ctype_digit($_POST['tomo_alcohol']) || !ctype_digit($_POST['fumo']) || !ctype_digit($_POST['pelo_color'])) { die('0: Datos no v&aacute;lidos'); }
    if(strlen($_POST['altura']) > 3 || strlen($_POST['peso']) > 3) { die('0: El peso no debe de tener mas de 3 caracteres'); }
    if($_POST['pelo_color'] > 10 || $_POST['ojos_color'] > 5 || $_POST['fisico'] > 5 || $_POST['dieta'] > 5 || $_POST['tomo_alcohol'] > 5 || $_POST['fumo'] > 5) { die('0: Error provocado'); }
    mysql_query('UPDATE `users` SET `height` = \''.intval($_POST['altura']).'\', `weight` = \''.intval($_POST['peso']).'\', `hair` = \''.intval($_POST['pelo_color']).'\', `eyes` = \''.intval($_POST['ojos_color']).'\', `physical` = \''.intval($_POST['fisico']).'\', `diet` = \''.intval($_POST['dieta']).'\', `smoke` = \''.intval($_POST['fumo']).'\', `drink_alcohol` = \''.intval($_POST['tomo_alcohol']).'\' WHERE `id` = \''.$logged['id'].'\'') or die('0: '.mysql_error());
    break;
  case '4':
    if(!$_POST['intereses'] && !$_POST['hobbies'] && !$_POST['tv'] && !$_POST['musica'] && !$_POST['deportes'] && !$_POST['libros'] && !$_POST['peliculas'] && !$_POST['comida'] && !$_POST['heroes']) { die('0: Completa al menos un campo'); }
    /* strlen alpedo, 255 caracteres es el limite de tinytext :/ */
    mysql_query('UPDATE `users` SET `my_interests` = \''.mysql_clean($_POST['intereses']).'\', `hobbies` = \''.mysql_clean($_POST['hobbies']).'\', `favorite_series` = \''.mysql_clean($_POST['tv']).'\', `favorite_music` = \''.mysql_clean($_POST['musica']).'\', `favorite_sports` = \''.mysql_clean($_POST['deportes']).'\', `favorite_books` = \''.mysql_clean($_POST['libros']).'\', `favorite_movies` = \''.mysql_clean($_POST['peliculas']).'\', `favorite_food` = \''.mysql_clean($_POST['comida']).'\', `my_heroes` = \''.mysql_clean($_POST['heroes']).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1') or die('0: '.mysql_error());
    break;
  case '5':
    if(!$_POST['avatar'] || !$_POST['id_user']) { die('0: Faltan datos'); }
    if($_POST['id_user'] != $logged['id']) { die('0: Todo bien al qaeda?'); }
    if(substr($_POST['avatar'], 0, 7) != 'http://') { die('0: El avatar debe comenzar con http://'); }
    if(stripos($_POST['avatar'], 'kn3.net') !== false) { die('0: No es posible usar avatares de kn3'); }
    if(!@getimagesize($_POST['avatar'])) { die('0: El avatar no pudo ser cargado. Intenta con otra imagen'); }
    if(strlen($_POST['avatar']) > 255) { die('0: La url no puede ser mayor a 255'); }
    mysql_query('UPDATE `users` SET `avatar` = \''.mysql_clean($_POST['avatar']).'\' WHERE `id` = \''.$logged['id'].'\'');
    break;
  case '6':
    if(!$_POST['id_user'] || !$_POST['firma']) { die('0: Faltan datos.. '.$_POST['id_user']); }
    if($_POST['id_user'] != $logged['id']) { die('0: al qaeda detected'); }
    if(strlen($_POST['firma']) < 5 || strlen($_POST['firma']) > 255) { die('0: La firma debe de tener entre 4 y 255 caracteres'); }
    mysql_query('UPDATE `users` SET `firm` = \''.mysql_clean($_POST['firma']).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1');
    break;
  case '7':
    if(!ctype_digit($_POST['info']) || !ctype_digit($_POST['muro']) || !ctype_digit($_POST['amistad']) || !ctype_digit($_POST['mp'])) { die('0: Error provocado pana'); }
    if($_POST['id_user'] != $logged['id']) { die('0: Osama est&aacute; feliz'); }
    if($_POST['info'] > 4 || $_POST['muro'] > 2 || $_POST['amistad'] > 2 || $_POST['mp'] > 2) { die; }
    mysql_query('UPDATE `users` SET `show_info` = \''.$_POST['info'].'\', `walls_comments` = \''.$_POST['muro'].'\', `friends_request` = \''.$_POST['amistad'].'\', `receive_pms` = \''.$_POST['mp'].'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1') or die('0: '.mysql_error());
    break;
  case '8':
    if(!$_POST['pass_actual'] || !$_POST['pass_new'] || !$_POST['pass_verify'] || !$_POST['id_user']) { die('0: El campo es requerido'); }
    if($_POST['id_user'] != $logged['id']) { die; }
    if($_POST['pass_new'] != $_POST['pass_verify']) { die('0: Las contrase&ntilde;as no coinciden'); }
    if(md5($_POST['pass_actual']) != $logged['password']) { die('0: La contrase&ntilde;a actual ingresada no es v&aacute;lida'); }
    if(strlen($_POST['pass_new']) < 4 || strlen($_POST['pass_new']) > 32) { die('0: La contrase&ntilde;a debe de tener entre 4 y 32 caracteres'); }
    mysql_query('UPDATE `users` SET `password` = \''.md5($_POST['pass_new']).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1') or die('0: Error');
    break;
  default: die('0: No se mandaron datos :/');
}
die('1: Cambios guardados!');
?>