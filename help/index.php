<?php
include('../config.php');
include('../functions.php');
define('help', true);
if(!$_GET['page'] || !preg_match('/^[a-z\_\-]+$/i', $_GET['page']) || !file_exists($_GET['page'].'.php') || $_GET['page'] == 'index') { $_GET['page'] = 'default'; }
define($config['define'], true);
include('../online.php'); //$pstats r,r
ob_start('compress');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- <?=date('Y');?> Moovax por DrChupaverga -->
<html version="XHTML+RDFa 1.0"  xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es" >
<head profile="http://purl.org/NET/erdf/profile">
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<link rel="schema.dc" href="http://purl.org/dc/elements/1.1/" />
<link rel="schema.foaf" href="http://xmlns.com/foaf/0.1/" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Ignacio" />
<meta name="title" content="<?=$config['name'];?> | Centro de Ayuda" />
<meta name="description" content="<?=$config['name'];?> es una comunidad en donde los usuarios comparten cosas entre si. Adem&aacute;s de incluir un sistema de redes sociales excelente." />
<meta name="keywords" content="Revolucionando la web,rapidshare,megaupload,mediafire,-1,-2,descarga,descarga-directa,bajar,mp3,fullposts,script,almeja,voope,linksharing,enlaces,juegos,musica,links,noticias,imagenes,videos,animaciones,arte,tecnologia,celulares,argentina,comunidad,fps,infornes,2008,2009,2010,2011,warez,linksharing,web 2.0,mediafire,descrgas mediafire, todo en uno, aio,directa 2010" />
<meta name="robots" content="All">
<meta name="revisit-after" content="1 days">
<meta http-equiv="refresh" content="600">
<title>Centro de Ayuda | <?=$config['name'];?></title>
<link rel="stylesheet" type="text/css" href="<?=$config['images'];?>/css/help.css" />
<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/help.js"></script>
<script type="text/javascript" src="/scripts.js"></script>
<script type="text/javascript" src="<?=$config['images'];?>/js/lazyload.js?v1.0"></script>
<script type="text/javascript">
var urls = {
	images : '<?=$config['images'];?>/images/ayuda',
	home : '<?=$config['url'];?>'
}
</script>
</head>
<body id="top">
<div id="mask"></div>
<div id="dialogBox"></div>
<div id="menu">
<div id="menu_sub">
<a href="/ayuda/" title="Centro de Ayuda | <?=$config['name'];?>">
<div id="logo"></div>
</a>
<div class="floatR" style="margin-top:4px;">
<center></center>
</div>
</div>
</div>
<div id="header"></div>
<div id="container_max">
<h1>Centro de Ayuda</h1>
<div class="breadcrumb">
<a href="<?=$config['help_url'];?>">Inicio</a> &rsaquo; <a href="/ayuda/">Ayuda</a>
<?php
if($logged['id'] && allow('admin_help')) {
?>
<span class="floatR">
<a href="/ayuda/administrar/" title="Administrar ayuda">Administrar ayuda</a> | <a href="/ayuda/articulos/agregar/" title="Agregar art&iacute;culo">Agregar art&iacute;culo</a></span><div class="clearfix"></div>
<?php
}
?>
</div>
<div id="cuerpocontainerON">
<?php
include($_GET['page'].'.php');
?>
<div id="footer">
<a href="/static/contactanos/" title="Contacto">Contacto</a> | <a href="/static/terminos-y-condiciones/" title="T&eacute;rminos">T&eacute;rminos</a> | <a href="/static/sitemap/" title="Mapa del sitio">Sitemap</a>
</div>
</div><!-- /cuerpocontainerON -->
</div><!-- /container_max -->
</body>
</html>
<?php ob_end_flush(); ?>