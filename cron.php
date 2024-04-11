<?php
include('config.php');
include('functions.php');
//Optimizar tablas
mysql_query('OPTIMIZE TABLE `articles`, `banned`, `blocked`, `categories`, `censorship`, `comments`, `complaints`, `contact`, `countries`, `c_votes`, `drafts`, `favorites`, `friends`, `groups`, `groups_actions`, `groups_ban`, `groups_categories`, `groups_comments`, `groups_history`, `groups_members`, `groups_topics`, `groups_votes`, `help_categories`, `history_mod`, `ips_ban`, `mails`, `messages`, `news`, `notifications`, `online`, `photos`, `posts`, `post_visits`, `p_categories`, `p_comments`, `p_votes`, `ranks`, `status`, `s_points`, `urls`, `users`, `votes`, `walls`, `w_likes`, `w_replies`') or die(mysql_error());
//Vaciar contenido del log
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/logged_3040303.txt', '', FILE_USE_INCLUDE_PATH);
?>