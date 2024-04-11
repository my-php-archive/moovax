<?php
if(!$_POST['add']) { die; }
include('../config.php');
include('../functions.php');
if(!allow('friend_sites')) { die('0No tienes permisos para estar aca puto'); }
?>
<div id="restar-dinero" class="form-container">
	<div id="error_data" class="redBox" style="display: none;margin-bottom:10px;padding:8px;"></div>
	<div class="data">
		<label>Nombre<span class="color_red">*</span></label>
		<input type="text" class="c_input" id="name" name="name">
	</div>
	<div class="data">
		<label class="floatL">URL<span class="color_red">*</span></label>
		<input type="text" class="c_input" id="web" name="web">
	</div>
	<div class="clear"></div>
	<span class="floatL"><span class="color_red">*</span>Campos obligatorios.</span><br><br>
</div>