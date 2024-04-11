<?php
if(!defined($config['define'])) { die; }
?>
<div class="breadcrumb">
<ul>
<li class="first"><a href="/" accesskey="1" class="home"></a></li>
<li><a href="/static/faqs/">FAQ's</a></li>
<li class="last"></li>
</ul>
</div>
<div class="clear"></div>
<a name="indice"></a><div id="box_ayuda_completo"><div style="margin-top:15px;margin-bottom:10px;">
<div class="floatL"><span class="MegaBulletIcons naranja" style="margin-top: -6px;"></span></div>
<div class="floatR"><span class="MegaBulletIcons naranja" style="margin-top: -6px;"></span></div>
<div style="text-align: center; font-size: 26px; font-weight: bold; color: rgb(102, 102, 102);">F.A.Q.s (preguntas frecuentes)</div>
<br></div>
<div class="portal_container">
<div style="text-align: left; font-size: 20px; font-weight: bold; color: rgb(102, 102, 102); class="portal_title"">Indice:</div>
<div class="barra-dashed"></div><ul>
<li><span class="BulletIcons verde"></span> <a href="#0">&iquest;Que es <?=$config['name'];?>?</a></li>
<li><span class="BulletIcons verde"></span> <a href="#1">&iquest;Cual es el objetivo?</a></li>
<li><span class="BulletIcons verde"></span> <a href="#2">&iquest;Como hacer un post?</a></li>
<li><span class="BulletIcons verde"></span> <a href="#3">&iquest;Tengo que estar registrado?</a></li>
<li><span class="BulletIcons verde"></span> <a href="#3.2">&iquest;Porque no veo el post que hice, alguien me lo borr&oacute;?</a></li>
<li><span class="BulletIcons verde"></span> <a href="#3.3">&iquest;Estoy suspendido? &iquest;que hice mal?</a></li>
<li><span class="BulletIcons verde"></span> <a href="#4">&iquest;Para que sirven los puntos?</a></li>
<li><span class="BulletIcons verde"></span> <a href="#5">Puntos &iquest;Como es el tema?</a></li>
</ul>
<br></div>
<br class="space"><br class="space">
<div class="portal_container">
<a name="0"><h2>&iquest;Que es <?=$config['name'];?>?</h2></a>
<div class="barra-dashed"></div>
<?=$config['name'];?> es un sitio de linksharing en el que cualquiera puede hacer posts, ya sea de informaci&oacute;n, ocio, etc.
Fue creado con el fin de hacer un lugar para compartir y hacer amigos, mezclando los formatos de foro y de red social. <br>
<br>
<a name="1"><h2>&iquest;Cual es el objetivo?</h2></a>
<div class="barra-dashed"></div>
Que pases un buen rato navegando por la p&aacute;gina para divertirte y encontrar cosas &uacute;tiles para vos.<br>
	<br>
<a name="2"><h2>&iquest;Como hacer un Post?</h2></a>
<div class="barra-dashed"></div>
    Primero que nada tenes que estar registrado (lo podes hacer desde <a href="/registrarse/">ac&aacute;</a>).<br>

    tenes que clickear en "<a href="/posts/agregar/">postear</a>" (antes de postear leer el <a href="/protocolo/">protocolo</a>)
    En el cuerpo del mensaje usas bbcode para hacer los posts.
<br>

<a name="3"><h2>&iquest;Tengo que estar registrado?</h2></a>
<div class="barra-dashed"></div>
    Si para hacer un Post.<br>
    Si para puntuar posts<br>

    Si para puntuar im&aacute;genes<br>
    Si para ver perfiles de los usuarios<br>
    Si para ver tu monitor de usuario<br>
    Si para comentar posts.<br>
	Si para agregar im&aacute;genes.<br>
	Si para comentar im&aacute;genes.<br>

    Si para agregar posts a "favoritos".<br>
    Si para enviar mensajes privados "MPs".<br>
	Si para agregar im&aacute;genes a "favoritos".<br>
	No para ver posts (excepto los posts privados).<br>
	No para ver la ayuda proporcionada por la web.<br>
<br>
<a name="3.2"><h2>&iquest;Porque no veo el post que hice, alguien me lo borr&oacute;?</h2></a>

<div class="barra-dashed"></div>
    Si no cumplis con el protocolo (<a href="/protocolo/">leelo ac&aacute;</a>) un moderador puede borrarte el post<br>
    Ahora si queres ver el porqu&eacute; del borrado, debes ir a la secci&oacute;n "<a href="/historial-mod/">historial de moderaci&oacute;n</a>" y ahi vas a poder ver tu post eliminado, quien lo elimino y por qu&eacute;
<br>
<a name="3.3"><h2>&iquest;Estoy suspendido? &iquest;que hice mal?</h2></a>

<div class="barra-dashed"></div>
    Basicamente se suspende a un usuario si:
    <ul>
        <li>Entras a <?=$config['name'];?> a generar bardo, floodear, insultar, spamear [Pena: suspencion indefinida]</li>
		<li>No cumplis con el protocolo [Pena: suspencion de 2 d&iacute;as dependiendo de la falta cometida.]</li>
    </ul>
    Cuando un usuario es suspendido m&aacute;s de una vez, los moderadores y admines veremos una lista de llamados de atenci&oacute;n y seguiremos el caso.

<br>
<a name="4"><h2>&iquest;Para que sirven los puntos?</h2></a>
<div class="barra-dashed"></div>
    Los puntos sirven para valorar un post o una im&aacute;gen, en un futuro es probable que se agreguen funciones con el cual se pueda participar con los puntos.
<br>
<a name="5"><h2>Puntos &iquest;Como es el tema?</h2></a>
<div class="barra-dashed"></div>
    Bueno, voy a explicar un poco esto:<br>
    <ul>

    <li>Cuando te <b>registr&aacute;s</b> tomas un valor de 50 puntos, y NUNCA vas a tener menos de cero puntos.</li>
    <li>Cuando haces un <b>post</b>, se te suma cierta cantidad de puntos dadas por el admin.</li>
	<li>Todos los d&iacute;as ten&eacute;s cierta cantidad (de acuerdo al rango) de puntos para puntuar posts o im&aacute;genes (debes haber pasado del rango turista), al puntuar, tus puntos para dar, se te iran descontando. Estos se te seran vueltos a dar todos los d&iacute;as a las 01:00 AM (horario de Argentina).</li>

    </ul></div></div><div style="clear: both;"></div><br class="space"><br class="space">
	<div align="left" style="padding:7px;"><a href="#indice" style="font-size: 18px; font-weight: bold; margin-top: 4px;">[Ir al &iacute;ndice]</a></div><br><hr class="divider"><br class="space">
	<div align="center"><center></center></div>
	<div style="clear: both;"></div>
	<div style="clear:both"></div></div>
	</div>