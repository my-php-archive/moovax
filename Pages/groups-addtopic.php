<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('Debes loguearte', 'Guachon'); }
//Group
if(!mysql_num_rows($ggg = mysql_query('SELECT * FROM `groups` WHERE `url` = \''.mysql_clean($_GET['group']).'\''))) { fatal_error('La comunidad no existe'); }
$group = mysql_fetch_assoc($ggg);
if($group['status'] != '0') { fatal_error('El grupo se encuentra eliminado'); }
if(!mysql_num_rows($query = mysql_query('SELECT `id`, `rank` FROM `groups_members` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\'')) && !allow('edittopic')) { fatal_error('No eres miembro de la comunidad'); }
list($idmember, $currentrank) = mysql_fetch_row($query);
if($currentrank == '1' || $currentrank == '2') { fatal_error('Tu rango no te permite crear temas'); }
if($group['id'] == 40 && !allow('show_panel')) { fatal_error('Esta comunidad es visible s&oacute;lo por el staff.'); }
if($_POST) {
  $title = trim($_POST['titulo']);
  if(!$title || !trim($_POST['cuerpo_comment'])) { fatal_error('Faltan datos'); }
  if(strlen($title) < 3) { fatal_error('El titulo debe tener al menos 3 caracteres'); }
  if(strlen($_POST['cuerpo_comment']) < 40) { fatal_error('El tema debe tener al menos 40 caracteres'); }
  if($_POST['sticky'] == 1 && $currentrank != '5') { $_POST['sticky'] = '0'; }
  if($_POST['id']) {
    if(!mysql_num_rows($query = mysql_query('SELECT `id`, `author`, `status` FROM `groups_topics` WHERE `id` = \''.(int)$_POST['id'].'\''))) { fatal_error('El tema no existe'); }
    $row = mysql_fetch_row($query);
    if($row[1] != $logged['id'] && $currentrank != '5' && $currentrank != '4' && !allow('edittopic')) { fatal_error('No puedes editar esto'); }
    if($row[2] != '0') { fatal_error('El tema est&aacute; eliminado'); }
    if(!trim($_POST['cause']) && $row[1] != $logged['id']) { fatal_error('Debes especificar la causa'); }
    mysql_query('UPDATE `groups_topics` SET `title` = \''.mysql_clean($title).'\', `body` = \''.mysql_clean($_POST['cuerpo_comment']).'\', `sticky` = \''.($_POST['sticky'] ? 1 : 0).'\', `closed` = \''.($_POST['nocoment'] ? 1 : 0).'\' WHERE `id` = \''.$row[0].'\' LIMIT 1') or fatal_error(mysql_error());
    mysql_query('INSERT INTO `groups_actions` (`author`, `group`, `action`, `title`, `url`, `reason`, `time`) VALUES (\''.$logged['id'].'\', \''.$group['id'].'\', \'0\', \''.mysql_clean($title).'\', \'/comunidades/'.$group['url'].'/'.$row[0].'/'.url(mysql_clean($title)).'\.html\', \''.mysql_clean($_POST['cause']).'\', \''.time().'\')') or die(mysql_error());
    fatal_error('El tema fue editado satisfactoriamente', 'YEAH!', 'Ir', '/comunidades/'.$group['url'].'/'.$row[0].'/'.url(htmlspecialchars($title)).'.html', 'btnGreen');
  } else {
    if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_topics` WHERE `author` = \''.$logged['id'].'\' && `time` > \''.(time()-200).'\''))) { fatal_error('Debes esperar para agregar otro tema', 'ANTI-FLOOD'); }
    //if($currentrank == '1' || $currentrank == '2') { fatal_error('Tu rango no te permite crear temas'); }
    mysql_query('INSERT INTO `groups_topics` (`group`, `author`, `title`, `body`, `status`, `sticky`, `closed`, `time`) VALUES (\''.$group['id'].'\', \''.$logged['id'].'\', \''.mysql_clean($title).'\', \''.mysql_clean($_POST['cuerpo_comment']).'\', \'0\', \''.($_POST['sticky'] ? 1 : 0).'\', \''.($_POST['nocoment'] ? 1 : 0).'\', \''.time().'\')') or fatal_error(mysql_error());
    $url = '/comunidades/'.$group['url'].'/'.mysql_insert_id().'/'.url(htmlspecialchars($title)).'.html';
    mysql_query('INSERT INTO `activity` (`author`, `title`, `url`, `what`, `time`, `type`) VALUES (\''.$logged['id'].'\', \''.mysql_clean($title).'\', \''.$url.'\', \''.mysql_insert_id().'\', \''.time().'\', \'3\')') or die(mysql_error());
    if($group['author'] != $logged['id']) {
      mysql_query('INSERT INTO `notifications` (`author`, `id_user`, `type`, `url`, `status`, `time`, `title`) VALUES (\''.$logged['id'].'\', \''.$group['author'].'\', \'19\', \''.$url.'\', \'0\', \''.time().'\', \''.htmlspecialchars($title).'\')');
    }
    fatal_error('El tema '.htmlspecialchars($title).' fue agregado', 'YEAH!', 'Go Go!', $url, 'btnGreen');
  }
}
$edit = false;
if($_GET['id']) {
  if(!mysql_num_rows($query = mysql_query('SELECT * FROM `groups_topics` WHERE `id` = \''.(int)$_GET['id'].'\''))) { fatal_error('El tema no existe'); }
  $row = mysql_fetch_assoc($query);
  if($row['status'] != '0') { fatal_error('El tema est&aacute; eliminado'); }
  if($row['author'] != $logged['id'] && !allow('edittopic') && $currentrank != '4' && $currentrank != '5') { fatal_error('No tienes permiso -uiy'); }
  if($group['id'] != $row['group']) { fatal_error(''); }
  $edit = true;
}
?>
<script>
function preview() {
   dialogBox.center();
   //dialogBox.close_button = true;
   dialogBox.show();
   dialogBox.title('Previsualizaci&oacute;n');
   var title = $('input[name="titulo"]').val();
   var content = $('textarea[name="cuerpo_comment"]').val();
   if(!title || !content) { alert('Completa todos los campos'); return false; }
   $.ajax({
     url: '/ajax/groups-topic_preview.php',
     data: 'titulo=' + encodeURIComponent(title) + '&body=' + encodeURIComponent(content),
     type: 'post',
     success: function(g) {
       if(g.charAt(0) == '0') {
         dialogBox.close();
         alert(g.substring(1));
       } else {
         dialogBox.body(g);
         dialogBox.buttons(true, true, '<?=($edit ? 'Editar tema' : 'Agregar tema');?>', "$('form[name=add_comunidad]').submit();", true, true, true, 'Cerrar previsualizaci&oacute;n', 'close', true, false);
		 $('#dialogBox #buttons .mBtn.btnOk').removeClass('btnCancel').addClass('btnGreen');
         $.scrollTo(0, 500)
       }
     }
   });
}
</script>
<div id="main_content">
<div class="breadcrumb">
<ul>
<li class="first"><a href="/" accesskey="1" class="home"></a></li>
<li><a href="/comunidades/" title="Comunidades">Comunidades</a></li>
<li style="font-weight:bold;"><?=($edit ? 'Editar' : 'Crear');?> Tema</li>
<li class="last"></li>
</ul>
</div>
<div class="clear"></div>
<div class="creartema-left">
<div class="box_title_content">
<div class="box_txt">Importante</div>
</div>
<div class="box_cuerpo_content">Antes de crear un nuevo tema es importante que leas el <a href="/static/protocolo/">protocolo</a>.<br /><br />
Al ser el creador del tema, tenes el permiso de editarlo, eliminarlo, eliminar comentarios, bloquear comentarios.<br /><br />
Si desea que su tema este fijado en la comunidad debe comunicarse con lo(s) Administrador(es) o Moderador(es) de la comunidad ya que ellos son los &uacute;nicos capaces de fijarlo.<br /><br />
Si tenes dudas sobre las comunidades visita <a href="/ayuda/categoria/comunidades/">este enlace</a>.</div>
<br class="space">
<div class="box_title_content">
<div class="box_txt">Destacados</div>
</div>
<div class="box_cuerpo_content">
<p align="center"></p>
</div>
</div>
<div class="creartema-right">
<div class="box_title_content">
<div class="box_txt"><?=($edit ? 'Editando: '.$row['title'] : 'Crear nuevo tema');?></div>
</div>
<div class="box_cuerpo_content">
<form name="add_comunidad" id="nuevocoment" method="post" action="/comunidades/<?=$group['url'];?>/<?=($edit ? 'editar/'.$row['id'] : 'agregar');?>/">
<?php
if($edit) { echo '<input type="hidden" id="id" name="id" value="'.$row['id'].'" />'; }
?><div class="form-container">
<b class="size13"><label for="uname">Titulo:</label></b>
<input style="width:420px;"  class="c_input" value="<?=($edit ? $row['title'] : '');?>" id="titulo" name="titulo" tabindex="1" datatype="text" dataname="Titulo" type="text">
<div class="clearBoth"></div>
<br class="space">
<div class="data">
<b class="size13">
<label for="uname">Cuerpo:</label>
</b>
<textarea style="height:300px;width:570px;"  id="VPeditor" name="cuerpo_comment" tabindex="3"><?=$row['body'];?></textarea>
<a href="#" smile=":bueno:"><img height="24" width="24" border="0" onclick="insertText(' :bueno:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/bueno.png" alt="Bueno" title="Bueno"></a><a href="#" smile=":malo:"><img height="24" width="24" border="0" onclick="insertText(' :malo:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/malo.png" alt="Malo" title="Malo"></a><a href="#" smile=":muerto:"><img height="24" width="24" border="0" onclick="insertText(' :muerto:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/muerto.png" alt="Muerto" title="Muerto"></a><a href="#" smile=":divertido:"><img height="24" width="24" border="0" onclick="insertText(' :divertido:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/divertido.png" alt="Divertido" title="Divertido"></a><a href="#" smile=":sinister:"><img height="24" width="24" border="0" onclick="insertText(' :sinister:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/sinister.png" alt="Siniestro" title="Siniestro"></a><a href="#" smile=":D"><img height="24" width="24" border="0" onclick="insertText(' :D', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/sonrisa.png" alt="Sonrisa" title="Sonrisa"></a><a href="#" smile=":arrogante:"><img height="24" width="24" border="0" onclick="insertText(' :arrogante:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/arrogante.png" alt="Arrogante" title="Arrogante"></a><a href="#" smile=":@"><img height="24" width="24" border="0" onclick="insertText(' :@', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/enojado.png" alt="Enojado" title="Enojado"></a><a href="#" smile=":relax:"><img height="24" width="24" border="0" onclick="insertText(' :relax:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/relax.png" alt="Relajado" title="Relajado"></a><a href="#" smile=":ironico:"><img height="24" width="24" border="0" onclick="insertText(' :ironico:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/ironico.png" alt="Ironico" title="Ironico"></a><a href="#" smile=":confused:"><img height="24" width="24" border="0" onclick="insertText(' :confused:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/confused.png" alt="Confundido" title="Confundido"></a><a href="#" smile=":shamed:"><img height="24" width="24" border="0" onclick="insertText(' :shamed:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/shamed.png" alt="Vergonzoso" title="Vergonzoso"></a><a href="#" smile=":disdain:"><img height="24" width="24" border="0" onclick="insertText(' :disdain:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/disdain.png" alt="Disdain" title="Disdain"></a><a href="#" smile=":("><img height="24" width="24" border="0" onclick="insertText(' :(', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/triste.png" alt="Triste" title="Triste"></a><a href="#" smile=":sarcastico:"><img height="24" width="24" border="0" onclick="insertText(' :sarcastico:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/sarcastico.png" alt="Sarcastico" title="Sarcastico"></a><a href="#" smile=":-)"><img height="24" width="24" border="0" onclick="insertText(' :-)', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/feliz.png" alt="Feliz" title="Feliz"></a><a href="#" smile=":lost:"><img height="24" width="24" border="0" onclick="insertText(' :lost:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/lost.png" alt="Perdido" title="Perdido"></a><a href="#" smile=":shock:"><img height="24" width="24" border="0" onclick="insertText(' :shock:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/shock.png" alt="Shock" title="Shock"></a><a href="#" smile=":llorar:"><img height="24" width="24" border="0" onclick="insertText(' :llorar:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/llorar.png" alt="Llorando" title="Llorando"></a><a href="#" smile=":pirata:"><img height="24" width="24" border="0" onclick="insertText(' :pirata:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/pirata.png" alt="Pirata" title="Pirata"></a><a href="#" smile=":devil:"><img height="24" width="24" border="0" onclick="insertText(' :devil:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/devil.png" alt="Diablo" title="Diablo"></a><a href="#" smile=":loser:"><img height="24" width="24" border="0" onclick="insertText(' :loser:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/loser.png" alt="Perdedor" title="Perdedor"></a><a href="#" smile=":ask:"><img height="24" width="24" border="0" onclick="insertText(' :ask:', document.forms.nuevocoment.VPeditor);" src="<?=$config['images'];?>/images/emoticons/ask.png" alt="Pregunta" title="Pregunta"></a>
</div>
<div class="clearBoth"></div>
<br />
<fieldset style="width:200px;"><legend><span class="tit_lab">Opciones</span></legend>
<?php
if($currentrank == 5) { echo '<label for="sticky"><input name="sticky"'.($row['sticky'] == 1 ? ' checked="checked"' : '').' id="sticky" value="1" type="checkbox" /> Fijar</label>'; }
?>

<label for="nocoment"><input name="nocoment" id="nocoment"<?=($row['closed'] == 1 ? ' checked="checked"' : '');?> value="1" type="checkbox" /> No permitir comentarios</label>
</fieldset>

<input name="comun" value="oficial" type="hidden" />
</div>
<hr style="clear: both; margin-bottom: 15px; margin-top: 20px;" class="divider" />
<?php
if($logged['id'] != $row['author'] && $edit) {
  echo '<b class="size13"><label for="ucausa">Causa:</label></b>
        <input style="width:420px;" class="c_input" name="cause" tabindex="1" datatype="text" dataname="cause" type="text">';
}
?>

<div id="buttons" align="right"><input tabindex="14" title="<?=($edit ? 'Editar' : 'Crear');?> tema" value="Previsualizar" class="Boton BtnBlue" name="Enviar" onclick="preview(); return false;" type="submit"/></div>
</form>
</div>
</div>
<div style="clear:both">
</div>
<div style="clear:both"></div></div>
</div></div>