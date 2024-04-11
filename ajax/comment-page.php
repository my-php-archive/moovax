<?php
if($_POST['id'] && $_POST['p']) {
  include('../config.php');
  include('../functions.php');
  $ajax = true;
} else {
  if(!$row['pid'] || !defined($config['define'])) { die; }
  $_POST['id'] = $row['pid'];
  $_POST['p'] = 1;
}
if(!ctype_digit($_POST['id'])) { die('0: La concha de tu hermana'); }
/* Young Turks eeeer34 (8) */
$comments = 'SELECT c.id, c.author, c.body, c.positive, c.negative, c.`time`, p.`status`, u.id AS id_user, p.author AS id_author, u.nick FROM comments AS c INNER JOIN `posts` AS p ON p.`id` = c.`id_post` INNER JOIN `users` AS u ON u.id = c.`author` WHERE p.id = \''.intval($_POST['id']).'\''.($ajax ? ' && p.`status` = \'0\'' : '').' ORDER BY c.`id` ASC';
$num = mysql_num_rows(mysql_query($comments));
$per = 100;
$_POST['p'] = (ctype_digit($_POST['p']) && $_POST['p'] ? $_POST['p'] : 1);
$limit = ($_POST['p']-1)*$per; //1:20
$tot = ceil($num / $per); //$per numtotal
if($_POST['p'] > $tot && $num) { die('0: Error provocado -mmm'); }
$i = 0;
$query = mysql_query($comments.' LIMIT '.$limit.', '.$per);
if($ajax) { echo '1: '; } 
if($num > $per) {
?>
<div class="paginadorCom">
<div class="before floatL"><a <?=($_POST['p'] <= 1 ? 'href="" onclick="return false" class="desactivado"' : 'href="#" onclick="comment.page('.($_POST['p']-1).'); return false"');?>><b>&laquo; Anterior</b></a>
</div>
<div style="float:left;width: 610px">
<ul>
<?php
for($i=1;$i<=$tot;$i++) {
   echo '<li class="numbers"><a '.($_POST['p'] == $i ? 'class="here" href="#"' : '').' onclick="'.($i != $_POST['p'] ? 'comment.page('.$i.'); ' : '').' return false">'.$i.'</a></li>';
}
?>
</ul>
</div>
<div class="floatR next"><a <?=(($_POST['p']) < $tot ? 'href="#" onclick="comment.page('.($_POST['p']+1).'); return false"' : 'href="#" onclick="return false" class="desactivado"');?>> <b>Siguiente &raquo;</b></a>
</div>
</div>
<div class="clearfix"></div>

<?php
}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('.numbersvotes .overview').bind('click', function(){ $(this).hide(); $(this).next().show(); });
	$('.numbersvotes .stats').bind('click', function(){ $(this).hide(); $(this).prev().show(); });
});
</script>
<div id="comments">
<?php
while($r = mysql_fetch_assoc($query)) {
  $styles = '';
  if($r['author'] == $logged['id']) { $styles = 'me'; }
  if($r['id_author'] == $r['author']) { $styles = 'autor'; }
?>

<div id="cmt_<?=$r['id'];?>">
<span id="comment_<?=$r['id'];?>" user_cmt="<?=$r['nick'];?>" text_cmt='<?=$r['body'];?>'></span>
<div class="comment-container<?=($styles ? '-'.$styles : '');?>">
<div class="comment-title">
<div class="floatL">
@<a class="hovercard" data-uid="<?=$r['author'];?>" href="/<?=$r['nick'];?>"><?=$r['nick'];?></a> - <span title="<?=date('d.m.Y', $r['time']);?> a las <?=date('G:i', $r['time']);?> hs." ts="<?=$r['time'];?>"><?=timefrom($r['time']);?></span> - dijo:
</div>

<div class="floatR answerOptions">
<ul>
<?php
$total = $r['positive'] - $r['negative'];
?>
<li class="numbersvotes"<?=($total == '0' ? ' style="display:none"' : '');?>>
<div class="overview" id="puts" name="puts">

<span class="<?=($total > 0 ? 'positivo' : 'negativo');?>"><?=($total > 0 ? '+'.$total : $total);?></span>
</div>
<div class="stats">
<span class="positivo">+<?=$r['positive'];?></span> / <span class="negativo">-<?=$r['negative'];?></span>
</div>
</li>
<?php
if($logged['id']) {
  if($r['author'] != $logged['id'] && $logged['id']) {
?>
<li class="icon-thumb-up"><a onclick="comment.vote(this, <?=$r['id'];?>, <?=$_POST['id'];?>, <?=$key;?>, 1, 'post')"><span class="voto-p-comentario"></span></a></li>
<li class="icon-thumb-down"><a onclick="comment.vote(this, <?=$r['id'];?>, <?=$_POST['id'];?>, <?=$key;?>, -1, 'post')"><span class="voto-n-comentario"></span></a></li>
<?php
}
?>
<li class="answerPerfil"><a href="/<?=$r['nick'];?>"  title="Ver perfil de <?=$r['nick'];?>" target="_self"><span class="ver-perfil"></span></a></li>
<li class="answerCitar"><a onclick="citar_comment(<?=$r['id'];?>); return false" href="#" title="Citar Comentario"><span class="citar-comentario"></span></a></li>
<?php
if(allow('delete_comments') || $logged['id'] == $r['author'] || $logged['id'] == $r['id_author']) {
?>
<li class="answerBorrar"><a onclick="if (!confirm('\xbfEstas seguro que deseas eliminar este comentario?')) return false; posts.del_comment('<?=$r['id'];?>','<?=$logged['id'];?>'); return false" href="#" title="Eliminar comentario"><span class="borrar-comentario"></span></a></li>
<?php
}
}
?>
</ul>
</div>
<div class="clear"></div>
</div>
<div class="comment-cuerpo"><?=BBposts($r['body'], false, true, false);?><div class="clearBoth"></div></div>
</div>
<div class="clear"></div>
<br class="space">
</div>
<?php
}
echo '</div>';
if($num > $per) {
?>
<div class="paginadorCom">
<div class="before floatL"><a <?=($_POST['p'] <= 1 ? 'href="" onclick="return false" class="desactivado"' : 'href="#" onclick="comment.page('.($_POST['p']-1).'); return false"');?>><b>&laquo; Anterior</b></a>
</div>
<div style="float:left;width: 610px">

<ul>
<?php
for($i=1;$i<=$tot;$i++) {
  echo '<li class="numbers"><a '.($_POST['p'] == $i ? 'class="here" href="#"' : '').' onclick="'.($i != $_POST['p'] ? 'comment.page('.$i.'); ' : '').' return false">'.$i.'</a></li>';
}
?>
</ul>
</div>

<div class="floatR next"><a <?=(($_POST['p']) < $tot ? 'href="#" onclick="comment.page('.($_POST['p']+1).'); return false"' : 'href="#" onclick="return false" class="desactivado"');?>> <b>Siguiente &raquo;</b></a>
</div>
</div>

<div class="clearfix"></div>
<?php
}
?>
