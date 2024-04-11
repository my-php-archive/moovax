<?php
$title = trim($_POST['titulo']);
$body = trim($_POST['body']);
if(empty($title) || !$body) { die('0Faltan datos'); }
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0Para agregar un nuevo tema debes est&aacute;r logueado'); }
if(strlen($title) < 3 || strlen($title) > 60) { die('0El t&iacute;tulo debe tener entre 3 y 60 caracteres'); }
if(strlen($body) < 50) { die('0El tema debe tener un m&iacute;nimo de 50 caracteres'); }
?>
<div id="preview"class="box_cuerpo" style="margin:-15px 0 0;font-size:13px;line-height:1.4em;width:750px;padding:12px 80px;overflow-y:auto;text-align:left"><?=BBposts(htmlspecialchars($body));?></div>
<script type="text/javascript">$(window).bind('resize',function(){$('#preview').height((document.documentElement.clientHeight - 120) + 'px');dialogBox.center();});$(window).trigger('resize');</script>