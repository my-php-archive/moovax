<?php
if(!defined('adm')) { die; }
if(!$_GET['f'] || !in_array($_GET['f'], array('photos', 'users', 'posts'))) { $_GET['f'] = 'posts'; }
if(!allow('complaints_'.$_GET['f'])) { fatal_error('No tene&eacute;s permisos para est&aacute;r ac&aacute'); }
?>

<!-- end -->
<span class="floatR">
	<b class="size12">Filtrar por:</b>
		<span class="filter_box">
			<span class="filterBy">
			<a id="tabposts" href="/admin/denuncias/posts/" onclick="admin.filter_denuncias('posts'); tabs.filterComms('posts'); return false;"<?=($_GET['f'] == 'posts' ? ' class="here"' : '');?>>Posts</a> -
			<a id="tabphotos" href="/admin/denuncias/photos/" onclick="admin.filter_denuncias('photos'); tabs.filterComms('photos'); return false;"<?=($_GET['f'] == 'photos' ? ' class="here"' : '');?>>Fotos</a> -
			<a id="tabusers" href="/admin/denuncias/users/" onclick="admin.filter_denuncias('users'); tabs.filterComms('users'); return false;"<?=($_GET['f'] == 'users' ? ' class="here"' : '');?>>Usuarios</a>
			<script type="text/javascript">var filterCommsHere = '<?=$_GET['f'];?>';</script>
			</span>
		</span>
</span>
<div class="clear"></div>
<br class="space">
<div class="box_title_content"><div class="box_txt">Denuncias (<span id="section"><?=$_GET['f'];?></span>)</div></div>
<div class="box_rss"></div>
<div class="box_cuerpo_content" style="background-color:#FFF">
  <div id="error_filter" class="displayN"></div>
  <div id="get_filter">
  <?php
  include('./ajax/admin-complaints.php');
  ?>
  </div>
</div>
<br class="space">
<span class="floatL"><input class="Boton Small BtnGray" onclick="location.href='javascript:history.go(-1)'" value="Volver al admin" type="button" /></span>
<span class="floatR"><input class="Boton Small BtnPurple" onclick="location.href='/admin-area/denuncias-eliminar/'" value="Eliminar todas las denuncias" type="button" /></span><div class="clear"></div>