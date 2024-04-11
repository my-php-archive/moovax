<?php
if(!defined($config['define'])) { die; }
?>
<script type="text/javascript">
  var ancho=new Array();
  var alto=new Array();
  ancho['0']=350;
  alto['0']=100;
  ancho['1']=200;
  alto['1']=200;
  ancho['2']=200;
  alto['2']=250;
  ancho['3']=285;
  alto['3']=134;
  ancho['4']=200;
  alto['4']=300;
  ancho['5']=320;
  alto['5']=100;
  ancho['6']=320;
  alto['6']=200;
  ancho['7']=320;
  alto['7']=300;

  var color = new Array();
  color['0'] = "rojo";
  color['1'] = "amarillo";
  color['2'] = "gris";
  color['3'] = "rosa";
  color['5'] = "violeta";
  color['6'] = "verde";
  color['7'] = "turquesa";


  function actualizar_preview(noselect){
    document.getElementById("cantidad").value = parseInt(document.getElementById("cantidad").value);
  	if (isNaN(document.getElementById("cantidad").value)) {
		  document.getElementById("cantidad").value="";
      alert("Debes ingresar un valor numerico para este campo!");
		  return;
	  }
    if (!document.getElementById("cantidad").value){
      alert("Debes ingresar un valor num&eacute;rico en el campo cantidad de posts listados");
      document.getElementById("cantidad").focus();
      return;
    }
    if (document.getElementById("cantidad").value > 50){
      alert("La cantidad maxima de posts listados es de 50");
      document.getElementById("cantidad").focus();
      return;
    }
    code='<div style="border: 1px solid rgb(213, 213, 213); padding: 2px 5px 5px; background: #D7D7D7 url(<?=$config['images'];?>/images/widget/widget-'+ color[document.getElementById("color").value] + '.gif) repeat-x scroll center top; width: '+ ancho[document.getElementById("tamano").value] + 'px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; text-align: left;"><a href="<?=$config['url'];?>"><img src="<?=$config['images'];?>/images/widget/widget-logo.png" alt="<?=$config['url'];?>"  style="border: 0pt none; margin: 0px 0px 5px 5px;" /></a><br><iframe src="<?=$config['url'];?>/share.php?cat=' + document.getElementById("categ").value + '&cantidad='+ document.getElementById("cantidad").value + '&an='+ ancho[document.getElementById("tamano").value] + '&color='+ color[document.getElementById("color").value] + '" style="border: 1px solid rgb(213, 213, 213); margin: 0pt; padding: 0pt; width: '+ ancho[document.getElementById("tamano").value] + 'px; height: '+ alto[document.getElementById("tamano").value] + 'px;" frameborder="0"></iframe></div>';

    document.getElementById("widget-preview").innerHTML=code;
    document.getElementById("codigo").value=code;
    focus_code(noselect);
    return;
  }

  function focus_code(noselect){
    if(!noselect)
      document.getElementById("codigo").focus();
    document.getElementById("codigo").select();
    return;
  }

</script><div class="breadcrumb">
	<ul>
		<li class="first"><a href="/" accesskey="1" class="home"></a></li>
		<li><a href="/static/widget/">Widget</a></li>
		<li class="last"></li>
	</ul>
</div>
<div class="clear"></div>

<div><div class="box_title_content">
<div class="box_txt">Widget <?=$config['name'];?></div></div>
<div class="box_cuerpo_content">
      Integra los &uacute;ltimos posts de <?=$config['name'];?> en tu Web y estate siempre actualizado.<br />

      En solo segundos podr&aacute;s tener un listado que estar&aacute; siempre
      actualizado con los &uacute;ltimos posts publicados en <?=$config['name'];?>.<br />

      Podes personalizar el listado para que se adapte al estilo de tu sitio, podes cambiar su tama&ntilde;o, color, cantidad de posts a listar y hasta podes filtrar por categor&iacute;as.<br /><br />

      <b>Como implementarlo:</b><br />
      <b>1.</b> Personalizalo a tu gusto. Cambiale color, y elejile el tama&ntilde;o.<br />

      <b>2.</b> Copia el c&oacute;digo generado y pegalo en tu p&aacute;gina.<br />

      <b>3.</b> Listo. Ya podes disfrutar de <?=$config['name'];?> Widget<br />
</div><br class="space">

<table width="100%" height="1">
  <tr>
    <td width="192" height="1" bgcolor="#d8e2f8"  style="border:1px dashed #CCC;">
    <p align="center"><b><font color="#000">Personalizaci&oacute;n</font></b></td>
    <td width="335" height="1" bgcolor="#d8e2f8"  style="border:1px dashed #CCC;">
    <p align="center"><b><font color="#000">C&oacute;digo embed</font></b></td>
  <td width="397" height="1" bgcolor="#d8e2f8"  style="border:1px dashed #CCC;">
  <p align="center"><b><font color="#000">Widget de ejemplo</font></b></td>
  </tr>
  <tr><td width="192" height="1" style="border:1px dashed #CCC;">
    <p align="left"><b>Categor&iacute;a:</b>
    <select id="categ" onchange="actualizar_preview();">
    <option selected="selected" value="0">Todas</option><?php
    $cat = mysql_query('SELECT `id`, `name` FROM `categories` ORDER BY `name` ASC');
    while($r = mysql_fetch_row($cat)) {
      echo '<option value="'.$r[0].'">'.$r[1].'</option>';
    }
    ?></select></p>
             <p align="left"><b>Cantidad:</b> <input size="4" maxlength="2" id="cantidad" value="20" onchange="actualizar_preview();" type="text"> <span class="smalltext">(max 50)</span></p>
             <p align="left"><b>Tama&ntilde;o:</b> <select id="tamano" onchange="actualizar_preview();">
              <option value="0">350 x 100</option>
              <option value="1">200 x 200</option>
              <option value="2">200 x 250</option>
              <option value="3">285 x 134</option>
              <option value="4">200 x 300</option>
              <option value="5">320 x 100</option>
              <option value="6">320 x 200</option>
              <option value="7">320 x 300</option>
			</select></p>
			<p align="left"><b>Color:</b> <select id="color" onchange="actualizar_preview();">
			  <option value="0">Rojo</option>
			  <option value="1">Amarillo</option>
			  <option value="2" selected="selected">Gris</option>
			  <option value="3">Rosa</option>
			  <option value="5">Violeta</option>
			  <option value="6">Verde</option>
			  <option value="7">Turquesa</option>
			  </select></p>
			</td><td width="335" align="center" height="1" style="border:1px dashed #CCC;">
      <p align="center">
      <textarea id="codigo" cols="47" rows="6" onClick="focus_code();"></textarea></td>
  <td align="center" width="397" height="1" style="border:1px dashed #CCC;">
  <input type="hidden" size="4" maxlength="2" id="cantidad" value="20" onchange="actualizar_preview();" />
   <p align="center"><div id="widget-preview">
		</div><script type="text/javascript">
  actualizar_preview(1);
        </script><br></p></td>
  </table></div>
<div style="clear:both"></div></div>
	</div>