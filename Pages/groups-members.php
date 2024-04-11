<?php
if(!defined($config['define'])) { die; }
if(!$_GET['id']) { fatal_error('Faltan datos'); }
if(!mysql_num_rows($query = mysql_query('SELECT * FROM `groups` WHERE `url` = \''.mysql_clean($_GET['id']).'\''))) {
  fatal_error('La comunidad no existe');
}
$group = mysql_fetch_assoc($query);
if($group['private'] == '1' && !$logged['id']) { fatal_error('Para ver esta comunidad debes loguearte'); }
if(mysql_num_rows($query2 = mysql_query('SELECT `id`, `status` FROM `groups_members` WHERE `group` = \''.$group['id'].'\' && `user` = \''.$logged['id'].'\''))) {
  $ismember = true;
  list($idmember, $status) = mysql_fetch_row($query2);
}
if(mysql_num_rows(mysql_query('SELECT `id` FROM `groups_ban` WHERE `user` = \''.$logged['id'].'\' && `group` = \''.$group['id'].'\''))) { fatal_error('No puedes ver esto'); }
$currentgroup = $group['id'];
?>
<script>
var group = '<?=$group['id'];?>';

</script>
<style>

.box_cuerpo div.filterBy {
  font-weight: bold;
  text-align:right;
  padding: 5px;
  color: #717171;
  background: #CFCFCF;
  border-bottom:1px solid #CCC;
  -webkit-border-radius:0;
  -moz-border-radius:0;
}

div.filterBy .search-input {
		padding-left: 20px;
		background: url('../search-i.png') no-repeat 3px 3px #FFF;
	margin: 0;
	width:105px;

}

div.filterBy .mBtn {
	padding-top:3px;
	width:8px;
	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	border-radius: 0px;
}
div.filterBy input {
  vertical-align: middle;
  margin: 0;
}

.com_populares ol li a {
  width: 100px;
  overflow:hidden;
  height:16px;
}
.box_cuerpo div.filterBy a {
  color:#2F2F2F;
}

.box_cuerpo div.filterBy a.here {
  color:#FFF;
  background:#8c8c8c;
  font-weight:bold;


    -moz-box-shadow: inset rgba(0, 0, 0, .3) 0 -3px 12px,
                   inset rgba(0, 0, 0, .7) 0  1px  3px;
  -webkit-box-shadow: inset rgba(0, 0, 0, .3) 0 -3px 12px,
                      inset rgba(0, 0, 0, .7) 0  1px  3px;
  padding:1px 8px;
  -moz-border-radius:20px;
  -webkit-border-radius:20px;
  border-radius:20px;
  color:#FFF;
  text-shadow:0 1px 1px #000;
}



.box_cuerpo ol.filterBy {
  position: absolute;
  display: none;
  /*height: 215px;
  _height: 270px;*/
  overflow: hidden;
  width: 270px
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
</style>

<div id="main_content">
<div class="breadcrumb">
<ul>
<li class="first"><a href="/" accesskey="1" class="home"></a></li>
<li><a href="/comunidades/" title="Comunidades">Comunidades</a></li>
<?php
$cat = mysql_fetch_row(mysql_query('SELECT `id`, `name` FROM `groups_categories` WHERE `id` = \''.$group['cat'].'\''));
?>
<li><a href="/comunidades/categoria/<?=$cat[0];?>" title="<?=$cat[1];?>" alt="<?=$cat[1];?>"><?=$cat[1];?></a></li>
<li><a href="/comunidades/<?=$group['url'];?>" title="<?=$group['name'];?>"><?=$group['name'];?></a></li>
<li style="font-weight:bold;">Miembros</li><li class="last"></li>
</ul>

</div>
<?php
include('groups-left.php');
?>
<div class="panel-center" style="width:512px;">
<div id="centro">
	<div class="filterBy">
	<div class="floatL">
		<input id="miembros_list_search" class="search-input" type="text" value="" />&nbsp;<input class="mBtn btnOk" value="&raquo;" onclick="comunidades.miembros_list_search_set(); return false;" type="button" style="padding-left:7px;padding-right:7px;width:auto;" />
	</div>
  <ul>
    <li id="filterBy1" class="here"><a href="#" onclick="comunidades.miembros_list(1);return false;">Miembros</a></li>
    <li id="filterBy2"><a href="#" onclick="comunidades.miembros_list(2);return false;">Suspendidos</a></li>
    <li id="filterBy3"><a href="#" onclick="comunidades.miembros_list(3);return false;">Historial</a></li>
  </ul>
  <span class="gif_cargando floatR"></span>
  <div class="clearBoth"></div>
</div>
</div>
<br class="space" />
<div id="showResult">
<?php
include('./ajax/groups-members-action.php');
?>
</div>
</div>

<div class="panel-right" style="width:267px;">
<div class="box_title_content">
<div class="box_txt">&Uacute;ltimos comentarios</div>
<div class="box_rss"><span class="floatR"><img alt="Actualizar" onclick="comunidades.update_comments_com('<?=$group['url'];?>'); return false;" src="<?=$config['images'];?>/images/icons/reload.png?v3.2.3" style="cursor: pointer;" title="Actualizar"></span></div>
</div>
<div class="box_cuerpo_content">
<span id="ult_comm">
<?php
include('./ajax/groups-comments.php');
?>
</span>
</div>
<br class="space">

<div class="box_title_content">
<div class="box_txt">&Uacute;ltimos Miembros</div>
</div>
<div class="box_cuerpo_content">
<?php
$query = mysql_query('SELECT u.nick, m.`time` FROM `users` AS u INNER JOIN `groups_members` AS m ON m.`user` = u.id WHERE m.`status` = \'0\' && u.`ban` = \'0\' && m.`group` = \''.$group['id'].'\' ORDER BY m.id DESC LIMIT 20') or die(mysql_error());
if(mysql_num_rows($query)) {
  while($r = mysql_fetch_row($query)) {
    echo '<font class="size11"><b><a href="/perfil/'.$r[0].'" title="'.$r[0].'" alt="'.$r[0].'">'.$r[0].'</a></b> - se uni&oacute; el '.date('d.m.Y', $r[1]).' a las '.date('G.i', $r[1]).' </font><br style="margin: 0px; padding: 0px;">';
  }
} else { echo '<div class="redbox">Nada por aqu&iacute;...</div>'; }
?>

</div>
<br class="space">
</div>
<div style="clear:both"></div></div>
</div></div>
