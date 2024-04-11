<?php
include("../config.php");
include("../functions.php");
$rss = mysql_query('SELECT p.`id`, p.body, p.author, p.cat, p.title, p.time, p.points, p.private, p.sticky, u.nick, c.name, c.url FROM posts AS p LEFT JOIN users AS u ON p.author = u.`id` LEFT JOIN categories AS c ON c.`id` = p.cat WHERE p.status = \'0\' ORDER BY p.id DESC LIMIT 25') or die(mysql_error());
header('Content-Type: text/xml');

echo'<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:wfw="http://wellformedweb.org/CommentAPI/"
     xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
<title>'.$config['name'].' - &#218;ltimos 25 posts</title>
<description>&#218;ltimos 25 posts de moovax.net</description>
<image><title>Moovax!</title><link>'.$config['url'].'/</link><url>'.$config['images'].'/images/logo-rss.gif</url></image>
<generator>'.$config['url'].'</generator>
<language>es</language>
<link>'.$config['url'].'</link>';

while($row=mysql_fetch_assoc($rss)){
echo'
        <item>
			<title>'.$row['title'].' ('.$row['points'].' puntos)</title>
			<link>'.$config['url'].'/posts/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html</link>
			<pubDate>'.date("d.m.Y", date($row['time'])).' a las '.date("H:m:s", date($row['time'])).' hs.</pubDate>
			<category><![CDATA['.$row['url'].']]></category>
			<comments>'.$config['url'].'/posts/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html#comentarios</comments>

			<description><![CDATA['.cut(BBposts($row['body']),'501').'
            <p><strong><a href=\''.$config['url'].'/posts/'.$row['url'].'/'.$row['id'].'/'.url($row['title']).'.html\'>Seguir leyendo... >></a></strong></p>]]></description>
		</item>';
}
echo'
</channel>
</rss>';