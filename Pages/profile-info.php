<?php
if(!defined('ok')) { die; }
?>
<div class="big-info clearfix">
    <div class="user_info clearfix">
	    <h2>Perfil e informaci&oacute;n de @<?=$row['nick'];?></h2>
	</div>
    <?php
    if((($row['show_info'] == '3' && $logged['id']) || ($row['show_info'] == '2' && mysql_num_rows(mysql_query('SELECT `id` FROM `friends` WHERE (`author` = \''.$logged['id'].'\' && `user` = \''.$row['id'].'\') || (`author` = \''.$row['id'].'\' && `user` = \''.$logged['id'].'\') && `status` = \'1\''))) || $row['show_info'] == '0') || $logged['id'] == $row['id']) {
    ?>
    <ul style="margin:6px;">
        <li><label>Nombre</label><strong><?=($row['name'] ? $row['name'] : 'No especificado');?></strong></li>
        <li><label>Edad</label><strong>
        <?php
        $age = date('Y')-$row['year']-1;
        if((date('n') == $row['month'] && date('j') >= $row['day']) || date('n') > $row['month']){ $age++; }
        echo $age;
        ?>
              </strong></li>
        <?php
        $e = mysql_fetch_row(mysql_query('SELECT `name` FROM `countries` WHERE `id` = \''.$row['country'].'\''));
        ?>
        <li><label>Pa&iacute;s</label><strong><?=$e[0];?></strong></li>
        <li><label>Email</label><strong><?=(!empty($row['email']) ? $row['email'] : 'No especificado');?></strong></li>
        <li><label>Es usuario desde</label><strong><?=timefrom($row['time']);?></strong></li>
        <li><label>Estudios</label><strong><?php
        switch($row['studies']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'Sin estudios'; break;
          case '2': echo 'Primario completo'; break;
          case '3': echo 'Secundario en curso'; break;
          case '4': echo 'Secundario completo'; break;
          case '5': echo 'Terciario en curso'; break;
          case '6': echo 'Terciario completo'; break;
          case '7': echo 'Universitario en curso'; break;
          case '8': echo 'Universitario completo'; break;
          case '9': echo 'Post-grado en curso'; break;
          case '10': echo 'Post-grado completo';
        }
        ?>
        </strong></li>
        <li class="sep"><h4>Vida personal</h4></li>
        <li><label>Le gustar&iacute;a</label><strong><?php
        switch($row['like']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'Hacer amigos'; break;
          case '2': echo 'Conocer gente con mis intereses'; break;
          case '3': echo 'Conocer gente para hacer negocios'; break;
          case '4': echo 'Encontrar pareja'; break;
          case '5': echo 'De todo';
        }
        ?></strong></li>
        <li><label>Estado civil</label><strong><?php
        $add = $row['sex'] == 0 ? 'o' : 'a';
        switch($row['marital_status']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'Solter'.$add; break;
          case '2': echo 'De novi'.$add; break;
          case '3': echo 'Casad'.$add; break;
          case '4': echo 'Divorciad'.$add; break;
          case '5': echo 'Viudo'.$add; break;
          case '6': echo 'En algo...';
        }
        ?></strong></li>
        <li><label>Hijos</label><strong><?php
        switch($row['children']) {
          case '0': echo 'Sin respuesta'; break;
          case '1': echo 'No tengo'; break;
          case '2': echo 'Alg&uacute;n d&iacute;a'; break;
          case '3': echo 'No son lo m&iacute;o'; break;
          case '4': echo 'Tengo, vivo con ellos'; break;
          case '5': echo 'Tengo, no vivo con ellos';
        }
        ?></strong></li>
        <li><label>Vive con</label><strong><?php
        switch($row['live_with']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'S&oacute;lo'; break;
          case '2': echo 'Con mis padres'; break;
          case '3': echo 'Con mi pareja'; break;
          case '4': echo 'Con amigos'; break;
          case '5': echo 'Otros';
        }
        ?></strong></li>

        <li class="sep"><h4>&iquest;C&oacute;mo es?</h4></li>
        <li><label>Mide</label><strong><?=($row['height'] ? $row['height'].'cm' : 'No especificado');?></strong></li>
        <li><label>Pesa</label><strong><?=($row['weight'] ? $row['weight'].'kg' : 'No especificado');?></strong></li>
        <li><label>Su pelo es</label><strong><?php
        switch($row['hair']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'Negro'; break;
          case '2': echo 'Casta&ntilde;o oscuro'; break;
          case '3': echo 'Casta&ntilde;o claro'; break;
          case '4': echo 'Rubio'; break;
          case '5': echo 'Pelirrojo'; break;
          case '6': echo 'Gris'; break;
          case '7': echo 'Canoso'; break;
          case '8': echo 'Te&ntilde;ido'; break;
          case '9': echo 'Rapado'; break;
          case '10': echo 'Calvo';
        }
        ?></strong></li>
        <li><label>Sus ojos son</label><strong><?php
        switch($row['eyes']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'Negros'; break;
          case '2': echo 'Marrones'; break;
          case '3': echo 'Celestes'; break;
          case '4': echo 'Verdes'; break;
          case '5': echo 'Grises';
        }
        ?>
        </strong></li>
        <li><label>Su f&iacute;sico es</label><strong><?php
        $q = ($row['sex'] == 0 ? 'o' : 'a');
        switch($row['physical']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'Delgad'.$q; break;
          case '2': echo 'Atl&eacute;tic'.$q; break;
          case '3': echo 'Normal'; break;
          case '4': echo 'Algunos kilos de m&aacute;s'; break;
          case '5': echo 'Corpulent'.$q;
        }
        ?></strong></li>

        <li class="sep"><h4>H&aacute;bitos personales</h4></li>
        <li><label>Mantiene una dieta</label><strong><?php
        switch($row['diet']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'Vegetariana'; break;
          case '2': echo 'Lacto vegetariana'; break;
          case '3': echo 'Org&aacute;nica'; break;
          case '4': echo 'De todo'; break;
          case '5': echo 'Comida basura';
        }
        ?></strong></li>
        <li><label>Fuma</label><strong><?php
        switch($row['smoke']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'No'; break;
          case '2': echo 'Casualmente'; break;
          case '3': echo 'Socialmente'; break;
          case '4': echo 'Regularmente'; break;
          case '5': echo 'Mucho'; break;
        }
        ?></strong></li>
        <li><label>Toma alcohol</label><strong><?php
        switch($row['drink_alcohol']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'No'; break;
          case '2': echo 'Casualmente'; break;
          case '3': echo 'Socialmente'; break;
          case '4': echo 'Regularmente'; break;
          case '5': echo 'Mucho';
        }
        ?></strong></li>

        <li class="sep"><h4>Vida profesional</h4></li>
        <li><label>Su profesi&oacute;n</label><strong><?=($row['profession'] ? $row['profession'] : 'No especificado');?></strong></li>
        <li><label>Trabaja en</label><strong><?=(!empty($row['company']) ? $row['company'] : 'No especificado');?></strong></li>
        <li><label>Nivel de ingresos</label><strong><?php
        switch($row['income']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'Sin ingresos'; break;
          case '2': echo 'Bajos'; break;
          case '3': echo 'Intermedios'; break;
          case '4': echo 'Altos';
        }
        ?></strong></li>
        <li><label>Sus inter&eacute;ses profesionales</label><strong><?=(!empty($row['interests']) ? $row['interests'] : 'No especificado');?></strong></li>
        <li><label>Sus habilidades profesionales</label><strong><?=(!empty($row['skills']) ? $row['skills'] : 'No especificado');?></strong></li>
        <li><label>Sector laboral</label><strong><?php
        switch($row['sector']) {
          case '0': echo 'No especificado'; break;
          case '1': echo 'Abastecimiento'; break;
          case '2': echo 'Administraci&oacute;n'; break;
          case '3': echo 'Apoderado aduanal'; break;
          case '4': echo 'Asesor&iacute;a en comercio exterior'; break;
          case '5': echo 'Asesor&iacute;a legal internacional'; break;
          case '6': echo 'Asistente de tr&aacute;fico'; break;
          case '7': echo 'Auditor&iacute;a'; break;
          case '8': echo 'Calidad'; break;
          case '9': echo 'Call center'; break;
          case '10': echo 'Capacitaci&oacute;n comercio exterior'; break;
          case '11': echo 'Comercial'; break;
          case '12': echo 'Comercio exterior'; break;
          case '13': echo 'Compras'; break;
          case '14': echo 'Compras internacionales/importaci&oacute;n'; break;
          case '15': echo 'Comunicaci&oacute;n social'; break;
          case '16': echo 'Comunicaciones externas'; break;
          case '17': echo 'Comunicaciones internas'; break;
          case '18': echo 'Consultor&iacute;a'; break;
          case '19': echo 'Consultor&iacute;as comercio exterior'; break;
          case '20': echo 'Contabilidad'; break;
          case '21': echo 'Control de gesti&oacute;n'; break;
          case '22': echo 'Creatividad'; break;
          case '23': echo 'Dise&ntilde;o'; break;
          case '24': echo 'Distribuci&oacute;n'; break;
          case '25': echo 'E-commerce'; break;
          case '26': echo 'Educaci&oacute;n'; break;
          case '27': echo 'Finanzas'; break;
          case '28': echo 'Finanzas internacionales'; break;
          case '29': echo 'Gerencia / direcci&oacute;n general'; break;
          case '30': echo 'Impuestos'; break;
          case '31': echo 'Ingenier&iacute;a'; break;
          case '32': echo 'Internet'; break;
          case '33': echo 'Investigaci&oacute;n y desarrollo'; break;
          case '34': echo 'J&oacute;venes profesionales'; break;
          case '35': echo 'Legal'; break;
          case '36': echo 'Log&iacute;stica'; break;
          case '37': echo 'Mantenimiento'; break;
          case '38': echo 'Marketing'; break;
          case '39': echo 'Medio ambiente'; break;
          case '40': echo 'Mercadotecnia internacional'; break;
          case '41': echo 'Multimedia'; break;
          case '42': echo 'Otra'; break;
          case '43': echo 'Pasant&iacute;as'; break;
          case '44': echo 'Periodismo'; break;
          case '45': echo 'Planeamiento'; break;
          case '46': echo 'Producci&oacute;n'; break;
          case '47': echo 'Producci&oacute;n e ingenier&iacute;a'; break;
          case '48': echo 'Recursos humanos'; break;
          case '49': echo 'Relaciones institucionales / p&uacute;blicas'; break;
          case '50': echo 'Salud'; break;
          case '51': echo 'Seguridad industrial'; break;
          case '52': echo 'Servicios'; break;
          case '53': echo 'Soporte t&eacute;cnico'; break;
          case '54': echo 'Tecnolog&iacute;a'; break;
          case '55': echo 'Tecnolog&iacute;as de la informaci&oacute;n'; break;
          case '56': echo 'Telecomunicaciones'; break;
          case '57': echo 'Telemarketing'; break;
          case '58': echo 'Traducci&oacute;n'; break;
          case '59': echo 'Transporte'; break;
          case '60': echo 'Ventas'; break;
          case '61': echo 'Ventas internacionales/exportaci&oacute;n';
        }
        /* Termine .____. */
        ?></strong></li>
        <li class="sep"><h4>Sus propias palabras</h4></li>
        <li><label>Inter&eacute;ses</label><strong><?=(!empty($row['my_interests']) ? $row['my_interests'] : 'No especificado');?></strong></li>
        <li><label>Hobbies</label><strong><?=(!empty($row['hobbies']) ? $row['hobbies'] : 'No especificado');?></strong></li>
        <li><label>Series de TV favoritas</label><strong><?=(!empty($row['favorite_series']) ? $row['favorite_series'] : 'No especificado');?></strong></li>
        <li><label>M&uacute;sica favorita</label><strong><?=(!empty($row['favorite_music']) ? $row['favorite_music'] : 'No especificado');?></strong></li>
        <li><label>Deportes y equipos</label><strong><?=(!empty($row['favorite_sports']) ? $row['favorite_sports'] : 'No especificado');?></strong></li>
        <li><label>Libros favoritos</label><strong><?=(!empty($row['favorite_books']) ? $row['favorite_books'] : 'No especificado');?></strong></li>
        <li><label>Pel&iacute;culas favoritas</label><strong><?=(!empty($row['favorite_movies']) ? $row['favorite_movies'] : 'No especificado');?></strong></li>
        <li><label>Comida favor&iacute;ta</label><strong><?=(!empty($row['favorite_food']) ? $row['favorite_food'] : 'No especificado');?></strong></li>
        <li><label>Sus heroes son</label><strong><?=(!empty($row['my_heroes']) ? $row['my_heroes'] : 'No especificado');?></strong></li>
    </ul>
    <?php
    } else {
      echo '<div class="redBox">'.$row['nick'].' '.($row['show_info'] == '1' ? 'no comparte su informaci&oacute;n con nadie' : 'solo comparte su informaci&oacute;n con ciertas personas').'</div>';
    }
    ?>
    <div class="clear"></div>

</div></div>
<div style="clear:both"></div>