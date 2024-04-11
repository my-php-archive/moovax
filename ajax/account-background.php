<?php
if(!defined('ok')) { die('few'); }
?>
<div id="edit-profile-right" style="display: block;">
<div class="boxtitleProfile clearfix">
<h3 style="margin-bottom:-6px;">Fondo de perfil</h3>
</div>
<div id="wall">
<div class="column-complete">
  <div class="left-column">
    Introduce la url de tu fondo:
  </div>
  <div class="right-column">
    <input type="text" value="<?=$logged['background'];?>" size="40" name="background" id="background">
    <a<?=(empty($logged['background']) ? ' style="display:none;"' : '');?> id="wallpajero" onclick="account.background(true);" href="#">Remover fondo</a>
  </div>
</div>
<div class="column-complete">
  <div class="left-column">
    Repetir fondo:
  </div>
  <div class="right-column">
    <input id="repeat" type="checkbox"<?=($logged['background_repeat'] == '1' ? ' checked="checked"' : '');?> autocomplete="off" />
  </div>
</div>
<div class="column-complete">
  <div class="left-column">
    Color de fondo:
  </div>
  <div class="right-column">
  <div id="colorSelector" class="floatL">
    <div style="background: url('http://o1.t26.net/colorpicker/images/select.png') repeat scroll center center transparent; width: 30px; height: 30px; background-color: #<?=$logged['background_color'];?>;"></div>
    <input type="hidden" autocomplete="off" value="<?=(!empty($logged['background_color']) ? '#'.$logged['background_color'] : '');?>" />
  </div>
  <script type="text/javascript">
  $('#colorSelector').ColorPicker({
  color: '',
  onChange: function(hsb, hex, rgb) {
  $('#colorSelector div').css('backgroundColor', '#' + hex);
  $('#colorSelector input').val('#' + hex);
  }
  });
  </script>
  </div>
</div>  <br /><br />
</div>

<div align="center" style="display:none;" id="loading_few"><img src="<?=$config['images'];?>/images/loading_large.gif"></div>
<div class="barra-dotted"></div>

<div align="center"><input type="button" title="Guardar cambios" value="Guardar cambios" class="Boton BtnGray" onclick="account.background(false);" id="save_perfil"></div>


</div>
