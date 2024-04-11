<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('Logueate'); }
$query = mysql_query('SELECT d.`id`, d.`title`, d.`type`, d.`cat`, d.`cause`, d.`time`, cat.`url`, cat.`name` FROM `drafts` AS d INNER JOIN categories AS cat ON cat.id = d.cat WHERE d.`author` = \''.$logged['id'].'\'') or die(mysql_error());
$cad = array();
while($row = mysql_fetch_assoc($query)) {
  $row['imagen'] = $row['url'];
  $row['url'] = '/posts/agregar/'.$row['id'];
  $row['fecha_print'] = date('d/m/Y', $row['time']).' a las '.date('G.i', $row['time']);
  $row['type'] = $row['type'] == 0 ? 'borradores' : 'eliminados';
  $row['borrador'] = 1;
  $cad[] = json_encode($row);
}
?>
<script type="text/javascript" src="/js/drafts.js"></script>
<div id="borradores">
<script type="text/javascript">
    var borradores_data = [<?=implode(',', $cad);?>];
</script>
<div class="clearfix">
<div class="left" style="float:left;width:200px">
<div class="boxy">
<div class="boxy-title">
<h3>Filtrar</h3>
<span></span>
</div><!-- boxy-title -->
<div class="boxy-content">
<h4>Mostrar</h4>
<ul class="cat-list" id="borradores-filtros">
<li id="todos" class="active"><span class="cat-title"><a href="" onclick="borradores.active(this); borradores.filtro = 'todos'; borradores.query(); return false;">Todos</a></span> <span class="count"></span></li>
<li id="borradores"><span class="cat-title"><a href="" onclick="borradores.active(this); borradores.filtro = 'borradores'; borradores.query(); return false;">Borradores</a></span> <span class="count"></span></li>
<li id="eliminados"><span class="cat-title"><a href="" onclick="borradores.active(this); borradores.filtro = 'eliminados'; borradores.query(); return false;">Eliminados</a></span> <span class="count"></span></li>
</ul>
<h4>Ordenar por</h4>
<ul id="borradores-orden" class="cat-list">
<li class="active"><span><a href="" onclick="borradores.active(this); borradores.orden = 'time'; borradores.query(); return false;">Fecha guardado</a></span></li>
<li><span><a href="" onclick="borradores.active(this); borradores.orden = 'title'; borradores.query(); return false;">T&iacute;tulo</a></span></li>
<li><span><a href="" onclick="borradores.active(this); borradores.orden = 'name'; borradores.query(); return false;">Categor&iacute;a</a></span></li>
</ul>
<h4>Categorias</h4>
<ul class="cat-list" id="borradores-categorias">
<li id="todas" class="active"><span class="cat-title active"><a href="" onclick="borradores.active(this); borradores.categoria = 'todas'; borradores.query(); return false;">Ver todas</a></span> <span class="count"></span></li>
</ul>
</div><!-- boxy-content -->
</div>
</div>
<div style="float:left;margin-left:10px;width:753px">
<div class="boxy">
<div class="boxy-title">
<h3>Posts</h3>
<label for="borradores-search" style="color: rgb(153, 153, 153); float: right; position: absolute; right: 135px; z-index: 20; display: block; top:5px;">Buscar</label><input type="text" id="borradores-search" value="" onKeyUp="borradores.search(this.value, event)" onFocus="borradores.search_focus()" onBlur="borradores.search_blur()" autocomplete="off" />
</div>
<div id="res" class="boxy-content">
<ul id="resultados-borradores">
<?php
if(!mysql_num_rows($query)) { echo '<div class="redBox">No tienes ning&uacute;n borrador ni post eliminado.</div>'; }
?>
</ul>
</div>
</div>
</div>
</div>
<div id="template-result-borrador" style="display:none">
<li id="borrador_id___id__">
<a title="__categoria_name__" class="categoriaPost __categoria__ __tipo__" href="__url__" onclick="__onclick__">__titulo__</a>
<span class="causa">Causa: __causa__</span>
<span class="gray">&Uacute;ltima vez guardado el __fecha_guardado__</span> <a style="float:right" href="" onclick="borradores.eliminar(__borrador_id__, true); return false;"><img src="<?=$config['images'];?>/images/icons/borrar.png" alt="eliminar" title="Eliminar Borrador" /></a>
</li>
</div>
</div>
<div style="clear:both"></div></div></div>