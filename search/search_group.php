<?php
if(!defined('search')) { die; }
unset($en);
$display = ''; //HTML&nb
$q = htmlspecialchars($q);
$times = array(2 => array('86400', '&Uacute;litmas 24 horas'), 3 => array('604800', '&Uacute;ltima semana'), 4 => array('2592000', '&Uacute;ltimo mes'), 5 => array('31536000', '&Uacute;ltimo a&ntilde;o'));
if($sort > 3 || $sort < 1 || !ctype_digit($sort)) { $sort = 1; }
$query = 'SELECT g.*, u.nick, COUNT(DISTINCT m.id) AS members, COUNT(DISTINCT t.id) AS topics, cat.`name` AS namecat, cat.`url` AS urlcat, cat.`img` FROM `groups` AS g INNER JOIN `users` AS u ON u.id = g.`author` LEFT OUTER JOIN `groups_members` AS m ON m.group = g.id LEFT OUTER JOIN `groups_topics` AS t ON t.group = g.id INNER JOIN `groups_categories` AS cat ON cat.id = g.cat WHERE g.`status` = \'0\' && MATCH(g.`name`) AGAINST(\''.mysql_clean($q).'\')';
if($autor != '-1' && mysql_num_rows($f = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `nick` = \''.mysql_clean($autor).'\''))) {
  list($id_user, $nick) = mysql_fetch_row($f);
  $query .= ' && u.id = \''.$id_user.'\'';
  $display .= '<span><strong>Autor: '.$nick.'</strong><a href="'.$config['search_url'].'/comunidades/?q='.$q.'&cat='.$cat.'&sort='.$sort.'&date='.$date.'&autor=-1"></a></span>';
}
if($date != '-1' && array_key_exists($date, $times)) {
  $query .= ' && g.`time` > \''.(time()-$times[$date][0]).'\'';
  $display .= '<span><strong>Tiempo: '.$times[$date][1].'</strong><a href="'.$config['search_url'].'/comunidades/?q='.$q.'&cat='.$cat.'&sort='.$sort.'&autor='.$autor.'&date=-1"></a></span>';
}
if($cat != '-1' && mysql_num_rows($cats = mysql_query('SELECT `id`, `name` FROM `groups_categories` WHERE `url` = \''.mysql_clean($cat).'\''))) {
  $r = mysql_fetch_row($cats);
  $query .= ' && cat.id = \''.$r[0].'\'';
  $display .= '<span><strong>Categor&iacute;a: '.$r[1].'</strong><a href="'.$config['search_url'].'/comunidades/?q='.$q.'&sort='.$sort.'&autor='.$autor.'&date='.$date.'&cat=-1"></a></span>';
}
$query .= ' GROUP BY g.id ORDER BY `'.($sort == 1 ? 'time' : ($sort == 2 ? 'members' : 'topics')).'` DESC';
$per = 40;
$num = mysql_num_rows(mysql_query($query));
$tot = ceil($num / $per);
$p = isset($_GET['p']) && ctype_digit($_GET['p']) && $_GET['p'] <= $tot ? $_GET['p'] : 1;
$limit = ($p-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per) or die(mysql_error());
?>
<div class="container clearfix">
<div id="sidebar">
  <div class="filter-box">
    <h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Buscar en</a></h6>
    <ul>
      <li class="clearfix"><a class="active" href="<?=$config['search_url'];?>/comunidades/?q=<?=$q;?>"><span>Comunidades</span></a></li>
      <li class="clearfix"><a href="<?=$config['search_url'];?>/temas/?q=<?=$q;?>"><span>Temas</span></a></li>
    </ul>
  </div>
  <div class="filter-box">
    <h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Creado</a></h6>
    <ul>
      <li class="clearfix"><a href="<?=$config['search_url'];?>/comunidades/?q=<?=$q;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&sort=<?=$sort;?>&date=2"><span>&Uacute;ltimas 24 horas</span></a></li>
      <li class="clearfix"><a href="<?=$config['search_url'];?>/comunidades/?q=<?=$q;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&sort=<?=$sort;?>&date=3"><span>&Uacute;ltima semana</span></a></li>
      <li class="clearfix"><a href="<?=$config['search_url'];?>/comunidades/?q=<?=$q;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&sort=<?=$sort;?>&date=4"><span>&Uacute;ltimo mes</span></a></li>
      <li class="clearfix"><a href="<?=$config['search_url'];?>/comunidades/?q=<?=$q;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&sort=<?=$sort;?>&date=5"><span>&Uacute;ltimo a&ntilde;o</span></a></li>
    </ul>
  </div>
  <div class="filter-box">
    <h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Categoria</a></h6>
    <select style="width: 140px" onchange="search.categoria('<?=$config['search_url'];?>/comunidades/?autor=<?=addslashes($autor);?>&sort=<?=addslashes($sort);?>&date=<?=addslashes($date);?>', '<?=$q;?>', this.value)">
      <option value="-1" selected="selected"></option>
      <?php
      $f = mysql_query('SELECT `url`, `name`, `id` FROM `groups_categories` ORDER BY `name` ASC');
      while($fe = mysql_fetch_row($f)) {
        echo '<option'.($fe[2] == $r[0] ? ' selected="selected"' : '').' value="'.$fe[0].'">'.$fe[1].'</option>'."\n";
      }
      ?>
    </select>
  </div>
  <div class="filter-box">
    <h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Autor</a></h6>
    <script>
    var few = '<?=$config['search_url'];?>/comunidades?cat=<?=addslashes($cat);?>&sort=<?=addslashes($sort);?>&date=<?=addslashes($date);?>';
    </script>
    <input type="text" style="width: 105px;float:left" value="<?=($autor != '-1' ? $autor : '');?>" autocomplete="off" title="Buscar por Usuario" onkeypress="search.autor_intro(event, few, '<?=$q;?>', this.value, 1)" />
    <input type="button" class="sbutton" value="&raquo;" onclick="search.autor_submit(few, '<?=addslashes($q);?>', $(this).prev().val(), 1)" />
  </div>
  <div class="clearfix clearBoth" style="clear:both"></div>
</div>
<div id="results" class="results">
<!-- Suggest -->
<p class="suggest" style="display:none">
	<span>Quisiste decir:</span> <a href=""></a> ?
</p>
<script type="text/javascript">search.suggest("<?=$q;?>", "<?=$q;?>", "<?=$q;?>", '/comunidades?&q=');</script><!-- /Suggest -->
<?php if(!empty($display)) { echo '<div class="filters-apply clearfix"> '.$display.' </div>'; } ?>
<!-- Sort -->
<div class="filter-bar clearfix">
  <span>Ordenar por:</span>
  <ul>
    <li<?=($sort == '-1' || $sort == '1' ? ' class="selected"' : '');?>><a href="<?=$config['search_url'];?>/comunidades?q=<?=$q;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&date=<?=$date;?>&sort=-1">Fecha</a></li>
    <li<?=($sort == '2' ? ' class="selected"' : '');?>><a href="<?=$config['search_url'];?>/comunidades?q=<?=$q;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&date=<?=$date;?>&sort=2">Miembros</a></li>
    <li<?=($sort == '3' ? ' class="selected"' : '');?>><a href="<?=$config['search_url'];?>/comunidades?q=<?=$q;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&date=<?=$date;?>&sort=3">Temas</a></li>
  </ul>
</div>

<font size=3>
<div id="cuerpocontainer">
<script type="text/javascript">
var buscador = {
	tipo: 'taringa',
	buscadorLite: false,
	onsubmit: function(){
		if(this.tipo=='google')
			if($('select[name="cat"]').val()=='-1')
				$('input[name="q"]').val($('input[name="q2"]').val());
			else
				$('input[name="q"]').val('site:taringa.net/posts/'+$('select[name="cat"]').val()+'/ ' + $('input[name="q2"]').val());
	},
	select: function(tipo){
		if(this.tipo==tipo)
			return;
		//Cambio de action form
		$('form[name="buscador"]').attr('action', '/posts/buscador/'+tipo+'/');
		//Solo hago los cambios visuales si no envia consulta
		if(!this.buscadorLite){
			//Cambio here en <a />
			$('a#select_' + this.tipo).removeClass('here');
			$('a#select_' + tipo).addClass('here');
			//Cambio de logo
			$('img#buscador-logo-'+this.tipo).css('display', 'none');
			$('img#buscador-logo-'+tipo).css('display', 'inline');
			//Muestro/oculto el input autor
			if(tipo=='warexd')
				$('span#filtro_autor').show();
			else
				$('span#filtro_autor').hide();
		}
		//Muestro/oculto los input google
		if(tipo=='google'){ //Ahora es google
			$('input[name="q"]').attr('name', 'q2');
			$('form[name="buscador"]').append('<input type="hidden" name="q" value="" /><input type="hidden" name="cx" value="partner-pub-5717128494977839:armknb-nql0" /><input type="hidden" name="cof" value="FORID:10" /><input type="hidden" name="ie" value="ISO-8859-1" />');
		}else if(this.tipo=='google'){ //El anterior fue google
			$('input[name="q"]').remove();
			$('input[name="cx"]').remove();
			$('input[name="cof"]').remove();
			$('input[name="ie"]').remove();
			$('input[name="q2"]').attr('name', 'q');
		}
		this.tipo = tipo;
		//En buscador lite envio consulta
		if(this.buscadorLite){
			this.onsubmit();
			$('form[name="buscador"]').submit();
		}else{
			//Foco en input query
			if(this.tipo=='google')
				$('input[name="q2"]').focus();
			else
				$('input[name="q"]').focus();
		}
	}
}
</script>

<div id="resultados">
<?php if($num) { ?>
<div id="showResult">
<table class="linksList">
  <thead>
    <tr>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; while($row = mysql_fetch_assoc($query)) { ?>
  <tr id="div_<?=(++$i);?>">
    <td></td>
    <td style="text-align: left;">
    <ol style="">
	<li class="result-i">
    <h2 title="<?=$row['namecat'];?>"><img src="<?=$config['images'];?>/images/comunidades/categorias/<?=$row['img'];?>.png" /> <a href="/comunidades/<?=$row['url'];?>/" title="<?=$row['name'];?>"><?=$row['name'];?></a></h2>
	<div class="info">
	<p><?=cut($row['desc'], 55);?></p>
	<div style="color:#676767;font-size:11px">
    <img title="Creado" alt="Creado" src="<?=$config['images'];?>/images/search/clock.png"> <span title="<?=date('d.m.Y', $row['time']);?>"><?=timefrom($row['time']);?></span>
				 - <img title="Autor" alt="Autor" src="<?=$config['images'];?>/images/search/autor.png"> <a href="/perfil/<?=$row['nick'];?>"><?=$row['nick'];?></a>
				 - <img title=" Miembros" alt="Miembros" src="<?=$config['images'];?>/images//search/miembros.png"> <?=$row['members'];?> Miembros
				 - <img title=" Temas" alt="Temas" src="<?=$config['images'];?>/images//search/temas.png"> <?=$row['topics'];?> Temas
	</div>
    </div>
    </li>
    </ol>
    </td>
  </tr>
  <?php } ?>
  </tbody>
</table>
</div>
<?php } else { ?>
<div class="med">
	<p>La b&uacute;squeda de <b><?=$q;?></b> no obtuvo ning&uacute;n resultado.</p>
	<p style="margin-top: 1em;">Sugerencias:</p>
	<ul>
		<li>Comprueba que todas las palabras est&aacute;n escritas correctamente.</li>
		<li>Intenta usar otras palabras.</li>
		<li>Intenta usar palabras m&aacute;s generales.</li>
        <?php if($logged['id']) { echo '<li><span style="background: #FFFFCC">No existe lo que buscas? <a href="'.$config['url'].'/agregar/">Aprovecha y crea un Post!</a></span></li>'; } ?>
    </ul>
</div>
<?php } ?>
</div><?php if($tot > $per) { ?>
<!-- Paginado -->
<div class="paginadorBuscador">
<?php if($p > 1) { echo '<div class="before floatL"><a href="'.$config['search_url'].'/comunidades/?q='.$q.'&autor='.$autor.'&cat='.$cat.'&sort='.$sort.'&date='.$date.'&p='.($i-1).'">Anterior</a></div> '; } ?>
  <div class="pagesCant">
  <ul>
  <li class="numbers">
  <?php
  unset($display);
  for($i=1;$i<=$tot;$i++) { echo '<a'.($i == $p ? ' class="here"' : '').' href="'.$config['search_url'].'/comunidades/?q='.$q.'&autor='.$autor.'&cat='.$cat.'&sort='.$sort.'&date='.$date.'&p='.($i).'">'.$i.'</a>'; }
  ?>
  </li>
  </ul>
  </div>
  <?php if($p < $tot) { echo '<div class="floatL next"><a href="'.$config['search_url'].'/comunidades/?q='.$q.'&autor='.$autor.'&cat='.$cat.'&sort='.$sort.'&date='.$date.'&p='.($i+1).'">Siguiente</a></div> '; } ?>
</div>
<!-- FIN - Paginado --><?php } ?></font> </div>
<div id="footer"><br>
<div class="search">
  <div class="search-box clearfix">
  <form name="buscar">
    <div class="input-left"></div>
    <input type="text" name="q" value="<?=($q ? $q : 'Buscar');?>" />
    <div class="input-right"></div>
    <div class="btn-search floatL">
    <a href="javascript:$('form[name=buscar]').submit()"></a>
    </div>
  </form>
  </div>
</div>
</div>
	</div>

</div>