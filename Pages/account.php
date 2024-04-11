<?php
if(!defined($config['define'])) { die; }
if(!$logged['id']) { fatal_error('Debes de estar logueado para ver esta secci&oacute;n'); }
if(!in_array($_GET['tab'], array('profile', 'apariencie', 'avatar', 'firm', 'friends', 'privacy', 'password', 'background'))) { $_GET['tab'] = 'profile'; }
?>
<script type="text/javascript" src="/js/account.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="<?=$config['images'];?>/css/colorpicker.css" />
<script src="/js/colorpicker.js" type="text/javascript"></script>
<style>
body{
    background-position: 0 119px!important;
	background-image: url(<?=$logged['background'];?>);
	background-repeat: <?=($logged['background_repeat'] == 0 ? 'no-' : '');?>repeat;
	background-color: #<?=$logged['background_color'];?>
}
</style>
<div id="edit-profile-left">
		<div class="box_title_content">
			<div class="box_txt">
				Opciones
			</div>
		</div>

		<div class="box_cuerpo_content" style="padding:0px;">
			<div class="userOptions">
				<ul>
					<li><a onclick="account.tabs(0); return false;" href="/cuenta/" title="Editar perfil">Editar mi perfil</a></li>

					<li><a onclick="account.tabs(1); return false;" href="/cuenta/apariencia" title="Editar apariencia">Editar mi apariencia</a></li>
					<li><a onclick="account.tabs(2); return false;" href="/cuenta/avatar" title="Editar avatar">Editar mi avatar</a></li>
					<li><a onclick="account.tabs(3); return false;" href="/cuenta/firma" title="Editar firma">Editar mi firma</a></li>
                    <li id="newcolor" style="background-color: #<?=($logged['background_color'] ? $logged['background_color'] : 'facbfa');?>; background-image: url('<?=$logged['background'];?>');"><a onclick="account.tabs(7); return false;" href="/cuenta/background" title="Fondo de perfil">Fondo de perfil</a></li>

					<li><a onclick="account.tabs(4); return false;" href="/cuenta/amigos" title="Editar mis amigos">Editar mis amigos</a></li>
					<li><a onclick="account.tabs(5); return false;" href="/cuenta/privacidad" title="Configuraci&oacute;n de privacidad">Configuraci&oacute;n de privacidad</a></li>

					<li style="border-bottom:none;"><a onclick="account.tabs(6); return false;" href="/cuenta/password" title="Cambiar mi password">Cambiar mi password</a></li>
				</ul>
			</div>
		</div>

		<br class="space">
		<div class="box_title_content">
			<div class="box_txt">
				Mis fotos
			</div>

		</div>
		<div class="box_cuerpo_content" style="padding:0px;">
			<div class="userOptions">
				<ul>
					<li><a href="/fotos/agregar/" title="Agregar foto">Agregar foto</a></li>

					<li style="border-bottom:none;"><a href="/fotos/user/<?=$logged['nick'];?>" title="Ver mis fotos">Ver mis fotos</a></li>
				</ul>

			</div>
		</div>

		<br class="space">
	</div>

	<br class="space">
<div id="edit-profile-right">
<?php
include('./ajax/account.php');
?>
</div>
<div style="clear:both"></div>  </div>     </div>