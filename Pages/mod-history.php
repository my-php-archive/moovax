<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('No puedes ver el historial de moderaci&oacute;n si no est&aacute;s logueado'); }
if(!$_GET['tab'] || ($_GET['tab'] != 'posts' && $_GET['tab'] != 'photos')) { $_GET['tab'] = 'posts'; }
?>
<script>
function history_tab(accion) {
  if(accion == actual) { return false; }
  $.ajax({
    beforeSend: function() { $('#mod_filter').css('opacity', 0.3); },
    type: 'POST',
    url: '/ajax/history-' + (accion == 'posts' ? 'posts' : 'photos') + '.php',
    data: 'tab=' + accion + '&ajax=true',
    success: function(t) {
      switch(t.charAt(0)) {
        case '0':
          alert(t.substring(2));
          break;
        case '1':
          $('#mod_filter').html(t.substring(2));
          $('#tab' + actual).removeClass('here');
          $('#tab' + accion).addClass('here');
          actual = accion;
          break;
      }
    },
    complete: function() {
      $('#mod_filter').css('opacity', 1);
    },
  });
}
</script>
<div class="breadcrumb">
  <ul>
      <li class="first"><a href="/" accesskey="1" class="home"></a></li>
  	<li><a href="/mod-histoy/">Historial de moderaci&oacute;n</a></li>
  	<li class="last"></li>
  </ul>
</div>
<div class="clear"></div>
<form action="/mod-history/" method="post" accept-charset="UTF-8">

<span class="floatR">
    <b class="size12">Filtrar por:</b>
	<span class="filter_box">
	    <span class="filterBy">
			<a id="tabposts" href="/mod-history/posts/" onclick="history_tab('posts'); return false;"<?=($_GET['tab'] == 'posts' ? ' class="here"' : '');?>>Posts</a> -
			<a id="tabphotos" href="/mod-history/photos/" onclick="history_tab('photos'); return false;"<?=($_GET['tab'] == 'photos' ? ' class="here"' : '');?>>Fotos</a>
		</span>
	</span>
</span>
<div class="clear"></div>
<br class="space">
<div id="mod_filter">
<?php
include('./ajax/history-'.$_GET['tab'].'.php');
?>
</div>
</div>
<div class="clear"></div>
<div class="clear"></div>
<br class="space">
<!--<span class="floatR"><input class="Boton BtnPurple" type="submit" name="eliminar" value="Limpiar Historial" /></span><div class="clear"></div> -->
</form><div style="clear:both"></div></div>
</div>