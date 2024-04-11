<?php
if(!defined('search')) { die; }
?>
<script>
var search_url = '<?=$config['search_url'];?>';
</script>
<body class="home <?=$class;?>" style="background:#EDEDED url('http://i.imgur.com/4jCBw.png');">
  <div id="wrapper">
  <div class="taringa-search">
    <div class="taringa-bar">
      <ul class="search-options"  style="height:27px;	margin:0 auto;	padding:0;	width:610px;">
        <li<?=(!$_GET['sa'] || $_GET['sa'] == 'posts' ? ' class="active"' : '');?>><a href="" onclick="window.search.home_change('posts', this); return false">Posts</a></li>
        <li<?=($_GET['sa'] == 'groups' ? ' class="active"' : '');?>><a href="" onclick="window.search.home_change('comunidades', this); return false">Comunidades</a></li>
        <li<?=($_GET['sa'] == 'topics' ? ' class="active"' : '');?>><a href="" onclick="window.search.home_change('internet', this); return false">Temas</a></li>
        <li id="logo">
        </li>
      </ul>
    </div>
    <div class="search clearfix">
      <div class="search-box">
      <form class="clearfix" name="search-box" style="padding:0;margin:0" action="<?=$config['search_url'];?>/<?=($_GET['sa'] == 'groups' ? 'comunidades' : ($_GET['sa'] == 'topics' ? 'temas' : 'posts'));?>/" method="GET" onsubmit="window.search.onsubmit()">
        <div class="input-left"></div>
        <input type="text" autocomplete="off" class="sinput" value="" name="q" title="Search" >
        <input type="hidden" name="engine" value="web" />
        <div class="input-right"></div>
        <div class="btn-search floatL">
        <a href="javascript:$('form[name=search-box]').submit()"></a>
        </div>
      </form>
      <div class="filter-adv open">
        <div>
        <div class="filterSearch clearfix" style="display:none">
          <div id="filterPosts"<?=($_GET['sa'] != 'posts' ? ' style="display:none;"' : '');?>>
            <div class="floatL">
              <ul class="clearfix">
                <li>
                  <label>Categor&iacute;a</label>
                  <select class="filterCategoria" onchange="search.q_focus()">
                  <option value="-1" selected="selected" autocomplete="off">Todas</option>
                  <?php
                  $query = mysql_query('SELECT `name`, `url` FROM `categories` ORDER BY `name` ASC');
                  while($r = mysql_fetch_row($query)) {
                    echo '<option value="'.$r[1].'">'.$r[0].'</option>'."\n";
                  }
                  ?>
                  </select>
                </li>
                <li>
                  <span>
                  <label>Autor</label>
                  <input type="text" class="filterAutor" value="" onkeypress="window.search.intro_submit(event)" />
                  </span>
                </li>
              </ul>
            </div>
          </div>
          <div id="filterComunidades"<?=($_GET['sa'] != 'groups' && $_GET['sa'] != 'topics' ? ' style="display:none;"' : '');?>>
            <div class="floatL">
              <ul class="clearfix">
              <li>
                <label>Categor&iacute;a</label>
                <select class="filterCategoria" onchange="search.q_focus()">
                <option value="-1">Todas</option>
                <?php
                $query = mysql_query('SELECT `name`, `url` FROM `groups_categories` ORDER BY `name` ASC');
                while(list($name, $url) = mysql_fetch_row($query)) {
                  echo '<option value="'.$url.'">'.$name.'</option>';
                }
                ?>
                </select>
              </li>
              </ul>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        </div>
        <a onclick="window.search.filterSearch_show(); return false" class="search-btn-option">Opciones</a>
        <script type="text/javascript">$('form[name="search-box"] input[name="q"]').focus(); search.home_change_actual = '<?=$class;?>';</script>
      </div>
      <div class="clearBoth"></div>
      </div>
    </div>

    <script type="text/javascript">
    	var optionst = {
    		'pubId' : 'pub-5717128494977839',
    		'query' : "",
    		'container' : 'avisosTop',
    		'number' : '3',
    		'channel' : '4859299527',
    		'colorText' : '#000000',
    		'colorTitleLink' : '#0000de',
    		'colorDomainLink' : '#228822',
    		'colorBackground' : '#FFFFFF',
    		'colorBorder': '#FFFFFF',
    		'colorText' : '#666666',
    		'linkTarget' : '_blank',
    		'hl' : 'es',
    		'adsafe' : 'low'
    	};
    	var optionsv = {
    		'pubId' : 'pub-5717128494977839',
    		'query' : "",
    		'container' : 'avisosVert',
    		'number' : '8',
    		'channel' : '2380070868',
    		'format' : 'narrow',
    		'colorText' : '#000000',
    		'colorTitleLink' : '#0000de',
    		'colorDomainLink' : '#228822',
    		'colorBackground' : '#ffffff',
    		'colorBorder': '#ffffff',
    		'colorText' : '#666666',
    		'linkTarget' : '_blank',
    		'hl' : 'es',
    		'adsafe' : 'low'
    	};
    	var dynamicAd = new google.ads.search.Ad(optionst);
    	var dynamicAd = new google.ads.search.Ad(optionsv);
    </script>
    <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
    try {
    var pageTracker = _gat._getTracker("UA-91290-9");
    pageTracker._trackPageview();
    } catch(err) {}
    </script>
  </div>
</body>
</html>