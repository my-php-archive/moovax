<?php
if(!$_GET['cantidad'] || !$_GET['an'] || !$_GET['color'] || !in_array($_GET['an'], array('350', '200', '285', '320'))) { die; }
include('config.php');
include('functions.php');
if(!ctype_digit($_GET['cantidad']) || $_GET['cantidad'] > 50) { die('Esto no fue configurado correctamente'); }
switch($_GET['color']) {
  case 'gris':
    //$style = array('BBBBBB', '');
    $color = 'BBBBBB';
    $background = 'bg_widget-gris.gif';
    break;
  case 'rojo':
    $color = 'FF7777';
    $background = 'bg_widget-rojo.gif';
    break;
  case 'amarillo':
    $color = 'FEFE78';
    $background = 'bg_widget-amarillo.gif';
    break;
  case 'rosa':
    $color = 'DD999A';
    $background = 'bg_widget-rosa.gif';
    break;
  case 'violeta':
    $color = '8C78FE';
    $background = 'bg_widget-violeta.gif';
    break;
  case 'verde':
    $color = '78FF75';
    $background = 'bg_widget-verde.gif';
    break;
  case 'turquesa':
    $color = '78F9FF';
    $background = 'bg_widget-turquesa.gif';
    break;
  default: die('Error provocado');
}
if($_GET['cat']) {
  if(!mysql_num_rows($cat = mysql_query('SELECT `id`, `name` FROM `categories` WHERE `id` = \''.(int)$_GET['cat'].'\''))) { die; }
  list($cat, $namecat) = mysql_fetch_row($cat);
  $catq = true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<style type="text/css">
body
{
    font-family: Arial,Helvetica,sans-serif;
    font-size:12px;
    margin: 0px;
    padding:0px;
    background: #<?=$color;?> url(<?=$config['images'];?>/images/widget/<?=$background;?>) repeat-x;
}
a{color: #000; text-decoration:none}
a:hover{color:#000000;}
*:focus{outline:0px;}
.nsfw{color: #FFbbBB}
.item
{
    width:333px;
    overflow:hidden;
    height:16px;
    margin: 2px 0px 0px 0px;
    padding:0px;
    border-bottom: 1px solid #F4F4F4;
}
.exterior{width:<?=($_GET['an']-17);?>px;}

.categoriaPost {
	clear:both;
	font-size:12px;
	height:16px;
	margin-bottom:5px;
	padding:3px 3px 3px 28px;
}
.categoriaPost, .categoriaPost a.privado  {
	background:transparent url(<?=$config['images'];?>/images/cat_post_icons16.png) no-repeat scroll left top;
}
.categoriaPost:hover{
	background-color:#CCC;

}
.categoriaPost a {
  display:block;
  height:18px;
}
/*.categoriaPost a:visited {
	color: #551A8B;
	font-weight:bold;
}*/
.categoriaPost a.privado {
	padding-left: 17px;
	background-position: -3px 0px;
}
.categoriaPost.juegos {
	background-position: 5px -44px;
}
.categoriaPost.imagenes {
	background-position: 5px -66px;
}
.categoriaPost.fotos {
	background-position: 5px -66px;
}
.categoriaPost.links {
	background-position: 5px -86px;
}
.categoriaPost.videos {
	background-position: 5px -110px;
}
.categoriaPost.arte {
	background-position: 5px -132px;
}
.categoriaPost.off-topic {
	background-position: 5px -152px;

}
.categoriaPost.animaciones {
	background-position: 5px -174px;
}
.categoriaPost.musica {
	background-position: 5px -196px;
}
.categoriaPost.downloads {
	background-position: 5px -218px;
}
.categoriaPost.noticias {
	background-position: 5px -240px;
}
.categoriaPost.info {
	background-position: 5px -284px;
}

.categoriaPost.cine-tv-musicales {
	background-position: 5px -305px;
}
.categoriaPost.patrocinados {
	background-position: 5px -332px;
}
.categoriaPost.famosos {
	background-position: 5px -332px;
}
.categoriaPost.poringueras {
	background-position: 5px -418px;
}
.categoriaPost.gay {
	background-position: 5px -507px;
}
.categoriaPost.relatos {
	background-position: 5px -528px;

}
.categoriaPost.linux {
	background-position: 5px -551px;
}
.categoriaPost.deportes {
	background-position: 5px -571px;
}
.categoriaPost.deportivas {
	background-position: 5px -571px;
}
.categoriaPost.celulares {
	background-position: 5px -595px;
}
.categoriaPost.apuntes-y-monografias {
	background-position: 5px -614px;
}
.categoriaPost.comics {
	background-position: 5px -636px;
}
.categoriaPost.solidaridad {
	background-position: 5px -661px;
}
.categoriaPost.recetas-y-cocina {
	background-position: 5px -678px;
}
.categoriaPost.mac {
	background-position: 5px -702px;
}
.categoriaPost.femme {
	background-position: 5px -727px;
}
.categoriaPost.autos-motos {
	background-position: 5px -747px;
}
.categoriaPost.humor {
	background-position: 5px -767px;
}
.categoriaPost.ebooks-tutoriales {
	background-position: 5px -789px;
}
.categoriaPost.salud-bienestar {
	background-position: 5px -808px;
}

.categoriaPost.comunidad-moovax{
	background-position: 5px -438px;
}

.categoriaPost.economia-negocios {
	background-position: 5px -846px;
}

.categoriaPost.mascotas {
	background-position: 5px -866px;
}
.categoriaPost.turismo {
	background-position: 5px -890px;
}
.categoriaPost.anime-manga-otros {
	background-position: 5px -912px;
}
.categoriaPost.ciencia-educacion {
	background-position: 5px -958px
}
.categoriaPost.hazlo-tu-mismo {
	background-position: 5px -935px
}
.categoriaPost.ecologia {
	background-position: 5px -459px

}
.categoriaPost.paisajes {
	background-position: 5px -459px
}
.categoriaPost img {
	display:none;
}
/* Stickys */
	#post-center li.categoriaPost.sticky{background-position:5px -21px; padding: 3px 3px 3px 20px;}
	#post-center li.categoriaPost.patrocinado{background-color:#FFFFCC; -moz-border-radius: 5px;-webkit-border-radius: 5px;}
	#post-center li.categoriaPost.sticky.patrocinado .categoriaPost:hover {background-color: transparent;}
	#post-center li.categoriaPost.sticky.patrocinado .categoriaPost {height: 16px;}
	#post-center  li.sticky a {
	  margin:0 0 0 0;
	  padding:0 0 0 28px;
	}
	#post-center li.sticky a:hover {
	  background-color:none;
	}
	.categoriaPost.sticky .categoriaPost.juegos{background-position:5px -44px;}
	.categoriaPost.sticky .categoriaPost.imagenes{background-position:5px -63px;}
	.categoriaPost.sticky .categoriaPost.links{background-position:5px -88px;}
	.categoriaPost.sticky .categoriaPost.videos{background-position:5px -110px;}
	.categoriaPost.sticky .categoriaPost.arte{background-position:5px -133px;}
	.categoriaPost.sticky .categoriaPost.off-topic{background-position:5px -152px;}
	.categoriaPost.sticky .categoriaPost.animaciones{background-position:5px -174px;}
	.categoriaPost.sticky .categoriaPost.musica{background-position:5px -196px;}
	.categoriaPost.sticky .categoriaPost.downloads{background-position:5px -218px;}
	.categoriaPost.sticky .categoriaPost.noticias{background-position:5px -240px;}
	.categoriaPost.sticky .categoriaPost.info{background-position:5px -284px;}
	.categoriaPost.sticky .categoriaPost.cine-tv-musicales{background-position:5px -305px;}
	.categoriaPost.sticky .categoriaPost.patrocinados{background-position:5px -332px;}
	.categoriaPost.sticky .categoriaPost.linux{background-position:5px -551px;}
	.categoriaPost.sticky .categoriaPost.deportes{background-position:5px -572px;}
	.categoriaPost.sticky .categoriaPost.celulares{background-position:5px -595px;}
	.categoriaPost.sticky .categoriaPost.apuntes-y-monografias{background-position:5px -614px;}
	.categoriaPost.sticky .categoriaPost.comics{background-position:5px -640px;}
	.categoriaPost.sticky .categoriaPost.solidaridad{background-position:5px -660px;}
	.categoriaPost.sticky .categoriaPost.recetas-y-cocina{background-position:5px -678px;}
	.categoriaPost.sticky .categoriaPost.mac{background-position:5px -702px;}
	.categoriaPost.sticky .categoriaPost.femme{background-position:5px -727px;}
	.categoriaPost.sticky .categoriaPost.autos-motos{background-position:5px -744px;}
	.categoriaPost.sticky .categoriaPost.humor{background-position:5px -767px;}
	.categoriaPost.sticky .categoriaPost.ebooks-tutoriales{background-position:5px -789px;}
	.categoriaPost.sticky .categoriaPost.anime-manga-otros {background-position: 5px -914px;}


.comunidad_borde2{
	background-color: #FFFFCC;
	margin: 4px;
	padding: 20px;
	text-align:center;
	border-top: 1px solid #FFD721;
	border-bottom: 1px solid #FFD721;
	}
</style>
</head>
<body>
<div class="exterior">
<?php
$query = mysql_query('SELECT p.*, cat.name, cat.url FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE p.`status` = \'0\''.($catq ? ' && p.`cat` = \''.$cat.'\'' : '').' ORDER BY p.`id` DESC LIMIT '.(int)$_GET['cantidad']) or die(mysql_error());
while($row = mysql_fetch_assoc($query)) {
  echo '<li class="categoriaPost '.$row['url'].'" title="'.$row['name'].'" style="margin-bottom:0px">
	<a target="_blank" title="'.$row['title'].'" href="'.$config['url'].'/posts/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html">'.cut($row['title'], 17, '...').'</a>
    </li>';
}
?>
<center>
<a href="<?=$config['url'];?>/posts/" target="_parent"><b>[ Ver m&aacute;s posts ]</b></a>
</center>
</div>
</body>
</html>

