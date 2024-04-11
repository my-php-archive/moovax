<?php
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die('0Debes loguearte'); }
if(!allow('manage_news')) { die; }
if($_POST) {
  if($_POST['action'] == 'add') {
    if(!$_POST['noticias'] || !is_array($_POST['noticias'])) { die; }
    $i = 0;
    foreach($_POST['noticias'] as $new) {
      if(mysql_num_rows(mysql_query('SELECT `id` FROM `news` WHERE `word` = \''.mysql_clean($new).'\''))) { continue; }
      $new = trim($new);
      if(!$new) { continue; }
      if(strlen($new) < 5 || strlen($new) > 255) { die('0Tu noticia <b>'.htmlspecialchars($new).'</b> debe tener entre 5 y 40 caracteres'); }
      mysql_query('INSERT INTO `news` (`word`, `act`) VALUES (\''.mysql_clean($new).'\', \'1\')');
      ++$i;
    }
    if($i == 0) { echo '0No se produjeron cambios'; } else { echo '1Cambios guardados'; }
  } else {
    if(!mysql_num_rows($new = mysql_query('SELECT `id` FROM `news` WHERE `id` = \''.(int)$_POST['id'].'\''))) { die('0La noticia no existe'); }
    list($id) = mysql_fetch_row($new);
    if($_POST['action'] == 'delete') {
      mysql_query('DELETE FROM `news` WHERE `id` = \''.$id.'\' LIMIT 1') or die('0: '.mysql_error());
    } else {
      $text = trim($_POST['text']);
      if(!$text || strlen($text) < 4 || strlen($text) > 255) { die('0Debe tener entre 3 y 255 caracteres'); }
      mysql_query('UPDATE `news` SET `word` = \''.$text.'\' WHERE `id` = \''.$id.'\' LIMIT 1');
    }
    echo '1';
  }
} else {
?>
1
<script>
function del(id) {
  $('#result' + id).slideUp(1000);
}
</script>
<div id="mostrame">
<form name="form" id="form">
<input type="hidden" id="action" name="action" value="add" />
<?php
$i = 0;
$few = mysql_query('SELECT `id`, `word` FROM `news` ORDER BY id ASC');
while($row = mysql_fetch_row($few)) {
  echo '<div id="result'.$row[0].'"><input size="40" type="text" value="'.$row[1].'" name="noticias['.(++$i).']" id="noticias['.($i).']" />
  <a onclick="admin.news_del('.$row[0].'); return false;"><img src="'.$config['images'].'/images/cross.png"></a>
  <a id="edit'.$row[0].'" onclick="admin.news_edit('.$row[0].'); return false;"><img src="'.$config['images'].'/images/edit2.png"></a>
  </div>';
}
?>
</form>
<input type="button" class="Boton Small BtnRed" onclick="add(); return false;" value="A&ntilde;adir otra" />
</div>
<script>
var actual = <?=$i;?>;
function add() {
  actual = ++actual;
  $('#form').html($('#form').html() + '<div style="margin: 0px 41px 0 0;" id="result"><input size="40" type="text" name="noticias[' + (actual) + ']" /></div>');
}
</script>
<?php
}
?>