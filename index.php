<?php
$timestart = microtime(true);
$memstart = round(memory_get_usage() / 1024,1);
include('config.php');
define($config['define'], true);
include('functions.php');
include('online.php');
if(!$_GET['page'] || !preg_match('/^[a-z\-\_]+$/i', $_GET['page'])) { $_GET['page'] = 'default'; }
if(!file_exists('Pages/'.$_GET['page'].'.php')) { die('Error'); }
$tcat = '';
if(in_array($_GET['page'], array('posts', 'addpost', 'search', 'post'))) {
  $tcat = 'posts';
} elseif(in_array($_GET['page'], array('photos', 'pictures', 'addphoto', 'photo'))) {
  $tcat = 'photos';
} elseif($_GET['page'] == 'default') {
  $tcat = 'portal';
} elseif($_GET['page'] == 'tops') {
  $tcat = 'tops';
} elseif(substr($_GET['page'], 0, 5) == 'group') {
  $tcat = 'groups';
}
if($porn) {
  $config['title'] = 'PORNO GAY GRATIS!!';
  $config['slogan'] = 'La mejor p&aacute;gina gay del mundo';
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="XHTML+RDFa 1.0" xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es" >
<head profile="http://purl.org/NET/erdf/profile">
<meta http-equiv="X-UA-Compatible" content="chrome=1" />
<link rel="schema.dc" href="http://purl.org/dc/elements/1.1/" />
<link rel="schema.foaf" href="http://xmlns.com/foaf/0.1/" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="author" content="Ignacio Vigna">
<meta name="country" content="Uruguay">
<meta name="title" content="<?=$config['slogan'];?> | <?=$config['name'];?>">
<meta name="description" content="Red social de contenidos: Posts, fotos, amigos y mucho m&aacute;s!" />
<meta name="robots" content="All" />
<meta name="revisit-after" content="1 days" />
<link rel="canonical" href="<?=$config['url'];?>" />
<meta name="keywords" content="<?=$config['name'];?>,linksharing,enlaces,juegos,musica,links,noticias,imagenes,videos,animaciones,arte,deportes,linux,apuntes,monografias,autos,motos,celulares,comics,tutoriales,ebooks,humor,mac,recetas,peliculas,series,argentina,comunidad" />
<meta name="generator" content="<?=$config['name'];?> - Descargas / mediafire / descargas / todo / office / windows / Para descargar en mediafire / juegos mediafire / programas y software mediafire / facebook mediafire / bajar / instalar gratis / Gratuito / borisdimael / zonefull / 2.0 / linksaring / rapidshare / descargas / directas / megaupload / mediafire / software / freeware / serial / gratis / programas / musica / juegos / peliculas" />
<?php if(!$tcat || $tcat == 'portal') { echo '<meta http-equiv="refresh" content="600" />'; } ?>
<link rel="icon" href="<?=$config['url'];?>/favicon.png" />
<link rel="alternate" type="application/atom+xml" title="<?=$config['name'];?> - &Uacute;ltimos posts" href="/rss/ultimos-posts.php" />
<link rel="alternate" type="application/atom+xml" title="<?=$config['name'];?> - Atom Feed" href="/rss/ultimos-posts-atom.php" />
<?php
if(!file_exists('Titles/'.$config['idioma'].'_'.$_GET['page'].'.php')) {
  echo '<title>'.$config['slogan'].' - '.$config['name'].'</title>';
} else {
  include('Titles/'.$config['idioma'].'_'.$_GET['page'].'.php');
  echo '<title>'.$title['default'].' - '.$config['name'].'</title>';
}
?>
<link href="<?=$config['images'];?>/css/estilos.css" rel="stylesheet" type="text/css" />

<?php
if(allow('show_panel')) { echo '<script type="text/javascript" src="/js/admin.js"></script>'; }
?>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/scripts2.js"></script>
<script type="text/javascript" src="<?=$config['images'];?>/js/lazyload.js"></script>
<script type="text/javascript" src="<?=$config['images'];?>/js/jquery.vTicker.js"></script>
<link href="<?=$config['images'];?>/css/facebook.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="<?=$config['images'];?>/js/facebox.js" type="text/javascript"></script>

<script type="text/javascript">
var urls = { images : '<?=$config['images'];?>/images', home : '' }
function islogged() {<?php
if($logged['id']) { echo 'return true;'; } else { echo 'return false;'; }
?>}
$(document).ready(function(){ timelib.current = <?=time();?>; timelib.upd(); })
jQuery(document).ready(function($) { $('a[rel*=facebox]').facebox({ loadingImage : '<?=$config['images'];?>/images/loading.gif', closeImage   : '<?=$config['images'];?>/images/closelabel.png'}) })
</script>
<!--[if IE 6]>
<script type="text/javascript" src="<?=$config['images'];?>/js/?type=ie_png"></script>
<script type="text/javascript">ie_png.fix('.png, .VPeditorButton');</script>
<![endif]-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29573947-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body id="top">
<!--[if lt IE 7.]>
<div id="browser_alert" class="warning_box"><span class="color_red"><strong>ALERTA!</strong></span> Tu navegador no es 100% compatible con <?=$config['name'];?>. Te recomendamos usar <a href="http://es-ar.www.mozilla.com/es-AR/" rel="nofollow">Mozilla Firefox</a> para ir m&aacute;s r&aacute;pido y disfrutar de un verdadero navegador.</div>
<![endif]-->
<div id="mask"></div>
<div id="dialogBox"></div>
<div id="header_content">
<?php
if($porn) {
  $logged['nick'] = 'Crepusculo Abierto';
  $i = array('Pete de clanpachanga mmm', 'Chupame la pija', 'FEWFEWFEWFEW', 'Anda a hacerle spam a tu abuela -ba', 'Oligofrenicos');
  $r = array('http://www10.pic-upload.de/16.03.12/v1uhwgamfzy9.jpg', 'http://www10.pic-upload.de/16.03.12/6cujmktfakle.jpg', 'http://www10.pic-upload.de/16.03.12/rdrdduqbxxtg.jpg', 'http://www10.pic-upload.de/16.03.12/rdrdduqbxxtg.jpg', 'http://www10.pic-upload.de/16.03.12/3pmfbso2nvr.jpg', 'http://www10.pic-upload.de/16.03.12/8u2ia54rcry.jpg', 'http://www10.pic-upload.de/16.03.12/sj645v844fzj.jpg', 'http://www10.pic-upload.de/11.03.12/z5dlhg3enlba.jpg', 'http://www10.pic-upload.de/11.03.12/eijmauiw4d3.jpg', 'http://i.minus.com/jcOnB53vvkkbe.jpg', 'http://i.imgur.com/jX8AU.png');
  echo '<style>
        #container_bg {
            background: url("'.$r[array_rand($r)].'") repeat-x scroll 0 0 #EDEDED;
            padding-bottom: 15px;
        }
        #header_content {
            background: url("http://images02.olx.com.ar/ui/9/83/09/1288099785_81327409_1-Fotos-de--A-quien-le-gustaria-chupar-esta-pija-1288099785.jpg") repeat-x scroll center top #FFFFFF;
            height: 250px;
            width: 100%;
        }
        #logo{ background: url(\'/media/images/logo-troll.png\') no-repeat; }
        </style><script> alert("'.$i[array_rand($i)].'"); dialogBox.alert(\''.$i[array_rand($i)].'\', \'<img width="300" height="300" src="'.$r[array_rand($r)].'">\'); </script>';
}
if(date('jn') == $logged['day'].$logged['month']) {
  echo '<style>
        #logo{
	        width: 350px;
	        height: 70px;
            background: url(\'/media/images/logo-cumple.png\') no-repeat;
	        float:left;
        }
        </style>';
}
?>
<div id="header"><a href="/" title="<?=$config['name'];?>" id="logo">
<img src="<?=$config['images'];?>/images/space.gif" border="0" alt="<?=$config['name'];?>" title="<?=$config['name'];?>" align="top" />
</a>
<span class="floatR" style="margin-top:5px;"></span>
</div>
</div>
</div>
<div class="clearBoth"></div>
<script type="text/javascript">
	var menu_section_actual = '<?=$tcat;?>';
</script>
<div id="menu_container_web">
<div id="menu_container">
<div id="menu_web">
<li><a id="tabbedportal" name="tabbedportal" class="padding_home<?=($_GET['page'] == 'default' ? ' here' : '');?>" href="/" onclick="return tabs.menu('portal', this.href);" title="Home"><img src="<?=$config['images'];?>/images/home_icon<?=($_GET['page'] == 'default' ? '_here' : '');?>.png" width="14" height="14"></a></li>
<li><a<?=($tcat == 'posts' ? ' class="here"' : '');?> id="tabbedposts" href="/posts/" onclick="return tabs.menu('posts', this.href);" title="Posts">Posts</a></li>
<li><a<?=($tcat == 'groups' ? ' class="here"' : '');?> id="tabbedgroups" href="/comunidades" onclick="return tabs.menu('groups', this.href);" title="Comunidades">Comunidades</a></li>
<li><a<?=($tcat == 'photos' ? ' class="here"' : '');?> id="tabbedphotos" href="/fotos/" onclick="return tabs.menu('photos', this.href);" title="Fotos">Fotos</a></li>
<li><a<?=($tcat == 'tops' ? ' class="here"' : '');?> id="tabbedtops" href="/tops/posts" onclick="return tabs.menu('tops', this.href);" title="TOPs">TOPs</a></li>
<!--<li><a<?=($tcat == 'activity' ? ' class="here"' : '');?> id="tabbedactivity" href="/actividad/" onclick="tabs.menu('activity', this.href); return false;" title="Actividad">Actividad</a></li>  -->
<?php if(!$logged['id']) { ?>
<li><a class="registrate" href="#" onclick="accounts.registro_load_form(); return false;" title="&iexcl;Registrate!">&iexcl;Registrate!</a></li>
<?php
}
if(allow('show_panel')) {
?>
<li><a class="adm<?=($tcat == 'admin' ? ' here' : '');?>" href="/admin" title="Administraci&oacute;n">Admin</a></li>
<?php
}
if($logged['id']) {
?>
<script>
$(document).ready(function(){
    $('div.menu_user > a[title]').tipsy({fade: true,gravity:'s'});
});
</script>
<div class="menu_user">
<?php
$notifications = mysql_num_rows(mysql_query('SELECT id FROM notifications WHERE id_user = \''.$key.'\' && status = \'0\''));
$messages = mysql_num_rows(mysql_query('SELECT id FROM messages WHERE receiver = \''.$key.'\' && receiver_status = \'0\' && `receiver_read` = \'0\''));
if($logged['points2'] > 0) { echo '<a class="first" title="Tienes '.$logged['points2'].' puntos para gastar"><span style="color:green">+'.$logged['points2'].'</span></a>'; }
?>
<a title="Mensajes" href="javascript:open_mp_box();"title="Mensajes" class="cosote_mp"><span class="options_user mensajes<?=($messages ? '-new' : '');?>"><span<?=($messages == 0 ? ' style="display:none;"' : '');?> id="noti_box_mp" class="notificaciones_cant"><?=$messages;?></span></span></a>
<a href="/posts/bookmarks/" title="Favoritos"><span class="options_user favoritos"></span></a>
<a href="/mis-borradores" title="Mis borradores"><span class="options_user Drafts"></span></a>
<a title="Notificaciones" href="/monitor" onclick="open_notificaciones_box(); return false;" class="cosote_notificaciones"><span class="options_user notificaciones"><span<?=($notifications == 0 ? ' style="display:none;"' : '');?> id="noti_box_not" class="notificaciones_cant"><?=$notifications;?></span></span></a>
<a href="/mod-history/" title="Historial de Moderaci&oacute;n"><span class="options_user modHistory"></span></a>
<a href="/<?=$logged['nick'];?>"  title="Mi perfil">&nbsp;<?=$logged['nick'];?></a>
<a href="javascript:open_account_box();" class="cosote_account" title="Mi cuenta">Cuenta</a>
<a class="last" href="/logout.php" onclick="accounts.logout_ajax();return false" title="Salir">Salir</a>
</div>
<div class="clearBoth"></div>
</div>
<div id="mp_box">
<div class="cuerpo_mp" style="max-height: 292px;">
<div style="padding: 6px;">
<b class="size15">Mensajes privados</b> <b class="floatR size11"><a onclick="mp.enviar_mensaje(''); return false">Nuevo mensaje</a></b>
<hr class="divider">
<div id="loading_mps" align="center">
<img src="<?=$config['images'];?>/images/loading.gif">
</div>
<span id="error_ult_mps" style="display: none;"></span>
<span id="ult_mps" style="display: none;"></span>
</div>
<div class="ver_mas"><a href="/mensajes/">Ver todos mis mensajes</a></div>
</div>
</div>
<div id="notifications_box">
<div class="cuerpo_notis" style="max-height: 282px;">
<div style="padding:6px;">
<b class="size15">Notificaciones</b><span id="loading_noti" style="display:none" class="floatR"><img src="<?=$config['images'];?>/images/load.gif" border="0"></span>
<hr class="divider">
<div id="loading_notificaciones" align="center">
<img src="<?=$config['images'];?>/images/loading.gif">
</div>
<span id="error_notificaciones" style="display:none;"></span>
<span id="ult_notificaciones" style="display:none;"></span>
</div>
<div class="ver_mas"><a href="/monitor">Ver m&aacute;s notificaciones</a></div>
</div>
		</div>
		<div id="account_box">
			<div class="cuerpo_account_options">
				<div style="padding: 6px;">
					<b class="size15">Opciones de usuario</b>
					<hr class="divider">
				</div>
				<ul class="opt">
					<li><a href="/<?=$logged['nick'];?>" title="Ver mi perfil">Ver mi perfil</a></li>
					<li><a href="/cuenta/amigos/" title="Editar mis amigos">Editar mis amigos</a></li>
					<li><a href="/cuenta" title="Editar mi perfil">Editar mi perfil</a></li>
					<li><a href="/cuenta/privacidad" title="Configuraci&oacute;n de privacidad">Configuraci&oacute;n de privacidad</a></li>
					<li><a href="/perfil/<?=$logged['nick'];?>/posts/" title="Ver mis posts">Ver mis posts</a></li>
					<li><a href="/perfil/<?=$logged['nick'];?>/comentarios/" title="Ver mis comentarios">Ver mis comentarios</a></li>
					<li><a href="/fotos/agregar/" title="Agregar foto">Agregar foto</a></li>
					<li><a href="/fotos/user/<?=$logged['nick'];?>" title="Ver mis fotos">Ver mis fotos</a></li>
				</ul>
			</div>
		</div>
        <?php
        } else {
          echo '<div class="login_container">
				    <a href="#" onclick="open_login_box(); return false;" title="Identificarme">Iniciar sesi&oacute;n</a>
			        </div><div class="clearBoth"></div>
	            </div>';
        }
        ?>
</div>
</div>
<div class="clearBoth"></div>
<div id="sub_menu_container">
	<div id="sub_menu">
    <?php if($tcat == 'posts' || $tcat == 'portal' || !$tcat) { ?>
	<li><a href="/" title="Inicio">Inicio</a></li>
    <?php
    if($tcat == 'portal') {
        echo '<li><a href="/ayuda/" title="Ayuda">Ayuda</a></li><li><a href="/static/chat/" title="Chat">Chat</a></li> ';
    } else {
        //echo '<li><a href="'.$config['search_url'].'/posts/" title="Buscador"><img src="http://ihsla.org/Images/icon_new.gif" /> Buscador</a></li>';
    }
echo '<li><a href="'.$config['search_url'].'/posts/" title="Buscador"><img src="http://ihsla.org/Images/icon_new.gif" /> Buscador</a></li>';
    if($logged['id']) {
    ?>
	<li><a href="/posts/agregar/" title="Agregar post">Agregar post</a></li>
    <?php if($tcat == 'portal') { echo '<li><a href="/fotos/agregar/" title="Agregar foto">Agregar foto</a></li>'; } } ?>
		<div class="select_cat">
			<span>Filtrar por categor&iacute;as:</span>
				<select style="width:208px" onchange="web.ir_a_categoria()" name="categoria" id="categoria">
					<option value="root" selected="selected">Filtrar por categor&iacute;as</option>
					<option value="-1">Ver todas</option>
					<option value="root">------</option>
                    <?php
                    $rows = mysql_query('SELECT `name`, `url` FROM `categories` ORDER BY `name` ASC') or die(mysql_error());
                    while($cat = mysql_fetch_row($rows)) {
                      echo '<option value="'.$cat[1].'"'.($_GET['categoria'] == $cat[1] && $_GET['categoria'] ? ' selected="selected"' : '').'>'.$cat[0].'</option>';
                    }
                    ?>
                </select>
		</div>
        <?php
        } elseif($tcat == 'photos') {
        ?>
        <li><a href="/fotos/" title="Inicio">Inicio</a></li>
        <?php
        if($logged['id']) {
        ?>
		<li><a href="/fotos/agregar/" title="Agregar foto">Agregar foto</a></li>
		<li><a href="/fotos/user/<?=$logged['nick'];?>" title="Mis fotos">Mis fotos</a></li>
        <?php
        }
        ?>
		<div class="select_cat">
			<span>Filtrar por categor&iacute;as:</span>
				<select style="width:208px" onchange="web.ir_a_categoria_f()" name="categoria" id="categoria">
					<option value="root" selected="selected">Filtrar por categor&iacute;as</option>
					<option value="-1">Ver todas</option>
					<option value="root">------</option>
                    <?php
                    $q = mysql_query('SELECT `name`, `url` FROM `p_categories` ORDER BY name ASC');
                    while($ps = mysql_fetch_row($q)) {
                      echo '<option value="'.$ps[1].'"'.($_GET['categoria'] == $ps[1] && $_GET['categoria'] ? ' selected="selected"' : '').'>'.$ps[0].'</option>';
                    }
                    ?>

                </select>
		</div>
        <?php
        } elseif($tcat == 'tops') {
        ?>
        <li><a href="/tops/posts/" title="Agregar foto">Posts</a></li>
        <li><a href="/tops/usuarios/" title="Agregar foto">Usuarios</a></li>
        <li><a href="/tops/fotos/" title="Agregar foto">Fotos</a></li>
        <li><a href="/tops/categorias/" title="Agregar foto">Categor&iacute;as</a></li>
        <?php
        } elseif($tcat == 'groups') {
        ?>
        <li><a href="/comunidades/" title="Inicio">Inicio</a></li>
        <?php
        if($logged['id']) { echo '<li><a href="/comunidades/mis-comunidades" title="Mis comunidades">Mis comunidades</a></li>'; }
        ?>
        <li><a href="<?=$config['search_url'];?>/comunidades/" title="Buscador"><img src="http://ihsla.org/Images/icon_new.gif" /> Buscador</a></li>
        <?php if($logged['id']) { echo '<li><a href="/comunidades/mod-history" title="Historial">Historial</a></li>'; } ?>
        <script>
        function ir_a_categoria_com(){
            if($('#categoria').val()==-1)
		    document.location.href='/comunidades/';
            else if($('#categoria').val()!='root')
            document.location.href='/comunidades/categoria/' + $('#categoria').val() + '/';
        }
        </script>
        <div class="select_cat">
			<span>Filtrar por categor&iacute;as:</span>
				<select style="width:208px" onchange="ir_a_categoria_com()" name="categoria" id="categoria">
					<option value="root" selected="selected">Filtrar por categor&iacute;as</option>
					<option value="-1">Ver todas</option>
					<option value="root">------</option>
                    <?php
                    $query = mysql_query('SELECT `name`, `url`, `id` FROM `groups_categories` ORDER BY name ASC');
                    while($rows = mysql_fetch_row($query)) {
                      echo '<option value="'.$rows[2].'"'.($_GET['cat'] == $rows[2] ? ' selected="true"' : '').'>'.$rows[0].'</option>';
                    }
                    ?>
                </select>
		</div>
        <?php
        }
        ?>
    </div>
<div class="clearBoth"></div>
</div>
<div id="container_bg">
<?php
if(!$logged['id']) {
?>
		<div id="login_box">
			<div class="login_cuerpo">
				<span class="login_procesando"></span>
					<div id="login_error"></div>
						<form method="post" action="javascript:accounts.login_ajax()">
							<div class="floatL" style="margin-right:4px;">
								<label style="margin-right:6px;">Usuario</label>
								<input maxlength="64" name="nick" id="nickname" class="ilogin" type="text" />

							</div>
							<div class="floatL" style="margin:0 4px;">
								<label style="margin-right:6px;">Contrase&ntilde;a</label>
									<input maxlength="64" name="pass" id="password" class="ilogin" type="password" />
							</div>
							<div class="floatL" style="margin-left:4px;padding-top:2px;">
								<input class="Boton BtnBlue" value="Entrar" title="Entrar" type="submit" />
							</div>

						</form>
                   <div id="fb-root"></div>
						<div class="floatR">
							<span style="text-transform:uppercase;font-weight:bold;">Ayuda</span>
							<hr class="divider">
							<a href="/recuperar-pass/" title="Oops, olvide mi contrase&ntilde;a!">Oops, olvide mi contrase&ntilde;a!</a>
						</div>
					<div class="clearBoth"></div>

				</div>
			</div>
            <?php
            }
            ?>

<div id="vp_nuevas">
<div class="new"></div>
<div class="txt">
<?php
$not = mysql_fetch_row(mysql_query('SELECT word FROM news WHERE `act` = \'1\' ORDER BY RAND()'));
echo $not[0];
?>
</div>
</div>
<div id="container_web">
<?php
if($config['manteniance'] === true && $logged['rank'] != 9) {
  echo '<div align="center" >
		<div class="mantenimiento_web" title="Estamos realizando algunas mejoras en el sitio">
		</div>
	</div><br><br>
		<center><center></center></center><br><div style="clear:both"></div></div>
	</div>';
} else { include('Pages/'.$_GET['page'].'.php'); }
include('footer.php');
ob_end_flush();
?>