<?php
header ("content-type: text/xml");
include('config.php');
include('functions.php');
echo '<?xml version="1.0" encoding="UTF-8"?> <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$eeeer34 = mysql_query("SELECT p.id, p.author, p.cat, p.title, p.time, p.points, p.private, p.sticky, u.nick, c.name, c.url FROM posts AS p LEFT JOIN users AS u ON p.author = u.id LEFT JOIN categories AS c ON c.id = p.cat WHERE p.status = '0'");
while($row = mysql_fetch_assoc($eeeer34)){
    $time = date("Y-m-d",$row['time']);
    echo'<url>
    <loc>'.$config['url'].'/posts/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html</loc>
    <lastmod>'.$time.'</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
    </url>';
    }
echo '</urlset>';
?>