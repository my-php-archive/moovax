<?php
if(!defined($config['define'])) { die; }
?>
<script type="text/javascript">
$(document).ready(function() {
  $.getScript('/js/my-groups_beta.js', function() {
    mygroups.groups = [{"url":"thecraperos","name":"The Craperos @Crecemos [._.]","avatar":"http://i.imgur.com/J91ub.jpg","cat":"Diversi&oacute;n y Esparcimiento","fdesc":"Aca podras trollear, aserte el malote , dejar de lado tu rango..en pocas palabras CRAP xD","desc":"Aca podras trollear, aserte el malote , dejar de lado tu rango..en pocas palabras CRAP xD...","members":"33","posts":"94","rank":"Crapero"}];
    mygroups.tp = 1;
    mygroups.order[0] = [0];
    mygroups.order[1] = [0];
    mygroups.order[2] = [0];
    mygroups.order[3] = [0];
    mygroups.order[4] = [0];
    mygroups.current_groups = mygroups.groups;
    mygroups.show();
})});
</script>
<style>
div.filterBy, .paginatorBar {
  background: #f3f3f3;
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  padding: 8px;
}

.paginatorBar a, .paginator a {
  font-weight:bold;
  padding: 5px 10px;
  color: #FFF;
  background: #383838;
 	-moz-border-radius: 3px;
 	-webkit-border-radius: 3px;
 	display:block;
}

.paginadorCom .next a, .paginadorCom .before a {
  font-weight:bold;
  padding: 5px 10px;
  color: #FFF;
  background: #383838;
 	-moz-border-radius: 3px;
 	-webkit-border-radius: 3px;
}
div.filterBy a {
	color:#2f2f2f
}
div.filterBy ul {
  float: right;
}


div.filterBy ul li {
  float: left;
  margin-left: 10px;
  color: #383838;
  font-weight:bold;
  background:#999;
 	-moz-border-radius: 3px;
 	-webkit-border-radius: 3px;
 	border-bottom:1px solid #FFF;
}

div.filterBy ul li a  {
  color: #FFF;
  font-weight:bold;
  padding: 5px 10px;
  display: block;
}

div.filterBy ul li:hover {
  background:#002561

}

div.filterBy ul li:hover a  {
  color: #FFF;

}

div.filterBy ul li.here {
  background: none;
  font-weight: bold;
  color: #FFF;
  background: #34569d;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
}

div.filterBy ul li.here a {
  color: #FFF;
}


div.filterBy ul li select {
  margin: 3px 0 0 5px;
}
.orderTxt {
  border-bottom: none!important;
  padding-top:5px;
  background:none!important;
}

.memberInfo {
	width: 33%;
	float: left;
}

.memberInfo a {
	font-size: 12px;
	font-weight: bold;
	color: #053e78;
}
.memberInfo img {
  width: 60px;
  height: 60px;
  display: block;
	padding: 1px;
	border: 1px solid #C1C1C1;
  margin-top: 5px;
}

a.btnNegative,a.btnPositive, a.btnNeutral {
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  color:#FFF;
  display:block;
  margin:10px 0 0;
  padding:5px;
}
</style>
<div id="cuerpocontainer">
<div class="comunidades">

<div class="breadcrump">
<ul>
<li class="first"><a href="/comunidades/" title="Comunidades">Comunidades</a></li><li>Mis comunidades</li><li class="last"></li>
</ul>
<input style="float:right;height:18px;padding:5px;_width:300px;width:320px;margin-right:180px;color:#ccc;" value="Buscar" onfocus="if(this.value=='Buscar'){this.value='';this.style.color='#000';}" onblur="if(this.value==''){this.value='Buscar';this.style.color='#CCC';}" onkeyup="mygroups.show(this.value, true);" type="text" />
</div>
 	<div style="clear:both"></div>

<div style="width:200px;float:right;">
<div class="box_title"></div>
<div class="box_cuerpo ads">
<center></center>
</div>
</div>
	<div style="width:700px;float:left;">

<div class="filterBy">
	<div class="floatL xResults">
		Mostrando <strong id="dstde">1 - 1</strong> resultados de <strong id="tgr">1</strong>
	</div>
	<ul class="floatR">
		<li class="orderTxt">Ordenar por:</li>
		<li><a href="#" onclick="mygroups.show('0');return false;">Nombre</a></li>
		<li class="here"><a href="#" onclick="mygroups.show('1');return false;">Rango</a></li>
		<li><a href="#" onclick="mygroups.show('2');return false;">Miembros</a></li>
		<li><a href="#" onclick="mygroups.show('3');return false;">Temas</a></li>
		<li><a href="#" onclick="mygroups.show('4');return false;">Actividad</a></li>
	</ul>
      <span id="mygroups_loading" class="gif_loading floatR"></span>
	<div class="clearBoth"></div>
</div> <!-- FILTER BY -->

<div id="showResult" class="resultFull">
</div>

<!-- Paginado -->
<!-- FIN - Paginado -->

</div>

</div>
<div style="clear:both"></div>
</div></div></div> <!--cc-->