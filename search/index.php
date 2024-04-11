<?php
include('../config.php');
include('../functions.php');
define('search', true); //jojo fighter
$times = array(2 => array('86400', '&Uacute;litmas 24 horas'), 3 => array('604800', '&Uacute;ltima semana'), 4 => array('2592000', '&Uacute;ltimo mes'), 5 => array('31536000', '&Uacute;ltimo a&ntilde;o'));
if(!$_GET['sa'] || ($_GET['sa'] != 'posts' && $_GET['sa'] != 'groups' && $_GET['sa'] != 'topics')) { $_GET['sa'] = 'posts'; }
$_GET['q'] = trim($_GET['q']); //Esto queda para todos
$q = $_GET['q'];
$f = array('date', 'cat', 'autor', 'sort', 'en');
foreach($f as $name) {
  $$name = empty($_GET[$name]) ? '-1' : htmlspecialchars($_GET[$name]);
}
if($_GET['q']) { $title = htmlspecialchars($_GET['q']).' - '.$config['name']; } else { $title = 'Buscador de '.$config['name']; }
/* filtros */
if($_GET['sa'] == 'posts') {
  $p = 'post';
  $class = 'posts';
} elseif($_GET['sa'] == 'groups') {
  $p = 'group';
  $class = 'comunidades';
} elseif($_GET['sa'] == 'topics') {
  $p = 'topic';
  $class = 'internet';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="description" content="El buscador de <?=$config['name'];?> ofrece excelentes resultados ya que permite la integraci&oacute;n de todos los contenidos de Internet junto a la mejor informaci&oacute;n seleccionada y evaluada por nuestra gran comunidad." />
  <link rel="search" type="application/opensearchdescription+xml" title="<?=$title;?>" href="/opensearch.xml" />
  <link rel="icon" href="<?=$config['url'];?>/favicon.png" type="image/x-icon">
  <title><?=$title;?></title>
  <link type="text/css" rel="stylesheet" href="<?=$config['images'];?>/images/search/estilo.css?2.1" />
  <script type="text/javascript">window.google_analytics_uacct = "UA-91290-9";</script>
  <script type="text/javascript">
    var global_location = '<?=$class;?>';
    var global_data = {
    pais: 'uy'
    }
    var urls = { images : '<?=$config['images'];?>/images', home : '<?=$config['search_url'];?>' }
  </script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="<?=$config['images'];?>/images/search/search.js?2.0"></script>
  <script src="<?=$config['url'];?>/js/scripts2.js" type="text/javascript"></script>
  <script type="text/javascript" src="http://www.google.com/jsapi?autoload=%7B%22modules%22%3A%5B%7B%22name%22%3A%22ads%22%2C%22version%22%3A%221%22%2C%22packages%22%3A%5B%22search%22%5D%7D%5D%7D"></script>
</head>
<?php if(empty($_GET['q']) && empty($author)) { include('default.php'); die; }  ?>
<body id="top" class="<?=$class;?>">
  <div id="wrapper">
  <div id="header" class="clearfix">
    <div class="taringa-bar clearfix">
    <ul class="floatL">
      <li class="tab-search iconos16 tab-home"><a href="<?=$config['url'];?>"><span></span></a></li>
      <li class="tab-search iconos16 tab-posts<?=($p == 'post' ? ' selected' : '');?>"><a href="<?=$config['search_url'];?>/posts/?q=<?=htmlspecialchars($q);?>"><span></span> Posts</a></li>
      <li class="tab-search iconos16 tab-comunidades<?=($p == 'group' ? ' selected' : '');?>"><a href="<?=$config['search_url'];?>/comunidades/?q=<?=htmlspecialchars($q);?>"><span></span> Comunidades</a></li>
      <li class="tab-search iconos16 tab-web<?=($p == 'topic' ? ' selected' : '');?>"><a href="<?=$config['search_url'];?>/temas?q=<?=htmlspecialchars($q);?>"><span></span> Temas</a></li>
    </ul>
    <?php if(!$logged['id']) { ?>
    <ul class="bar-list floatR">
      <li class="registrate"><a href="javascript:alert('No disponible');"><span>Registrate</span></a></li>
      <li class="identificate"><a href="" onclick="open_login_box(); return false"><span>Identificate</span></a></li>
    </ul>
    <div id="login_box" style="display: none">
      <div class="login_header">
        <img title="Cerrar mensaje" onclick="close_login_box();" class="login_cerrar" src="<?=$config['search_url'];?>/images/search/cerrar.png" style="display: none;" />
      </div>
      <div class="login_cuerpo">
        <span class="gif_cargando floatR" id="login_cargando" style="display: none;"></span>
        <div id="login_error" style="display: none;"></div>
        <form action="javascript:login_ajax();" method="post">
          <label>Usuario</label>
          <input type="text" class="ilogin" id="nickname" name="nick" maxlength="64" />
          <label>Contrase&ntilde;a</label>
          <input type="password" class="ilogin" id="password" name="pass" maxlength="64" />
          <input type="submit" title="Entrar" value="Entrar" class="mBtn btnOk" />
          <div style="color: rgb(102, 102, 102); padding: 5px; font-weight: normal; display: none;" class="floatR">
          <input type="checkbox"> Recordarme?
          </div>
        </form>
        <div class="login_footer">
          <strong>AYUDA</strong><br>
          <a href="<?=$config['url'];?>/password/">&#191;Olvidaste tu contrase&ntilde;a?</a>
        </div>
      </div>
    </div>
    <?php } else { ?>
    <ul class="bar-list floatR">
    <?php
    if(!empty($logged['city'])) {
      $i = 0;
      do {
        ++$i;
        if($i == 2) {
          $c = file_get_contents('http://www.ipaddressapi.com/lookup/'.$_SERVER['REMOTE_ADDR']);
	      $ex = explode('<th>City:</th><td>', $c);
	      $ex2 = explode('</td>', $ex[1]);
	      $logged['city'] = $ex2[0];
        }
        $st = mysql_fetch_row($query);
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, 'http://www.google.com/ig/api?weather='.$logged['city']);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($c);
        $ex = explode('<current_conditions>', $data);
        //imagen
        $im = explode('<icon data="', $ex[1]);
        $im = explode('"/>', $im[1]);
        //fin imagen
        $ex = explode('<temp_c data="', $ex[1]);
        $ex = explode('"/>', $ex[1]);
        $ex = intval($ex[0]);
      } while((empty($ex) && $i != 2 ? true : 0));
      if(!empty($ex)) { echo '<li><a href="#" title=""><img style="vertical-align: top; width: border: medium none; 16px; height: 16px;" src="http://www.google.com/'.$im[0].'"> '.$ex.'º C</a></li>'; }
    }
    ?>

		<li class="monitor icon"><a title="Monitor de usuario" href="<?=$config['url'];?>/monitor"><span></span></a></li>
		<li class="favoritos icon"><a title="Mis Favoritos" href="<?=$config['url'];?>/favoritos.php"><span></span></a></li>
		<li class="mensajes icon"><a title="Mensajes" href="<?=$config['url'];?>/mensajes/"><span></span></a></li>
		<li class="nick icon"><a title="Mi Perfil" href="<?=$config['url'];?>/perfil/<?=$logged['nick'];?>"><span><?=$logged['nick'];?></span></a></li>
		<li class="salir icon"><a title="Salir" href="<?=$config['url'];?>/ajax/logout.php?nope=true"><span></span></a></li>
	</ul>
    <?php } ?>
    <script type="text/javascript">
        $('form[name="search-box"] input[name="q"]').focus();
    	search.home_change_actual = 'posts';
    </script>
    </ul>
    </div>
    <div class="search clearfix">
      <div id="logo">
        <a href="/">Inicio</a>
      </div>
      <div class="search-box clearfix">
        <form name="buscar">
          <div class="input-left"></div>
          <input type="text" name="q" value="<?=($q ? htmlspecialchars($q) : 'Buscar');?>" />
          <div class="input-right"></div>
          <div class="btn-search floatL">
          <a href="javascript:$('form[name=buscar]').submit()"></a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include('search_'.$p.'.php'); ?>
</body>
</html>