<?php
if(!defined($config['define'])) { die; }
define('ok', true);
if(!$_GET['id']) { fatal_error('Faltan datos'); }
$qs = mysql_query('SELECT * FROM `users` WHERE '.(ctype_digit($_GET['id']) ? '`id`' : '`nick`').' = \''.mysql_clean($_GET['id']).'\'');
//if(!mysql_num_rows($qs) && $_GET['uri']) { die(include('404.php')); }
$_SERVER['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : $_SERVER['X_FORWARDED_FOR'];
if(!mysql_num_rows($qs)) {
  if($_GET['uri']) { include('not.php'); }
  fatal_error('El usuario ingresado no existe');
}
$row = mysql_fetch_assoc($qs);
//$_SERVER['REMOTE_ADDR'] = '300';
if(!mysql_num_rows(mysql_query('SELECT `id` FROM `post_visits` WHERE `ip` = \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\' && `type` = \'1\' && `post` = \''.$row['id'].'\'')) && $_SERVER['REMOTE_ADDR'] && $_SERVER['REMOTE_ADDR'] != $row['lastip']) {
  mysql_query('INSERT INTO `post_visits` (`post`, `ip`, `time`, `type`) VALUES (\''.$row['id'].'\', \''.mysql_clean($_SERVER['REMOTE_ADDR']).'\', \''.time().'\', \'1\')') or die(mysql_error());
}
if(!$_GET['sa'] || !in_array($_GET['sa'], array('muro', 'informacion', 'posts', 'comentarios', 'amigos', 'fotos', 'actividad'))) { $_GET['sa'] = 'muro'; }
switch($_GET['sa']) {
  case 'muro':
    $query = mysql_query('SELECT w.*, u.nick, u.avatar FROM `walls` AS w INNER JOIN `users` AS u ON u.id = w.author WHERE w.profile = \''.$row['id'].'\' ORDER BY w.id DESC') or die(mysql_error());
    $tab = 'wall';
    $currenttab = '0';
    break;
  case 'informacion':
    $tab = 'info';
    $currenttab = '1';
    break;
  case 'posts':
    $query = mysql_query('SELECT p.`id`, p.`title`, cat.`url`, cat.`name`, `p`.`points` FROM `posts` AS p INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE p.`author` = \''.$row['id'].'\' && p.`status` = \'0\' ORDER BY p.`id` DESC LIMIT 15');
    if(mysql_num_rows($query)) {
      $tot = mysql_num_rows(mysql_query('SELECT `id` FROM `posts` WHERE `author` = \''.$row['id'].'\' && `status` = \'0\''));
      $posts = true;
    }
    $tab = 'posts';
    $currenttab = '2';
    break;
  case 'comentarios':
    $query = 'SELECT p.id, p.title, cat.url, c.body, c.`time` FROM `posts` AS p INNER JOIN `comments` AS c ON c.id_post = p.id INNER JOIN `categories` AS cat ON cat.id = p.cat WHERE c.`author` = \''.$row['id'].'\' && p.`status` = \'0\' ORDER BY c.`id` DESC';
    $tab = 'comments';
    $currenttab = '3';
    break;
  case 'amigos':
    $query = 'SELECT u.id as uid, u.nick, u.status, u.avatar, p.img_pais, p.`name`, f.`time`, f.`id` FROM `users` AS u INNER JOIN `friends` AS f ON IF(f.`author` = \''.$row['id'].'\', f.`user`, f.`author`) = u.id RIGHT JOIN `countries` AS p ON p.id = u.country WHERE (`f`.`author` = \''.$row['id'].'\' || f.`user` = \''.$row['id'].'\') && f.`status` = \'1\' ORDER BY f.`id` DESC';
    $tab = 'friends';
    $currenttab = '4';
    break;
  case 'fotos':
    $query = 'SELECT p.id, p.title, p.`time`, p.votes, cat.url, cat.name FROM `photos` AS p INNER JOIN `p_categories` AS cat ON cat.id = p.cat WHERE p.`author` = \''.$row['id'].'\' && p.status = \'0\' ORDER BY p.id DESC';
    $tab = 'photos';
    $currenttab = '5';
    break;
  case 'actividad':
    $query = '';
    $tab = 'activity';
    $currenttab = '6';
}
?>
<style>
body{
    background-position: 0 119px!important;
	background-image: url(<?=$row['background'];?>);
	background-repeat: <?=($row['background_repeat'] == 0 ? 'no-' : '');?>repeat;
	background-color: #<?=$row['background_color'];?>
}
</style>
<div id="perfil-left">
	<div class="box_cuerpo_content" style="border-top:1px solid #C9CACB;">
		<div class="av_content">
			<div class="avatar_box">
				<img src="<?=$row['avatar'];?>" alt="Avatar de <?=$row['nick'];?>" onerror="error_avatar(this)" border="0">
			</div>
			<div class="user_data">
    			<ul>
    			    <li class="username"><a href="/<?=$row['nick'];?>">@<?=$row['nick'];?></a></li><br>
    				<hr class="divider">
    				<li><img src="<?=$config['images'];?>/images/profile_stats.png" align="top">&nbsp;<b><?=mysql_num_rows(mysql_query('SELECT `id` FROM `post_visits` WHERE `type` = \'1\' && `post` = \''.$row['id'].'\''));?></b> visitas al perfil</li>
                    <?php
                    if($logged['id']) {
                        if($logged['id'] != $row['id'] && $row['friends_request'] == '0') {
                            $friend = mysql_num_rows(mysql_query('SELECT `id` FROM `friends` WHERE ((`author` = \''.$logged['id'].'\' && `user` = \''.$row['id'].'\') || (`user` = \''.$logged['id'].'\' && `author` = \''.$row['id'].'\')) && `status` = \'1\''));
                    ?>
    				<li id="mostrar_agregar"<?=($friend ? ' style="display:none"' : '');?>><img src="<?=$config['images'];?>/images/add_buddy.png" align="top"> <a href="#" onclick="friends.add_form('<?=$row['id'];?>'); return false;" title="A&ntilde;adir a mis amigos" > Agregar a mis amigos</li>
    				<li id="mostrar_eliminar"<?=(!$friend ? ' style="display:none"' : '');?>><img src="<?=$config['images'];?>/images/del_buddy.png" align="top"> <a href="#" onclick="friends.del_form('<?=$row['id'];?>'); return false;" title="Dejar de ser amigos" > Eliminar amistad</li>
                <?php
                    }
                    if($logged['id'] != $row['id']) {
                      echo '<li><img src="'.$config['images'].'/images/report.png" align="absmiddle" > <a onclick="web.denounce_user(\''.$row['id'].'\'); return false;" title="Denunciar">Denunciar</a></li>';
                      $num = mysql_num_rows(mysql_query('SELECT `id` FROM `blocked` WHERE `author` = \''.$logged['id'].'\' && `user` = \''.$row['id'].'\''));
                      echo '<li id="bloquear"'.($num ? ' style="display: none;"' : '').'><img src="'.$config['images'].'/images/negative.png" align="absmiddle">  <a onclick="block(\''.$row['id'].'\',\'0\'); return false;" href="#">Bloquear</a></li>
                            <li id="desbloquear"'.(!$num ? ' style="display: none;"' : '').'><img src="'.$config['images'].'/images/positive.png" align="absmiddle">  <a onclick="block('.$row['id'].',1); return false;" href="#">Desbloquear</a></li>';
                    } else {
                      echo '<li><img src="'.$config['images'].'/images/settings.png" align="top"> <a href="/cuenta" title="Editar mi perfil">Editar mi perfil</a></li>
                            <li><img src="'.$config['images'].'/images/info.png" align="top" > <a href="/cuenta/apariencia" title="Editar mi informaci&oacute;n">Editar mi informaci&oacute;n</a></li></ul>';
                    }
                }
                ?>
                </ul>
			</div>

			<div class="clear"></div>
            <?php
            if(!empty($row['message'])) {
            ?>
            <!-- mensaje -->
            <br class="space"><hr class="divider">
			<div class="personal_txt"><?=$row['message'];?></div>
            <div class="clear"></div>
            <!-- fin mensaje -->
            <?php
            }
            ?>

		    <div style="display:block" id="menu_show" class="menu_data">
            <?php
            $ptitle = 'Desconectado';
            $pimg = 'user_offline.gif';
            if(mysql_num_rows(mysql_query('SELECT `id` FROM `online` WHERE `user` = \''.$row['id'].'\''))) {
              $ptitle = 'Conectado';
              $pimg = 'user_online.gif';
            }
            if($row['ban'] == '1'){
              $ptitle = 'suspendido';
              $pimg = 'suspendido.png';
            }
            ?>
    			<h6>Perfil <span style="float:right; margin: 5px 1px 0 0;"><img title="<?=$ptitle;?>" src="<?=$config['images'];?>/images/<?=$pimg;?>"></span></h6>
    			<ul>
    				<li<?=($_GET['sa'] == 'muro' ? ' class="selected"' : '');?> id="tab_0"><a onclick="profile_tab(0,<?=$row['id'];?>); return false;" href="/perfil/<?=$row['nick'];?>/muro/">Muro</a><span class="options muro"></span></li>
                    <li<?=($_GET['sa'] == 'actividad' ? ' class="selected"' : '');?> id="tab_6"><a onclick="profile_tab(6,<?=$row['id'];?>); return false;" href="/perfil/<?=$row['nick'];?>/actividad/">Actividad</a><img align="absmiddle" style="border: 3px;" src="<?=$config['images'];?>/images/icons/actividad.png" class="options actividad"></li>
    				<li<?=($_GET['sa'] == 'informacion' ? ' class="selected"' : '');?> id="tab_1"><a onclick="profile_tab(1,<?=$row['id'];?>); return false;" href="/perfil/<?=$row['nick'];?>/informacion/">Informaci&oacute;n</a><span class="options info"></span></li>
    				<li<?=($_GET['sa'] == 'posts' ? ' class="selected"' : '');?> id="tab_2"><a onclick="profile_tab(2,<?=$row['id'];?>); return false;" href="/perfil/<?=$row['nick'];?>/posts/">Posts</a><span class="options posts"></span></li>
    				<li<?=($_GET['sa'] == 'comentarios' ? ' class="selected"' : '');?> id="tab_3"><a onclick="profile_tab(3,<?=$row['id'];?>); return false;" href="/perfil/<?=$row['nick'];?>/comentarios/">Comentarios</a><span class="options comments"></span></li>
    				<li<?=($_GET['sa'] == 'amigos' ? ' class="selected"' : '');?> id="tab_4"><a onclick="profile_tab(4,<?=$row['id'];?>); return false;" href="/perfil/<?=$row['nick'];?>/amigos/">Amigos</a> <span class="options amigos"></span></li>
    				<li<?=($_GET['sa'] == 'fotos' ? ' class="selected"' : '');?> id="tab_5"> <a onclick="profile_tab(5,<?=$row['id'];?>); return false;" href="/perfil/<?=$row['nick'];?>/fotos/">Fotos</a><span class="options images"></span></li>
                    <?php
                    if($logged['id'] == $row['id']) { echo '<li'.($_GET['sa'] == 'editar' ? ' class="selected"' : '').'><a href="/cuenta">Editar mi perfil</a><span class="options account"></span></li>'; }
                    if($logged['id'] != $row['id'] && $logged['id']) { echo '<li><a href="#" onclick="mp.enviar_mensaje(\''.$row['nick'].'\'); return false">Enviar mensaje</a><span class="options sendpm"></span></li>'; }
                    ?>
    			</ul>
                <br>
                <?php
                /*if($logged['id'] == $row['id']) {
                  echo '<span class="floatL" >
    			        <b class="size12">Link para referencias:</b> <br>
    			        <input style="width:240px" type="text" readonly="true" value="'.$config['url'].'/registro/ref/'.$row['nick'].'">
    			        </span>';
                }*/
                ?>
    			<div class="clear"></div>
    			<br><br>
		    </div>
		    <div class="clear"></div>
		    <div class="corner-up"  title="Ocultar men&uacute;" onclick="tabs.user_info('hide');return false;"></div>
		</div>
		<div class="corner-down" title="Mostrar men&uacute;" onclick="tabs.user_info('show');return false;" style="display:none"></div>
	    <div class="user_info">
    		<h1>Datos</h1>
    		<div class="data_user">
    			<li>Nick: <span class="data-right"><a href="/<?=$row['nick'];?>" title="@<?=$row['nick'];?>">@<?=$row['nick'];?></a></span></li>
    			<li>Es usuario desde:<span class="data-right"><?=timefrom($row['time']);?></span></li>
    			<li>Sexo:<span class="data-right"><?=($row['sex'] == 0 ? 'Hombre' : 'Mujer');?> - <img src="<?=$config['images'];?>/images/<?=($row['sex'] == 0 ? 'Hombre' : 'Mujer');?>.gif" border="0" align="absmiddle"></span></li>
                <?php
                if(mysql_num_rows($pa = mysql_query('SELECT `name`, `img_pais` FROM `countries` WHERE `id` = \''.$row['country'].'\''))) {
                  $rw = mysql_fetch_row($pa);
                  $rw[1] = $rw[1].'.png';
                } else {
                  $rw = array('No definido', 'ot.gif');
                }
                $r = mysql_fetch_row(mysql_query('SELECT `name`, `img` FROM `ranks` WHERE `id` = \''.$row['rank'].'\''));
                ?>
    			<li>Ciudad:<span class="data-right"><?=$row['city'];?></span></li>
                <li>Pa&iacute;s:<span class="data-right"><img alt="" title="<?=$rw[0];?>" src="<?=$config['images'];?>/images/icons/banderas/<?=$rw[1];?>" align="absmiddle" /></span></li>
                <li>Puntos:<span class="data-right"><?=$row['points'];?></span></li>
    			<li>Rango:<span class="data-right"><?=$r[0];?> - <img src="<?=$config['images'];?>/images/rangos/<?=$r[1];?>" align="absmiddle"></span></li>
                <?php
                if($row['status'] != 0) {
                  $st = mysql_fetch_assoc(mysql_query('SELECT `name`, `img` FROM `status` WHERE `id` = \''.$row['status'].'\''));
                  echo '<li>Estado:<span class="data-right">'.$st['name'].' - <img title="'.$st['name'].'" src="'.$config['images'].'/images/estado/'.$st['img'].'" alt="" align="absmiddle" /></span></li>';
                }
                ?>
                <li>Entradas en su muro:<span class="data-right" id="cantmuro"><?=mysql_num_rows(mysql_query('SELECT `id` FROM `walls` WHERE `profile` = \''.$row['id'].'\''));?></span></li><div class="clear"></div>
    	    </div>
        </div>
    </div><br class="space"><div align="center" id="ads_300x250"></div>
    <?php
    if((allow('ban') || allow('track_ip') || allow('edit_user')) && $row['id'] != $logged['id']) {
    ?>
    <br class="space">
    <div class="box_title_content">
    	<div class="box_txt">
    		Opciones para <?=$row['nick'];?>
    	</div>
    </div>
    <div class="box_cuerpo_content" style="padding:0px">
        <div class="userOptions">
        	<ul>
            <?php if(allow('ban') && $row['ban'] == '0') { echo '<li><a href="#" onclick="admin.ban_form(\''.$row['id'].'\', \''.$row['nick'].'\'); return false">Banear a @'.$row['nick'].'</a></li>'; } ?>
            <?php if(allow('track_ip')) { echo '<li><a href="/admin/rastrear-ip/'.$row['lastip'].'">Rastrear IP de @'.$row['nick'].'</a></li>'; } ?>
            <?php if(allow('edit_user')) { echo '<li><a href="#" onclick="admin.edit_user(\''.$row['id'].'\'); return false;">Editar perfil de @'.$row['nick'].'</a></li>'; } ?>
            </ul>
    	</div>
    </div>
    <?php
    }
    ?>
</div>
<div id="perfil-center">
<!-- sin lo ponemos aca se va a borrar -sabeee -->
<script> var currenttab = '<?=$currenttab;?>'; </script>
<?php
include('profile-'.$tab.'.php');
?>

</div>
<div style="clear:both"></div>
</div>
</div>