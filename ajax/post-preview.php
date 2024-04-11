<?php
include('../config.php');
include('../functions.php');
if(!$key) { die('0: No est&aacute;s logueado'); }
if(!$_POST['titulo']) { die('0: El campo <b>titulo</b> es requerido'); }
if(!$_POST['cuerpo']) { die('0: El campo <b>cuerpo</b> es requerido'); }
if(strlen($_POST['cuerpo']) < 100) { die('0: El post debe de tener 100 caracteres como minimo'); }
if(strlen($_POST['titulo']) > 90) { die('0: El titulo no debe de exceder los 90 caracteres'); }
if(!$_POST['add']) { die; }
//if(!$_POST['categoria']) { die('0: El campo categor&iacute;a es requerido'); }
//if(!mysql_num_rows(mysql_query('SELECT `id` FROM `categories` WHERE `id` = \''.intval($_POST['categoria']).'\''))) { die('0: La categor&iacute;a no existe '.$_POST['categoria']); }
?>
1:
<form style="margin: 0;" id="addPost" name="addPost" accept-charset="UTF-8" method="post" action="/posts/agregar/enviando/">
<div class="displayN" id="preview" style="display: inline;"><div style="margin-bottom:8px">
	<div id="ver-post-left">
		<div id="shadow_p">
				<div class="box_title_content">
					<div class="box_txt">Posteado por</div>
				</div>
						<div style="background:#F3F2F3;" class="box_cuerpo_content">
								<div class="avatarBox">
									<a title="Ver Perfil" href="/perfil/<?=$logged['nick'];?> /">
										<img border="0" onerror="error_avatar(this)" alt="Avatar" src="<?=$logged['avatar'];?>">
									</a>

								</div>
								<div align="center"><img width="130" height="10" border="0" style="margin-bottom:3px" src="<?=$config['images'];?>/images/avatarShadow.png"></div>
                            <?php
                            if(!empty($logged['message'])) { echo '<div align="center" class="messageBox">'.$logged['message'].'</div>'; }
                            ?>
							<span class="nick-poster">
								<a href="/perfil/<?=$logged['nick'];?> /">
									<?=$logged['nick'];?>
								</a>
							</span>
							<br> 
                   							<b style="font-size:11px;color:#454545;text-shadow:0 1px 0 #FFFFFF;"></b>

							<span title="">
                            <?php
                            $rank = mysql_fetch_row(mysql_query('SELECT `name`, `img` FROM `ranks` WHERE `id` = \''.$logged['rank'].'\''));
                            ?>
                            <img border="0" src="<?=$config['images'];?>/images/rangos/<?=$rank[1];?>">
                            </span> <img border="0" title="<?=($logged['sex'] == '0' ? 'Hombre' : 'Mujer');?>" src="<?=$config['images'];?>/images/<?=($logged['sex'] == '0' ? 'Hombre' : 'Mujer');?>.gif">
                            <?php
                            if(mysql_num_rows($query = mysql_query('SELECT `name`, `img_pais` FROM countries WHERE id = \''.$logged['country'].'\''))) {
                              $row = mysql_fetch_row($query);
                              echo '<span title="'.$row[0].'"><img align="absmiddle" src="'.$config['images'].'/images/icons/banderas/'.strtolower($row[1]).'.png" title="'.$row[0].'" alt=""></span>';
                            } else { echo '<span title="Otro pais"><img align="absmiddle" src="'.$config['images'].'/images/icons/banderas/ot.gif" title="Otro país" alt=""></span>'; }
                            ?>

<hr class="divider"><div class="metadata-usuario">
								<span class="nData"><span id="cant_pts_post"><?=$logged['points'];?></span></span>
								<span class="txtData">Puntos</span>

								<span class="nData"><a style="color: rgb(1, 150, 255);" target="_blank" href="/perfil/DrDexter/posts/"><?=mysql_num_rows(mysql_query('SELECT id FROM `posts` WHERE author = \''.$key.'\' && `status` = \'0\''));?></a></span>
								<span class="txtData"><a target="_blank" href="/perfil/<?=$logged['nick'];?> /posts/">Posts</a></span>

								<span class="nData"><a style="color: rgb(69, 108, 0);" target="_blank" href="/perfil/DrDexter/comentarios/"><?=mysql_num_rows(mysql_query('SELECT id FROM comments WHERE author = \''.$key.'\''));?></a></span>
								<span class="txtData"><a target="_blank" href="/perfil/<?=$logged['nick'];?> /comentarios/">Comentarios</a></span>
							</div>
						</div>
					</div>
				</div>
					<div id="ver-post-right">
						<div class="post-title"><?=htmlspecialchars($_POST['titulo']);?></div>
						<div style="margin-bottom:6px;border-bottom:1px solid #CFCFCF;" class="post-container">
						<?php
                        echo BBposts(htmlspecialchars($_POST['cuerpo']));
                        ?>
				<div class="clear"></div>
				</div>
				<div align="center" style="margin-bottom: 6px;">
					<input type="button" title="Agregar post" value="Agregar post" class="Boton BtnBlue" onclick="posts.<?=($_POST['add'] == '1' ? 'add_post()' : 'edit_post()');?>"> <input type="button" title="Cerrar la previsualización" value="Cerrar la previsualización" class="Boton BtnGray" onclick="posts.close_prev()">
				</div>
				</div><div class="clear">