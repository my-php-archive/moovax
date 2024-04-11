<?php
$config['bd_host'] = 'localhost'; //Servidor bd
$config['bd_user'] = 'user'; //Nombre de usuario bd
$config['bd_pass'] = 'password'; //Pass bd
$config['bd_name'] = 'few'; //Nombre de la base de datos
$config['name'] = 'Moovax';
$config['slogan'] = 'Compartiendo e innovando';
$config['url'] = 'http://moovax.net';
$config['url2'] = 'moovax.net';
$config['images'] = 'http://images.moovax.net/media'; //Imagenes
$config['define'] = 'define'; //Nombre del define()
$config['mail'] = 'ftp@taringa.net'; //Mail server
$config['recaptcha_privatekey'] = '6LfCYM0SAAAAANFokZUK-B9z6YHwEO3-vKpYhrIl'; // Key para recaptcha
$config['recaptcha_publickey'] = '6LfCYM0SAAAAAB1aFkMvwkydKlGGBeaNx6ShiwCK'; // Key para recaptcha
$config['cookie_name'] = 'igsc'; //Nombre de la cookie
$config['years'] = '14';
$config['idioma'] = 'spanish';
$config['author'] = 'Ignacio Vigna'; // 
$config['manteniance'] = false; 
$config['name_short'] = 'M!'; 
$config['search_url'] = 'http://buscar.moovax.net/';
date_default_timezone_set('America/Montevideo');
@$connection = mysql_connect($config['bd_host'], $config['bd_user'], $config['bd_pass']) or die(mysql_error());
mysql_select_db($config['bd_name'], $connection);
