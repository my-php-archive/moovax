<?php
if(!defined($config['define'])) { die; }
if(!$_GET['categoria'] || empty($_GET['categoria'])) { $_GET['categoria'] = '-1'; }
if(!$_GET['orden'] || empty($_GET['orden'])) { $_GET['orden'] = '-1'; }
if(!$_GET['autor'] || empty($_GET['autor'])) { $_GET['autor'] = '-1'; }
$where = '';
$order = '';
if($_GET['orden'] == 'puntos') {
  $order .= ' p.`points` DESC';
} elseif($_GET['orden'] == 'relevancia') {
  $order .= ' p.`visits` DESC';
} else { $order .= 'p.`time` DESC'; }
if($_GET['categoria'] != '-1' && mysql_num_rows($rosw = mysql_query('SELECT `id` FROM `categories` WHERE `url` = \''.mysql_clean($_GET['categoria']).'\''))) {
  $row = mysql_fetch_row($rosw);
  $where .= ' && cat.`id` = \''.$row[0].'\'';
}
if($_GET['autor'] != '-1') {
  $where .= ' && u.`nick` = \''.mysql_clean($_GET['autor']).'\''; //she makes mi wana eeeer34
  $nick = htmlspecialchars($_GET['autor']);
}
$query = 'SELECT p.`id`, p.title, p.points, p.`time`, cat.url, cat.name, u.nick FROM `posts` AS p INNER JOIN `users` AS u ON u.id = p.`author` INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE p.`status` = \'0\' && p.`title` LIKE \'%'.mysql_clean($_GET['q']).'%\' '.$where.' ORDER BY '.$order;
$num = mysql_num_rows(mysql_query($query));
$per = 50;
$total = ceil($num / $per);
$_GET['p'] = $_GET['p'] && ctype_digit($_GET['p']) ? $_GET['p'] : '1';
$act = ($_GET['p']-1)*$per;
if($_GET['p'] > $total && $_GET['p'] && $total > 0) {
  fatal_error('No te pases de vivo <img src="http://i.imgur.com/doCpk.gif">');
}
$search = mysql_query($query.' LIMIT '.$act.', '.$per) or die(mysql_error());
?>

<script type="text/javascript">
		function errorr(search){
			if(search == 'Buscar...'){ $('#search').focus();  return false;}
			//Doble Seguridad!
			if(search == ''){ $('#search').focus();  return false;}
		}
	</script>
 <div class="breadcrumb">
			<ul>

				<li class="first"><a href="/" accesskey="1" class="home"></a></li>
                <?php
                if(!$_GET['q']) { echo '<li><a href="/posts/buscador/">Buscador</a></li>'; } else { echo '<li><a href="/posts/buscador/?q='.htmlspecialchars($_GET['q']).'&categoria='.htmlspecialchars($_GET['categoria']).'&orden='.htmlspecialchars($_GET['orden']).'&autor='.htmlspecialchars($_GET['autor']).'">Resultados para '.htmlspecialchars($_GET['q']).'</a></li>'; }
                ?>

				<li class="last"></li>
			</ul>
		</div><div style="clear:both"></div>

<div style="padding:10px;background:#FFFFFF;border:1px solid #C8C8C8;">

<div class="size18" style="font-weight:bold;">Buscar posts</div><br />
<div style="padding:10px;background:#EEEEEE;border:1px solid #C8C8C8;">

<form action="/posts/buscador/" method="GET" accept-charset="UTF-8">

<div class="floatL">
<input type="text" size="100" <?=($_GET['q'] ? 'value="'.htmlspecialchars($_GET['q']).'"' : '');?> maxlength="60" name="q" id="search" tabindex="1" autocomplete="off" title="Buscar..." onfocus="if(this.value=='Buscar...') this.value='';" onblur="if(this.value=='') this.value='Buscar...';" value="Buscar..." style="width:400px;height:22px;font-size:18px;" />
<input class="Boton BtnGray" onclick="return errorr(this.form.search.value);" value="Buscar" title="Buscar" style="height:32px;font-size:18px;" type="submit" />
</div>
<div class="floatL" style="margin-left:6px;">
	<span style="color:#7A6654;font-size:12px;">Categor&iacute;a</span>
	<br />

	<select tabindex="4" name="categoria">
        <option value="-1" selected="selected">Todas</option>
        <?php
        $qqqq = mysql_query('SELECT `url`, `name` FROM `categories` ORDER BY `name` ASC') or die(mysql_error());
        while($ccat = mysql_fetch_row($qqqq)) {
          echo '<option value="'.$ccat[0].'"'.($_GET['categoria'] == $ccat[0] ? ' selected="selected"' : '').'>'.$ccat[1].'</option>   '; //$cccat[0] row eeer34
        }
        ?>
	</select>

</div>

<div class="floatL" style="margin-left:6px;">
	<span style="color:#7A6654;font-size:12px;">Orden</span>
	<br />
	<select tabindex="4" name="orden">
		<option<?=($_GET['orden'] == 'fecha' ? ' selected="selected"' : '');?> value="fecha">Fecha</option>
    	<option<?=($_GET['orden'] == 'puntos' ? ' selected="selected"' : '');?> value="puntos">Puntos</option>
        <option<?=($_GET['orden'] == 'relevancia' ? ' selected="selected"' : '');?> value="relevancia">Relevancia</option>
	</select>

</div>

<div class="floatL" style="margin-left:6px;">
	<span style="color:#7A6654;font-size:12px;">Usuario</span>
	<br />
	<input style="height: 15px;font-size:11px;padding:1px;width:100px;" value="<?=$nick;?>" name="autor" type="text" />
</div>

<div class="clearBoth"></div>

</form></div>

	</div>
    <?php
    if(($_GET['q'] && !empty($_GET['q'])) || $_GET['autor'] != '-1') {
    ?>
    <div class="clear"></div>
<br>
<?php
if(mysql_num_rows($search)) {
?>
<div id="resultados">
		<table class="linksList">
			<thead>
				<tr>
					<th></th>
					<th style="text-align: center;"><?=$num;?> resultados para "<?=htmlspecialchars($_GET['q']);?>"</th>

					<th>Por</th>
					<th>Puntos</th>
					<th>Fecha</th>
</tr>
</thead>
<tbody>
<?php
while($row = mysql_fetch_assoc($search)) {
?>
<tr>
	<td title="<?=$row['name'];?>" style="width:18px">
		<span class="categoriaPost <?=$row['url'];?>"></span>

	</td>
	<td style="text-align: left;">
		<a title="<?=$row['title'];?>" href="/posts/<?=$row['url'];?>/<?=$row['id'];?>/<?=url($row['title']);?>.html"><?=$row['title'];?></a>
	</td>
	<td>
		<a href="/perfil/<?=$row['nick'];?>" title="Ver perfil"><?=$row['nick'];?></a>
	</td>

	<td>

		<span class="color_green"><?=$row['points'];?></span>
	</td>
	<td style="width:180px">
		<?=date('d.m.Y', $row['time']);?> a las <?=date('G:i', $row['time']);?> hs.
	</td>

</tr>
<?php
}
?>
</tbody>
<hr class="divider">
<div class="paginadorCom" style="width:954px">
    <div class="floatL before"><a <?=($_GET['p'] <= 1 ? 'href="#" onclick="return false" class="desactivado"' : 'href="/posts/buscador/?q='.htmlspecialchars($_GET['q']).'&categoria='.htmlspecialchars($_GET['categoria']).'&orden='.htmlspecialchars($_GET['orden']).'&autor='.htmlspecialchars($_GET['autor']).'&p='.($_GET['p']-1).'"');?>><b>&laquo; Anterior</b></a></div>
    <div class="floatR next"><a <?=($_GET['p'] < $total ? 'href="/posts/buscador/?q='.htmlspecialchars($_GET['q']).'&categoria='.htmlspecialchars($_GET['categoria']).'&orden='.htmlspecialchars($_GET['orden']).'&autor='.htmlspecialchars($_GET['autor']).'&p='.($_GET['p']+1).'"' : 'href="#" onclick="return false" class="desactivado"');?>><b>Siguiente &raquo;</b></a></div>
</div>
</table>

</div>
<?php
} else {
?>

<div id="resultados" style="width:100%">
	<div class="redBox">
		No se encontraron resultados para "<?=htmlspecialchars($_GET['q']);?>"
	</div></div><div style="clear:both"></div></div>
	</div>
<?php
}
?>

<?php
}
?>
</div><div style="clear:both"></div></div>