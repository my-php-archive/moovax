<?php
if(!defined('ok')) { die; }
?>
<div class="boxtitleProfile clearfix">
    <h3 style="margin-bottom:-6px;">Cambiar mi contrase&ntilde;a</h3>
</div>
<div id="exito" class="yellowBox" style="display:none; margin:10px;"></div>
<form name="save_pass">
  <div class="column-complete">
      <div class="left-column">
  	    Contrase&ntilde;a actual:
  	</div>
  	<div class="right-column">
  	    <input id="pass_actual" name="pass_actual" size="30" maxlength="32" value="" type="password">
  	</div>
  </div>
  <div class="column-complete">
      <div class="left-column">
  	    Contrase&ntilde;a nueva:
  	</div>
  	<div class="right-column">
          <input id="pass_new" name="pass_new" size="30" maxlength="32" value="" type="password">
  	</div>
  </div>

  <div class="column-complete">
      <div class="left-column">
  	    Repetir contrase&ntilde;a:
  	</div>
  	<div class="right-column">
  	    <input id="pass_verify" name="pass_verify" size="30" maxlength="32" value="" type="password">
  	</div>
  </div>
  <br><br><div align="center"><input id="save_pass" class="Boton BtnGray" onclick="account.new_pass();" value="Guardar cambios" title="Guardar cambios" type="button"></div>
  <input type="hidden" value="<?=$logged['id'];?>" name="id_user">
</form>