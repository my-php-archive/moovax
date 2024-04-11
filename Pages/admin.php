<?php
if(!defined($config['define'])) { die; }
if(!allow('show_panel') && !$_GET['mayonesa']) { fatal_error('Chupame la pija mayonesa'); }
if(!$_GET['action']) { $_GET['action'] = 'index'; }
if(!preg_match('/[a-z]+/i', $_GET['action'])) { die; }
define('adm', true);
?>
<div class="breadcrumb">
    <ul>
        <li class="first"><a href="/" accesskey="1" class="home"></a></li>
		<li><a href="<?=$title['url'];?>"><?=$title['default'];?></a></li>
		<li class="last"></li>
	</ul>
</div>
<div style="clear:both"></div>
<?php
if($_GET['action'] != 'complaints') {
?>
<div id="adm-left">
    <?php
    if(allow('complaints_posts') || allow('complaints_users') || allow('complaints_photos')) {
    ?>
	<div class="box_title_content">
	    <div class="box_txt">Panel de denuncias</div>
	</div>
	<div class="box_cuerpo_content" >
	<?php if(allow('complaints_posts')) { ?><span class="BulletIcons verde"></span> <a href="/admin/denuncias/posts/" title="Posts denunciados">Posts denunciados</a> (<?=mysql_num_rows(mysql_query('SELECT c.`id` FROM `complaints` AS c INNER JOIN `posts` AS p ON p.id = c.id_post WHERE c.`what` = \'0\' && c.`status` = \'0\''));?>)<br><?php } ?>
    <?php if(allow('complaints_photos')) { ?><span class="BulletIcons verde"></span> <a href="/admin/denuncias/photos/"  title="Fotos denunciadas">Fotos denunciadas</a> (<?=mysql_num_rows(mysql_query('SELECT c.`id` FROM `complaints` AS c INNER JOIN `photos` AS p ON p.id = c.id_post WHERE c.`what` = \'1\' && c.`status` = \'0\''));?>)<br> <?php } ?>
    <?php if(allow('complaints_users')) { ?><span class="BulletIcons verde"></span> <a href="/admin/denuncias/users/"  title="Usuarios denunciados">Usuarios denunciados</a> (<?=mysql_num_rows(mysql_query('SELECT c.`id` FROM `complaints` AS c INNER JOIN `users` AS u ON u.id = c.`id_post` WHERE c.`what` = \'2\' && c.`status` = \'0\''));?>)<br><?php } ?>
	</div>
	<br class="space">
    <?php
    }
    if(allow('delete_posts') || allow('delete_photos')) {
    ?>
	<div class="box_title_content">
		<div class="box_txt">Papelera de reciclaje</div>
	</div>
	<div class="box_cuerpo_content" >
		<?php if(allow('delete_posts')) { ?><span class="BulletIcons naranja"></span> <a href="/admin/papelera/posts/"  title="Posts eliminados">Posts eliminados</a><br><?php } ?>
		<?php if(allow('delete_photos')) { ?><span class="BulletIcons naranja"></span> <a href="/admin/papelera/fotos/"  title="Fotos eliminadas">Fotos eliminadas</a><br><?php } ?>
	</div>
	<br class="space">
    <?php
    }
    if(allow('show_userlist') || allow('ban') || allow('track_ip') || allow('censure') || allow('friend_sites') || allow('manage_news') || allow('stitches') || allow('edit_ranks') || allow('category_manage') || allow('show_mps')) {
    ?>
	<div class="box_title_content">
		<div class="box_txt">Web en general</div>
	</div>
	<div class="box_cuerpo_content" >
		<?php if(allow('show_userlist')) { ?><span class="BulletIcons violeta"></span> <a href="/admin/usuarios/ID/"  title="Lista de usuarios">Lista de usuarios</a><br><?php } ?>
		<?php if(allow('ban')) { ?><span class="BulletIcons violeta"></span> <a href="/admin/baneados/"  title="Usuarios baneados">Usuarios baneados</a><br><?php } ?>
		<?php if(allow('track_ip')) { ?><span class="BulletIcons violeta"></span> <a href="/admin/rastrear-ip/"  title="Rastrear IPs">Rastrear IPs</a><br> <?php } ?>
		<?php if(allow('censure')) { ?><span class="BulletIcons violeta"></span> <a href="#" onclick="admin.censor_words(); return false" title="Palabras censuradas">Palabras censuradas</a><br><?php } ?>
		<?php if(allow('friend_sites')) { ?><span class="BulletIcons violeta"></span> <a href="/admin/friends/" title="Patrocinados">Patrocinados (webs amigas)</a><br><?php } ?>
		<?php if(allow('manage_news')) { ?><span class="BulletIcons violeta"></span> <a href="#" onclick="admin.news(); return false" title="Administrar noticias">Administrar noticias</a><br><?php } ?>
		<?php if(allow('stitches')) { ?><span class="BulletIcons violeta"></span> <a href="#" onclick="admin.add_points(); return false" title="Dar puntos">Dar puntos a alguien</a><br><?php } ?>
		<?php if(allow('edit_ranks')) { ?><span class="BulletIcons violeta"></span> <a href="/admin/rangos/" title="Rangos">Rangos</a><br><?php } ?>
        <?php if(allow('ban_ip')) { ?><span class="BulletIcons verde"></span> <a href="/admin/ipban/" title="Rangos">Banear IPs</a><br><?php } ?>
        <?php if(allow('edit_settings')) { ?><span class="BulletIcons naranja"></span> <a href="/admin/config/" title="Script">Configuraci&oacute;n del script</a><br><?php } ?>
        <?php if(allow('edit_settings')) { ?><span class="BulletIcons rojo"></span> <a href="/admin/remove/" title="Script">Eliminar masivamente</a><br><?php } ?>
		<?php
        if(allow('show_contact')) {
        $num = mysql_num_rows(mysql_query('SELECT `id` FROM `contact`'));
        ?>
        <span class="BulletIcons violeta"></span> <a href="/admin/contactantes/"<?=($num ? ' style="color: red; font-weight:bold;"' : '');?> title="Contactantes">Ver contactantes</a><?=($num ? ' ('.$num.')' : '');?><br>
        <?php
        }
        ?>
		<?php if(allow('show_mps')) { ?><span class="BulletIcons violeta"></span> <a href="/admin/mensajes/"  title="Mensajes">Centro de mensajes</a><br><?php } ?>
	</div>
    <?php
    } /* Muchos ifs la puta madre ._. */
    ?>
</div>
<?php
}
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/adm/'.$_GET['action'].'.php')) {
  include($_SERVER['DOCUMENT_ROOT'].'/adm/'.$_GET['action'].'.php');
} else fatal_error('Error harry');
?>
<div style="clear:both"></div></div>    </div>