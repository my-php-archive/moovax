<?php
if(!defined('ok')) { die; }
$row = mysql_fetch_assoc($query);
?>
<div class="boxtitleProfile clearfix">
    <h3 style="margin-bottom:-6px;">Editar mi apariencia</h3>
</div>
<div class="redBox">Al editar mi apariencia tambi&eacute;n acepto los <a href="/terminos-y-condiciones/" target="_blank">T&eacute;rminos de uso</a>.</div>
<div class="aparence">
    <br />
	<div class="DesOpt" onclick="chgsec(this)">1. Formaci&oacute;n y trabajo</div>
	<div class="box_cuerpo_content" id="contennnt" style="display: none;">

    <form id="save_profile1" class="horizontal">
	    <table cellpadding="4" width="100%">
		    <tbody>
			    <tr>
				    <td align="right" valign="top" width="23%">
					    <b>Estudios:</b>
					</td>
					<td width="40%">
					    <select id="estudio" name="estudio">
						    <option<?=($row['studies'] == '0' ? ' selected="selected"' : '');?> value="0">Sin Respuesta</option>
							<option<?=($row['studies'] == '1' ? ' selected="selected"' : '');?> value="1">Sin Estudios</option>
							<option<?=($row['studies'] == '2' ? ' selected="selected"' : '');?> value="2">Primario completo</option>
							<option<?=($row['studies'] == '3' ? ' selected="selected"' : '');?> value="3">Secundario en curso</option>
							<option<?=($row['studies'] == '4' ? ' selected="selected"' : '');?> value="4">Secundario completo</option>
							<option<?=($row['studies'] == '5' ? ' selected="selected"' : '');?> value="5">Terciario en curso</option>
							<option<?=($row['studies'] == '6' ? ' selected="selected"' : '');?> value="6">Terciario completo</option>
							<option<?=($row['studies'] == '7' ? ' selected="selected"' : '');?> value="7">Universitario en curso</option>
							<option<?=($row['studies'] == '8' ? ' selected="selected"' : '');?> value="8">Universitario completo</option>
							<option<?=($row['studies'] == '9' ? ' selected="selected"' : '');?> value="9">Post-grado en curso</option>
							<option<?=($row['studies'] == '10' ? ' selected="selected"' : '');?> value="10">Post-grado completo</option>
						</select>
					</td>
				</tr>
				<tr>
				    <td align="right" valign="top" width="23%">
					    <b>Profesi&oacute;n:</b>
					</td>
					<td width="40%">
					    <input size="30" maxlength="32" name="profesion" id="profesion" value="<?=$row['profession'];?>" type="text" />
					</td>
				</tr>
				<tr>
    				<td align="right" valign="top">
    				    <b>Empresa:</b>
    				</td>
    				<td>
    				    <input size="30" maxlength="32" name="empresa" id="empresa" value="<?=$row['company'];?>" type="text" />
    				</td>
				</tr>
				<tr>
				    <td align="right" valign="top" width="23%">
					    <b>Sector:</b>
					</td>
					    <td width="40%">
						    <select id="sector" name="sector">
                            <option value="0">Sin respuesta</option>
                            <?php
                            $em = array(1 => 'Abastecimiento', 2 => 'Administraci&oacute;n', 3 => 'Apoderado aduanal', 4 => 'Asesor&iacute;a en comercio exterior', 5 => 'Asesor&iacute;a legal internacional',
                                        6 => 'Asistente de tr&aacute;fico', 7 => 'Auditor&iacute;a', 8 => 'Calidad', 9 => 'Call center', 10 => 'Capacitaci&oacute;n comercio exterior', 11 => 'Comercial',
                                        12 => 'Comercio exterior', 13 => 'Compras', 14 => 'Compras internacionales/importaci&oacute;n', 15 => 'Comunicaci&oacute;n social', 16 => 'Comunicaciones externas',
                                        17 => 'Comunicaciones internas', 18 => 'Consultor&iacute;a', 19 => 'Consultor&iacute;as comercio exterior', 20 => 'Contabilidad', 21 => 'Control de gesti&oacute;n',
                                        22 => 'Creatividad', 23 => 'Dise&ntilde;o', 24 => 'Distribuci&oacute;n', 25 => 'E-commerce', 26 => 'Educaci&oacute;n', 27 => 'Finanzas', 28 => 'Finanzas internacionales',
                                        29 => 'Gerencia / direcci&oacute;n general', 30 => 'Impuestos', 31 => 'Ingenier&iacute;a', 32 => 'Internet', 33 => 'Investigaci&oacute;n y desarrollo', 34 => 'J&oacute;venes profesionales',
                                        35 => 'Legal', 36 => 'Log&iacute;stica', 37 => 'Mantenimiento', 38 => 'Marketing', 39 => 'Medio ambiente', 40 => 'Mercadotecnia internacional', 41 => 'Multimedia', 42 => 'Otra', 43 => 'Pasant&iacute;as',
                                        44 => 'Periodismo', 45 => 'Planeamiento', 46 => 'Producci&oacute;n', 47 => 'Producci&oacute;n e ingenier&iacute;a', 48 => 'Recursos humanos', 49 => 'Relaciones institucionales / p&uacute;blicas', 50 => 'Salud',
                                        51 => 'Seguridad industrial', 52 => 'Servicios', 53 => 'Soporte t&eacute;cnico', 54 => 'Tecnolog&iacute;a', 55 => 'Tecnolog&iacute;as de la informaci&oacute;n', 56 => 'Telecomunicaciones', 57 => 'Telemarketing',
                                        58 => 'Traducci&oacute;n', 59 => 'Transporte', 60 => 'Ventas', 61 => 'Ventas internacionales/exportaci&oacute;n');
                            foreach($em as $id => $text) {
                              echo '<option value="'.$id.'"'.($id == $row['sector'] ? ' selected="selected"' : '').'>'.$text.'</option> ';
                            }
                            ?>
							</select>
						</td>
					</tr>
					<tr>
					    <td align="right" valign="top">
						    <b>Nivel de ingresos:</b>
						</td>
						<td>
						    <select id="ingresos" name="ingresos">
									<option<?=($row['income'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
									<option<?=($row['income'] == '1' ? ' selected="true"' : '');?> value="1">Sin ingresos</option>
									<option<?=($row['income'] == '2' ? ' selected="true"' : '');?> value="2">Bajos</option>
									<option<?=($row['income'] == '3' ? ' selected="true"' : '');?> value="3">Intermedios</option>
									<option<?=($row['income'] == '4' ? ' selected="true"' : '');?> value="4">Altos</option>
							</select>
						</td>
					</tr>
					<tr>
					    <td align="right" valign="top">
						    <b>Intereses Profesionales:</b>
						</td>
						<td>
						    <textarea name="intereses" cols="30" rows="5" id=""><?=$row['interests'];?></textarea>
						</td>
					</tr>
					<tr>
					    <td align="right" valign="top">
						    <b>Habilidades Profesionales:</b>
						</td>
						<td><textarea name="habilidades" cols="30" rows="5" id="habilidades_profesionales"><?=$row['skills'];?></textarea></td>
					</tr>
					<tr>
					    <td colspan="3" align="left">
						    <hr class="divider">
							<input class="Boton BtnGray" type="button" value="Guardar cambios" onclick="account.save(1);" id="save_paso1" title="Guardar cambios" />
							<span class="floatR" id="exito_paso1" style="display:none"></span><span class="floatR" id="cargando_paso" style="display:none"><img src="/load.gif" border="0"></span>
						</td>
						<input type="hidden" value="1" name="id_user">
					</tr>
				</tbody>
			</table>
		</form>
		</div>

		<br />


		<div class="DesOpt" onclick="chgsec(this)">2. M&aacute;s sobre mi</div>
		<div class="box_cuerpo_content" id="contennnt" style="display: none;">

			<form id="save_profile2">
				<table width="100%" cellpadding="4">
					<tbody>
						<tr>

							<td valign="top" width="23%" align="right">
								<b>Me gustar&iacute;a:</b>
							</td>
							<!-- me gustaria -->
							<td width="40%">
								<table width="100%" border="0">
									<tbody>
										<select name="me_gustaria">
													<option<?=($row['like'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
													<option<?=($row['like'] == '1' ? ' selected="true"' : '');?> value="1">Hacer amigos</option>
													<option<?=($row['like'] == '2' ? ' selected="true"' : '');?> value="2">Conocer gente con mis intereses</option>
													<option<?=($row['like'] == '3' ? ' selected="true"' : '');?> value="3">Conocer gente para hacer negocios</option>
													<option<?=($row['like'] == '4' ? ' selected="true"' : '');?> value="4">Encontrar pareja</option>
													<option<?=($row['like'] == '5' ? ' selected="true"' : '');?> value="5">De todo</option>
										</select>
									</tbody>
								</table>
							</td>
						</tr>
						<!-- en el amor estoy -->
						<tr>

							<td valign="top" align="right">

								<b>Estado civil:</b>
							</td>
							<td>
								<table width="100%" border="0">
									<tbody>

										<select id="estado_civil" name="estado_civil">
											<option<?=($row['marital_status'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
											<option<?=($row['marital_status'] == '1' ? ' selected="true"' : '');?> value="1">Soltero/a</option>
											<option<?=($row['marital_status'] == '2' ? ' selected="true"' : '');?> value="2">De novio/a</option>
											<option<?=($row['marital_status'] == '3' ? ' selected="true"' : '');?> value="3">Casado/a</option>
											<option<?=($row['marital_status'] == '4' ? ' selected="true"' : '');?> value="4">Divorciado/a</option>
											<option<?=($row['marital_status'] == '5' ? ' selected="true"' : '');?> value="5">Viudo/a</option>
											<option<?=($row['marital_status'] == '6' ? ' selected="true"' : '');?> value="6">En algo...</option>

										</select>

									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<!-- hijos -->
							<td valign="top" width="23%" align="right">

								<b>Hijos:</b>

							</td>
							<td width="40%">
								<table width="100%" border="0">
									<tbody>
										<select id="hijos" name="hijos">
											<option<?=($row['children'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
											<option<?=($row['children'] == '1' ? ' selected="true"' : '');?> value="1">No tengo</option>
											<option<?=($row['children'] == '2' ? ' selected="true"' : '');?> value="2">Alg&uacute;n d&iacute;a</option>
											<option<?=($row['children'] == '3' ? ' selected="true"' : '');?> value="3">No son lo m&iacute;o</option>
											<option<?=($row['children'] == '4' ? ' selected="true"' : '');?> value="4">Tengo, vivo con ellos</option>
											<option<?=($row['children'] == '5' ? ' selected="true"' : '');?> value="5">Tengo, no vivo con ellos</option>

										</select>
									</tbody>
								</table>
							</td>

						</tr>
						<tr>
							<!-- vivo con -->
							<td valign="top" width="23%" align="right">

								<b>Vivo con:</b>
							</td>
							<td width="40%">
								<table width="100%" border="0">

									<tbody>
										<select id="vivo_con" name="vivo_con">
											<option<?=($row['live_with'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
											<option<?=($row['live_with'] == '1' ? ' selected="true"' : '');?> value="1">S&oacute;lo</option>
											<option<?=($row['live_with'] == '2' ? ' selected="true"' : '');?> value="2">Con mis padres</option>
											<option<?=($row['live_with'] == '3' ? ' selected="true"' : '');?> value="3">Con mi pareja</option>
											<option<?=($row['live_with'] == '4' ? ' selected="true"' : '');?> value="4">Con amigos</option>
											<option<?=($row['live_with'] == '5' ? ' selected="true"' : '');?> value="5">Otro</option>

										</select>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="3" align="left">
								<hr class="divider">
								<input class="Boton BtnGray" type="button" value="Guardar cambios" onclick="account.save(2);" id="save_paso2" title="Guardar cambios" />

								<span class="floatR" id="exito_paso2" style="display:none"></span><span class="floatR" id="cargando_paso" style="display:none"><img src="/load.gif" border="0"></span>
							</td>
						<input type="hidden" value="1" name="id_user">
						</tr>
					</tbody>
				</table>
			</form>
		</div>


		<br />

		<div class="DesOpt" onclick="chgsec(this)">3. Como soy</div>
		<div class="box_cuerpo_content" id="contennnt" style="display: none;">
			<form id="save_profile3">
				<table width="100%" cellpadding="4">
					<tbody>
						<tr>

							<td align="right" width="23%">

								<b>Mi altura:</b>
							</td>
							<td width="40%">
								<input name="altura" id="altura" size="3" maxlength="3" type="text" value="<?=$row['height'];?>" /> cent&iacute;metros
							</td>
						</tr>

						<tr>
							<td align="right">

								<b>Mi peso:</b>
							</td>
							<td>
								<input name="peso" id="peso" size="3" maxlength="3" type="text" value="<?=$row['weight'];?>" /> kilogramos
							</td>
						</tr>

						<tr>
							<td align="right" width="23%">

								<b>Color de pelo:</b>
							</td>
							<td width="40%">
								<select id="pelo_color" name="pelo_color">
									<option<?=($row['hair'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
									<option<?=($row['hair'] == '1' ? ' selected="true"' : '');?> value="1">Negro</option>
									<option<?=($row['hair'] == '2' ? ' selected="true"' : '');?> value="2">Casta&ntilde;o oscuro</option>
									<option<?=($row['hair'] == '3' ? ' selected="true"' : '');?> value="3">Casta&ntilde;o claro</option>
									<option<?=($row['hair'] == '4' ? ' selected="true"' : '');?> value="4">Rubio</option>
									<option<?=($row['hair'] == '5' ? ' selected="true"' : '');?> value="5">Pelirrojo</option>
									<option<?=($row['hair'] == '6' ? ' selected="true"' : '');?> value="6">Gris</option>
									<option<?=($row['hair'] == '7' ? ' selected="true"' : '');?> value="7">Canoso</option>
									<option<?=($row['hair'] == '8' ? ' selected="true"' : '');?> value="8">Te&ntilde;ido</option>
									<option<?=($row['hair'] == '9' ? ' selected="true"' : '');?> value="9">Rapado</option>
									<option<?=($row['hair'] == '10' ? ' selected="true"' : '');?> value="10">Calvo</option>

								</select>
							</td>
						</tr>
						<tr>
							<td align="right">
								<b>Color de ojos:</b>

							</td>
							<td>

								<select id="ojos_color" name="ojos_color">
									<option<?=($row['eyes'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
									<option<?=($row['eyes'] == '1' ? ' selected="true"' : '');?> value="1">Negros</option>
									<option<?=($row['eyes'] == '2' ? ' selected="true"' : '');?> value="2">Marrones</option>
									<option<?=($row['eyes'] == '3' ? ' selected="true"' : '');?> value="3">Celestes</option>
									<option<?=($row['eyes'] == '4' ? ' selected="true"' : '');?> value="4">Verdes</option>
									<option<?=($row['eyes'] == '5' ? ' selected="true"' : '');?> value="5">Grises</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">
								<b>Complexi&oacute;n:</b>

							</td>
							<td>
								<select id="fisico" name="fisico">
									<option<?=($row['physical'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
									<option<?=($row['physical'] == '1' ? ' selected="true"' : '');?> value="1">Delgado/a</option>
									<option<?=($row['physical'] == '2' ? ' selected="true"' : '');?> value="2">Atl&eacute;tico</option>
									<option<?=($row['physical'] == '3' ? ' selected="true"' : '');?> value="3">Normal</option>
									<option<?=($row['physical'] == '4' ? ' selected="true"' : '');?> value="4">Algunos kilos de m&aacute;s</option>
									<option<?=($row['physical'] == '5' ? ' selected="true"' : '');?> value="5">Corpulento/a</option>
								</select>
							</td>
						</tr>

						<tr>
							<td align="right" valign="top">

								<b>Mi dieta es:</b>
							</td>
							<td>
								<select id="dieta" name="dieta">
									<option<?=($row['diet'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
									<option<?=($row['diet'] == '1' ? ' selected="true"' : '');?> value="1">Vegetariana</option>
									<option<?=($row['diet'] == '2' ? ' selected="true"' : '');?> value="2">Lacto vegetariana</option>
									<option<?=($row['diet'] == '3' ? ' selected="true"' : '');?> value="3">Org&aacute;nica</option>
									<option<?=($row['diet'] == '4' ? ' selected="true"' : '');?> value="4">De todo</option>
									<option<?=($row['diet'] == '5' ? ' selected="true"' : '');?> value="5">Comida basura</option>

								</select>
							</td>
						</tr>
						<tr>

							<td align="right" valign="top">
								<b>Fumo:</b>
							</td>
							<td>

								<table border="0" width="100%">
									<tbody>
										<select id="fumo" name="fumo">
											<option<?=($row['smoke'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
											<option<?=($row['smoke'] == '1' ? ' selected="true"' : '');?> value="1">No</option>
											<option<?=($row['smoke'] == '2' ? ' selected="true"' : '');?> value="2">Casualmente</option>
											<option<?=($row['smoke'] == '3' ? ' selected="true"' : '');?> value="3">Socialmente</option>
											<option<?=($row['smoke'] == '4' ? ' selected="true"' : '');?> value="4">Regularmente</option>
											<option<?=($row['smoke'] == '5' ? ' selected="true"' : '');?> value="5">Mucho</option>
										</select>

									</tbody>
								</table>
							</td>
						</tr>

						<tr>
							<td align="right" valign="top">
								<b>Tomo alcohol:</b>
							</td>

							<td>
								<table border="0" width="100%">
									<tbody>
										<select id="tomo_alcohol" name="tomo_alcohol">

											<option<?=($row['drink_alcohol'] == '0' ? ' selected="true"' : '');?> value="0">Sin respuesta</option>
											<option<?=($row['drink_alcohol'] == '1' ? ' selected="true"' : '');?> value="1">No</option>
											<option<?=($row['drink_alcohol'] == '2' ? ' selected="true"' : '');?> value="2">Casualmente</option>
											<option<?=($row['drink_alcohol'] == '3' ? ' selected="true"' : '');?> value="3">Socialmente</option>
											<option<?=($row['drink_alcohol'] == '4' ? ' selected="true"' : '');?> value="4">Regularmente</option>
											<option<?=($row['drink_alcohol'] == '5' ? ' selected="true"' : '');?> value="5">Mucho</option>

										</select>
									</tbody>
								</table>
							</td>

						</tr>
						<tr>
							<td colspan="3" align="left">
								<hr class="divider">

								<input class="Boton BtnGray" type="button" value="Guardar cambios" onclick="account.save(3);" id="save_paso3" title="Guardar cambios" />
								<span class="floatR" id="exito_paso3" style="display:none"></span><span class="floatR" id="cargando_paso" style="display:none"><img src="/load.gif" border="0"></span>
							</td>
						<input type="hidden" value="1" name="id_user">
						</tr>
					</tbody>
				</table>

			</form>

		</div>

		<br />

		<div class="DesOpt" onclick="chgsec(this)">4. Intereses y preferencias</div>
		<div class="box_cuerpo_content" id="contennnt" style="display: none;">

			<form id="save_profile4">
				<table width="100%" cellpadding="4">
					<tbody>

						<tr>
							<td align="right" valign="top" width="23%">
								<b>Mis intereses:</b>
							</td>
							<td width="40%">
								<textarea style="width:235px;height:102px;" name="intereses" cols="30" rows="5" id="mis_intereses"><?=$row['my_interests'];?></textarea>
							</td>

						</tr>

						<tr>
							<td align="right" valign="top">
								<b>Hobbies:</b>
							</td>
							<td>
								<textarea style="width:235px;height:102px;" name="hobbies" cols="30" rows="5" id="hobbies"><?=$row['hobbies'];?></textarea>

							</td>
						</tr>

						<tr>
							<td align="right" valign="top">
								<b>Series de TV favoritas:</b>
							</td>
							<td>
								<textarea style="width:235px;height:102px;" name="tv" cols="30" rows="5" id="series_tv_favoritas"><?=$row['favorite_series'];?></textarea>

							</td>
						</tr>

						<tr>
							<td align="right" valign="top" width="23%">
								<b>M&uacute;sica favorita:</b>
							</td>
							<td width="40%">

								<textarea style="width:235px;height:102px;" name="musica" cols="30" rows="5" id="musica_favorita"><?=$row['favorite_music'];?></textarea>
							</td>

						</tr>
						<tr>
							<td align="right" valign="top">
								<b>Deportes y equipos favoritos:</b>
							</td>

							<td>
								<textarea style="width:235px;height:102px;" name="deportes" cols="30" rows="5" id="deportes_y_equipos_favoritos"><?=$row['favorite_sports'];?></textarea>
							</td>

						</tr>
						<tr>
							<td align="right" valign="top">
								<b>Libros Favoritos:</b>

							</td>
							<td>
								<textarea style="width:235px;height:102px;" name="libros" cols="30" rows="5" id="libros_favoritos"><?=$row['favorite_books'];?></textarea>
							</td>

						</tr>
						<tr>
							<td align="right" valign="top" width="23%">
								<b>Pel&iacute;culas favoritas:</b>

							</td>
							<td width="40%">
								<textarea style="width:235px;height:102px;" name="peliculas" cols="30" rows="5" id="peliculas_favoritas"><?=$row['favorite_movies'];?></textarea>

							</td>
						</tr>
						<tr>
							<td align="right" valign="top">
								<b>Comida favor&iacute;ta:</b>

							</td>
							<td>
								<textarea style="width:235px;height:102px;" name="comida" cols="30" rows="5" id="comida_favorita"><?=$row['favorite_food'];?></textarea>

							</td>
						</tr>
						<tr>
							<td align="right" valign="top">
								<b>Mis h&eacute;roes son:</b>

							</td>
							<td>
								<textarea style="width:235px;height:102px;" name="heroes" cols="30" rows="5" id="mis_heroes_son"><?=$row['my_heroes'];?></textarea>

							</td>
						</tr>
						<tr>
							<td colspan="3" align="left">
								<hr class="divider">

								<input class="Boton BtnGray" type="button" value="Guardar cambios" onclick="account.save(4);" id="save_paso4" title="Guardar cambios" />
								<span class="floatR" id="exito_paso4" style="display:none"></span><span class="floatR" id="cargando_paso" style="display:none"><img src="/load.gif" border="0"></span>
							</td>
						<input type="hidden" value="1" name="id_user">
						</tr>
					</tbody>

				</table>
			</form>

		</div>
	</div>
