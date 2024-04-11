<?php
if(!defined('ok')) { die; }
$row = mysql_fetch_assoc($query);
?>
		<div class="boxtitleProfile clearfix">
			<h3 style="margin-bottom:-6px;">Editar mi perfil</h3>
		</div>

	<form name="profile" accept-charset="UTF-8">
	<div id="exito" class="yellowBox" style="display:none; margin:10px;"></div>
		<div class="column-complete">
			<div class="left-column">Nombre:</div>
			<div class="right-column">
				<input name="nombre" size="40" value="<?=$row['name'];?>" type="text">
			</div>
		</div>


		<div class="column-complete">

			<div class="left-column">
				Nick:
			</div>
			<div class="right-column">
				<span class="text-right-column"><?=$row['nick'];?></span>
			</div>
		</div>


		<div class="column-complete">
			<div class="left-column">

				Fecha de nacimiento:
			</div>
			<div class="right-column">
				<span class="text-right-column">
					<select tabindex="1" name="dia_naci" autocomplete="off">
					<option value="">D&iacute;a:</option>
                    <?php
                    for($i=1;$i<=31;$i++) {
                      echo '<option value="'.$i.'"'.($i == $row['day'] ? ' selected="selected"' : '').'>'.$i.'</option>';
                    }
                    ?>
                   </select>
                   <select tabindex="2" name="mes_naci" autocomplete="off">
                   <option value="">Mes:</option>
                   <?php
                   $month = array(0, 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre');
                   for($i=1;$i<=12;$i++) {
                     echo '<option value="'.$i.'"'.($i == $row['month'] ? ' selected="selected"' : '').'>'.$month[$i].'</option>';
                   }
                   ?>
				   </select>
					<select tabindex="3" name="ano_naci" autocomplete="off">
					<option value="">A&ntilde;o:</option>
                    <?php
                    for($i=date('Y', time());$i >= 1900; $i--) {
                      echo '<option value="'.$i.'"'.($i == $row['year'] ? ' selected="selected"' : '').'>'.$i.'</option> ';
                    }
                    ?>
					</select>
				</span>
			</div>
		</div>


		<div class="column-complete">
			<div class="left-column">
				Pa&iacute;s:
			</div>
			<div class="right-column">
				<span class="text-right-column">

					<select name="pais">
					<option value="">Pa&iacute;s</option>
                    <?php
                    $query = mysql_query('SELECT `id`, `name` FROM `countries` ORDER BY `name` ASC');
                    while($m = mysql_fetch_row($query)) {
                      echo '<option value="'.$m[0].'"'.($m[0] == $row['country'] ? ' selected="selected"' : '').'>'.$m[1].'</option>';
                    }
                    ?>
                    </select>
				</span>
			</div>
		</div>

		<div class="column-complete">

			<div class="left-column">
				Ciudad:
			</div>
			<div class="right-column">
				<input name="ciudad" size="40" type="text" value="<?=$row['city'];?>">
			</div>
		</div>

		<div class="column-complete">
			<div class="left-column">

				Sexo:
			</div>
			<div class="right-column">
				<span class="text-right-column">
					<select name="sexo" size="1">
					    <option value="0"<?=($row['sex'] == '0' ? ' selected="selected"' : '');?>>Masculino</option>
					    <option value="1"<?=($row['sex'] == '1' ? ' selected="selected"' : '');?>>Femenino</option>
					</select>

				</span>
			</div>
		</div>

		<div class="column-complete">
			<div class="left-column">
				Texto personal:
			</div>
			<div class="right-column">
				<input name="texto_personal" size="40" maxlength="45" value="<?=$row['message'];?>" type="text">

			</div>

		</div>

		<div class="column-complete">
			<div class="left-column">
				Sitio web:
			</div>
			<div class="right-column">
				<input name="sitio_web" size="40" value="<?=$row['website'];?>" type="text">
			</div>

		</div>


		<div class="column-complete">
			<div class="left-column">
				<span class="BulletIcons violeta"></span>Tu contrase&ntilde;a actual:
			</div>
			<div class="right-column">
				<input name="pass" size="40" autocomplete="off" type="password">
			</div>
		</div>
		<div class="clear"></div>

		<center><span class="BulletIcons violeta"></span>Por razones de seguridad, necesitamos que ingreses tu contrase&ntilde;a actual.<div class="clear"></div></center>
		<div align="center"><input id="save_perfil" onclick="accounts.edit_profile(0); return false" class="Boton BtnGray" value="Guardar cambios" title="Guardar cambios" type="button"></div>
		<input name="id_member" value="1" type="hidden">
</form>