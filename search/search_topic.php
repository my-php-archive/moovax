<?php
if(!defined('search')) { die; }
if($sort > 3 || $sort < 1 || !ctype_digit($sort)) { $sort = 1; }
if($sort == 3) { die(include($_SERVER['DOCUMENT_ROOT'].'/500.shtml')); }
$times = array(2 => array('86400', '&Uacute;litmas 24 horas'), 3 => array('604800', '&Uacute;ltima semana'), 4 => array('2592000', '&Uacute;ltimo mes'), 5 => array('31536000', '&Uacute;ltimo a&ntilde;o'));
$display = '';
$query = 'SELECT t.*, g.name, g.url, cat.`name` AS namecat, cat.`url` AS urlcat, cat.`img`, u.nick FROM `groups_topics` AS t INNER JOIN `groups` AS g ON g.id = t.group INNER JOIN `users` AS u ON u.id = t.`author` LEFT JOIN `groups_categories` AS cat ON cat.id = g.cat WHERE t.`status` = \'0\' && g.`status` = \'0\'';
if($autor != '-1' && mysql_num_rows($s = mysql_query('SELECT id, nick FROM `users` WHERE `nick` = \''.mysql_clean($autor).'\''))) {
  list($id_user, $nick) = mysql_fetch_row($s);
  $query .= ' && t.`author` = \''.$id_user.'\'';
  $display .= '<span><strong>Autor: '.$nick.'</strong><a href="'.$config['search_url'].'/temas/?q='.$q.'&cat='.$cat.'&sort='.$sort.'&date='.$date.'&autor=-1"></a></span>';
}
if($cat != '-1' && mysql_num_rows($a = mysql_query('SELECT `id`, `name` FROM `groups_categories` WHERE `url` = \''.mysql_clean($cat).'\''))) {
  $r = mysql_fetch_row($a);
  $query .= ' && g.`cat` = \''.$r[0].'\'';
  $display .= '<span><strong>Categor&iacute;a: '.$r[1].'</strong><a href="'.$config['search_url'].'/temas/?q='.$q.'&sort='.$sort.'&date='.$date.'&autor='.$autor.'&cat=-1"></a></span>';
}
if($date != '-1' && array_key_exists($date, $times)) {
  $query .= ' && t.`time` > \''.(time()-$times[$date][0]).'\'';
  $display .= '<span><strong>'.$times[$date][1].'</strong><a href="'.$config['search_url'].'/temas/?q='.$q.'&sort='.$sort.'&autor='.$autor.'&cat='.$cat.'&date=-1"></a></span>';
}
if($en != '-1' && mysql_num_rows($group = mysql_query('SELECT `id` FROM `groups` WHERE `url` = \''.mysql_clean($en).'\' && `status` = \'0\''))) {
  $gr = mysql_fetch_row($group);
  $query .= ' && g.`id` = \''.$gr[0].'\'';
}

$query .= ' && MATCH(t.`title`) AGAINST (\''.mysql_clean($q).'\')';
$query .= ' GROUP BY t.id ORDER BY `'.($sort == 3 ? 'visits' : ($sort == 2 ? 'votes' : 'time')).'` DESC';
$per = 50;
$num = mysql_num_rows(mysql_query($query));
$tot = ceil($num / $per);
$_GET['p'] = ctype_digit($_GET['p']) && $_GET['p'] <= $tot ? $_GET['p'] : 1;
$limit = ($_GET['p']-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per) or die(mysql_error());
$q = htmlspecialchars($q);

?>
<div class="container clearfix">
		<div id="sidebar">
		<div class="filter-box">
	<h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Buscar en</a></h6>
	<ul>
		<li class="clearfix"><a href="<?=$config['search_url'];?>/comunidades/?q=<?=$q;?>"><span>Comunidades</span></a></li>
		<li class="clearfix"><a href="<?=$config['search_url'];?>/temas/?q=<?=$q;?>"><span><b>Temas</b></span></a></li>
	</ul>
</div>
<div class="filter-box">
	<h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Creado</a></h6>
	<ul>
		<li class="clearfix"><a href="<?=$config['search_url'];?>/temas/?q=<?=$q;?>&cat=<?=$cat;?>&autor=<?=$autor;?>&sort=<?=$sort;?>&date=2"><span>&Uacute;ltimas 24 horas</span></a></li>
		<li class="clearfix"><a href="<?=$config['search_url'];?>/temas/?q=<?=$q;?>&cat=<?=$cat;?>&autor=<?=$autor;?>&sort=<?=$sort;?>&date=3"><span>&Uacute;ltima semana</span></a></li>
		<li class="clearfix"><a href="<?=$config['search_url'];?>/temas/?q=<?=$q;?>&cat=<?=$cat;?>&autor=<?=$autor;?>&sort=<?=$sort;?>&date=4"><span>&Uacute;ltimo mes</span></a></li>
		<li class="clearfix"><a href="<?=$config['search_url'];?>/temas/?q=<?=$q;?>&cat=<?=$cat;?>&autor=<?=$autor;?>&sort=<?=$sort;?>&date=5"><span>&Uacute;ltimo a&ntilde;o</span></a></li>
	</ul>
</div>
<div class="filter-box">

	<h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Categoria</a></h6>
	<select style="width: 140px" onchange="search.categoria('<?=$config['search_url'];?>/temas/?cat=<?=addslashes($cat);?>&autor=<?=addslashes($autor);?>&sort=<?=addslashes($sort);?>&date=<?=addslashes($date);?>&', '<?=addslashes($q);?>', this.value)">
		<option value="-1" selected="selected"></option>
        <?php
        $fgew = mysql_query('SELECT * FROM `groups_categories` ORDER BY `name` ASC');
        while($cas = mysql_fetch_assoc($fgew)) { echo '<option value="'.$cas['url'].'"'.($cas['url'] == $cat ? ' selected="selected"' : '').'>'.$cas['name'].'</option>'."\n"; }
        ?>
</select>
</div>
<div class="filter-box">
	<h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Autor</a></h6>
    <script>
    var gew = '<?=$config['search_url'];?>/temas/?cat=<?=$cat;?>&sort=<?=$sort;?>&date=<?=$date;?>&';
    </script>
	<input type="text" style="width: 105px;float:left" value="<?=($autor != '-1' ? htmlspecialchars($autor) : '');?>" autocomplete="off" title="Buscar por Usuario" onkeypress="search.autor_intro(event, gew, '<?=addslashes($q);?>', this.value, 1)" />
	<input type="button" class="sbutton" value="&raquo;" onclick="search.autor_submit(gew, '<?=addslashes($q);?>', $(this).prev().val(), 1)" />
</div>
<div class="clearfix clearBoth" style="clear:both"></div>
	</div>
	<div id="results" class="results">
<!-- Suggest -->
<p class="suggest" style="display:none">
	<span>Quisiste decir:</span> <a href=""></a> ?
</p>
<script type="text/javascript">search.suggest("<?=$q;?>", "<?=$q;?>", "<?=$q;?>", '/temas/?q=');</script><!-- /Suggest -->
<!-- Sort -->
<?php if(!empty($display)) { echo '<div class="filters-apply clearfix">',$display,'</div>'; } ?>
<div class="filter-bar clearfix">
	<span>Ordenar por:</span>
	<ul>
		<li<?=($sort == '-1' || $sort == '1' ? ' class="selected"' : '');?>><a href="<?=$config['search_url'];?>/temas/?q=<?=$q;?>&cat=<?=$cat;?>&autor=<?=$autor;?>&date=<?=$date;?>&sort=-1">Fecha</a></li>
		<li<?=($sort == '2' ? ' class="selected"' : '');?>><a href="<?=$config['search_url'];?>/temas/?q=<?=$q;?>&cat=<?=$cat;?>&autor=<?=$autor;?>&date=<?=$date;?>&sort=2">Votos</a></li>
		<li<?=($sort == '3' ? ' class="selected"' : '');?>><a href="<?=$config['search_url'];?>/temas/?q=<?=$q;?>&cat=<?=$cat;?>&autor=<?=$autor;?>&date=<?=$date;?>&sort=3">Visitas</a></li>
	</ul>
</div>
<!-- /Sort -->
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
    <ol style="display:table">
      <li class="result-i">
        <h2 title="<?=$row['namecat'];?>" class=""><img src="<?=$config['images'];?>/images/comunidades/categorias/<?=$row['img'];?>.png" /> <a title="<?=$row['title'];?>" href="/comunidades/<?=$row['url'];?>/<?=$row['id'];?>/<?=url($row['title']);?>.html"><?=$row['title'];?></a></h2>
        <div class="info">
          <div style="color:#676767;font-size:11px">
            <img src="<?=$config['images'];?>/images/search/clock.png" alt="Creado"  title="Creado" /> <span title="<?=date('d.m.Y', $row['time']);?>"><?=timefrom($row['time']);?></span>
            - <img src="<?=$config['images'];?>/images/search/autor.png" alt="Autor"  title="Autor" /> <a href="/perfil/<?=$row['nick'];?>"><?=$row['nick'];?></a> en <a title="<?=$row['name'];?>" href="/comunidades/<?=$row['url'];?>/"><?=$row['name'];?></a>
            - Calificaci&oacute;n <b><?=$row['votes'];?></b>
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
<?php if($tot > $per) { ?>
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
<!-- FIN - Paginado -->
<?php } } else { ?>
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
</font> </div>		<div id="footer"><br>
			<div class="search">
<div class="search-box clearfix">
			<form name="buscar">
				<div class="input-left"></div>
				<input type="text" name="q" value="<?=$q;?>" />
				<div class="input-right"></div>
				<div class="btn-search floatL">
					<a href="javascript:$('form[name=buscar]').submit()"></a>
				</div>
			</form>
				</div>
			</div>
		</div>
	</div>
		<div id="avisosVert"></div>
</div>