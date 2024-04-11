<?php
if(!defined('adm')) { die; }
if(!$logged['id']) { fatal_error('Logueate'); }
if(!allow('edit_settings')) { fatal_error('No tienes permisos para acceder a esta secci&oacute;n'); }
$types = array('name' => 'Nombre del script', 'slogan' => 'Slogan de tu web', 'url' => 'URL de la web', 'search_url' => 'URL del buscador', 'images' => 'Ruta de las imagenes', 'define' => 'Nombre del define', 'mail' => 'Mail', 'recaptcha_publickey' => 'Captcha: public key', 'cookie_name' => 'Nombre de la cookie', 'years' => 'Edad m&iacute;nima requerida', 'manteniance' => array('Desactivado' => false, 'Activado' => true), 'idioma' => 'Idioma del script', 'bd_host' => 'MySQL host', 'bd_user' => 'MySQL user', 'bd_pass' => 'MySQL password', 'bd_name' => 'MySQL name');
$radio = array('manteniance' => 'Modo de mantenimiento');
?>
<style>
.data{
  padding: 6px 8px;
	border-bottom:1px dotted #AEAEAE

}
</style>
<div id="adm-right">
    <div id="ajax">
        <div class="box_title_content">
        <div class="box_txt">
        Configuraci&oacute;n general (&Uacute;ltima vez modificado: Bebe bonita eeeer34)
        </div>
        </div>
        <div class="box_cuerpo_content">
            <form id="new" style="text-align:3px;">
            <?php
            $i = 0;
            foreach($types as $name => $desc) {
              echo '<div class="data" style="background:#'.(substr($name, 0, 3) == 'bd_' ? 'FAD9D9' : (++$i == 1 ? 'FFFCEB' : 'EAFEFC')).'">';
              if(is_array($desc)) {
                echo '<b>'.$radio[$name].'</b>: <select name="'.$name.'">';
                foreach($desc as $radio => $value) {
                  echo '<option'.($config[$name] == $value ? ' selected="selected"' : '').' value="'.$value.'">'.$radio.'</option>';
                }
                echo '</select>';
              } else {
                echo $desc.': <input type="text" id="'.$name.'" name="'.$name.'" value="'.($name != 'bd_pass' ? $config[$name] : '').'" />';
              }
              echo '</div>';
              $i = ($i == 2 ? 0 : 1);
            }
            ?>


            </form>
        <div id="load-ajax" style="display: none;"><center><img src="<?=$config['images'];?>/images/loading.gif" /></center></div>
        <div id="success" style="display: none;" class="yellowBox size12"></div>
        </div>

    </div>
    <br />
    <span class="floatR"><input class="Boton Small BtnPurple" onclick="admin.load_settings(); return false;" value="Guardar cambios" type="button" /></span>
</div>