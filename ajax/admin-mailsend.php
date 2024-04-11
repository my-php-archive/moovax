<?php
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0Logueate guacho'); }
if(!allow('show_contact')) { die('0Chupame la japi'); }
if(!mysql_num_rows($query = mysql_query('SELECT `comment`, `email`, `time` FROM `contact` WHERE `id` = \''.(int)$_GET['replyTo'].'\''))) { die('0Lo que intentas responder no existe'); }
$r = mysql_fetch_row($query);
if($_GET['send']) {
  $body = trim($_GET['body']);
  $title = trim($_GET['title']);
  if(!$_GET['mail'] || !$body) { die('0Faltan datos...'); }
  $ma = array();
  foreach(explode(',', $_GET['mail']) as $mail) {
    $mail = trim($mail);
    if(empty($mail) || !filter_var($mail, FILTER_VALIDATE_EMAIL)) { continue; }
    $ma[] = $mail;
  }
  $ma = array_unique($ma);
  if($_GET['ok'] != '1' && !in_array($r[1], $ma)) { die('2El mail ingresado es distinto al mail del contactante, enviar mail de todas formas?'); }
  if(count($ma) < 1) { die('El/los mail ingresado no es v&aacute;lido'); }
  $mail = 'El '.date('d/m/Y', $r[2]).' '.$r[1].' dijo:<br />'."\r\n";
  $mail .= $r[0]."\r\n\r\n<br /> ----------------- <br />\r\n";
  $mail .= $body;
  $headers = 'From: '.$config['mail']."\r\n".'Reply-To: '.$config['name']."\r\n".'Content-Type: text/html; charset=utf-8'."\r \n".'X-Mailer: PHP/'.phpversion();
  @mail(implode(', ', $ma), (empty($title) ? 'Gracias por contactarse con '.$config['url2'] : $title), $mail, $headers);
  echo '1 El mail fue enviado a: '.implode(', ', $ma);
} else {
?>
<div id="edit_cat" class="form-container">
	<div class="greenBox" style="margin-bottom:10px;padding:8px;">El titulo no es requerido</div>
	<div class="data">
		<label>T&iacute;tulo:</label>
		<input type="text" class="c_input" id="titlte" placeholder="Ingrese el titulo" name="title" value="">
	</div>
    <div class="data">
		<label>Para:</label>
		<input type="text" class="c_input" id="mail" placheholder="Ingrese el mail" name="mail" value="<?=$r[1];?>">
	</div>
	<div class="data">
        <label>Mensaje:</label>
        <textarea style="width: 783px; height: 171px;" id="body" name="body"></textarea>
	</div>
	<div class="clear"></div>
</div>
<?php } ?>