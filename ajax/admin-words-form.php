<?php
include('../config.php');
include('../functions.php');
if(!$logged['id']) { die; }
if(!allow('censure')) { die('0: No tienes permisos para estar ac&aacute;'); }
$ms = array();
$q = mysql_query('SELECT `word` FROM `censorship` ORDER BY `id` ASC');
while($m = mysql_fetch_row($q)) {
    $ms[] = $m[0];
}
?>
1:
<div class="form-container" id="censor">
	<div style="display: none;margin-bottom:10px;padding:8px;" class="redBox" id="error_data"></div>
	<div class="data">
		<label>Palabras censuradas:</label>
		<textarea onblur="no_foco(this);" onfocus="foco(this);" style="height: 100px;" name="censurar" id="censurar" class="c_input_desc"><?=implode(', ', $ms);?></textarea>
		<div align="left" class="size10">Escribe una serie de palabras separadas por espacio y coma. Por ejemplo: <b>spirate, taringa, kasirit, etc.</b>
		<br><br><span class="color_red">Importante:</span> Al final de la ultima palabra no debes dejar <b>coma</b></div>
	</div>

</div>