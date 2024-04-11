<?php
if(!defined($config['define'])) { die; }
if(!$_GET['currenttop'] || !in_array($_GET['currenttop'], array('posts', 'fotos', 'usuarios', 'categorias'))) { $_GET['currenttop'] = 'posts'; }
/*if($_GET['currenttop'] == 'posts' && $_GET['cat'] && $_GET['cat'] != '-1') {
  $ns = mysql_num_rows($q = mysql_query('SELECT `url` FROM `categories` WHERE `url` = \''.mysql_clean($_GET['url']).'\''));
} elseif($_GET['currenttop'] == 'categorias') {
  $ns = mysql_num_rows
}  */
$cat = $_GET['cat'] ? htmlspecialchars($_GET['cat']) : '-1';
?>
<div class="breadcrumb">
	<ul>
		<li class="first"><a href="/" accesskey="1" class="home"></a></li>
		<li><a href="/tops/">TOP's</a></li>
		<li class="last"></li>
	</ul>
</div>
<div class="clear"></div>
	<script type="text/javascript">
			var donde_actual = '<?=$_GET['currenttop'];?>';
            var time = '<?=htmlspecialchars($_GET['time']);?>';
	</script>
	<div class="left" style="float:left;width:167px">
		<div class="boxy">
			<div class="boxy-title">
				<h3>Filtrar</h3>
				<span class="icon-noti comentarios-n"></span><span id="loading" class="floatR" style="display:none;margin-top:-16px;"><img src="<?=$config['images'];?>/images/cargando.gif" ></span>
			</div>
			<div class="boxy-content">
            <span id="categorias"<?=($_GET['currenttop'] == 'categorias' ? ' style="display:none;"' : '');?>>
			<h3 style="font-size:12px;">Categor&iacute;a:</h3>
            <select onchange="location.href='/tops/<?=$_GET['currenttop'];?>/?time=<?=htmlspecialchars($_GET['time']);?>&cat='+$(this).val()" id="postssss" style="<?=($_GET['currenttop'] != 'posts' && $_GET['currenttop'] != 'usuarios' ? 'display:none;' : '');?>">
            <option value="-1">Todas</option>
            <?php
            $r = mysql_query('SELECT `url`, `name` FROM `categories` ORDER BY `name` ASC');
            while($rq = mysql_fetch_row($r)) { echo '<option value="'.$rq[0].'"'.($_GET['cat'] == $rq[0] ? ' selected="true"' : '').'>'.$rq[1].'</option>'; }
            ?>
            </select>
            <select style="<?=($_GET['currenttop'] != 'fotos' ? 'display: none;' : '');?>" onchange="location.href='/tops/<?=$_GET['currenttop'];?>/?time=<?=htmlspecialchars($_GET['time']);?>&cat='+$(this).val()" id="categoriasss">
            <option value="-1">Todas</option>
            <?php
            $ct = mysql_query('SELECT `name`, `url` FROM `p_categories` ORDER BY `name` ASC');
            while(list($name, $url) = mysql_fetch_row($ct)) {
              echo '<option value="'.$url.'"'.($_GET['cat'] == $url  ? ' selected="true"' : '').'>'.$name.'</option>';
            }
            ?>
            </select>
            <div class="barra-dashed"></div>
            </span>
            <h3>Tipo:</h3>
					<ul>
						<li id="top_posts"<?=($_GET['currenttop'] == 'posts' ? ' class="selected"' : '');?>><a href="/tops/posts" onclick="tops_filtro('posts');return false;" title="Posts"><span title="Posts" style="margin-top:-3px; font-size: 14px;">Posts <span class="floatR"><img src="<?=$config['images'];?>/images/note.png" border="0" align="absmiddle"></span></span></a></li>
						<li id="top_usuarios"<?=($_GET['currenttop'] == 'usuarios' ? ' class="selected"' : '');?>><a href="/tops/usuarios" onclick="tops_filtro('usuarios');return false;" title="Usuarios"><span title="Usuarios" style="margin-top:-3px; font-size: 14px;">Usuarios <span class="floatR"><img src="<?=$config['images'];?>/images/user.png" border="0" align="absmiddle"></span></span></a></li>
						<li id="top_fotos"<?=($_GET['currenttop'] == 'fotos' ? ' class="selected"' : '');?>><a href="/tops/fotos" onclick="tops_filtro('fotos');return false;" title="Im&aacute;genes"><span title="Im&aacute;genes" style="margin-top:-3px; font-size: 14px;">Im&aacute;genes <span class="floatR"><img src="<?=$config['images'];?>/images/fotos.png" border="0" align="absmiddle"></span></span></a></li>
						<li id="top_categorias"<?=($_GET['currenttop'] == 'categorias' ? ' class="selected"' : '');?>><a href="/tops/categorias" onclick="tops_filtro('categorias');return false;" title="Categor&iacute;as"><span title="Categor&iacute;as" style="margin-top:-3px; font-size: 14px;">Categor&iacute;as <span class="floatR"><img src="<?=$config['images'];?>/images/layout_header.png" border="0" align="absmiddle"></span></span></a></li>
					</ul>

            <div class="barra-dashed"></div>
            <!--<span style="margin-top:-3px; font-size: 13px;"><b>Tiempo:</b></span> -->
            <ul id="filtertime">
            <li <?=($_GET['time'] == 'ayer' ? ' class="selected"' : '');?>><a onclick="location.href='/tops/' + donde_actual + '/?time=ayer&cat=<?=$cat;?>'" title="Posts">Ayer </a></li>
            <li <?=($_GET['time'] == 'hoy' ? ' class="selected"' : '');?>><a onclick="location.href='/tops/' + donde_actual + '/?time=hoy&cat=<?=$cat;?>'" title="Posts">Hoy </a></li>
            <li <?=($_GET['time'] == 'semana' ? ' class="selected"' : '');?>><a onclick="location.href='/tops/' + donde_actual + '/?time=semana&cat=<?=$cat;?>'" title="Posts">Semana </a></li>
            <li <?=($_GET['time'] == 'mes' ? ' class="selected"' : '');?>><a onclick="location.href='/tops/' + donde_actual + '/?time=mes&cat=<?=$cat;?>'" title="Posts">Mes </a></li>
            <li <?=($_GET['time'] == '-1' || !$_GET['time'] ? ' class="selected"' : '');?>><a onclick="location.href='/tops/' + donde_actual + '/?time=-1&cat=<?=$cat;?>'" title="Posts">Todos los tiempos</a></li>
            </ul>
            </div>
		</div>
		<div class="clear"></div>
	</div>

<div id="tops_right">
  <span id="mostrar">
  <?php
  include('./ajax/tops-filter.php');
  ?>
  </span>
</div>
		<div class="clear"></div>
</div><div style="clear:both"></div></div>	</div>