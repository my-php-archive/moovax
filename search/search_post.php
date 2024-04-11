<?php
if(!defined('search')) { die; }
if($sort > 3 || !ctype_digit($sort)) { $sort = 1; }
if($date > 5 || !ctype_digit($date)) { $date = 1; }
$dtime = array(2 => array('86400', '&Uacute;litmas 24 horas'), 3 => array('604800', '&Uacute;ltima semana'), 4 => array('2592000', '&Uacute;ltimo mes'), 5 => array('31536000', '&Uacute;ltimo a&ntilde;o'));
$display = '';
$query = 'SELECT p.*, COUNT(DISTINCT favorites.id) AS favorites, COUNT(DISTINCT comments.id) AS comments, users.nick FROM `posts` AS p INNER JOIN `users` ON users.id = p.`author` LEFT OUTER JOIN `favorites` ON favorites.id_pf = p.id LEFT OUTER JOIN `comments` ON comments.id_post = p.id WHERE p.`status` = \'0\'';
if($autor != '-1' && mysql_num_rows($dttt = mysql_query('SELECT `id`, `nick` FROM `users` WHERE `nick` = \''.mysql_clean($autor).'\''))) {
  list($id, $autor) = mysql_fetch_row($dttt);
  $query .= ' && users.id = \''.$id.'\'';
  $display .= '<span><strong>Autor: '.$autor.'</strong><a href="'.$config['search_url'].'/posts/?q='.htmlspecialchars($q).'&en='.$en.'&autor=-1&cat='.$cat.'&sort='.$sort.'&date='.$date.'"></a></span>';
}
if($cat != '-1' && mysql_num_rows($qs = mysql_query('SELECT `id`, `name` FROM `categories` WHERE `url` = \''.mysql_clean($cat).'\''))) {
  $pe = mysql_fetch_row($qs);
  $query .= ' && p.`cat` = \''.$pe[0].'\'';
  $display .= '<span><strong>Categor&iacute;a: '.$pe[1].'</strong><a href="'.$config['search_url'].'/posts/?q='.htmlspecialchars($q).'&en='.$en.'&autor='.$autor.'&cat=-1&sort='.$sort.'&date='.$date.'"></a></span>';
}
if($date != '-1' && array_key_exists($date, $dtime)) {
  $query .= ' && p.`time` > \''.(time()-$dtime[$date][0]).'\'';
  $display .= '<span><strong>'.$dtime[$date][1].'</strong><a href="'.$config['search_url'].'/?q='.htmlspecialchars($q).'&en='.$en.'&autor='.$autor.'&cat='.$cat.'&sort='.$sort.'&date=-1"></a></span>';
}
$query .= ' && (MATCH(p.`title`) AGAINST(\''.mysql_clean($q).'\')';
if($en != 'todo') {
  $display .= '<span><strong>Buscar: S&oacute;lo t&iacute;tulo</strong><a href="'.$config['search_url'].'/posts/?q='.htmlspecialchars($q).'&en=todo&autor=-1&cat='.$cat.'&sort='.$sort.'&date='.$date.'"></a></span>';
} else {
  $display .= '<span><strong>Buscando en todo</strong><a href="'.$config['search_url'].'/posts/?q='.htmlspecialchars($q).'&en=-1&autor=-1&cat='.$cat.'&sort='.$sort.'&date='.$date.'"></a></span>';
  $query .= ' || MATCH(p.`body`) AGAINST(\''.mysql_clean($q).'\')';
}
$query .= ')';
$query .= ' GROUP BY p.id ORDER BY `'.($sort == '-1' || $sort == '1' ? 'time' : ($sort == '2' ? 'points' : 'visits')).'` DESC';
$tot = mysql_num_rows(mysql_query($query));
$per = 40;
$num = ceil($tot / $per);
$p = ctype_digit($_GET['p']) && $_GET['p'] <= $num ? $_GET['p'] : '1';
$limit = ($p-1)*$per;
$query = mysql_query($query.' LIMIT '.$limit.', '.$per) or die(mysql_error());
$q = htmlspecialchars($q);
?>
<div class="container clearfix">
		<div id="sidebar">
		<div class="filter-box">
	<h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Motor</a></h6>
	<ul>
		<li class="clearfix"><a class="selected" href="<?=$config['search_url'];?>/posts/?q=<?=$q;?>"><span><b><?=$config['name'];?></b></span></a></li>
		<li class="clearfix"><a href="javascript:alert('no disponible');"><span>Google</span></a></li>
	</ul>
</div>
<div class="filter-box">
	<h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Creado</a></h6>
	<ul>

		<li class="clearfix"><a href="<?=$config['search_url'];?>/posts?q=<?=$q;?>&date=2&autor=<?=$autor;?>&cat=<?=$cat;?>&sort=<?=$sort;?>&en=<?=$en;?>"><span>&Uacute;ltimas 24 horas</span></a></li>
		<li class="clearfix"><a href="<?=$config['search_url'];?>/posts?q=<?=$q;?>&date=3&autor=<?=$autor;?>&cat=<?=$cat;?>&sort=<?=$sort;?>&en=<?=$en;?>"><span>&Uacute;ltima semana</span></a></li>
		<li class="clearfix"><a href="<?=$config['search_url'];?>/posts?q=<?=$q;?>&date=4&autor=<?=$autor;?>&cat=<?=$cat;?>&sort=<?=$sort;?>&en=<?=$en;?>"><span>&Uacute;ltimo mes</span></a></li>
		<li class="clearfix"><a href="<?=$config['search_url'];?>/posts?q=<?=$q;?>&date=5&autor=<?=$autor;?>&cat=<?=$cat;?>&sort=<?=$sort;?>&en=<?=$en;?>"><span>&Uacute;ltimo a&ntilde;o</span></a></li>
	</ul>
</div>
<div class="filter-box">
	<h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Categoria</a></h6>
	<select style="width: 140px" onchange="search.categoria('<?=$config['search_url'];?>/posts/?date=<?=$date;?>&autor=<?=addslashes($autor);?>&cat=<?=addslashes($cat);?>&sort=<?=addslashes($sort);?>&en=<?=addslashes($en);?>&', '<?=addslashes($q);?>', this.value)">
		<option value="-1" selected="selected"></option>
        <?php
        $qe = mysql_query('SELECT `name`, `url` FROM `categories` ORDER BY `name` DESC');
        while($r = mysql_fetch_row($qe)) {
          echo '<option'.($r[1] == $cat ? ' selected="true"' : '').' value="'.$r[1].'">'.$r[0].'</option>';
        }
        ?>
    </select>
</div>
<div class="filter-box">
	<h6><a href="#"><span class="iconos16 icon-expand"></span></a> <a href="#">Autor</a></h6>
	<input type="text" style="width: 105px;float:left"<?=($autor != '-1' ? ' value="'.$autor.'"' : '');?> autocomplete="off" title="Buscar por Usuario" onkeypress="search.autor_intro(event, '<?=$config['search_url'];?>/posts?', '<?=$q;?>', this.value, 1)" />
	<input type="button" class="sbutton" value="&raquo;" onclick="search.autor_submit('<?=$config['search_url'];?>/posts/?date=<?=$date;?>&autor=<?=addslashes($autor);?>&cat=<?=addslashes($cat);?>&sort=<?=addslashes($sort);?>&en=<?=addslashes($en);?>&', '<?=addslashes($q);?>', $(this).prev().val(), 1)" />
</div>
<div class="clearfix clearBoth" style="clear:both"></div>
	</div>
	<div id="results" class="results">
<!-- Filters -->
<?php if(!empty($display)) { echo '<div class="filters-apply clearfix">'.$display.'</div>  '; } ?>
<!-- /Filters -->
<!-- Suggest -->
<p class="suggest" style="display:none">
	<span>Quisiste decir:</span> <a href=""></a> ?
</p>
<script type="text/javascript">search.suggest("<?=$q;?>", "<?=$q;?>", "<?=$q;?>", '/posts?&q=');</script><!-- /Suggest -->
<!-- Sort -->
<div class="filter-bar clearfix">
	<span>Ordenar por:</span>
	<ul>
		<li<?=($sort == '1' || $sort == '-1' ? ' class="selected"' : '');?>><a href="<?=$config['search_url'];?>/posts?q=<?=$q;?>&date=<?=$date;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&en=<?=$en;?>">Fecha</a></li>
		<li<?=($sort == '2' ? ' class="selected"' : '');?>><a href="<?=$config['search_url'];?>/posts?q=<?=$q;?>&sort=2&date=<?=$date;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&en=<?=$en;?>">Calificacion</a></li>
		<li<?=($sort == '3' ? ' class="selected"' : '');?>><a href="<?=$config['search_url'];?>/posts?q=<?=$q;?>&sort=3&date=<?=$date;?>&autor=<?=$autor;?>&cat=<?=$cat;?>&en=<?=$en;?>">Relevancia</a></li>
	</ul>
</div>
<!-- /Sort -->
<!-- Banners -->
<!--<div id="avisosTop"></div> -->
<!-- /Banners -->

<font size=3>
<div id="cuerpocontainer">
<script type="text/javascript">
var buscador = {
	tipo: 'warexd',
	buscadorLite: false,
	onsubmit: function(){
		if(this.tipo=='google')
			if($('select[name="cat"]').val()=='-1')
				$('input[name="q"]').val($('input[name="q2"]').val());
			else
				$('input[name="q"]').val('site:warexd.com/posts/'+$('select[name="cat"]').val()+'/ ' + $('input[name="q2"]').val());
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
<?php if($tot > 0) { ?>
	<div id="showResult">
		<table class="linksList">
			<thead>
				<tr>
					<th></th>
</tr>
</thead>
<tbody>
<?php
$i = 0;
while($row = mysql_fetch_assoc($query)) {
?>
<tr id="div_<?=(++$i);?>">
  <td></td>
  <td style="text-align: left;">
    <ol style="display:none">
      <li class="result-i">
      <?php
      $cat = mysql_fetch_row(mysql_query('SELECT `url` FROM `categories` WHERE `id` = \''.$row['cat'].'\''));
      $author = mysql_fetch_row(mysql_query('SELECT `nick` FROM `users` WHERE `id` = \''.$row['author'].'\''));
      ?>
        <h2 title="<?=$cat[0];?>" class="categoriaPost <?=$cat[0];?>"><a title="<?=$row['title'];?>" href="/posts/<?=$cat[0];?>/<?=$row['id'];?>/<?=url($row['title']);?>.html" class="titlePost"><?=$row['title'];?></a></h2>
        <div class="info">
          <img src="<?=$config['images'];?>/images/search/clock.png" alt="Clock" /> <strong title="<?=timefrom($row['time']);?>"><?=timefrom($row['time']);?></strong> - <img src="<?=$config['images'];?>/images/search/autor.png" alt="Autor" /><strong><a href="/perfil/<?=$author[0];?>/"><?=$author[0];?></a></strong><br />
          <img src="<?=$config['images'];?>/images/search/puntos.png" alt="puntos" /> Puntos <strong><?=$row['points'];?></strong> - <img src="<?=$config['images'];?>/images/search/favoritos.gif" alt="favoritos" /> Favoritos  <strong><?=$row['favorites'];?></strong> - <img src="<?=$config['images'];?>/images/search/comentarios.gif" alt="comentarios" /> Comentarios <strong><?=$row['comments'];?></strong>
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
        <?php
        if($logged['id']) {
          echo '<li><span style="background: #FFFFCC">No existe lo que buscas? <a href="'.$config['url'].'/agregar/">Aprovecha y crea un Post!</a></span></li>';
        }
        ?>
	</ul>
</div>
<?php } ?>

<!-- Paginado -->

<?php if($tot > $per) { ?>
<div class="paginadorBuscador" align="center">
<?php
if($p > 1) {
  echo '<div class="before floatL">
<a href="'.$config['search_url'].'/posts?q='.$q.'&date='.$date.'&autor='.$autor.'&cat='.$cat.'&sort='.$sort.'&en='.$en.'&p='.($p-1).'">Anterior</a>
</div>';
}
?>
<div class="pagesCant">
<ul>
<?php
for($i=1;$i<=$num;$i++) {
  echo '<li class="numbers"><a class="'.($i == $p ? 'here' : '').'" href="'.$config['search_url'].'/posts?q='.$q.'&date='.$date.'&autor='.$autor.'&cat='.$cat.'&sort='.$sort.'&en='.$en.'&p='.$i.'">'.$i.'</a></li>';
}
?>
</ul>
</div>
<?php
if($p < $num) {
  echo '<div class="next floatL">
<a href="'.$config['search_url'].'/posts?q='.$q.'&date='.$date.'&autor='.$autor.'&cat='.$cat.'&sort='.$sort.'&en='.$en.'&p='.($p+1).'">Siguiente</a>
</div>';
}
?>
</div>
<?php } ?>

<!-- FIN - Paginado --></font> </div>		</div><div id="footer"><br>
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
</div>