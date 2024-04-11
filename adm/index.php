<?php
if(!defined($config['define']) && !defined('adm')) { include('../404.php'); die; }
?>
<div id="adm-right" >
<div class="box_title_content"><div class="box_txt">Administraci&oacute;n de <?=$config['name'];?></div></div>
<div class="box_rss"></div>

<div class="box_cuerpo_content">
<div class="size15">Hola <b style="color:#004A95"><?=$logged['nick'];?></b>, bienvenido a el admin de <b style="color:#004A95"><?=$config['name'];?></b>.</div>
<br><div class="size13">
<span class="BulletIcons rojo"></span> No toques ni hagas cualquier acci&oacute;n que conlleve al mal funcionamiento de la web. <br>
<span class="BulletIcons rojo"></span> Si no sabes como manejarte en esta secci&oacute;n, &iexcl;Por favor consulta antes de actuar!. <br>

<span class="BulletIcons rojo"></span> Estas herramientas se te dan para uso &uacute;nica y exclusivamente de esta web</div>
<br><div class="size17" style="color:#FF6600"><b>Protocolo de moderadores:</b></div>
<div class="barra-dashed"></div>
<div class="size13">Un moderador es un usuario con mayores privilegios en la web, con lo cual implica una mayor responsabilidad.
<div class="barra-dashed"></div>
Un error de uno, es un error de todos.
<div class="barra-dashed"></div>
Hacer un post puede llevar mucho tiempo y dedicaci&oacute;n, y debe ser igualmente proporcional al tiempo para evaluar si un post debe ser borrado o editado.
<div class="barra-dashed"></div>
Un moderador no puede insultar, maltratar, trollear, ni burlarse de los dem&aacute;s. Si nosotros lo hacemos, lo estamos permitiendo.</div>
<div class="barra-dashed"></div>
<div class="size17" style="color:#FF6600"><b>Importante para moderar:</b></div>
<hr>
- Todo contenido que se comenta en: comunicaciones de moderador o las normas que estan en esta hoja, no decirlo en publico. tampoco decir quien esta baneado y quien no. (<b>NO SACAR CAPTURAS Y DIFUNDIRLAS</b>)
<hr>
<b>Sobre el ban:</b>
<table align="center" width="100%" valign="top" style="margin:0px;padding:0px;"><tbody><tr valign="top"><td width="200px" valign="top" style="border:1px solid #7C7C7C;background:#D0D0D0;">Motivos</td><td width="200px" valign="top" style="border:1px solid #7C7C7C;background:#D0D0D0;">Cantidad de días</td><td width="200px" valign="top" style="border:1px solid #7C7C7C;background:#D0D0D0;">Captura de pantalla</td></tr>
<tr valign="top"><td valign="top" style="border:1px solid #7C7C7C;;">Spam en comentarios y MP.</td><td valign="top" style="border:1px solid #7C7C7C;">* 15 días p/user conocido. Caso contrario, de por vida.<br>* User recurrente, de por vida.</td><td valign="top" style="border:1px solid #7C7C7C;">No es necesario.-</td></tr>
<tr valign="top"><td valign="top" style="border:1px solid #7C7C7C;">Insultos o Comentarios fuera de lugar (<span style="color:#FF9400;" alt="adj. y s. Que siente odio u hostilidad hacia los extranjeros." title="adj. y s. Que siente odio u hostilidad hacia los extranjeros.">Xenófobos</span>, Discriminatorios, etc).</td><td valign="top" style="border:1px solid #7C7C7C;">* 5 días p/usuario conocido. Caso contrario, de por vida.<br>* Usuario recurrente, de por vida.</td><td valign="top" style="border:1px solid #7C7C7C;">Si es necesario.-</td></tr>
<tr valign="top"><td valign="top" style="border:1px solid #7C7C7C;">Insultos/Ataques/Burlas entre Usuarios en comentarios, MP o Muro.</td><td style="border:1px solid #7C7C7C;">* 10 días p/usuario<br>Caso contrario, de por vida.<br>* Usuario recurrente, de por vida.</td><td valign="top" style="border:1px solid #7C7C7C;">Si es necesario.-</td></tr>
<tr valign="top"><td valign="top" style="border:1px solid #7C7C7C;">Suma dudosa de Puntos.</td><td valign="top" style="border:1px solid #7C7C7C;">* 30 días.<br>* Definitivo, en caso de haber sido suspendido y recurre en igual falta.</td><td valign="top" style="border:1px solid #7C7C7C;">Si es necesario.-</td></tr>
<tr valign="top"><td valign="top" style="border:1px solid #7C7C7C;">IP Clonada.</td><td style="border:1px solid #7C7C7C;">* 10 días.<br>* Definitivo, en caso de haber sido suspendido y recurre en igual falta.</td><td style="border:1px solid #7C7C7C;">No es necesario.-</td></tr></tbody></table>
* Si un usuario es suspendido por un <b>MOD</b> ese usuario <b>DEBE</b> cumplir la pena.
<br>
* Si un MOD levanta la suspensión de un Usuario sin consulta previa al que lo realizó, se lo deshabilitará de Moovax! tarde o temprano.
<br>
* JAMAS deberán bannearse entre MOD’s, el que lo haga deberá atenerse a la decisión que tome el resto de sus compañeros.
<br> 
<hr>
<b class="size12">Puntos importantes:</b>
<br>
<span class="size11" style="color:green;">
* Cuando se elimina un post y la causa es RePost agregar el ID del post principal (No es necesario agrear link completo, con ID solo ya esta).
<br>
* Cuando en un post está roto el enlace fijarse si se puede repara, si no se puede eliminar post.
<br>
* Solo los posts en la categoría Noticias requieren fuente.
</span>
</div>
<?php
$query = mysql_query('SHOW TABLE STATUS');
$n = 0;
while($r = mysql_fetch_assoc($query)) {
  $n += $r['Data_length'];
}
$n = round(($n/1048576), 2);
?>
<span class="size11">
<div class="floatR">
P&aacute;gina creada y dise&ntilde;ada por <strong>IgnacioViglo</strong> | Administrada por: <strong>DjAlan98</strong></div>
<div class="floatL">
Peso de la base de datos: <strong><?=$n;?></strong> mb
</div>
</span>

<div class="clear"></div></div>