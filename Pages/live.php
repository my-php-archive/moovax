<?php
ob_end_flush();
if(!defined($config['define'])) { die; }
?>
<style type="text/css">
.categoriaList li label {
	float: left;
}
#live #PlayPause {
	text-align: center;
	padding: 3px 0;
	display: block;
	margin: 5px;
	float: right;
	cursor:	pointer;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
}
#live #live #PlayPause:active {
	background-color: #C1C1C1;
}
#live table#liveBoard {
	width: 740px;
	font-size: 13px;
}
#live table#liveBoard th{
	margin: 0;
	color: #FFF;
	padding: 8px;
	text-align: left;
	text-transform: uppercase;
	background: #004a95;
	border-bottom: 1px solid #05325f;
}
#live table#liveBoard tr {
	background: #EEE;
}
#live table#liveBoard th.usuario {
	border-left: 5px solid #004a95!important;
	-moz-border-radius-topleft: 5px;
	-webkit-border-radius-topleft: 5px;
	border-radius-topleft: 5px;
}
#live table#liveBoard th.accion{
	width: 185px;
}
#live table#liveBoard th.titulo{
	-moz-border-radius-topright: 5px;
	-webkit-border-radius-topright: 5px;
	border-radius-topright: 5px;
}
#live table#liveBoard td{
	margin: 0;
	padding: 5px;
	color: #FFF!important;
	border-bottom: 1px solid #CCC;
	border-top: 1px solid #FFF;
}
#live table#liveBoard td a {
	margin: 0;
	font-weight: bold;
	color: #777!important;
	width: 90px;
	overflow: hidden;
}

#live table#liveBoard td.usuario a{
	display: block;
}

#live table#liveBoard td.usuario, #live table#liveBoard th.usuario {
	width: 100px;
	overflow: hidden;
}
#live .categoriaList ul li stong {
	color: #000;
}
#live table#liveBoard  td.accion {
	font-weight: bold;
	width: 185px;
}
#live table#liveBoard  th.titulo,#live table#liveBoard  td.titulo{
	overflow: hidden;
}
#live table#liveBoard tr.post td.accion {
	color: #004a95!important;
}
#live table#liveBoard tr.comentario td.accion  {
	color: #f7941d!important;
}
#live table#liveBoard tr.comunidad td.accion  {
	color: #007236!important;
}
#live table#liveBoard tr.tema  td.accion {
	color: #7cc576!important;
}
#live table#liveBoard tr.usuario td.accion {
	color: #ed145b!important;
}
#live table#liveBoard tr.photo td.accion {
	color: #00BFFF!important;
}
#live table#liveBoard tr.photo td.accion {
	color: #00BFFF!important;
}
#live table#liveBoard tr.wall td.accion {
	color: #F5A9A9!important;
}


/* Estadisticas / filtros */
#live .categoriaList h6{
	float: left;
	background: none;
	margin: 0;
}
#live .categoriaList ul{
	background: url("/images/hrline.gif") repeat-x scroll left top transparent;
}
#live .categoriaList ul li{
	color: #8D8D8D;
}
#live .categoriaList ul li span.number{
	color: #000;
	display: block;
	font-weight: bold;
	margin-right: 10px;
}
.categoriaList {
  -moz-border-radius:10px;
  background:#EAEAEA;
}

.categoriaList ul {
  padding-bottom:10px;
}

.categoriaList li {
  position:relative;
  font-size:12px;
  line-height:16px;
  padding:2.5px 0 2.5px 8px;
}

.column {
  width: 55px;
  margin:0 5px;
}
.categoriaList  {
	-moz-border-radius: 5px;
	border: 1px solid #CCC;
	background: #f6f6f6;
	margin-bottom: 10px;
}
.categoriaList h6 {
	margin: 0 0 10px 0;
	font-size: 13px;
	font-weight: bold;
	padding: 8px 0 10px 8px;
	background: url('/images/hrline.gif') bottom left repeat-x;
}

.estadisticasList ul{
	font-family: Helvetica, Arial;
}

.estadisticasList ul li a span.number {
		font-weight: bold;
		display: block;
		color: #000;
		margin-right: 10px;
}

.estadisticasList ul li a {
	color: #8d8d8d;
	display: block;
}
.estadisticasList ul{
	font-family: Helvetica, Arial;
}

.estadisticasList ul li a:hover {
	color: #000!important;
	text-decoration: none;
}

.estadisticasList ul li:hover {
	background: #fcfcfc;
}
/* new clearfix */
.clearfix:after {
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;
	}
* html .clearfix             { zoom: 1; } /* IE6 */
*:first-child+html .clearfix { zoom: 1; } /* IE7 */
#estadisticas {

}


</style>
<div id="cuerpocontainer">
<!-- inicio cuerpocontainer -->

<script src="/js/live.js?1.1" type="text/javascript"></script>
	<script type="text/javascript">
		var live_data = <?php include('./ajax/live.php'); ?>;
		$(document).ready(function(){
			live.calcVel(1000); //Velocidad inicial
			live.inicializar();
		});
	</script>
	<div id="live">
		<div id="template-liveBoard"><!--
			<tr class="__class__">
				<td class="usuario">
					<a href="/perfil/__nick__" target="_blank">__nick__</a>
				</td>
				<td class="accion">__accion_name__</td>
				<td class="titulo">
					<a href="__url__" target="_blank">__titulo__</a>
				</td>
			</tr>
		--></div>
		<div style="float:left; width:705px">
			<div class="">
				<h2 style="font-size: 24px;font-family:Helvetica,Arial"><?=$config['name']?> al minuto</h2>
			</div>
			<table id="liveBoard" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th class="usuario">Usuario</th>
						<th class="accion">Acci&oacute;n</th>
						<th class="titulo">T&iacute;tulo</th>
					</tr>
				</thead>
				<tbody></tbody>

			</table>
		</div>
		<div style="width:210px; float:right">
			<div id="estadisticass" class="categoriaList estadisticasList">
				<div class="clearfix">
					<h6>Estad&iacute;sticas</h6>
					<span id="PlayPause"><img src="<?=$config['images'];?>/images/icon_pause.png" alt="" /></span>
                </div>
				<ul>
					<li class="clearfix"><span class="floatL">Tiempo</span><span id="time" class="floatR number">00:00:00</span></li>
					<li class="clearfix"><span class="floatL">Velocidad actual</span><span id="velocidad" class="floatR number" title="Medido en acciones por segundo">0 a/s</span></li>
					<li class="clearfix"><span class="floatL">Acciones totales</span><span id="total" class="floatR number">0</span></li>
				</ul>
			</div>
			<div id="filtros" class="categoriaList">
				<div class="clearfix">
				<h6>Filtrar Actividad</h6>
				</div>
				<ul>
					<span class="accionObjeto_post">
						<li class="clearfix"><strong>Posts</strong></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/post.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('post', 'agregar')">Nuevos</label><span class="accionTipo_agregar floatR number">0</span></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/puntos.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('post', 'votar')">Votados</label><span class="accionTipo_votar floatR number">0</span></li>
						<!--<li class="clearfix"><label><span class="icon-noti favoritos-n"></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('post', 'favorito')">Favoritos</label><span class="accionTipo_favorito floatR number">20</span></li>-->
						<!--<li class="clearfix"><label><span class="icon-noti follow-n"></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('post', 'seguir')">Seguidores</label><span class="accionTipo_seguir floatR number">2</span></li>-->
					</span>

					<span class="accionObjeto_comentario">
						<li class="clearfix"><strong>Comentarios</strong></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/comentario.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('comentario', 'agregar')">Nuevos</label><span class="accionTipo_agregar floatR number">0</span></li>
						<!--<li class="clearfix"><label><span class="thumbs thumbsUp"></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('comentario', 'votar')">Votados</label><span class="accionTipo_votar floatR number">56</span></li>-->
					</span>

					<span class="accionObjeto_comunidad">
						<li class="clearfix"><strong>Comunidades</strong></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/comment_add.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('comunidad', 'agregar')">Nuevas</label><span class="accionTipo_agregar floatR number">0</span></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/user_add.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('comunidad', 'participar')">Miembros</label><span class="accionTipo_participar floatR number">0</span></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/like.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('comunidad', 'recomendar')">Recomendaciones</label><span class="accionTipo_recomendar floatR number">0</span></li>
					</span>

					<span class="accionObjeto_tema">
						<li class="clearfix"><strong>Temas</strong></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/post.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('tema', 'agregar')">Nuevos</label><span class="accionTipo_agregar floatR number">0</span></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/quote.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('tema', 'respuesta-agregar')">Respuestas</label><span class="accionTipo_respuesta-agregar floatR number">0</span></li>
					</span>

					<span class="accionObjeto_usuario">
						<li class="clearfix"><strong>Usuarios</strong></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/favorito.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('usuario', 'friend')">Seguidores</label><span class="accionTipo_seguir floatR number">0</span></li>
					</span>
                    <span class="accionObjeto_photo">
						<li class="clearfix"><strong>Fotos</strong></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/post.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('photo', 'agregar')">Nueva</label><span class="accionTipo_agregar floatR number">0</span></li>
                        <li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/quote.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('photo', 'comment')">Comentario</label><span class="accionTipo_comment floatR number">0</span></li>
					</span>
                    <span class="accionObjeto_wall">
						<li class="clearfix"><strong>Muros</strong></li>
						<li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/post.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('wall', 'agregar')">Nuevas entradas</label><span class="accionTipo_agregar floatR number">0</span></li>
                        <li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/quote.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('wall', 'comentario')">Respuestas</label><span class="accionTipo_comentario floatR number">0</span></li>
                        <li class="clearfix"><label><span><img src="<?=$config['images'];?>/images/notificaciones/like.png" /></span><input type="checkbox" autocomplete="off" checked="checked" onchange="live.changeFiltro('wall', 'votar')">Likes</label><span class="accionTipo_votar floatR number">0</span></li>
					</span>
				</ul>
			</div>
		</div>
	</div>
	<div style="clear:both"></div>
</div></div></div>
