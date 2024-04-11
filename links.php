<?php
include('config.php');
include('functions.php');



$link = mysql_clean($_REQUEST['get']);

if(!$link)
{
header("Location: /index.php");
}
if(!filter_var($link, FILTER_VALIDATE_URL)){
fatal_error('url no v&aacute;lida');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html version="XHTML+RDFa 1.0"  xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es" >
		<head>
			<meta http-equiv="X-UA-Compatible" content="chrome=1" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title><?=$config['name'];?> | Links</title>
			<style>
				body {
					padding:0;
					margin:0;
					line-height:1.3em;
					font-family: "Lucida Grande",Tahoma,Arial,Verdana,Sans-Serif;
					font-size:11px;	
					background:#F4F4F4;
				}
				a {cursor:pointer;text-decoration:none;color:#333;}
				a:link{text-decoration:none;color:#333;}
				a:visited{text-decoration:none;color:#333;}
				a:active{color:#333;outline:none;}
				a:focus{color:#333;outline:none;}
				a:hover{text-decoration:underline;color:#000000;}
				#header_content{
					background:transparent url("<?=$config['images'];?>/images/bg-headerLink.png") repeat-x top left;
					width:100%;
					height:100px;
				}
				#header{
					width:742px;
					margin:0 auto;
					position:relative;
				}
				#container_max{
					width:742px;
					margin:0 auto;
					position:relative;
				}
				#banners_container{
					background:#FFFFFF;
					border:1px solid #C6C3C6;
					padding:6px;
					height:auto;
					width:auto;
				}
			</style>

		</head>
		<body>
			<div id="header_content">
				<div id="header">
					<div align="center"><img src="<?=$config['images'];?>/images/moovax-links.png" alt="<?=$config['name'];?> Links" title="<?=$config['name'];?> Links" /></div>
				</div>
			</div>
			<div id="container_max"><h1><a href="<?=$link;?>" rel="nofollow" title="Continuar">Continuar</a></h2>

				<div id="banners_container" align="center">
					
					<div style="clear:both;"></div>
				</div>
				<br />
				<div id="banners_container" align="center">

					<div style="clear:both;"></div>

				</div>
			</div>
		</body>
	</html>
