function el(id){
  if(document.getElementById)
    return document.getElementById(id);
  else if(window[id])
    return window[id];
  return null;
}
var proc = Array();
if(!lang)
	var lang = Array();
/* Editor */
lang['ingrese el id de yt'] = "Ingrese el ID del video de YouTube:\n\nEjemplo:\nSi la URL de su video es:\nhttp://www.youtube.com/watch?v=JwQZQygg3Lk\nEl ID es: JwQZQygg3Lk";
lang['ingrese el id de yt IE'] = "Ingrese el ID del video de YouTube:\nPor ejemplo: CACqDFLQIXI";
lang['ingrese solo el id de yt'] = "Ingrese solo el ID de YouTube";
lang['ingrese solo el id de gv'] = "Ingrese solo el ID de GoogleVideo";
/* Fin Editor */
lang['error procesar'] = 'Error al intentar procesar tu solicitud!';


var clientPC = navigator.userAgent.toLowerCase();
var clientVer = parseInt(navigator.appVersion);

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1) && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1) && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);
var is_moz = 0;

/* Obtenemos el elemento */
function el(id){
  if(document.getElementById)
    return document.getElementById(id);
  else if(window[id])
    return window[id];
  return null;
}




function mozWrap(txtarea, open, close){
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if(selEnd == 1 || selEnd == 2)
    selEnd = selLength;
	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}

function hidediv(id){
	if(document.getElementById) // DOM3 = IE5, NS6
		document.getElementById(id).style.display = 'none';
	else{
    if(document.layers) // Netscape 4
      document.id.display = 'none';
    else // IE 4
      document.all.id.style.display = 'none';
  }
}

function showdiv(id){
	if(document.getElementById) // DOM3 = IE5, NS6
		document.getElementById(id).style.display = 'block';
	else{
		if(document.layers) // Netscape 4
			document.id.display = 'block';
		else // IE 4
			document.all.id.style.display = 'block';
	}
}

function createXMLHttpRequest(){
var xmlhttp = null;
try {xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");}
catch(e){alert("Tu explorador no soporta este sistema, Voope te recomienda que uses Firefox (http://es-ar.www.mozilla.com/es-AR/)");}return xmlhttp;}
var xhr = createXMLHttpRequest();

/* Citar comentarios */
function citar_comment(id) {
	var user = el('comment_' + id).getAttribute('user_cmt');
	var cita = el('comment_' + id).getAttribute('text_cmt');
	var text = ($('#VPeditor').val() != '') ? $('#VPeditor').val() + '\n': '';
	text += '[quote=' + user + ']' + cita + '[/quote]\n';
	$('#VPeditor').val(text);
	$('#VPeditor').focus()
}/* FIN Citar comentarios */

/* insertText */
function insertText(text, textarea) {
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange) {
		var caretPos = textarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ': text;
		caretPos.select()
	} else if (typeof(textarea.selectionStart) != "undefined") {
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var scrollPos = textarea.scrollTop;
		textarea.value = begin + text + end;
		if (textarea.setSelectionRange) {
			textarea.focus();
			textarea.setSelectionRange(begin.length + text.length, begin.length + text.length)
		}
		textarea.scrollTop = scrollPos
	} else {
		textarea.value += text;
		textarea.focus(textarea.value.length - 1)
	}
}
/* Box login */
function open_login_box(action) {
	if ($('#login_box').css('display') == 'block' && action != 'open') close_login_box();
	else {
		$('#login_error').css('display', 'none');
		$('.login_procesando').css('display', 'none');
		$('.login').addClass('here');
		$('#login_box').fadeIn('fast');
		$('#nickname').focus()
	}
};
function close_login_box() {
	$('.login').removeClass('here');
	$('#login_box').fadeOut('fast')
}
/* Fin Box login */

/* Funciones Posts */
var posts = {
	compartir: function () {
		$('#compartimela').slideDown('slow');
		$('#compartila').css('display', 'none');
		$('#no_me_la_compartas').css('display', 'block')
	},
	no_compartir: function () {
		$('#compartimela').slideUp('slow');
		$('#compartila').css('display', 'block');
		$('#no_me_la_compartas').css('display', 'none')
	},
	previsualiza_post: function (add) {
		$('#vp-loading').fadeIn('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/post-preview.php',
			data: 'titulo=' + encodeURIComponent($('#titulo').val()) + '&cuerpo=' + encodeURIComponent($('#VPeditor').val()) + '&add=' + add,
			cache: false,
			success: function (h) {
				$('#vp-loading').fadeOut('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#preview').html(h.substring(3));
					$('#preview').css('display', 'inline');
					scrollUp();
					break
				}
			},
			error: function () {
				$('#vp-loading').fadeOut('slow');
				dialogBox.error_500("posts.previsualiza_post()");
				return
			}
		})
	},
	close_prev: function () {
		$('#preview').children().children().slideUp('slow')
	},
	add_post: function () {
		var params = 'titulo=' + encodeURIComponent($('input[name="titulo"]').val()) + '&cuerpo=' + encodeURIComponent($('textarea[name="cuerpo"]').val()) + '&categoria=' + encodeURIComponent($('select[name="categorias"]').val());
		params += $('input[name="privado"]').is(':checked') ? '&privado=1': '';
		params += $('input[name="cerrado"]').is(':checked') ? '&cerrado=1': '';
		params += $('input[name="sticky"]').is(':checked') ? '&sticky=1': '';
		params += '&borrador= ' + $('#borrador').val();
		$('#vp-loading').fadeIn('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/post-add.php',
			data: params,
			cache: false,
			success: function (h) {
				$('#vp-loading').fadeOut('slow');
				$('#preview').children().children().fadeOut('fast');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#box-editor').fadeOut('slow');
					$('#return-add-post').html(h.substring(3));
					$('#return-add-post').addClass('post-agregado');
					$('#return-add-post').slideDown('fast');
					break;
				default:
					$('#box-editor').fadeOut('slow');
					$('#return-add-post').html(h.substring(3));
					$('#return-add-post').addClass('post-agregado');
					$('#return-add-post').slideDown('fast');
					break
				}
			},
			error: function () {
				$('#vp-loading').fadeOut('slow');
				dialogBox.error_500("posts.add_post()");
				return
			}
		})
	},
	edit_post: function () {
		var params = 'titulo=' + encodeURIComponent($('input[name="titulo"]').val()) + '&cuerpo=' + encodeURIComponent($('textarea[name="cuerpo"]').val()) + '&categoria=' + encodeURIComponent($('select[name="categorias"]').val());
		params += $('input[name="privado"]').is(':checked') ? '&privado=1': '';
		params += $('input[name="cerrado"]').is(':checked') ? '&cerrado=1': '';
		params += $('input[name="sticky"]').is(':checked') ? '&sticky=1': '';
		params += $('#causa') ? '&causa=' + $('#causa').val() : '';
		params += '&borrador= ' + $('#borrador').val();
		$('#vp-loading').fadeIn('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/post-add.php',
			data: params + '&id_post=' + encodeURIComponent($('#p').val()),
			cache: false,
			success: function (h) {
				$('#vp-loading').fadeOut('slow');
				$('#preview').fadeOut('fast');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#box-editor').fadeOut('slow');
					$('#return-add-post').html(h.substring(3));
					$('#return-add-post').addClass('post-agregado');
					$('#return-add-post').slideDown('fast');
					break
				}
			},
			error: function () {
				$('#vp-loading').fadeOut('slow');
				dialogBox.error_500("posts.edit_post()");
				return
			}
		})
	},
	add_comment: function (cat) {
		if ($('#VPeditor').val() == '') {
			$('#VPeditor').focus();
			return
		}
		$("#return_add_comment").slideUp(1);
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/comment-add.php',
			data: 'body=' + encodeURIComponent($('#VPeditor').val()) + '&id=' + g_post + '&categoria=' + cat,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#return_add_comment').removeClass('Globo GlbRed');
					$('#cantcomments').html(parseInt($('#cantcomments').html()) + 1);
					$('#cantcomments2').html(parseInt($('#cantcomments2').html()) + 1);
					$('#return_add_comment').html(h.substring(3)).slideDown('slow', function () {
						$('.agregar_comment').hide('slow');
						$('#VPeditor').val('')
					});
					if ($('#sin_comentarios')) {
						$('#sin_comentarios').hide('slow')
					}
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("posts.add_comment('" + cat + "')")
			}
		})
	},
	del_comment: function (id, user) {
		$('#vp-loading').fadeIn('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/comment-delete.php',
			data: 'id=' + id + '&post=' + g_post + '&user=' + user,
			cache: false,
			success: function (h) {
				$('#vp-loading').fadeOut('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#cmt_' + id).html(h.substring(3));
					$('#cmt_' + id).fadeOut('slow');
					$('#cantcomments').html(parseInt($('#cantcomments').html()) - 1);
					$('#cantcomments2').html(parseInt($('#cantcomments2').html()) - 1);
					break
				}
			},
			error: function () {
				$('#vp-loading').fadeOut('slow');
				dialogBox.error_500("posts.del_comment('" + id + "','" + user + "')");
				return
			}
		})
	},
	add_bookmark: function () {
		$('#vp-loading').slideDown('slow');
		$('#button_add_fav').fadeOut('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/posts-add-bookmark.php',
			data: 'post=' + g_post,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#success_ajax').show('slow');
					$('#success_ajax').addClass('yellowBox').html(h.substring(3));
					$('#cant_favs_post').html(parseInt($('#cant_favs_post').html()) + 1);
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				$('#button_add_fav').fadeIn('slow');
				dialogBox.error_500("posts.add_bookmark('" + id + "')");
				return
			}
		})
	},
	denunciar_post: function (id) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Denunciar post');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/complaint-form.php',
			data: 'id=' + id,
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.title('Denunciar post');
					dialogBox.body(h.substring(3), 450);
					dialogBox.buttons(true, true, 'Enviar Denuncia', 'posts.denunciar_post_send(' + id + ')', true, true, true);
					dialogBox.center();
					break
				}
			},
			error: function () {
				dialogBox.error_500("posts.denunciar_post('" + id + "')");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	denunciar_post_send: function (id) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Enviando...', 'Denunciar post');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/complaint-send.php',
			data: 'razon=' + encodeURIComponent($('#razon').val()) + '&comentario=' + encodeURIComponent($('#comentario').val()) + '&id=' + id,
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Denunciar post', h.substring(3));
					break;
				case '2':
					dialogBox.alert('Anti flood', h.substring(3));
					break;
				case '3':
					$('#error_data').css('display', 'block').html(h.substring(3));
					break
				}
			},
			error: function () {
				dialogBox.error_500("posts.denunciar_post('" + id + "')");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	borrar_post: function (aceptar) {
		if (!aceptar) {
			dialogBox.show();
			dialogBox.title('Borrar post');
			dialogBox.body('&iquest;Seguro que deseas borrar este post?');
			dialogBox.buttons(true, true, 'SI', 'posts.borrar_post(1)', true, false, true, 'NO', 'close', true, true);
			dialogBox.center();
			return
		} else if (aceptar == 1) {
			dialogBox.show();
			dialogBox.title('Borrar post');
			dialogBox.body('Te pregunto de nuevo... &iquest;Seguro que deseas borrar este post?');
			dialogBox.buttons(true, true, 'SI', 'posts.borrar_post(2)', true, false, true, 'NO', 'close', true, true);
			dialogBox.center();
			return
		}
		dialogBox.procesando_inicio('Eliminando...', 'Borrar Post');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/post-elim.php',
			data: 'id=' + g_post + '&causa=' + encodeURIComponent($('#causa').val()),
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Post borrado', h.substring(3), true);
					break
				}
			},
			error: function () {
				dialogBox.error_500("posts.borrar_post(2)")
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	votar: function (puntos) {
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/post-vote.php',
			data: 'post=' + g_post + '&puntos=' + puntos,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#success_ajax').show('slow');
					$('#add_points').slideUp('slow');
					$('#success_ajax').addClass('yellowBox').html(h.substring(3));
					$('#cant_pts_post_dos').html(parseInt($('#cant_pts_post_dos').html()) + parseInt(puntos));
					$('#cant_pts_post').html(parseInt($('#cant_pts_post').html()) + parseInt(puntos));
					$('#cant_pts_post_' + id).html(parseInt($('#cant_pts_post_' + id).html()) + parseInt(puntos));
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("posts.votar('" + puntos + "')")
			}
		})
	},
	TopsPostsFilter: function (time) {
		$('#loading_tops').fadeIn('fast');
		$('#box_tops_posts').slideUp('slow');
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/posts-tops.php',
			data: 'filter=' + time + '&ajax=true',
			success: function (h) {
				$('#loading_tops').fadeOut('fast');
				$('#vp-loading').slideUp('slow');
				if (h.charAt(0) == 0) {
					$('#error_tops_posts').addClass('color_red');
					$('#error_tops_posts').html(h.substring(3)).slideDown('slow');
					$('#error_tops_posts').slideDown('slow')
				} else {
					$('#box_tops_posts').html(h);
					$('#box_tops_posts').slideDown('slow')
				}
			},
			error: function () {
				$('#loading_tops').fadeOut('fast');
				$('#vp-loading').slideUp('slow');
				$('#error_tops_posts').addClass('color_red');
				$('#error_tops_posts').html(lang['error procesar']);
				$('#error_tops_posts').slideDown('slow');
				return
			},
		})
	},
	up_comments: function (cat, country) {
		$('#ult_comm').slideUp('slow');
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/update-comments.php',
			data: 'categoria=' + cat + '&country=' + country,
			success: function (h) {
				$('#ult_comm').html(h);
				$('#ult_comm').slideDown('slow');
				$('#vp-loading').slideUp('slow')
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("act_comm_posts()");
				return
			},
		})
	},
	del_bookmark: function (id, type) {
		$('#vp-loading').slideDown('slow');
		dialogBox.close_button = false;
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/bookmarks-delete.php',
			data: 'id=' + id + '&type=' + type,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				if (h.charAt(0) == 0) {
					dialogBox.alert('Error', h.substring(3));
					dialogBox.body(h.substring(3), 300);
					dialogBox.buttons(true, true, 'Aceptar', 'dialogBox.close()', true, true);
					dialogBox.center()
				} else if (h.charAt(0) == 1) {
					$('#bookmark_' + id).addClass('eliminado');
					$('#bookmark_img_' + id).html(h.substring(3)).fadeOut('fast');
					$('#bookmark_img2_' + id).fadeIn('fast');
					$('#favorites_num').html(parseInt($('#favorites_num').html()) - 1)
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("bookmark_delete('" + id + "')");
				return
			}
		})
	},
	res_bookmark: function (id, type) {
		$('#vp-loading').slideDown('slow');
		dialogBox.close_button = false;
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/favorite-reload.php',
			data: 'id=' + id + '&type=' + type,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				if (h.charAt(0) == 0) {
					dialogBox.alert('Error', h.substring(3));
					dialogBox.body(h.substring(3), 300);
					dialogBox.buttons(true, true, 'Aceptar', 'dialogBox.close()', true, true);
					dialogBox.center()
				} else if (h.charAt(0) == 1) {
					$('#bookmark_' + id).removeClass('eliminado');
					$('#bookmark_img_' + id).html(h.substring(3)).fadeIn('fast');
					$('#bookmark_img2_' + id).fadeOut('fast');
					$('#favorites_num').html(parseInt($('#favorites_num').html()) + 1)
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("bookmark_reload('" + id + "')");
				return
			}
		})
	}
}
/* Funciones Fotos */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('17 r={1d:5(O){$(\'#8-9\').s(\'4\');$.e({v:\'w\',m:x.y+\'/e/g-1K.z\',A:\'E=\'+R+\'&O=\'+O,B:5(h){$(\'#8-9\').o(\'4\');F(h.G(0)){a\'0\':6.t(\'H\',h.b(3));c;a\'1\':$(\'#S\').1e(\'4\');$(\'#1L\').o(\'4\');$(\'#S\').J(\'1f\').7(h.b(3));$(\'#1g\').7(I($(\'#1g\').7())+I(O));c}},C:5(){$(\'#8-9\').o(\'4\');6.D("E.1d(\'"+O+"\')")}})},1h:5(K){1i($(\'#T\').l()==\'\'){$(\'#T\').1M();d}$("#1j").o(1);$(\'#8-9\').s(\'4\');$.e({v:\'w\',m:x.y+\'/e/g-i-1k.z\',A:\'18=\'+n($(\'#T\').l())+\'&j=\'+R+\'&19=\'+K,B:5(h){$(\'#8-9\').o(\'4\');F(h.G(0)){a\'0\':6.t(\'H\',h.b(3));c;a\'1\':$(\'#U\').7(I($(\'#U\').7())+1);$(\'#V\').7(I($(\'#V\').7())+1);$(\'#1j\').7(h.b(3)).s(\'4\',5(){$(\'.1N\').1l(\'4\');$(\'#T\').l(\'\')});1i($(\'#1m\')){$(\'#1m\').1l(\'4\')}c}},C:5(){$(\'#8-9\').o(\'4\');6.D("r.1h(\'"+K+"\')")}})},1n:5(j,W){$(\'#8-9\').X(\'4\');$.e({v:\'w\',m:x.y+\'/e/g-1O-1k.z\',A:\'j=\'+j+\'&E=\'+R+\'&W=\'+W,1a:P,B:5(h){$(\'#8-9\').q(\'4\');F(h.G(0)){a\'0\':6.t(\'H\',h.b(3));c;a\'1\':$(\'#1o\'+j).7(h.b(3));$(\'#1o\'+j).o(\'4\');$(\'#U\').7(I($(\'#U\').7())-1);$(\'#V\').7(I($(\'#V\').7())-1);c}},C:5(){$(\'#8-9\').q(\'4\');6.D("r.1n(\'"+j+"\',\'"+W+"\')");d}})},1p:5(){$(\'#8-9\').s(\'4\');$(\'#1q\').q(\'4\');$.e({v:\'w\',m:x.y+\'/e/1r-i-1P.z\',A:\'E=\'+R,B:5(h){$(\'#8-9\').o(\'4\');F(h.G(0)){a\'0\':6.t(\'H\',h.b(3));c;a\'1\':$(\'#S\').1e(\'4\');$(\'#S\').J(\'1f\').7(h.b(3));$(\'#1s\').7(I($(\'#1s\').7())+1);c}},C:5(){$(\'#8-9\').o(\'4\');$(\'#1q\').X(\'4\');6.D("r.1p()");d}})},1b:5(j){6.1t=P;6.1u(\'1Q...\',\'Y E\');$.e({v:\'w\',m:x.y+\'/e/1v-1w-g.z\',A:\'j=\'+j,B:5(h){F(h.G(0)){a\'0\':6.t(\'H\',h.b(3));c;a\'1\':6.1R(\'Y E\');6.1S(h.b(3),1T);6.1U(Q,Q,\'1V 1W\',\'r.1x(\'+j+\')\',Q,Q,Q);6.1X();c}},C:5(){6.D("r.1b(\'"+j+"\')");d},1y:5(){6.1z()}})},1x:5(j){6.1t=P;6.1u(\'1Y...\',\'Y E\');$.e({v:\'w\',m:x.y+\'/e/1v-1w-g-1Z.z\',A:\'1A=\'+n($(\'#1A\').l())+\'&18=\'+n($(\'#18\').l())+\'&j=\'+j,B:5(h){F(h.G(0)){a\'0\':6.t(\'H\',h.b(3));c;a\'1\':6.t(\'Y E\',h.b(3));c;a\'2\':6.t(\'20 21\',h.b(3));c;a\'3\':$(\'#22\').23(\'24\',\'25\').7(h.b(3));c}},C:5(){6.D("r.1b(\'"+j+"\')");d},1y:5(){6.1z()}})},1B:5(){17 u=\'Z=\'+n($(\'p[k="Z"]\').l())+\'&m=\'+n($(\'p[k="m"]\').l())+\'&10=\'+n($(\'1C[k="10"]\').l())+\'&19=\'+n($(\'1D[k="1E"]\').l());u+=$(\'p[k="L"]\').M(\':N\')?\'&L=1\':\'\';u+=$(\'p[k="11"]\').M(\':N\')?\'&11=1\':\'\';u+=$(\'p[k="1F"]\').M(\':N\')?\'&L=2\':\'\';$(\'#8-9\').X(\'4\');$.e({v:\'w\',m:x.y+\'/e/g-i.z\',A:u,1a:P,B:5(h){$(\'#8-9\').q(\'4\');F(h.G(0)){a\'0\':6.t(\'H\',h.b(3));c;a\'1\':$(\'#12-13\').q(\'4\');$(\'#d-i-g\').7(h.b(3));$(\'#d-i-g\').J(\'14-15\');$(\'#d-i-g\').s(\'16\');c;a\'2\':$(\'#12-13\').q(\'4\');$(\'#d-i-g\').7(h.b(3));$(\'#d-i-g\').J(\'14-15\');$(\'#d-i-g\').s(\'16\');c}},C:5(){$(\'#8-9\').q(\'4\');6.D("r.1B()");d}})},1G:5(){17 u=\'Z=\'+n($(\'p[k="Z"]\').l())+\'&m=\'+n($(\'p[k="m"]\').l())+\'&10=\'+n($(\'1C[k="10"]\').l())+\'&19=\'+n($(\'1D[k="1E"]\').l())+\'&1H=\'+n($(\'p[k="1H"]\').l())+\'&f=\'+n($(\'p[k="f"]\').l());u+=$(\'p[k="L"]\').M(\':N\')?\'&L=1\':\'\';u+=$(\'p[k="11"]\').M(\':N\')?\'&11=1\':\'\';u+=$(\'p[k="1F"]\').M(\':N\')?\'&L=2\':\'\';$(\'#8-9\').X(\'4\');$.e({v:\'w\',m:x.y+\'/e/g-i.z\',A:u,1a:P,B:5(h){$(\'#8-9\').q(\'4\');F(h.G(0)){a\'0\':6.t(\'H\',h.b(3));c;a\'1\':$(\'#12-13\').q(\'4\');$(\'#d-i-g\').7(h.b(3));$(\'#d-i-g\').J(\'14-15\');$(\'#d-i-g\').s(\'16\');c;a\'2\':$(\'#12-13\').q(\'4\');$(\'#d-i-g\').7(h.b(3));$(\'#d-i-g\').J(\'14-15\');$(\'#d-i-g\').s(\'16\');c}},C:5(){$(\'#8-9\').q(\'4\');6.D("r.1G()");d}})},1I:5(K,1J){$(\'#1c\').o(\'4\');$(\'#8-9\').s(\'4\');$.e({v:\'w\',m:x.y+\'/e/26-27-1r.z\',A:\'e=1&K=\'+K+\'&28=\'+1J,B:5(h){$(\'#1c\').7(h);$(\'#1c\').s(\'4\');$(\'#8-9\').o(\'4\')},C:5(){$(\'#8-9\').o(\'4\');6.D("r.1I()");d},})}}',62,133,'||||slow|function|dialogBox|html|vp|loading|case|substring|break|return|ajax||photo||add|id|name|val|url|encodeURIComponent|slideUp|input|fadeOut|fotos|slideDown|alert|params|type|POST|urls|home|php|data|success|error|error_500|foto|switch|charAt|Error|parseInt|addClass|cat|privado|is|checked|puntos|false|true|g_foto|return_ajax|VPeditor|cant_cmt|cant_cmt2|user|fadeIn|Denunciar|titulo|descripcion|cerrado|box|editor|post|agregado|fast|var|comentario|categoria|cache|denunciar_foto|ult_comm|votar|show|yellowBox|cant_pts|add_comment|if|return_add_comment|comment|hide|sin_comentarios|del_comment|cmt_|add_bookmark|button_add_fav|photos|cant_favs|close_button|procesando_inicio|complaint|form|denunciar_foto_send|complete|procesando_fin|razon|add_photo|textarea|select|categorias|amigos|edit_photo|causa|up_comments|pa|vote|add_points|focus|agregar_comment|del|bookmark|Cargando|title|body|450|buttons|Enviar|Denuncia|center|Enviando|send|Anti|flood|error_data|css|display|block|update|comments|pais'.split('|'),0,{}));
/* Pestañas y otros */
eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('o p={q:2(a,b){1(6!=a){$(\'#f\'+6).7(\'0\');$(\'#f\'+a).8(\'0\')}6=a;9 c},r:2(a){1(d!=a){$(\'#g\'+d).7(\'0\');$(\'#g\'+a).8(\'0\')}d=a;9 c},s:2(a){1(e!=a){$(\'#h\'+e).7(\'0\');$(\'#h\'+a).8(\'0\')}e=a;9 c},t:2(a){1(a==\'u\'){$(\'#i\').v(\'j\');$(\'.3-k\').4(\'5\',\'l\');$(\'.3-m\').4(\'5\',\'n\')}w 1(a==\'x\'){$(\'#i\').y(\'j\');$(\'.3-m\').4(\'5\',\'l\');$(\'.3-k\').4(\'5\',\'n\')}}}',35,35,'here|if|function|corner|css|display|menu_section_actual|removeClass|addClass|return|||true|TopsPostsTabsHere|filterCommsHere|tabbed|tabTopsPosts|tab|menu_show|slow|down|none|up|block|var|tabs|menu|TopsPostsTabs|filterComms|user_info|show|slideDown|else|hide|slideUp'.split('|'),0,{}));
/* Mensajes privados */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('16 g={N:6(7){4.r=s;4.O(\'17...\',\'n 5\');$.c({t:\'18\',u:v.w+\'/c/o-P-19.x\',y:\'7=\'+7,z:6(h){Q(h.p(0)){d\'0\':4.i(\'A\',h.b(3));e;d\'1\':4.1a(\'n 5\');4.R(h.b(3),1b);4.S(8,8,\'n 5\',\'g.B()\',8,8,8);4.T();e}j(7!=\'\'){$(\'#9-5 #7\').k(7).1c(\'C\');$(\'#9-5 #D\').q()}E{$(\'#9-5 #7\').q()}},F:6(){4.G("g.N()")},U:6(){4.V()}})},B:6(){j($(\'#9-5 #7\').l()==\'\'){$(\'#9-5 #H\').k(\'1d 1e a 1f 1g 1h 1i 5\').I(\'C\');$(\'#9-5 #7\').q();J}E j($(\'W[X="5"]\').l()==\'\'){$(\'#9-5 #H\').k(\'1j 5 1k 1l\').I(\'C\');$(\'#9-5 #5\').q();J}4.r=s;4.O(\'1m...\',\'n 5\');$.c({t:\'Y\',u:v.w+\'/c/o-Z.x\',y:\'10=P&7=\'+K($(\'#9-5 #7\').l())+\'&D=\'+K($(\'#9-5 #D\').l())+\'&5=\'+K($(\'W[X="5"]\').l()),z:6(h){Q(h.p(0)){d\'0\':4.i(\'A\',h.b(3));e;d\'1\':4.i(\'1n 1o\',h.b(3));e;d\'2\':4.i(\'1p 1q\',h.b(3));e;d\'3\':$(\'#H\').11(\'1r\',\'1s\').k(h.b(3));e}},F:6(){4.G("g.B()")},U:6(){4.V()}})},12:6(f){$(\'#L-M\').I(\'m\');4.r=s;$.c({t:\'Y\',u:v.w+\'/c/o-Z.x\',y:\'o=\'+f+\'&10=1t&c=8\',z:6(h){$(\'#L-M\').13(\'m\');j(h.p(0)==0){4.i(\'A\',h.b(3));4.R(h.b(3),1u);4.S(8,8,\'1v\',\'4.1w()\',8,8);4.T()}E j(h.p(0)==1){$(\'#14\'+f).11(\'1x\',\'#1y\');$(\'1z#1A\'+f).k(h.b(3)).15(\'m\');$(\'#14\'+f).15(\'m\')}},F:6(){$(\'#L-M\').13(\'m\');4.G("g.12(\'"+f+"\')");J}})},}',62,99,'||||dialogBox|mensaje|function|para|true|enviar||substring|ajax|case|break|id|mp||alert|if|html|val|slow|Enviar|pm|charAt|focus|close_button|false|type|url|urls|home|php|data|success|Error|enviar_mensaje_send|fast|asunto|else|error|error_500|error_data|slideDown|return|encodeURIComponent|vp|loading|enviar_mensaje|procesando_inicio|send|switch|body|buttons|center|complete|procesando_fin|textarea|name|GET|actions|action|css|del_inbox|slideUp|mensaje_inbox_|fadeOut|var|Cargando|POST|form|title|600|fadeIn|Debes|especificar|quien|le|envias|el|El|es|obligatorio|Enviando|Mensaje|enviado|Anti|flood|display|block|delete|300|Aceptar|close|background|FEE3E3|img|del_mp_'.split('|'),0,{}));
/* Time library  */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('3 0={4:m,b:15,q:8(x){6(!7.4)u r;3 r=m;3 t={s:{e:\'M&9;s 5 1 a&v;o\',f:\'M&9;s 5 1 B\',g:\'C\',h:\'2 1 D\',i:\'2 1 j\',l:\'w 5 1 j\'},p:{e:\'M&9;s 5 $1 a&v;E\',f:\'M&9;s 5 $1 F\',g:\'2 $1 d&G;H\',h:\'2 $1 I\',i:\'2 $1 J\',l:\'w 5 1 j\'}};3 n=7.4-x;3 d={e:K,f:L,g:N,h:O,i:P,l:1};Q(k R d){6(n>=d[k]){3 c=S.T(n/d[k]);6(c==1)r=t.s[k];y 6(c>1)r=t.p[k].U(\'$1\',c);y r=\'2 V W\';X}}u r?r:\'2 Y\'},z:8(){Z(8(){6(0.4){0.4=0.4+0.b;$(\'10[A]\').11(8(){$(7).12(0.q($(7).13(\'A\')))})}0.z()},7.b*14)}}',62,68,'timelib||Hace|var|current|de|if|this|function|aacute||iupd|||year|month|day|hour|minute|minuto||second|false||||timetowords||||return|ntilde|Menos||else|upd|ts|mes|Ayer|hora|os|meses|iacute|as|horas|minutos|31536000|2678400||86400|3600|60|for|in|Math|floor|replace|mucho|tiempo|break|instantes|setTimeout|span|each|html|attr|1000|'.split('|'),0,{}));
/* Cuentas */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('O p={21:6(){O 8=22 23();8[\'P\']=$(\'#Q #24\');8[\'q\']=$(\'#Q #25\');8[\'k\']=$(\'#Q #26\');8[\'17\']=$(\'#Q .27\');8[\'1l\']=$(\'#Q .28\');8[\'18\']=$(\'#Q g[r="29"]\');H(1m($(8[\'P\']).7())){$(8[\'P\']).19();R}11 H(1m($(8[\'q\']).7())){$(8[\'q\']).19();R}$(8[\'k\']).I(\'d\');$(8[\'17\']).V(\'1n\',\'2a\');$(8[\'18\']).2b(\'W\',\'W\').1o(\'W\');$.e({r:\'x\',y:z.A+\'/e/2c.B\',12:t,J:\'P=\'+9($(8[\'P\']).7())+\'&q=\'+9($(8[\'q\']).7()),C:6(h){K(h.u(0)){j\'0\':$(8[\'k\']).L(h.f(3)).D(\'d\');$(8[\'P\']).19();$(8[\'18\']).2d(\'W\').2e(\'W\');i;j\'1\':2f();1p.13();i;j\'2\':$(8[\'1l\']).V(\'2g-2h\',\'v\').V(\'2i-2j\',\'2k%\').L(h.f(3));i}},k:6(){$(8[\'k\']).L(2l[\'k 2m\']).w()},1q:6(){$(8[\'17\']).V(\'1n\',\'2n\')}})},1r:6(){O S=\'1s=\'+9($(\'g[b="1s"]\').7())+\'&1t=\'+9($(\'g[b="1t"]\').7())+\'&1u=\'+9($(\'g[b="1u"]\').7());$(\'#l-m\').1a(\'d\');$(\'#o\').I(\'c\');$(\'#E\').w(\'c\');$.e({r:\'x\',y:z.A+\'/e/2o-q.B\',J:S,12:t,C:6(h){$(\'#l-m\').T(\'d\');K(h.u(0)){j\'0\':$(\'#E\').U(\'c\');$(\'#o\').w(\'c\');4.F(\'M\',h.f(3));1v.13();i;j\'1\':$(\'#E\').U(\'c\');$(\'#o\').L(h.f(3));$(\'#o\').D(\'c\');i}},k:6(){$(\'#l-m\').T(\'d\');$(\'#E\').U(\'c\');$(\'#o\').D(\'c\');4.N("p.1r()");1v.13();R}})},1w:6(){O S=\'G=\'+9($(\'g[b="G"]\').7())+\'&1x=\'+9($(\'g[b="1x"]\').7())+\'&1y=\'+9($(\'g[b="1y"]\').7())+\'&1z=\'+9($(\'g[b="1z"]\').7());$(\'#l-m\').1a(\'d\');$(\'#o\').I(\'c\');$(\'#E\').w(\'c\');$.e({r:\'x\',y:z.A+\'/e/1A-q.B\',J:S,12:t,C:6(h){$(\'#l-m\').T(\'d\');K(h.u(0)){j\'0\':$(\'#E\').U(\'c\');$(\'#o\').w(\'c\');4.F(\'M\',h.f(3));i;j\'1\':$(\'#E\').U(\'c\');$(\'#o\').L(h.f(3));$(\'#o\').D(\'c\');$(\'#o\').1o(\'2p-2q\');i}},k:6(){$(\'#l-m\').T(\'d\');$(\'#E\').U(\'c\');$(\'#o\').D(\'c\');4.N("p.1w()");R}})},1b:6(X){H(!X){4.w();4.1c(\'2r 1d&1e;n\');4.14(\'&1B;2s 1C 2t 1D 1d&1e;n?\',1E);4.Y(5,5,\'1F\',\'p.1b(5)\',5,t,5,\'1G\',\'15\',5,5);4.v()}11{4.1f(\'2u 1d&1e;n...\');$.e({r:\'x\',y:z.A+\'/e/2v.B\',12:t,C:6(h){K(h.u(0)){j\'0\':4.F(\'M\',h.f(3));i;j\'1\':4.15();1p.13();i}4.v()},k:6(){4.N("p.1b(\'"+X+"\')")},1q:6(){4.Z()}})}},16:6(X){H(!X){4.w();4.1c(\'2w 1g\');4.14(\'&1B;2x&2y;s 2z 2A 1C 2B +20 1g a 1D 2C?\');4.Y(5,5,\'1F\',\'p.16(5)\',5,t,5,\'1G\',\'4.15()\',5,5);4.v()}11{4.1f(\'2D 1g...\');$.e({r:\'x\',y:z.A+\'/2E/p.16.B\',J:\'\',C:6(h){4.Z();K(h.u(0)){j\'0\':4.F(\'M\',h.f(3));i;j\'1\':4.F(\'2F 2G\',h.f(3),5);i}4.v()},k:6(){4.Z();4.N("p.16()")}})}},1H:6(G){O S=\'2H= \'+G+\'&1I=\'+9($(\'g[b="1I"]\').7())+\'&1J=\'+9($(\'g[b="1J"]\').7())+\'&1K=\'+9($(\'10[b="1K"]\').7())+\'&1L=\'+9($(\'10[b="1L"]\').7())+\'&1M=\'+9($(\'10[b="1M"]\').7())+\'&1N=\'+9($(\'10[b="1N"]\').7())+\'&1O=\'+9($(\'10[b="1O"]\').7())+\'&1P=\'+9($(\'g[b="1P"]\').7())+\'&1Q=\'+9($(\'g[b="1Q"]\').7())+\'&1R=\'+9($(\'g[b="1R"]\').7())+\'&q=\'+9($(\'g[b="q"]\').7())+\'&1S=\'+9($(\'g[b="1S"]\').7());$(\'#l-m\').D(\'d\');$.e({r:\'x\',y:z.A+\'/e/2I-2J.B\',J:S,C:6(h){$(\'#l-m\').I(\'d\');K(h.u(0)){2K:4.F(\'M\',h.f(3));i;j\'1\':$(\'#1T\').L(h.f(3));$(\'#1T\').D(\'d\');$(\'#2L\').T(\'d\');i}},k:6(){$(\'#l-m\').I(\'d\');4.N(\'p.1H()\');R}})},2M:6(){O 1h=t;4.2N=5;4.2O=\'1i\';4.w(5);4.Y(t);4.1f(\'2P...\',\'1U\');4.v();$.e({r:\'x\',y:z.A+\'/e/2Q-2R-e.B\',C:6(h){4.Z();K(h.u(0)){j\'0\':4.F(\'M\',h.f(3));i;j\'1\':4.1c(\'1U\');4.14(h.f(3),2S);4.Y(5,5,\'2T &2U;\',"1i.2V(2)",5,5,5);4.v();$(\'#1V .1W .1X\').V(\'1Y\',\'2W%\');H(!1h)$(\'#1V .1W .1X\').2X({\'1Y\':\'0%\'},2Y);2Z.1h=5;i}4.v()},k:6(){4.Z();4.N("1i.30("+J+")")}})},1Z:6(G){$(\'#1j\').T(\'d\');$(\'#l-m\').D(\'d\');4.31=t;$.e({r:\'x\',y:z.A+\'/e/1A-1k.B\',J:\'G=\'+G+\'&1k=\'+9($(\'#1k\').7()),C:6(h){$(\'#l-m\').I(\'d\');H(h.u(0)==0){$(\'#1j\').1a(\'d\');4.F(\'M\',h.f(3));4.14(h.f(3),1E);4.Y(5,5,\'32\',\'4.15()\',5,5);4.v()}11 H(h.u(0)==1){$(\'#33\').L(h.f(3))}},k:6(){$(\'#1j\').w(\'c\');$(\'#l-m\').I(\'c\');4.N("p.1Z(\'"+G+"\')");R}})}}',62,190,'||||dialogBox|true|function|val|el|encodeURIComponent||name|fast|slow|ajax|substring|input||break|case|error|vp|loading||return_ajax|accounts|pass|type||false|charAt|center|show|POST|url|urls|home|php|success|slideDown|ajax_loading|alert|id|if|slideUp|data|switch|html|Error|error_500|var|nick|login_box|return|params|fadeOut|hide|css|disabled|aceptar|buttons|procesando_fin|select|else|cache|reload|body|close|add_points|cargando|button|focus|fadeIn|logout_ajax|title|sesi|oacute|procesando_inicio|puntos|show_progreso|registro|status_img|status|cuerpo|empty|display|addClass|location|complete|recuperar_pass|email|recaptcha_response_field|recaptcha_challenge_field|Recaptcha|restore_pass|pass1|pass2|mail|change|iquest|deseas|tu|300|SI|NO|edit_profile|id_member|nombre|dia_naci|mes_naci|ano_naci|pais|sexo|ciudad|texto_personal|sitio_web|paypal|exito|Registro|RegistroForm|barra_progreso|progreso|width|change_status||login_ajax|new|Array|nickname|password|login_error|login_procesando|login_cuerpo|submit|block|attr|login|removeAttr|removeClass|close_login_box|text|align|line|height|150|lang|procesar|none|recover|post|agregado|Cerrar|Realmente|cerrar|Cerrando|logout|Recargar|Est|aacute|seguro|que|recargar|cuenta|Recargando|cuentas|Puntos|agregados|ps|account|save|default|save_perfil|registro_load_form|mask_close|class_aux|Cargando|register|form|305|Siguiente|raquo|change_paso|100|animate|2000|this|load_form|close_button|Aceptar|return_status'.split('|'),0,{}));
/* Amistades */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('1f 6={W:4(5){2.u(\'E...\',\'L t\');$.7({f:\'q\',g:i.j+\'/7/6-X-Y.k\',r:\'A=\'+5,l:4(h){v(h.d(0)){a\'0\':2.c(\'s\',h.8(3));b;a\'1\':2.M(\'L t\');2.N(h.8(3),O);2.P(9,9,\'1g 1h Q t\',\'6.R(\'+5+\')\',9,9,9);2.S();b}},m:4(){2.n("6.W("+5+")");o},w:4(){2.x()}})},R:4(5){2.u(\'1i...\',\'L t\');$.7({f:\'q\',g:i.j+\'/7/6-X.k\',r:\'A=\'+5,l:4(h){v(h.d(0)){a\'0\':2.c(\'s\',h.8(3));b;a\'1\':2.c(\'1j 1k\',h.8(3));$(\'#Z\').10(\'F\');$(\'#11\').12(\'F\');b}},m:4(){2.n("6.R("+5+")");o},w:4(){2.x()}})},13:4(5){2.u(\'E...\',\'B t\');$.7({f:\'q\',g:i.j+\'/7/6-T-Y.k\',r:\'A=\'+5,l:4(h){v(h.d(0)){a\'0\':2.c(\'s\',h.8(3));b;a\'1\':2.M(\'B t\');2.N(h.8(3),O);2.P(9,9,\'B\',\'6.U(\'+5+\')\',9,9,9);2.S();b}},m:4(){2.n("6.13("+5+")");o},w:4(){2.x()}})},U:4(5){2.u(\'1l...\',\'B 1m\');$.7({f:\'q\',g:i.j+\'/7/6-T.k\',r:\'A=\'+5,l:4(h){v(h.d(0)){a\'0\':2.c(\'s\',h.8(3));b;a\'1\':2.c(\'G 14\',h.8(3));$(\'#Z\').12(\'F\');$(\'#11\').10(\'F\');b}},m:4(){2.n("6.U("+5+")");o},w:4(){2.x()}})},C:4(){2.u(\'E...\',\'15 Q G\');$.7({f:\'q\',g:i.j+\'/7/6-C.k\',r:\'\',l:4(h){v(h.d(0)){a\'0\':2.c(\'s\',h.8(1));b;a\'1\':2.M(\'15 Q G\');2.N(h.8(1),O);2.P(9,9,\'1n\',\'2.1o()\',9,9,16);2.S();b}},m:4(){2.n("6.C()");o},w:4(){2.x()}})},1p:4(5){2.u(\'E...\',\'B t\');$.7({f:\'q\',g:i.j+\'/7/6-T.k\',r:\'A=\'+5,l:4(h){v(h.d(0)){a\'0\':2.c(\'s\',h.8(3));b;a\'1\':2.c(\'G 14\',h.8(3));$(\'#1q\'+5).p(\'e\');b}},m:4(){2.n("6.C()");o},w:4(){2.x()}})},H:4(5){$(\'#y-z\').V(\'e\');$.7({f:\'q\',g:i.j+\'/7/6-H.k\',r:\'5=\'+5+\'&17=1\',l:4(h){$(\'#y-z\').p(\'e\');I(h.d(0)==0){2.c(\'s\',h.8(3))}18 I(h.d(0)==1){$(\'#J\').D(19($(\'#J\').D())-1);$(\'#1a\'+5).p(\'e\');6.K()}},m:4(){$(\'#y-z\').p(\'e\');2.n("6.H(\'"+5+"\')");o}})},1b:4(5){$(\'#y-z\').V(\'e\');$.7({f:\'q\',g:i.j+\'/7/6-H.k\',r:\'5=\'+5+\'&17=0\',l:4(h){$(\'#y-z\').p(\'e\');I(h.d(0)==0){2.c(\'s\',h.8(3))}18 I(h.d(0)==1){$(\'#J\').D(19($(\'#J\').D())-1);$(\'#1a\'+5).p(\'e\');6.K()}},m:4(){$(\'#y-z\').p(\'e\');2.n("6.1b(\'"+5+"\')");o}})},K:4(){$.7({f:\'1r\',g:i.j+\'/7/6-C.k\',1s:16,l:4(h){$(\'#1c\').D(h.8(1));$(\'#1c\').V(\'e\');$(\'#1t\').p({1d:1e});$(\'#1u\').p({1d:1e})},m:4(){2.n("6.K()");o},})}}',62,93,'||dialogBox||function|id|friends|ajax|substring|true|case|break|alert|charAt|slow|type|url||urls|home|php|success|error|error_500|return|slideUp|POST|data|Error|amistad|procesando_inicio|switch|complete|procesando_fin|vp|loading|user|Eliminar|requests|html|Cargando|fast|Amistad|accept|if|cant_soli|update|Agregar|title|body|400|buttons|de|add_send|center|del|del_send|slideDown|add_form|add|form|mostrar_agregar|hide|mostrar_eliminar|show|del_form|eliminada|Solicitudes|false|tipo|else|parseInt|ams_|decline|mas_ams|duration|1000|var|Enviar|solicitud|Enviando|Solicitud|enviada|Eliminando|amigo|Cerrar|close|del_wall|amis_|GET|cache|sol_acep|sol_rech'.split('|'),0,{}));
/* Muros */
var muros = {
	checkearTecla: function (e, object) {
		var ob = $(object).attr('pid');
		if(e.keyCode == 13) { document.getElementById("commentgrande" + ob).submit(); }
	    return true; // Devuelvo true en caso de no ser el enter
	},
	add_comment: function (id, own) {
		if ($('#comment_muro').val() == 'Actualiza tu estado') {
			$('#comment_muro').focus();
			return
		} else if ($('#comment_muro').val() == 'Escribir en su muro...') {
			$('#comment_muro').focus();
			return
		}
		$('#last_update').fadeOut('fast');
		$('.msg_add_muro').hide();
		$('#vp-loading').slideDown('slow');
		$('#button_add_comment').attr('disabled', 'disabled').addClass('disabled');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/wall-comment.php',
			data: 'comentario=' + encodeURIComponent($('#comment_muro').val()) + '&id_perfil=' + id,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					$('#last_update').fadeIn('fast');
					$('#button_add_comment').removeAttr('disabled').removeClass('disabled');
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#last_update').html($('#comment_muro').val()).fadeIn('fast');
					$('#return_agregar_muro').slideDown('slow');
					$('#return_agregar_muro').html(h.substring(3));
					$('#cantmuro').html(parseInt($('#cantmuro').html()) + 1);
					if (own) {
						$('#comment_muro').val('Escribir en su muro...')
					} else {
						$('#comment_muro').val('Actualiza tu estado')
					}
					$('#button_add_comment').removeAttr('disabled').removeClass('disabled');
					if ($('#sin_comments_muro')) $('#sin_comments_muro').slideUp('slow');
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				$('#button_add_comment').removeAttr('disabled').removeClass('disabled');
				dialogBox.error_500("muros.add_comment('" + id + "','" + own + "')");
				return
			},
		})
	},
	add_sub_comment: function (perfil, id) {
		if ($('#sub_comment_muro_' + id).val() == '') {
			$('#sub_comment_muro_' + id).focus();
			return
		}
		if ($('#sub_comment_muro_' + id).val() == 'Escribe un comentario...') {
			$('#sub_comment_muro_' + id).focus();
			return
		}
		$('.msg_add_sub_muro').hide();
		$('#vp-loading').fadeIn('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/wall-addsubcomment.php',
			data: 'comentario=' + encodeURIComponent($('#cf_' + id).val()) + '&perfil=' + perfil + '&comment=' + id,
			success: function (h) {
				$('#vp-loading').fadeOut('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#return_sub_comentar_muro_' + id).slideDown('slow');
					$('#return_sub_comentar_muro_' + id).html(h.substring(3));
					$('#cf_' + id).val('Escribe un comentario...');
					$('#comentariomostrar' + id).hide();
					$('#more_comments' + id + ', #view_allcomments' + id).show();
					
					break
				}
			},
			error: function () {
				$('#vp-loading').fadeOut('slow');
				dialogBox.error_500("muros.add_sub_comment('" + perfil + "','" + id + "')");
				return
			},
		})
	},
	del_sub_comment: function (id) {
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/del-subcomment.php',
			data: 'id=' + id,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					//$('.msg_del_muro_' + id).css('display', 'none');
					$('#cl_' + id).slideUp('slow');
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("muros.del_sub_comment('" + id + "')");
				return
			}
		})
	},
	del_comment: function (id) {
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/wall-delcomment.php',
			data: 'id=' + id,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					//$('.msg_add_muro').css('display', 'none');
					$('#pub_' + id).slideUp('slow');
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("muros.del_comment('" + id + "')");
				return
			}
		})
	},
	i_like: function (id, type, obj) {
		dialogBox.buttons(true);
		$('#vp-loading').slideDown('slow');
		var contrast = (type == 'comment' ? $('#lk_' + id) : $('#lk_cm_' + id));
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/wall-like.php',
			data: 'id=' + id + '&tipo=' + type,
			success: function (h) {
				$('#vp-loading').slideUp('fast');
				switch (h.charAt(0)) {
				case '0':
					$(contrast).fadeIn('fast');
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$(contrast).html(h.substring(3));
					$(obj).slideUp(500);
					//$('.cm_like' + id).hide();
					if(type == 'comment') { $('#cb_' + id + ' > .ufiItem').show(500); }
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("muros.i_like('" + id + "','" + type + "')");
				return
			}
		})
	},
	show_comment_box: function(id) {
		$('#comentariomostrar' + id).slideToggle(800);
	},	
	i_dont_like: function (id, type, obj) {
		dialogBox.buttons(true);
		$('#vp-loading').slideDown('slow');
		$('#i_dont_like_txt_' + id).fadeOut('fast');
		var contrast = (type == 'comment' ? $('#lk_' + id) : $('#lk_cm_' + id));
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/wall-dont-like.php',
			data: 'id=' + id + '&tipo=' + type,
			success: function (h) {
				$('#vp-loading').slideUp('fast');
				switch (h.charAt(0)) {
				case '0':
					$(contrast).fadeIn('fast');
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$(contrast).html(h.substring(3));
					$(obj).slideUp(500);
					//$('.cm_like' + id).hide();
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("muros.i_dont_like('" + id + "','" + type + "')");
				return
			}
		})
	},
	ver_likes: function (id, type) {
		dialogBox.buttons(true);
		dialogBox.procesando_inicio('Cargando...', 'Solicitando...');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/wall-show-likes.php',
			data: 'id=' + id + '&tipo=' + type,
			success: function (h) {
				dialogBox.procesando_fin();
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Personas que les gusta esto!', h.substring(3), false, 450);
					break
				}
			},
			error: function () {
				dialogBox.error_500("muros.ver_likes('" + id + "','" + type + "')");
				return
			}
		})
	},
	filter_wall: function (id, action) {
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'GET',
			url: urls.home + '/ajax/profile-wall-filter.php?id_user=' + id + '&action=' + action,
			cache: false,
			success: function (h) {
				$('#ult_comm_muro').html(h);
				$('#ult_comm_muro').slideDown('slow');
				$('#vp-loading').slideUp('slow');
				$('#return_agregar_muro').fadeOut(500)
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("muros.filter_wall('" + id + "','" + action + "')");
				return
			},
		})
	},
	more_comments: function(id) {
		if(!id) return false;
		$('#load' + id).show();
		$.ajax({
			url: '/ajax/wall-comments.php',
			type: 'post',
			data: 'id=' + id + '&_=true',
			success: function(t) {
				if(t.charAt(0) == '0') {
					dialogBox.alert('Error', t.substring(1));
				} else if(t.charAt(0) == '1') {
					$('#more_comments' + id).html(t.substring(1));
					$('#view_allcomments' + id).hide(500);
				}
			},
			error: function() { alert('gew'); }
		});
	}		
}
/* web general */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('W r={1r:5(){o($("#i").6()==-1)s.t.u="/X/";Y o($("#i").6()!="Z")s.t.u="/X/"+$("#i").6()+"/"},1s:5(){o($("#i").6()==-1)s.t.u="/10/";Y o($("#i").6()!="Z")s.t.u="/10/"+$("#i").6()+"/"},v:5(){W a="11="+8($(\'j[f="11"]\').6())+"&12="+8($(\'j[f="12"]\').6())+"&13="+8($(\'j[f="13"]\').6())+"&14="+8($(\'j[f="14"]\').6())+"&15="+8($(\'1t[f="15"]\').6())+"&w="+8($(\'1u[f="w"]\').6())+"&16="+8($(\'j[f="16"]\').6())+"&17="+8($(\'j[f="17"]\').6());$("#k-l").1v("g");$.e({x:"y",z:A.B+"/e/1w-e.C",D:a,1x:18,E:5(a){$("#k-l").19("g");F(a.G(0)){9"0":4.m("H",a.7(3));1y.1z();c;9"1":$("#n").I(a.7(3));$("#n").J("1a-1b");$("#n").K("d");$("#v").p("d");c;9"2":$("#n").I(a.7(3));$("#n").J("1a-1b");$("#n").K("d");$("#v").p("d");c}},L:5(){$("#k-l").19("g");4.M("r.v()");N}})},1c:5(a){o(a==1d){N 18}4.R(h);$("#k-l").K("g");$("#S").p("g").J("1e");$("#1f").q("d");$("#T"+O).1g("1h");$("#T"+a).J("1h");$("#U"+O).V("d");$("#U"+a).q("d");$("#q"+O).V("d");$("#q"+a).q("d");O=a;$.e({x:"y",z:A.B+"/e/1A-T.C",D:"1B="+a,E:5(a){$("#k-l").p("g");$("#1f").V("d");F(a.G(0)){9"0":4.m("H",a.7(3));c;1C:$("#S").I(a.7(3));$("#S").K("g").1g("1e")}},L:5(){$("#k-l").p("g");4.M("r.1c(\'"+a+"\')")}});1d=a},1D:5(a){4.1i("1E...","P Q");$.e({x:"y",z:A.B+"/e/1j-1k-1F.C",D:"1l="+a,E:5(b){F(b.G(0)){9"0":4.m("H",b.7(3));c;9"1":4.U("P Q");4.1G(b.7(3),1H);4.R(h,h,"1I 1J","r.1m("+a+")",h,h,h);4.1K();c}},L:5(){4.M("1n("+a+")");N},1o:5(){4.1p()}})},1m:5(a){4.R(h);4.1i("1L...","P Q");$.e({x:"y",z:A.B+"/e/1j-1k.C",D:"1q="+8($("#1q").6())+"&w="+8($("#w").6())+"&1l="+a,E:5(a){F(a.G(0)){9"0":4.m("H",a.7(3));c;9"1":4.m("P Q",a.7(3));c;9"2":4.m("1M 1N",a.7(3));c;9"3":$("#1O").1P("1Q","1R").I(a.7(3));c}},L:5(){4.M("1n(\'"+a+"\')");N},1o:5(){4.1p()}})}}',62,116,'||||dialogBox|function|val|substring|encodeURIComponent|case|||break|fast|ajax|name|slow|true|categoria|input|vp|loading|alert|return_contact|if|slideUp|show|web|document|location|href|contact_form|comentario|type|POST|url|urls|home|php|data|success|switch|charAt|Error|html|addClass|slideDown|error|error_500|return|filtro_portal|Denunciar|usuario|buttons|filter_portal|filter|title|hide|var|posts|else|root|fotos|nombre|email|empresa|horario|motivo|recaptcha_response_field|recaptcha_challenge_field|false|fadeOut|post|agregado|portal_filter|actual|opacity|loading_filter|removeClass|selected|procesando_inicio|user|complaint|id|denounce_user_send|denunciar_user|complete|procesando_fin|razon|ir_a_categoria|ir_a_categoria_f|select|textarea|fadeIn|contact|cache|Recaptcha|reload|portal|ref|default|denounce_user|Cargando|form|body|450|Enviar|Denuncia|center|Enviando|Anti|flood|error_data|css|display|block'.split('|'),0,{}))
/* Comentarios */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('8 m={y:2(a,b,c,d,e,f){$.9({n:"z",A:B.C+"/9/m-y"+(f=="D"?"-D":"")+".E",F:"G="+b+"&Z="+c+"&10="+d+"&11="+e+"&n="+f,12:2(){$("#H-I").13("J")},o:2(a){14(a.K(0)){L"1":8 c=$("#15"+b+" 16.17");8 d=$(c).6(".18").6("q"),f=$(c).6(".M").6("q.r"),g=$(c).6(".M").6("q.s");8 h=k($(d).5()),i=k($(f).5()),j=19.1a(k($(g).5()));h+=e;7(e>0){i+=1}l 7(e<0){j+=1}$(f).5("+"+N(i));$(g).5("-"+N(j));7(h==0){$(c).O();$(d).5("+0")}l{$(c).P();7(h>0){$(d).5("+"+h).Q("s").R("r")}l 7(h<0){$(d).5(h).Q("r").R("s")}}S;L"0":t.u("T",a.U(3));S}},V:2(){$("#H-I").1b("J")},v:2(a){t.u("T!",a.U(3))}})},w:2(a){$("#W").P();$.1c("#1d",1e);$("#x").X("Y",.4);1f $.9({n:"z",A:B.C+"/9/m-w.E",F:{G:1g,p:a},o:2(b){8 c=k(b.K(0)),d=b.1h(3);7(c==1){$("#x-1i").5(d);1j.1k="w-"+a}l{t.u("1l!",d)}},v:2(){1m.o("0: 1n 1o v 1p 1q 1r 1s")},V:2(){$("#W").O();$("#x").X("Y",1)}})}}',62,91,'||function|||html|children|if|var|ajax|||||||||||parseInt|else|comment|type|success||span|positivo|negativo|dialogBox|alert|error|page|comments|vote|POST|url|urls|home|foto|php|data|id|vp|loading|slow|charAt|case|stats|String|hide|show|removeClass|addClass|break|Error|substring|complete|loading_ajax|css|opacity|post|user|score|beforeSend|slideDown|switch|cmt_|li|numbersvotes|overview|Math|abs|slideUp|scrollTo|comentarios|250|return|g_post|substr|container|location|hash|Oops|this|Ocurrio|un|al|procesar|lo|solicitado'.split('|'),0,{}))
/* dialogBox */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('X 0={z:p,w:\'\',M:5,N:p,E:8(a){3(1.z)Y;q 1.z=5;3($(\'#0\').t()==\'\')$(\'#0\').t(\'<4 s="9"><4 s="u"></4><4 s="1o"><4 s="F"><4 s="Z"></4></4><4 s="10"></4><4 s="1p"><4 s="6"></4></4></4></4>\');3(a==5)$(\'#0\').O(1.w);q 3(1.w!=\'\'){$(\'#0\').P(1.w);1.w=\'\'}3(1.M)$(\'#G\').11(8(){0.n()});q $(\'#G\').1q(\'11\');3(1.N)$(\'#0 #9\').1r(\'<12 Q="R" 13="\'+14.15+\'/1s/R.1t" x="1u" S="0.n()"  u="1v 1w 1x"/>\');q $(\'#0 #9 .R\').16();$(\'#G\').r({\'x\':$(17).x(),\'v\':$(17).v(),\'y\':\'H\'});3(A.B.18&&A.B.19<7)$(\'#0 #9\').r(\'T\',\'1a\');q $(\'#0 #9\').r(\'T\',\'1y\');$(\'#0 #9\').1b(\'I\')},n:8(){1.w=\'\';1.M=5;1.N=p;1.z=p;$(\'#G\').r(\'y\',\'J\');$(\'#0 #9\').1c(\'I\',8(){$(1).16()});1.U()},K:8(){3($(\'#0 #9\').v()>$(V).v()-1z)$(\'#0 #9\').r({\'T\':\'1a\',\'1d\':1A});q $(\'#0 #9\').r(\'1d\',$(V).v()/2-$(\'#0 #9\').v()/2);$(\'#0 #9\').r(\'1B\',$(V).x()/2-$(\'#0 #9\').x()/2)},u:8(a){$(\'#0 #u\').t(a)},L:8(a,b,c){3(!b&&(A.B.1C||(A.B.18&&A.B.19<7)))b=\'1D\';$(\'#0 #9\').x(b?b:\'\').v(c?c:\'\');$(\'#0 #10\').t(a)},6:8(a,b,c,d,e,f,g,h,i,j,k){3(!a){$(\'#0 #6\').r(\'y\',\'J\').t(\'\');Y}3(d==\'n\')d=\'0.n()\';3(i==\'n\'||!h)i=\'0.n()\';3(!h){h=\'1e\';j=5}X l=\'\';3(b)l+=\'<1f 1g="1h" Q="o C\'+(e?\'\':\' m\')+\'" 1i="y:\'+(b?\'W-H\':\'J\')+\'"\'+(b?\' 1j="\'+c+\'"\':\'\')+(b?\' S="\'+d+\'"\':\'\')+(e?\'\':\' m\')+\' />\';3(g)l+=\' <1f 1g="1h" Q="o D\'+(e?\'\':\' m\')+\'" 1i="y:\'+(g?\'W-H\':\'J\')+\'"\'+(g?\' 1j="\'+h+\'"\':\'\')+(g?\' S="\'+i+\'"\':\'\')+(j?\'\':\' m\')+\' />\';$(\'#0 #6\').t(l).r(\'y\',\'W-H\');3(f)$(\'#0 #6 .o.C\').1k();q 3(k)$(\'#0 #6 .o.D\').1k()},1E:8(a,b){3($(\'#0 #6 .o.C\'))3(a)$(\'#0 #6 .o.C\').P(\'m\').1l(\'m\');q $(\'#0 #6 .o.C\').O(\'m\').1m(\'m\',\'m\');3($(\'#0 #6 .o.D\'))3(b)$(\'#0 #6 .o.D\').P(\'m\').1l(\'m\');q $(\'#0 #6 .o.D\').O(\'m\').1m(\'m\',\'m\')},1F:8(a,b,c,d){3(1G(d)){d=1H}1.E();1.u(a);1.L(b,d);1.6(5,5,\'1I\',\'0.n();\'+(c?\'1J.1K();\':\'n\'),5,5,p);1.K()},1L:8(a){1M(8(){0.U();0.E();0.u(\'1N 1O!\');0.L(1P[\'1Q 1R\'],1n);0.6(5,5,\'1S\',\'0.n();\'+a,5,5,5,\'1e\',\'n\',5,p);0.K()},1T)},1U:8(a,b){3(!1.z){1.E();1.u(b);1.L(p,1n);1.6(p,p);1.K()}$(\'#0 #F #Z\').t(\'<1V /><12 13="\'+14.15+\'/1W.1X" />\');$(\'#0 #F\').1b(\'I\')},U:8(){$(\'#0 #F\').1c(\'I\')}};',62,122,'dialogBox|this||if|div|true|buttons||function|dialog|||||||||||||disabled|close|mBtn|false|else|css|id|html|title|height|class_aux|width|display|is_show|jQuery|browser|btnOk|btnCancel|show|procesando|mask|block|fast|none|center|body|mask_close|close_button|addClass|removeClass|class|close_dialog|onclick|position|procesando_fin|window|inline|var|return|mensaje|modalBody|click|img|src|urls|images|remove|document|msie|version|absolute|fadeIn|fadeOut|top|Cancelar|input|type|button|style|value|focus|removeAttr|attr|300|cuerpo|buttonscon|unbind|append|icons|png|16px|Cerrar|esta|ventana|fixed|60|20|left|opera|400px|buttons_enabled|alert|empty|400|Aceptar|location|reload|error_500|setTimeout|Error|detectado|lang|error|procesar|Reintentar|200|procesando_inicio|br|loading|gif'.split('|'),0,{}));


/* Eliminar notificacion */
function del_notification(id) {
	$('#loading_noti').show('fast');
	dialogBox.close_button = false;
	$.ajax({
		type: 'POST',
		url: urls.home + '/ajax/notifications-delete.php',
		data: 'id=' + id,
		success: function (h) {
			$('#loading_noti').hide('fast');
			if (h.charAt(0) == 0) {
				dialogBox.alert('Error', h.substring(3));
				dialogBox.body(h.substring(1), 300);
				dialogBox.buttons(true, true, 'Aceptar', 'dialogBox.close()', true, true);
				dialogBox.center()
			} else if (h.charAt(0) == 1) {
				$('#notification_' + id).html(h.substring(1)).slideUp('fast')
			}
		},
		error: function () {
			$('#loading_noti').hide('fast');
			dialogBox.error_500("del_notification('" + id + "')");
			return
		}
	})
}
/* Ver mas notificaciones */
function more_notifications(pag, user) {
	$('#notifications').slideUp('slow');
	$('#loading').slideDown('fast');
	$('#vp-loading').slideDown('slow');
	dialogBox.close_button = false;
	$.ajax({
		type: 'GET',
		url: urls.home + '/ajax/notificaciones.more.php',
		data: 'pag=' + pag + '&user=' + user,
		success: function (h) {
			$('#loading').slideUp('slow');
			$('#vp-loading').slideUp('slow');
			if (h.charAt(0) == 0) {
				dialogBox.alert('Error', h.substring(3));
				dialogBox.body(h.substring(3), 300);
				dialogBox.buttons(true, true, 'Aceptar', 'dialogBox.close()', true, true);
				dialogBox.center()
			} else if (h.charAt(0) == 1) {
				$('#notifications').html(h.substring(3)).slideDown('slow')
			}
		},
		error: function () {
			$('#loading').hide('fast');
			$('#vp-loading').slideUp('fast');
			dialogBox.error_500("more_notifications('" + pag + "','" + user + "')");
			return
		}
	})
}
//boxes en ajax
function open_account_box(action) {
	if ($('#account_box').css('display') == 'block' && action != 'open') close_account_box();
	else {
		close_notificaciones_box();
		close_mp_box();
		$('.cosote_account').addClass('here');
		$('#account_box').fadeIn('fast')
	}
};
function close_account_box() {
	$('.cosote_account').removeClass('here');
	$('#account_box').hide('slow')
};
function open_mp_box(action) {
	$('#noti_cant_mp').hide('fast');
	if ($('#mp_box').css('display') == 'block' && action != 'open') close_mp_box();
	else {
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/pms-open.php',
			success: function (h) {
				$('#loading_mps').slideUp('fast');
				if (h.charAt(0) == 0) $('#error_ult_mps').html(h.substring(3)).slideDown('slow');
				else if (h.charAt(0) == 1) {
					$('#ult_mps').html(h.substring(3));
					$('#ult_mps').fadeIn('slow');
					//$('#noti_box_mp').fadeOut('slow')
					live.update();
				}
			},
			error: function () {
				$('#error_ult_mps').fadeIn('slow');
				return
			},
		});
		close_account_box();
		close_notificaciones_box();
		$('.cosote_mp').addClass('here');
		$('#mp_box').fadeIn('fast')
	}
};
function close_mp_box() {
	$('.cosote_mp').removeClass('here');
	$('#mp_box').hide('slow')
};
function open_notificaciones_box(action) {
	$('#noti_cant_nt').hide('fast');
	if ($('#notifications_box').css('display') == 'block' && action != 'open') close_notificaciones_box();
	else {
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/notifications.php',
			success: function (h) {
				$('#loading_notificaciones').slideUp('fast');
				if (h.charAt(0) == 0) $('#error_notificaciones').html(h.substring(1)).slideDown('slow');
				else if (h.charAt(0) == 1) {
					live.update();
					$('#globo_notificaciones').fadeOut('slow');
					$('#ult_notificaciones').html(h.substring(1));
					$('#ult_notificaciones').fadeIn('slow');
					$('#noti_box_not').fadeOut('slow').html('0');
				}
			},
			error: function () {
				$('#error_ult_notificaciones').fadeIn('slow');
				return
			},
		});
		close_account_box();
		close_mp_box();
		$('.cosote_notificaciones').addClass('here');
		$('#notifications_box').fadeIn('fast')
	}
};
function close_notificaciones_box() {
	$('.cosote_notificaciones').removeClass('here');
	$('#notifications_box').hide('slow')
};

/* Errores en Avatares? - Get fix it */
function error_avatar(obj){
	obj.src = urls.images+'/avatares/avatar_' + Math.floor(Math.random()*10) + '.gif';
}
/* Opciones desplegables */
function DesOpt2(opcion){
    $('#dov_' + opcion).slideUp('slow');
    $('#div_' + opcion).slideUp('slow');
    $('#dev_' + opcion).show(1);
}

function DesOpt(opcion){
    $('#dev_' + opcion).hide(1);
    $('#div_' + opcion).slideDown('slow');
    $('#dov_' + opcion).slideDown('slow');
}

// Funcion desplegable arriba mas compleja
function DespleOps2(opcion){
    $('#dov_' + opcion).slideUp('slow');
    $('#div_' + opcion).slideUp('slow');
    $('#dev_' + opcion).show(1);
}
function DespleOps(opcion,opcion1,opcion2){
    DespleOps2(opcion2);
    DespleOps2(opcion1);
    $('#dev_' + opcion).hide(1);
    $('#div_' + opcion).slideDown('slow');
    $('#dov_' + opcion).slideDown('slow');
}
/* Abrir/Cerrar */
function chgsec(obj) {
	$('div.aparence > #contennnt').slideUp('slow');
	if ($(obj).next().css('display') == 'none') {
		$(obj).next().slideDown('slow');
	}
}

function filter (x, obj) {
	//alert(cls);
	if (x) {
		$('.' + x).slideToggle('slow');
		var v = $(obj).attr('checked') ? 1 : 0;
		//document.cookie = 'monitor['+x+']='+v+';expires=Thu, 26 Jul 2012 16:12:48 GMT;path=/;domain=.'+lang['regex_domain'];
		$.ajax({
			beforeSend: function() { $('.' + x).css('opacity', 0.4); },
			type: 'POST',
			url: '/ajax/notism.php',
			data: 'notifications=' + x + ':' + v,
			success: function(t) {
				if(t.charAt(0) == 0) { alert(t.substring(3)); }
			},
			error: function() { alert('loco1'); },
			complete: function() { $('.' + x).css('opacity', 1); }
		});
	}
}


/* Easing 1.3 */
jQuery.extend(jQuery.easing, {
	easeOutBounce: function (x, t, b, c, d) {
		if ((t /= d) < (1 / 2.75)) {
			return c * (7.5625 * t * t) + b;
		} else if (t < (2 / 2.75)) {
			return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b;
		} else if (t < (2.5 / 2.75)) {
			return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b;
		} else {
			return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b;
		}
	}
});
/* scrollTo 1.4.2 by Ariel Flesler */
;(function(d){var k=d.scrollTo=function(a,i,e){d(window).scrollTo(a,i,e)};k.defaults={axis:'xy',duration:parseFloat(d.fn.jquery)>=1.3?0:1};k.window=function(a){return d(window)._scrollable()};d.fn._scrollable=function(){return this.map(function(){var a=this,i=!a.nodeName||d.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!i)return a;var e=(a.contentWindow||a).document||a.ownerDocument||a;return d.browser.safari||e.compatMode=='BackCompat'?e.body:e.documentElement})};d.fn.scrollTo=function(n,j,b){if(typeof j=='object'){b=j;j=0}if(typeof b=='function')b={onAfter:b};if(n=='max')n=9e9;b=d.extend({},k.defaults,b);j=j||b.speed||b.duration;b.queue=b.queue&&b.axis.length>1;if(b.queue)j/=2;b.offset=p(b.offset);b.over=p(b.over);return this._scrollable().each(function(){var q=this,r=d(q),f=n,s,g={},u=r.is('html,body');switch(typeof f){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(f)){f=p(f);break}f=d(f,this);case'object':if(f.is||f.style)s=(f=d(f)).offset()}d.each(b.axis.split(''),function(a,i){var e=i=='x'?'Left':'Top',h=e.toLowerCase(),c='scroll'+e,l=q[c],m=k.max(q,i);if(s){g[c]=s[h]+(u?0:l-r.offset()[h]);if(b.margin){g[c]-=parseInt(f.css('margin'+e))||0;g[c]-=parseInt(f.css('border'+e+'Width'))||0}g[c]+=b.offset[h]||0;if(b.over[h])g[c]+=f[i=='x'?'width':'height']()*b.over[h]}else{var o=f[h];g[c]=o.slice&&o.slice(-1)=='%'?parseFloat(o)/100*m:o}if(/^\d+$/.test(g[c]))g[c]=g[c]<=0?0:Math.min(g[c],m);if(!a&&b.queue){if(l!=g[c])t(b.onAfterFirst);delete g[c]}});t(b.onAfter);function t(a){r.animate(g,j,b.easing,a&&function(){a.call(this,n,b)})}}).end()};k.max=function(a,i){var e=i=='x'?'Width':'Height',h='scroll'+e;if(!d(a).is('html,body'))return a[h]-d(a)[e.toLowerCase()]();var c='client'+e,l=a.ownerDocument.documentElement,m=a.ownerDocument.body;return Math.max(l[h],m[h])-Math.min(l[c],m[c])};function p(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);

/* autogrow 1.2.2 */
(function(b){var c=null;b.fn.autogrow=function(o){return this.each(function(){new b.autogrow(this,o)})};b.autogrow=function(e,o){this.options=o||{};this.dummy=null;this.interval=null;this.line_height=this.options.lineHeight||parseInt(b(e).css('line-height'));this.min_height=this.options.minHeight||parseInt(b(e).css('min-height'));this.max_height=this.options.maxHeight||parseInt(b(e).css('max-height'));this.textarea=b(e);if(this.line_height==NaN)this.line_height=0;this.init()};b.autogrow.fn=b.autogrow.prototype={autogrow:'1.2.2'};b.autogrow.fn.extend=b.autogrow.extend=b.extend;b.autogrow.fn.extend({init:function(){var a=this;this.textarea.css({overflow:'hidden',display:'block'});this.textarea.bind('focus',function(){a.startExpand()}).bind('blur',function(){a.stopExpand()});this.checkExpand()},startExpand:function(){var a=this;this.interval=window.setInterval(function(){a.checkExpand()},400)},stopExpand:function(){clearInterval(this.interval)},checkExpand:function(){if(this.dummy==null){this.dummy=b('<div></div>');this.dummy.css({'font-size':this.textarea.css('font-size'),'font-family':this.textarea.css('font-family'),'width':this.textarea.css('width'),'padding':this.textarea.css('padding'),'line-height':this.line_height+'px','overflow-x':'hidden','position':'absolute','top':0,'left':-9999}).appendTo('body')}var a=this.textarea.val().replace(/(<|>)/g,'');if($.browser.msie){a=a.replace(/\n/g,'<BR>new')}else{a=a.replace(/\n/g,'<br>new')}if(this.dummy.html()!=a){this.dummy.html(a);if(this.max_height>0&&(this.dummy.height()+this.line_height>this.max_height)){this.textarea.css('overflow-y','auto')}else{this.textarea.css('overflow-y','hidden');if(this.textarea.height()<this.dummy.height()+this.line_height||(this.dummy.height()<this.textarea.height())){this.textarea.animate({height:(this.dummy.height()+this.line_height)+'px'},100)}}}}})})(jQuery);

/* Autocomplete 1.1 */
(function($){$.fn.extend({autocomplete:function(urlOrData,options){var isUrl=typeof urlOrData=="string";options=$.extend({},$.Autocompleter.defaults,{url:isUrl?urlOrData:null,data:isUrl?null:urlOrData,delay:isUrl?$.Autocompleter.defaults.delay:10,max:options&&!options.scroll?10:150},options);options.highlight=options.highlight||function(value){return value;};options.formatMatch=options.formatMatch||options.formatItem;return this.each(function(){new $.Autocompleter(this,options);});},result:function(handler){return this.bind("result",handler);},search:function(handler){return this.trigger("search",[handler]);},flushCache:function(){return this.trigger("flushCache");},setOptions:function(options){return this.trigger("setOptions",[options]);},unautocomplete:function(){return this.trigger("unautocomplete");}});$.Autocompleter=function(input,options){var KEY={UP:38,DOWN:40,DEL:46,TAB:9,RETURN:13,ESC:27,COMMA:188,PAGEUP:33,PAGEDOWN:34,BACKSPACE:8};var $input=$(input).attr("autocomplete","off").addClass(options.inputClass);var timeout;var previousValue="";var cache=$.Autocompleter.Cache(options);var hasFocus=0;var lastKeyPressCode;var config={mouseDownOnSelect:false};var select=$.Autocompleter.Select(options,input,selectCurrent,config);var blockSubmit;$.browser.opera&&$(input.form).bind("submit.autocomplete",function(){if(blockSubmit){blockSubmit=false;return false;}});$input.bind(($.browser.opera?"keypress":"keydown")+".autocomplete",function(event){hasFocus=1;lastKeyPressCode=event.keyCode;switch(event.keyCode){case KEY.UP:event.preventDefault();if(select.visible()){select.prev();}else{onChange(0,true);}break;case KEY.DOWN:event.preventDefault();if(select.visible()){select.next();}else{onChange(0,true);}break;case KEY.PAGEUP:event.preventDefault();if(select.visible()){select.pageUp();}else{onChange(0,true);}break;case KEY.PAGEDOWN:event.preventDefault();if(select.visible()){select.pageDown();}else{onChange(0,true);}break;case options.multiple&&$.trim(options.multipleSeparator)==","&&KEY.COMMA:case KEY.TAB:case KEY.RETURN:if(selectCurrent()){event.preventDefault();blockSubmit=true;return false;}break;case KEY.ESC:select.hide();break;default:clearTimeout(timeout);timeout=setTimeout(onChange,options.delay);break;}}).focus(function(){hasFocus++;}).blur(function(){hasFocus=0;if(!config.mouseDownOnSelect){hideResults();}}).click(function(){if(hasFocus++>1&&!select.visible()){onChange(0,true);}}).bind("search",function(){var fn=(arguments.length>1)?arguments[1]:null;function findValueCallback(q,data){var result;if(data&&data.length){for(var i=0;i<data.length;i++){if(data[i].result.toLowerCase()==q.toLowerCase()){result=data[i];break;}}}if(typeof fn=="function")fn(result);else $input.trigger("result",result&&[result.data,result.value]);}$.each(trimWords($input.val()),function(i,value){request(value,findValueCallback,findValueCallback);});}).bind("flushCache",function(){cache.flush();}).bind("setOptions",function(){$.extend(options,arguments[1]);if("data"in arguments[1])cache.populate();}).bind("unautocomplete",function(){select.unbind();$input.unbind();$(input.form).unbind(".autocomplete");});function selectCurrent(){var selected=select.selected();if(!selected)return false;var v=selected.result;previousValue=v;if(options.multiple){var words=trimWords($input.val());if(words.length>1){var seperator=options.multipleSeparator.length;var cursorAt=$(input).selection().start;var wordAt,progress=0;$.each(words,function(i,word){progress+=word.length;if(cursorAt<=progress){wordAt=i;return false;}progress+=seperator;});words[wordAt]=v;v=words.join(options.multipleSeparator);}v+=options.multipleSeparator;}$input.val(v);hideResultsNow();$input.trigger("result",[selected.data,selected.value]);return true;}function onChange(crap,skipPrevCheck){if(lastKeyPressCode==KEY.DEL){select.hide();return;}var currentValue=$input.val();if(!skipPrevCheck&&currentValue==previousValue)return;previousValue=currentValue;currentValue=lastWord(currentValue);if(currentValue.length>=options.minChars){$input.addClass(options.loadingClass);if(!options.matchCase)currentValue=currentValue.toLowerCase();request(currentValue,receiveData,hideResultsNow);}else{stopLoading();select.hide();}};function trimWords(value){if(!value)return[""];if(!options.multiple)return[$.trim(value)];return $.map(value.split(options.multipleSeparator),function(word){return $.trim(value).length?$.trim(word):null;});}function lastWord(value){if(!options.multiple)return value;var words=trimWords(value);if(words.length==1)return words[0];var cursorAt=$(input).selection().start;if(cursorAt==value.length){words=trimWords(value)}else{words=trimWords(value.replace(value.substring(cursorAt),""));}return words[words.length-1];}function autoFill(q,sValue){if(options.autoFill&&(lastWord($input.val()).toLowerCase()==q.toLowerCase())&&lastKeyPressCode!=KEY.BACKSPACE){$input.val($input.val()+sValue.substring(lastWord(previousValue).length));$(input).selection(previousValue.length,previousValue.length+sValue.length);}};function hideResults(){clearTimeout(timeout);timeout=setTimeout(hideResultsNow,200);};function hideResultsNow(){var wasVisible=select.visible();select.hide();clearTimeout(timeout);stopLoading();if(options.mustMatch){$input.search(function(result){if(!result){if(options.multiple){var words=trimWords($input.val()).slice(0,-1);$input.val(words.join(options.multipleSeparator)+(words.length?options.multipleSeparator:""));}else{$input.val("");$input.trigger("result",null);}}});}};function receiveData(q,data){if(data&&data.length&&hasFocus){stopLoading();select.display(data,q);autoFill(q,data[0].value);select.show();}else{hideResultsNow();}};function request(term,success,failure){if(!options.matchCase)term=term.toLowerCase();var data=cache.load(term);if(data&&data.length){success(term,data);}else if((typeof options.url=="string")&&(options.url.length>0)){var extraParams={timestamp:+new Date()};$.each(options.extraParams,function(key,param){extraParams[key]=typeof param=="function"?param():param;});$.ajax({mode:"abort",port:"autocomplete"+input.name,dataType:options.dataType,url:options.url,data:$.extend({q:lastWord(term),limit:options.max},extraParams),success:function(data){var parsed=options.parse&&options.parse(data)||parse(data);cache.add(term,parsed);success(term,parsed);}});}else{select.emptyList();failure(term);}};function parse(data){var parsed=[];var rows=data.split("\n");for(var i=0;i<rows.length;i++){var row=$.trim(rows[i]);if(row){row=row.split("|");parsed[parsed.length]={data:row,value:row[0],result:options.formatResult&&options.formatResult(row,row[0])||row[0]};}}return parsed;};function stopLoading(){$input.removeClass(options.loadingClass);};};$.Autocompleter.defaults={inputClass:"ac_input",resultsClass:"ac_results",loadingClass:"ac_loading",minChars:1,delay:400,matchCase:false,matchSubset:true,matchContains:false,cacheLength:10,max:100,mustMatch:false,extraParams:{},selectFirst:true,formatItem:function(row){return row[0];},formatMatch:null,autoFill:false,width:0,multiple:false,multipleSeparator:", ",highlight:function(value,term){return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi,"\\$1")+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>");},scroll:true,scrollHeight:180};$.Autocompleter.Cache=function(options){var data={};var length=0;function matchSubset(s,sub){if(!options.matchCase)s=s.toLowerCase();var i=s.indexOf(sub);if(options.matchContains=="word"){i=s.toLowerCase().search("\\b"+sub.toLowerCase());}if(i==-1)return false;return i==0||options.matchContains;};function add(q,value){if(length>options.cacheLength){flush();}if(!data[q]){length++;}data[q]=value;}function populate(){if(!options.data)return false;var stMatchSets={},nullData=0;if(!options.url)options.cacheLength=1;stMatchSets[""]=[];for(var i=0,ol=options.data.length;i<ol;i++){var rawValue=options.data[i];rawValue=(typeof rawValue=="string")?[rawValue]:rawValue;var value=options.formatMatch(rawValue,i+1,options.data.length);if(value===false)continue;var firstChar=value.charAt(0).toLowerCase();if(!stMatchSets[firstChar])stMatchSets[firstChar]=[];var row={value:value,data:rawValue,result:options.formatResult&&options.formatResult(rawValue)||value};stMatchSets[firstChar].push(row);if(nullData++<options.max){stMatchSets[""].push(row);}};$.each(stMatchSets,function(i,value){options.cacheLength++;add(i,value);});}setTimeout(populate,25);function flush(){data={};length=0;}return{flush:flush,add:add,populate:populate,load:function(q){if(!options.cacheLength||!length)return null;if(!options.url&&options.matchContains){var csub=[];for(var k in data){if(k.length>0){var c=data[k];$.each(c,function(i,x){if(matchSubset(x.value,q)){csub.push(x);}});}}return csub;}else if(data[q]){return data[q];}else if(options.matchSubset){for(var i=q.length-1;i>=options.minChars;i--){var c=data[q.substr(0,i)];if(c){var csub=[];$.each(c,function(i,x){if(matchSubset(x.value,q)){csub[csub.length]=x;}});return csub;}}}return null;}};};$.Autocompleter.Select=function(options,input,select,config){var CLASSES={ACTIVE:"ac_over"};var listItems,active=-1,data,term="",needsInit=true,element,list;function init(){if(!needsInit)return;element=$("<div/>").hide().addClass(options.resultsClass).css("position","absolute").appendTo(document.body);list=$("<ul/>").appendTo(element).mouseover(function(event){if(target(event).nodeName&&target(event).nodeName.toUpperCase()=='LI'){active=$("li",list).removeClass(CLASSES.ACTIVE).index(target(event));$(target(event)).addClass(CLASSES.ACTIVE);}}).click(function(event){$(target(event)).addClass(CLASSES.ACTIVE);select();input.focus();return false;}).mousedown(function(){config.mouseDownOnSelect=true;}).mouseup(function(){config.mouseDownOnSelect=false;});if(options.width>0)element.css("width",options.width);needsInit=false;}function target(event){var element=event.target;while(element&&element.tagName!="LI")element=element.parentNode;if(!element)return[];return element;}function moveSelect(step){listItems.slice(active,active+1).removeClass(CLASSES.ACTIVE);movePosition(step);var activeItem=listItems.slice(active,active+1).addClass(CLASSES.ACTIVE);if(options.scroll){var offset=0;listItems.slice(0,active).each(function(){offset+=this.offsetHeight;});if((offset+activeItem[0].offsetHeight-list.scrollTop())>list[0].clientHeight){list.scrollTop(offset+activeItem[0].offsetHeight-list.innerHeight());}else if(offset<list.scrollTop()){list.scrollTop(offset);}}};function movePosition(step){active+=step;if(active<0){active=listItems.size()-1;}else if(active>=listItems.size()){active=0;}}function limitNumberOfItems(available){return options.max&&options.max<available?options.max:available;}function fillList(){list.empty();var max=limitNumberOfItems(data.length);for(var i=0;i<max;i++){if(!data[i])continue;var formatted=options.formatItem(data[i].data,i+1,max,data[i].value,term);if(formatted===false)continue;var li=$("<li/>").html(options.highlight(formatted,term)).addClass(i%2==0?"ac_even":"ac_odd").appendTo(list)[0];$.data(li,"ac_data",data[i]);}listItems=list.find("li");if(options.selectFirst){listItems.slice(0,1).addClass(CLASSES.ACTIVE);active=0;}if($.fn.bgiframe)list.bgiframe();}return{display:function(d,q){init();data=d;term=q;fillList();},next:function(){moveSelect(1);},prev:function(){moveSelect(-1);},pageUp:function(){if(active!=0&&active-8<0){moveSelect(-active);}else{moveSelect(-8);}},pageDown:function(){if(active!=listItems.size()-1&&active+8>listItems.size()){moveSelect(listItems.size()-1-active);}else{moveSelect(8);}},hide:function(){element&&element.hide();listItems&&listItems.removeClass(CLASSES.ACTIVE);active=-1;},visible:function(){return element&&element.is(":visible");},current:function(){return this.visible()&&(listItems.filter("."+CLASSES.ACTIVE)[0]||options.selectFirst&&listItems[0]);},show:function(){var offset=$(input).offset();element.css({width:typeof options.width=="string"||options.width>0?options.width:$(input).width(),top:offset.top+input.offsetHeight,left:offset.left}).show();if(options.scroll){list.scrollTop(0);list.css({maxHeight:options.scrollHeight,overflow:'auto'});if($.browser.msie&&typeof document.body.style.maxHeight==="undefined"){var listHeight=0;listItems.each(function(){listHeight+=this.offsetHeight;});var scrollbarsVisible=listHeight>options.scrollHeight;list.css('height',scrollbarsVisible?options.scrollHeight:listHeight);if(!scrollbarsVisible){listItems.width(list.width()-parseInt(listItems.css("padding-left"))-parseInt(listItems.css("padding-right")));}}}},selected:function(){var selected=listItems&&listItems.filter("."+CLASSES.ACTIVE).removeClass(CLASSES.ACTIVE);return selected&&selected.length&&$.data(selected[0],"ac_data");},emptyList:function(){list&&list.empty();},unbind:function(){element&&element.remove();}};};$.fn.selection=function(start,end){if(start!==undefined){return this.each(function(){if(this.createTextRange){var selRange=this.createTextRange();if(end===undefined||start==end){selRange.move("character",start);selRange.select();}else{selRange.collapse(true);selRange.moveStart("character",start);selRange.moveEnd("character",end);selRange.select();}}else if(this.setSelectionRange){this.setSelectionRange(start,end);}else if(this.selectionStart){this.selectionStart=start;this.selectionEnd=end;}});}var field=this[0];if(field.createTextRange){var range=document.selection.createRange(),orig=field.value,teststring="<->",textLength=range.text.length;range.text=teststring;var caretAt=field.value.indexOf(teststring);field.value=orig;this.selection(caretAt,caretAt+textLength);return{start:caretAt,end:caretAt+textLength}}else if(field.selectionStart!==undefined){return{start:field.selectionStart,end:field.selectionEnd}}};})(jQuery);

/* checkdate (php.js) 911.2217 */
function checkdate(a,c,b){return a>0&&a<13&&b>0&&b<32768&&c>0&&c<=(new Date(b,a,0)).getDate()};

/* strpos (php.js) 909.322 */
function strpos(a,c,b){a=(a+"").indexOf(c,b?b:0);return a===-1?false:a};

/* empty (php.js) 911.1619 */
function empty(a){var b;if(a===""||a===0||a==="0"||a===null||a===false||typeof a==="undefined")return true;if(typeof a=="object"){for(b in a)return false;return true}return false};

/* sleep */
function sleep(milliseconds){
  var start = new Date().getTime();
  for(var i = 0; i < 1e7; i++){
    if((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

/* scrollUp */
function scrollUp(){
	var cs = (document.documentElement && document.documentElement.scrollTop)? document.documentElement : document.body;
	var step = Math.ceil(cs.scrollTop / 10);
	scrollBy(0, (step-(step*2)));
	if(cs.scrollTop>0)
	setTimeout('scrollUp()', 40);
}

/* jquery tooltip beta */
(function ($) {
	$.fn.tooltip = function (opts) {

		opts = $.extend({
			className: 'tooltip',
			content: 'title',
			offset: [ 0, 0 ],
			align: 'center',
			inDelay: 100,
			outDelay: 100
		}, opts || {});

		var mouseOutCallback = function (obj) {
			var tooltip = $.data(obj, 'tooltip');
			if (tooltip && !$.data(tooltip[0], 'hover')) {
				tooltip.hide();
			}
		}

		this.live('mouseenter', function () {
			var obj = this;
			setTimeout(function () {
				var pos = $.extend({}, $(obj).offset(), { width: obj.offsetWidth, height: obj.offsetHeight });
				if (!$.data(obj, 'tooltip')) {
					var title;
					if (typeof opts.content == 'string' && $(obj).attr(opts.content) != 'undefined' && $(obj).attr(opts.content) != '') {
						title = $(obj).attr(opts.content);
					} else if (typeof opts.content == 'function') {
						title = opts.content(obj);
					}
					var tooltip = $('<div class="' + opts.className + '">' + title + '</div>').appendTo(document.body);
					$.data(obj, 'tooltip', tooltip);
					tooltip.hover(function () {
						$.data(this, 'hover', true);
					}, function () {
						$.removeData(this, 'hover');
						setTimeout(function () {
							mouseOutCallback(obj);
						}, opts.outDelay);
					});
				} else {
					var tooltip = $.data(obj, 'tooltip').show();
				}
				tooltip.css({
					display: 'block',
					position: 'absolute',
					zIndex: 99999,
					top: 0,
					left: 0
				});
				var left;
				if (opts.align == 'left') {
					left = pos.left;
				} else if (opts.align == 'center') {
					left = pos.left + pos.width / 2 - tooltip[0].offsetWidth / 2;
				} else if (opts.align == 'right') {
					left = pos.left + pos.width - tooltip[0].offsetWidth;
				}
				left += opts.offset[1];
				tooltip.css({
					top: pos.top + opts.offset[0],
					left: left
				});
			}, opts.inDelay);
		}).live('mouseleave', function () {
			var obj = this;
			setTimeout(function () {
				mouseOutCallback(obj);
			}, opts.outDelay);
		});
	}
})(jQuery);



/* tipsy 0.1.7 */
(function($) {
    $.fn.tipsy = function(options) {

        options = $.extend({}, $.fn.tipsy.defaults, options);

        return this.each(function() {

            var opts = $.fn.tipsy.elementOptions(this, options);

            $(this).hover(function() {

                $.data(this, 'cancel.tipsy', true);

                var tip = $.data(this, 'active.tipsy');
                if (!tip) {
                    tip = $('<div class="tipsy"><div class="tipsy-inner"/></div>');
                    tip.css({position: 'absolute', zIndex: 100000});
                    $.data(this, 'active.tipsy', tip);
                }

                if ($(this).attr('title') || typeof($(this).attr('original-title')) != 'string') {
                    $(this).attr('original-title', $(this).attr('title') || '').removeAttr('title');
                }

                var title;
                if (typeof opts.title == 'string') {
                    title = $(this).attr(opts.title == 'title' ? 'original-title' : opts.title);
                } else if (typeof opts.title == 'function') {
                    title = opts.title.call(this);
                }

                tip.find('.tipsy-inner')[opts.html ? 'html' : 'text'](title || opts.fallback);

                var pos = $.extend({}, $(this).offset(), {width: this.offsetWidth, height: this.offsetHeight});
                tip.get(0).className = 'tipsy'; // reset classname in case of dynamic gravity
                tip.remove().css({top: 0, left: 0, visibility: 'hidden', display: 'block'}).appendTo(document.body);
                var actualWidth = tip[0].offsetWidth, actualHeight = tip[0].offsetHeight;
                var gravity = (typeof opts.gravity == 'function') ? opts.gravity.call(this) : opts.gravity;

                switch (gravity.charAt(0)) {
                    case 'n':
                        tip.css({top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-north');
                        break;
                    case 's':
                        tip.css({top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}).addClass('tipsy-south');
                        break;
                    case 'e':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}).addClass('tipsy-east');
                        break;
                    case 'w':
                        tip.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}).addClass('tipsy-west');
                        break;
                }

                if (opts.fade) {
                    tip.css({opacity: 0, display: 'block', visibility: 'visible'}).animate({opacity: 1.0});
                } else {
                    tip.css({visibility: 'visible'});
                }

            }, function() {
                $.data(this, 'cancel.tipsy', false);
                var self = this;
                setTimeout(function() {
                    if ($.data(this, 'cancel.tipsy')) return;
                    var tip = $.data(self, 'active.tipsy');
                    if (opts.fade) {
                        tip.stop().fadeOut(function() { $(this).remove(); });
                    } else {
                        tip.remove();
                    }
                }, 100);

            });

        });

    };

    // Overwrite this method to provide options on a per-element basis.
    // For example, you could store the gravity in a 'tipsy-gravity' attribute:
    // return $.extend({}, options, {gravity: $(ele).attr('tipsy-gravity') || 'n' });
    // (remember - do not modify 'options' in place!)
    $.fn.tipsy.elementOptions = function(ele, options) {
        return $.metadata ? $.extend({}, options, $(ele).metadata()) : options;
    };

    $.fn.tipsy.defaults = {
        fade: false,
        fallback: '',
        gravity: 'n',
        html: false,
        title: 'title'
    };

    $.fn.tipsy.autoNS = function() {
        return $(this).offset().top > ($(document).scrollTop() + $(window).height() / 2) ? 's' : 'n';
    };

    $.fn.tipsy.autoWE = function() {
        return $(this).offset().left > ($(document).scrollLeft() + $(window).width() / 2) ? 'e' : 'w';
    };

})
(jQuery);

$(function(){
	/* Tipsy text urls */
	$('#tipsy_top a').tipsy({fade: true,gravity:'s'});
	$('#tipsy_right a').tipsy({fade: true,gravity:'w'});
	$('#tipsy_left a').tipsy({fade: true,gravity:'e'});
	$('#tipsy_bottom a').tipsy({fade: true,gravity:'n'});
	/* Tipsy text normal */
	$('#tipsy_topn').tipsy({fade: true,gravity:'s'});
	$('#tipsy_rightn').tipsy({fade: true,gravity:'w'});
	$('#tipsy_leftn').tipsy({fade: true,gravity:'e'});
	$('#tipsy_bottomn').tipsy({fade: true,gravity:'n'});
	/* Otros */
	$('#pie a').tipsy({fade: true,gravity:'s'});
	$('.options li a').tipsy({fade: true,gravity:'n'});

	for(i=1; i<=15; i++)
		$('.editor'+i+' > a:first-child').tipsy({fade: true,gravity:'s'});
});

/* Mensaje de funcion deshabilitada (solo para visitantes) */
function funcion_desactivada(){
   dialogBox.show(true);
           dialogBox.title('Advertencia!');
         dialogBox.body('Lo sentimos, est&aacute; funci&oacute;n se encuentra desactivada. Gracias por tu comprensi&oacute;n...', 305);
         dialogBox.center();
		 dialogBox.buttons(true, true, 'Aceptar', 'dialogBox.close()', true, true);

}

/* Mensaje de funcion solo para usuarios registrados */
function solo_usuarios(){
   dialogBox.show(true);
         dialogBox.title('Atenci&oacute;n!');
         dialogBox.body('Lo sentimos, est&aacute; funci&oacute;n est&aacute; disponible para usuarios <a href="/registro/" title="Registrarse" target="_blank"><b>registrados</b></a>. Si ya tenes usuario entonces <a href="/ingresar/" title="Ingresar" target="_blank"><b>Logueate</b></a><b>!</b>', 305);
         dialogBox.center();
		 dialogBox.buttons(true, true, 'Aceptar', 'dialogBox.close()', true, true);

}

var Hovercard = {
	cache: {},
	lock: {},
	callback: function (obj) {

		var uid = $(obj).attr('data-uid'),
			template;

		if (!Hovercard.cache[uid]) {
			template = '';
			if (!Hovercard.lock[uid]) {
				Hovercard.lock[uid] = true;
				$.ajax({
					type: 'POST',
					url: '/ajax/mentions-user.php',
					data: 'uid=' + uid,
					beforeSend: function() { template = '<div class="hovercard-' + uid + ' tooltip-c"><div id="fewfew" name="fewfew" align="center"> <img src="/media/images/loading.gif" border="0" alt="Cargando..." title="Cargando..." /></div></div>'; },
					success: function (r) {
						template = $('#fewfew').fadeOut(500);
						if(r.charAt(0) == 1) {
							template = r.substring(1);
							$('.hovercard-' + uid).html(template);
							Hovercard.cache[uid] = template;
						} else {
							dialogBox.alert('Error', r.substring(1));
							return false;
						}
					},
					//complete: function() { $('#ajax_loading').toggle(500).fadeOut(); }
				});
			}
		} else {
			template = Hovercard.cache[uid];
		}
		return '<div class="hovercard-' + uid + ' tooltip-c">' + template + '</div>';
	}
};


/* Empieza el editor */
(function ($) {
	$.fn.VPeditor = function (f, g) {
		var k, ctrlKey, shiftKey, altKey;
		ctrlKey = shiftKey = altKey = false;
		k = {
			id: '',
			nameSpace: 'bbcode',
			root: '',
			previewInWindow: '',
			previewAutoRefresh: false,
			previewPosition: '',
			previewTemplatePath: '',
			previewParserPath: '',
			previewParserVar: '',
			resizeHandle: false,
			beforeInsert: '',
			afterInsert: '',
			onEnter: {},
			onShiftEnter: {},
			onCtrlEnter: {},
			onTab: {},
			VoopeWSet: [{}]
		};
		$.extend(k, f, g);
		if (!k.root) {
			$('script').each(function (a, b) {
				miuScript = $(b).get(0).src.match(/(.*)jquery\.VPeditor(\.pack)?\.js$/);
				if (miuScript !== null) {
					k.root = miuScript[1]
				}
			})
		}
		return this.each(function () {
			var d, textarea, levels, scrollPosition, caretPosition, caretOffset, clicked, hash, header, footer, previewWindow, template, iFrame, abort;
			d = $(this);
			textarea = this;
			levels = [];
			abort = false;
			scrollPosition = caretPosition = 0;
			caretOffset = -1;
			k.previewParserPath = localize(k.previewParserPath);
			k.previewTemplatePath = localize(k.previewTemplatePath);
			function localize(a, b) {
				if (b) {
					return a.replace(/("|')~\//g, "$1" + k.root)
				}
				return a.replace(/^~\//, k.root)
			}
			function init() {
				id = '';
				nameSpace = '';
				if (k.id) {
					id = 'id="' + k.id + '"'
				} else if (d.attr("id")) {
					id = 'id="VPeditor' + (d.attr("id").substr(0, 1).toUpperCase()) + (d.attr("id").substr(1)) + '"'
				}
				if (k.nameSpace) {
					nameSpace = 'class="' + k.nameSpace + '"'
				}
				var b = parseInt($('textarea:#VPeditor').css('width').replace('px', '')) + parseInt(6);
				d.wrap('<div ' + nameSpace + ' style="width:' + b + 'px;"></div>');
				d.wrap('<div ' + id + ' class="VPeditor"></div>');
				d.wrap('<div class="VPeditorContainer"></div>');
				d.addClass("VPeditorEditor");
				header = $('<div class="VPeditorHeader"></div>').insertBefore(d);
				$(dropMenus(k.VoopeWSet)).appendTo(header);
				footer = $('<div class="VPeditorFooter"></div>').insertAfter(d);
				if (k.resizeHandle === true && $.browser.safari !== true) {
					resizeHandle = $('<div class="VPeditorResizeHandle"></div>').insertAfter(d).bind("mousedown", function (e) {
						var h = d.height(),
						y = e.clientY,
						mouseMove,
						mouseUp;
						mouseMove = function (e) {
							d.css("height", Math.max(20, e.clientY + h - y) + "px");
							return false
						};
						mouseUp = function (e) {
							$("html").unbind("mousemove", mouseMove).unbind("mouseup", mouseUp);
							return false
						};
						$("html").bind("mousemove", mouseMove).bind("mouseup", mouseUp)
					});
					footer.append(resizeHandle)
				}
				d.keydown(keyPressed).keyup(keyPressed);
				d.bind("insertion", function (e, a) {
					if (a.target !== false) {
						get()
					}
					if (textarea === $.VPeditor.focused) {
						CasitaW(a)
					}
				});
				d.focus(function () {
					$.VPeditor.focused = this
				})
			}
			function dropMenus(b) {
				var c = $('<ul></ul>'),
				i = 0;
				$('li:hover > ul', c).css('display', 'block');
				$.each(b, function () {
					var a = this,
					t = '',
					title, li, j;
					title = (a.key) ? (a.name || '') + ' [Ctrl+' + a.key + ']': (a.name || '');
					key = (a.key) ? 'accesskey="' + a.key + '"': '';
					if (a.separator) {
						li = $('<li class="VPeditorSeparator"></li>').appendTo(c)
					} else {
						i++;
						for (j = levels.length - 1; j >= 0; j--) {
							t += levels[j] + "-"
						}
						li = $('<li class="VPeditorButton png VPeditorButton' + t + (i) + ' ' + (a.className || '') + '"><a href="" ' + key + ' title="' + title + '"' + a.stynn + '>' + (a.name || '') + '</a></li>');
						li.bind("contextmenu", function () {
							return false
						}).click(function () {
							return false
						}).mousedown(function () {
							if (a.call) {
								eval(a.call)()
							}
							setTimeout(function () {
								CasitaW(a)
							},
							1);
							return false
						}).hover(function () {
							$('ul', this).show()
						},
						function () {
							$('ul', this).hide()
						}).appendTo(c);
						if (a.dropMenu) {
							levels.push(i);
							$(li).addClass('VPeditorDropMenu').append(dropMenus(a.dropMenu))
						}
					}
				});
				levels.pop();
				return c
			}
			function magicCasitaWs(c) {
				if (c) {
					c = c.toString();
					c = c.replace(/\(\!\(([\s\S]*?)\)\!\)/g, function (x, a) {
						var b = a.split('|!|');
						if (altKey === true) {
							return (b[1] !== undefined) ? b[1] : b[0]
						} else {
							return (b[1] === undefined) ? "": b[0]
						}
					});
					c = c.replace(/\[\!\[([\s\S]*?)\]\!\]/g, function (x, a) {
						var b = a.split(':!:');
						if (abort === true) {
							return false
						}
						value = prompt(b[0], (b[1]) ? b[1] : '');
						if (value === null) {
							abort = true
						}
						return value
					});
					return c
				}
				return ""
			}
			function prepare(a) {
				if ($.isFunction(a)) {
					a = a(hash)
				}
				return magicCasitaWs(a)
			}
			function build(a) {
				openWith = prepare(clicked.openWith);
				placeHolder = prepare(clicked.placeHolder);
				replaceWith = prepare(clicked.replaceWith);
				closeWith = prepare(clicked.closeWith);
				if (replaceWith !== "") {
					block = openWith + replaceWith + closeWith
				} else if (selection === '' && placeHolder !== '') {
					block = openWith + placeHolder + closeWith
				} else {
					block = openWith + (a || selection) + closeWith
				}
				return {
					block: block,
					openWith: openWith,
					replaceWith: replaceWith,
					placeHolder: placeHolder,
					closeWith: closeWith
				}
			}
			function CasitaW(a) {
				var b, j, n, i;
				hash = clicked = a;
				get();
				$.extend(hash, {
					line: "",
					root: k.root,
					textarea: textarea,
					selection: (selection || ''),
					caretPosition: caretPosition,
					ctrlKey: ctrlKey,
					shiftKey: shiftKey,
					altKey: altKey
				});
				prepare(k.beforeInsert);
				prepare(clicked.beforeInsert);
				if (ctrlKey === true && shiftKey === true) {
					prepare(clicked.beforeMultiInsert)
				}
				$.extend(hash, {
					line: 1
				});
				if (ctrlKey === true && shiftKey === true) {
					lines = selection.split(/\r?\n/);
					for (j = 0, n = lines.length, i = 0; i < n; i++) {
						if ($.trim(lines[i]) !== '') {
							$.extend(hash, {
								line: ++j,
								selection: lines[i]
							});
							lines[i] = build(lines[i]).block
						} else {
							lines[i] = ""
						}
					}
					string = {
						block: lines.join('\n')
					};
					start = caretPosition;
					b = string.block.length + (($.browser.opera) ? n: 0)
				} else if (ctrlKey === true) {
					string = build(selection);
					start = caretPosition + string.openWith.length;
					b = string.block.length - string.openWith.length - string.closeWith.length;
					b -= fixIeBug(string.block)
				} else if (shiftKey === true) {
					string = build(selection);
					start = caretPosition;
					b = string.block.length;
					b -= fixIeBug(string.block)
				} else {
					string = build(selection);
					start = caretPosition + string.block.length;
					b = 0;
					start -= fixIeBug(string.block)
				}
				if ((selection === '' && string.replaceWith === '')) {
					caretOffset += fixOperaBug(string.block);
					start = caretPosition + string.openWith.length;
					b = string.block.length - string.openWith.length - string.closeWith.length;
					caretOffset = d.val().substring(caretPosition, d.val().length).length;
					caretOffset -= fixOperaBug(d.val().substring(0, caretPosition))
				}
				$.extend(hash, {
					caretPosition: caretPosition,
					scrollPosition: scrollPosition
				});
				if (string.block !== selection && abort === false) {
					insert(string.block);
					set(start, b)
				} else {
					caretOffset = -1
				}
				get();
				$.extend(hash, {
					line: '',
					selection: selection
				});
				if (ctrlKey === true && shiftKey === true) {
					prepare(clicked.afterMultiInsert)
				}
				prepare(clicked.afterInsert);
				prepare(k.afterInsert);
				if (previewWindow && k.previewAutoRefresh) {
					refreshPreview()
				}
				shiftKey = altKey = ctrlKey = abort = false
			}
			function fixOperaBug(a) {
				if ($.browser.opera) {
					return a.length - a.replace(/\n*/g, '').length
				}
				return 0
			}
			function fixIeBug(a) {
				if ($.browser.msie) {
					return a.length - a.replace(/\r*/g, '').length
				}
				return 0
			}
			function insert(a) {
				if (document.selection) {
					var b = document.selection.createRange();
					b.text = a
				} else {
					d.val(d.val().substring(0, caretPosition) + a + d.val().substring(caretPosition + selection.length, d.val().length))
				}
			}
			function set(a, b) {
				if (textarea.createTextRange) {
					if ($.browser.opera && $.browser.version >= 9.5 && b == 0) {
						return false
					}
					range = textarea.createTextRange();
					range.collapse(true);
					range.moveStart('character', a);
					range.moveEnd('character', b);
					range.select()
				} else if (textarea.setSelectionRange) {
					textarea.setSelectionRange(a, a + b)
				}
				textarea.scrollTop = scrollPosition;
				textarea.focus()
			}
			function get() {
				textarea.focus();
				scrollPosition = textarea.scrollTop;
				if (document.selection) {
					selection = document.selection.createRange().text;
					if ($.browser.msie) {
						var a = document.selection.createRange(),
						rangeCopy = a.duplicate();
						rangeCopy.moveToElementText(textarea);
						caretPosition = -1;
						while (rangeCopy.inRange(a)) {
							rangeCopy.moveStart('character');
							caretPosition++
						}
					} else {
						caretPosition = textarea.selectionStart
					}
				} else {
					caretPosition = textarea.selectionStart;
					selection = d.val().substring(caretPosition, textarea.selectionEnd)
				}
				return selection
			}
			function keyPressed(e) {
				shiftKey = e.shiftKey;
				altKey = e.altKey;
				ctrlKey = (!(e.altKey && e.ctrlKey)) ? e.ctrlKey: false;
				if (e.type === 'keydown') {
					if (ctrlKey === true) {
						li = $("a[accesskey=" + String.fromCharCode(e.keyCode) + "]", header).parent('li');
						if (li.length !== 0) {
							ctrlKey = false;
							setTimeout(function () {
								li.triggerHandler('mousedown')
							},
							1);
							return false
						}
					}
					if (e.keyCode === 13 || e.keyCode === 10) {
						if (ctrlKey === true) {
							ctrlKey = false;
							CasitaW(k.onCtrlEnter);
							return k.onCtrlEnter.keepDefault
						} else if (shiftKey === true) {
							shiftKey = false;
							CasitaW(k.onShiftEnter);
							return k.onShiftEnter.keepDefault
						} else {
							CasitaW(k.onEnter);
							return k.onEnter.keepDefault
						}
					}
					if (e.keyCode === 9) {
						if (shiftKey == true || ctrlKey == true || altKey == true) {
							return false
						}
						if (caretOffset !== -1) {
							get();
							caretOffset = d.val().length - caretOffset;
							set(caretOffset, 0);
							caretOffset = -1;
							return false
						} else {
							CasitaW(k.onTab);
							return k.onTab.keepDefault
						}
					}
				}
			}
			init()
		})
	};
	$.fn.VPeditorRemove = function () {
		return this.each(function () {
			var a = $(this).unbind().removeClass('VPeditorEditor');
			a.parent('div').parent('div.VPeditor').parent('div').replaceWith(a)
		})
	};
	$.VPeditor = function (a) {
		var b = {
			target: false
		};
		$.extend(b, a);
		if (b.target) {
			return $(b.target).each(function () {
				$(this).focus();
				$(this).trigger('insertion', [b])
			})
		} else {
			$('textarea').trigger('insertion', [b])
		}
	}
})(jQuery);
bbcode = {
  VoopeWSet: [
      {name:'Negrita', key:'B', openWith:'[b]', closeWith:'[/b]'},
      {name:'Cursiva', key:'I', openWith:'[i]', closeWith:'[/i]'},
      {name:'Subrayado', key:'U', openWith:'[u]', closeWith:'[/u]'},
      {name:'Tachado', key:'S', openWith:'[s]', closeWith:'[/s]'},
      {separator:'---------------' },
      {name:'Texto alineado a la izquierda', openWith:'[align=left]', closeWith:'[/align]'},
      {name:'Texto alineado al centro', openWith:'[align=center]', closeWith:'[/align]'},
      {name:'Texto alineado a la derecha', openWith:'[align=right]', closeWith:'[/align]'},
      {separator:'---------------' },
      {name:'Colores', dropMenu: [
          {openWith:'[color=#000000]', closeWith:'[/color]', className:"c000000" },
          {openWith:'[color=#993300]', closeWith:'[/color]', className:"c993300" },
          {openWith:'[color=#333300]', closeWith:'[/color]', className:"c333300" },
          {openWith:'[color=#003300]', closeWith:'[/color]', className:"c003300" },
          {openWith:'[color=#003366]', closeWith:'[/color]', className:"c003366" },
          {openWith:'[color=#000080]', closeWith:'[/color]', className:"c000080" },
          {openWith:'[color=#333399]', closeWith:'[/color]', className:"c333399" },
          {openWith:'[color=#333333]', closeWith:'[/color]', className:"c333333" },
          {openWith:'[color=#800000]', closeWith:'[/color]', className:"c800000" },
          {openWith:'[color=#FF6600]', closeWith:'[/color]', className:"cFF6600" },
          {openWith:'[color=#808000]', closeWith:'[/color]', className:"c808000" },
          {openWith:'[color=#008000]', closeWith:'[/color]', className:"c008000" },
          {openWith:'[color=#008080]', closeWith:'[/color]', className:"c008080" },
          {openWith:'[color=#0000FF]', closeWith:'[/color]', className:"c0000FF" },
          {openWith:'[color=#666699]', closeWith:'[/color]', className:"c666699" },
          {openWith:'[color=#808080]', closeWith:'[/color]', className:"c808080" },
          {openWith:'[color=#FF0000]', closeWith:'[/color]', className:"cFF0000" },
          {openWith:'[color=#FF9900]', closeWith:'[/color]', className:"cFF9900" },
          {openWith:'[color=#99CC00]', closeWith:'[/color]', className:"c99CC00" },
          {openWith:'[color=#339966]', closeWith:'[/color]', className:"c339966" },
          {openWith:'[color=#33CCCC]', closeWith:'[/color]', className:"c33CCCC" },
          {openWith:'[color=#3366FF]', closeWith:'[/color]', className:"c3366FF" },
          {openWith:'[color=#800080]', closeWith:'[/color]', className:"c800080" },
          {openWith:'[color=#999999]', closeWith:'[/color]', className:"c999999" },
          {openWith:'[color=#FF00FF]', closeWith:'[/color]', className:"cFF00FF" },
          {openWith:'[color=#FFCC00]', closeWith:'[/color]', className:"cFFCC00" },
          {openWith:'[color=#FFFF00]', closeWith:'[/color]', className:"cFFFF00" },
          {openWith:'[color=#00FF00]', closeWith:'[/color]', className:"c00FF00" },
          {openWith:'[color=#00FFFF]', closeWith:'[/color]', className:"c00FFFF" },
          {openWith:'[color=#00CCFF]', closeWith:'[/color]', className:"c00CCFF" },
          {openWith:'[color=#993366]', closeWith:'[/color]', className:"c993366" },
          {openWith:'[color=#C0C0C0]', closeWith:'[/color]', className:"cC0C0C0" },
          {openWith:'[color=#FF99CC]', closeWith:'[/color]', className:"cFF99CC" },
          {openWith:'[color=#FFCC99]', closeWith:'[/color]', className:"cFFCC99" },
          {openWith:'[color=#FFFF99]', closeWith:'[/color]', className:"cFFFF99" },
          {openWith:'[color=#CCFFCC]', closeWith:'[/color]', className:"cCCFFCC" },
          {openWith:'[color=#CCFFFF]', closeWith:'[/color]', className:"cCCFFFF" },
          {openWith:'[color=#99CCFF]', closeWith:'[/color]', className:"c99CCFF" },
          {openWith:'[color=#CC99FF]', closeWith:'[/color]', className:"cCC99FF" },
          {openWith:'[color=#FFFFFF]', closeWith:'[/color]', className:"cFFFFFF" }


      ]},
      {name:'Tama&ntilde;o', dropMenu :[
          {name:'Chiquita', openWith:'[size=10px]', closeWith:'[/size]' },
          {name:'Mediana', openWith:'[size=12px]', closeWith:'[/size]' },
          {name:'Normal', openWith:'[size=14px]', closeWith:'[/size]' },
          {name:'Grande', openWith:'[size=16px]', closeWith:'[/size]' },
          {name:'Muy grande', openWith:'[size=20px]', closeWith:'[/size]' },
          {name:'Gigante', openWith:'[size=28px]', closeWith:'[/size]' }
      ]},
      {name:'Fuente', dropMenu :[
          {name:'Arial', stynn:' style="font-family: Arial; "', openWith:'[font=arial]', closeWith:'[/font]' },
          {name:'Trebuchet MS', stynn:' style="font-family: Trebuchet MS; "', openWith:'[font=Trebuchet MS]', closeWith:'[/font]' },
          {name:'Arial Black', stynn:' style="font-family: arial black; "', openWith:'[font=arial black]', closeWith:'[/font]' },
          {name:'Comic Sans MS', stynn:' style="font-family: comic sans ms; "', openWith:'[font=comic sans ms]', closeWith:'[/font]' },
          {name:'Courier New', stynn:' style="font-family: courier new; "', openWith:'[font=courier new]', closeWith:'[/font]' },
          {name:'Georgia', stynn:' style="font-family: georgia; "', openWith:'[font=georgia]', closeWith:'[/font]' },
          {name:'Tahoma', stynn:' style="font-family: tahoma; "', openWith:'[font=tahoma]', closeWith:'[/font]' },
          {name:'Times New Roman', stynn:' style="font-family: times new roman; "', openWith:'[font=times new roman]', closeWith:'[/font]' },
          {name:'Verdana', stynn:' style="font-family: verdana; "', openWith:'[font=verdana]', closeWith:'[/font]' },
		  {name:'Consolas', stynn:' style="font-family: Consolas; "', openWith:'[font=Consolas]', closeWith:'[/font]' },
          {name:'Lucida Console', stynn:' style="font-family: Lucida Console; "', openWith:'[font=Lucida Console]', closeWith:'[/font]' },
       ]},
      {separator:'---------------' },
      {name:'Enlace', beforeInsert:function(h){ vp_enlace(h);}},
      {name:'Imagen' , beforeInsert:function(h){ vp_img(h);}},
      {name:'Video YouTube', beforeInsert:function(h){ vp_yt(h);}},
      {name:'Video Google', beforeInsert:function(h){ vp_google(h);}},
      {name:'Archivo SWF', beforeInsert:function(h){ vp_swf(h);}},
      {separator:'---------------' },
      {name:'Codigo', openWith:'[code]', closeWith:'[/code]'},
      {name:'Cita', openWith:'[quote]', closeWith:'[/quote]'},
      {name:'Download', openWith:'[download]', closeWith:'[/download]'},
      {name:'Password', openWith:'[password]', closeWith:'[/password]'},
   ]
}

//ENLACE
function vp_enlace(h) {
	if (h.selection == '') {
		var a = prompt('Ingrese la URL que desea postear', 'http://');
		if (a != null) {
			h.replaceWith = '[url]' + a + '[/url]';
			h.openWith = '';
			h.closeWith = ''
		} else {
			h.replaceWith = '';
			h.openWith = '';
			h.closeWith = ''
		}
	} else if (h.selection.substring(0, 7) == 'http://' || h.selection.substring(0, 8) == 'https://' || h.selection.substring(0, 6) == 'ftp://') {
		h.replaceWith = '';
		h.openWith = '[url]';
		h.closeWith = '[/url]'
	} else {
		var a = prompt('Ingrese la URL que desea postear', 'http://');
		if (a != null) {
			h.replaceWith = '';
			h.openWith = '[url=' + a + ']';
			h.closeWith = '[/url]'
		} else {
			h.replaceWith = '';
			h.openWith = '';
			h.closeWith = ''
		}
	}
}
//IMAGEN
function vp_img(h) {
	if (h.selection != '' && h.selection.substring(0, 7) == 'http://') {
		h.replaceWith = '[img]' + h.selection + '[/img]\n';
		h.openWith = '';
		h.closeWith = ''
	} else {
		var a = prompt('Ingrese la URL de la imagen', 'http://');
		if (a != null) {
			h.replaceWith = '[img]' + a + '[/img]\n';
			h.openWith = '';
			h.closeWith = ''
		} else {
			h.replaceWith = '';
			h.openWith = '';
			h.closeWith = ''
		}
	}
}
//YOUTUBE
function vp_yt(h) {
	var msg = prompt(lang['ingrese el id de yt' + (is_ie ? ' IE': '')], lang['ingrese solo el id de yt']);
	if (msg != null) {
		h.replaceWith = '[youtube=' + msg + ']\n';
		h.openWith = '';
		h.closeWith = ''
	} else {
		h.replaceWith = '';
		h.openWith = '';
		h.closeWith = ''
	}
}//GOOGLE
function vp_google(docId) {
	if (docId.selection != '' && docId.selection.substring(0, com / googleplayer.swf) == 'Ingrese el ID de Google') {
		docId.replaceWith = '[gvideo]' + docId.selection + '[/gvideo]\n';
		docId.openWith = '';
		docId.closeWith = ''
	} else {
		var google = prompt('Ingrese el ID del video de Google', 'Ingrese el ID de Google');
		if (google != null) {
			docId.replaceWith = '[gvideo=http://video.google.com/googleplayer.swf?docId=' + google + ']\n';
			docId.openWith = '';
			docId.closeWith = ''
		} else {
			docId.replaceWith = '';
			docId.openWith = '';
			docId.closeWith = ''
		}
	}
}
//SWF
function vp_swf(h) {
	if (h.selection != '' && h.selection.substring(0, 7) == 'http://') {
		h.replaceWith = '[swf]' + h.selection + '[/swf]\n';
		h.openWith = '';
		h.closeWith = ''
	} else {
		var a = prompt('Ingrese la URL del archivo SWF', 'http://');
		if (a != null) {
			h.replaceWith = '[swf]' + a + '[/swf]\n';
			h.openWith = '';
			h.closeWith = ''
		} else {
			h.replaceWith = '';
			h.openWith = '';
			h.closeWith = ''
		}
	}
}

/*FIN EDITOR*/

/* Mostramos el editor */
$(document).ready(
function(){
    $('#VPeditor').VPeditor(bbcode); //imprimo el editor
	$('.img_load').lazyload({placeholder : urls.images+'/loading.gif', threshold : 100}); // imprimo el loading
	$('#emoticons a').click(function(){
		$('#VPeditor').focus();
		emoticon = ' ' + $(this).attr("smile") + ' ';
		$.VPeditor({ replaceWith:emoticon });
		return false;
	});
	$('#photo_thumb').lazyload({threshold : 100});
	$('.hovercard').tooltip({
		content: Hovercard.callback,
		offset: [ -145, 5 ],
	});
	$('.hovercard-avatar').tooltip({
		offset: [ -145, 5 ],
		content: Hovercard.callback,
	});

    });

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}
var cache = {};
function favorite(fav, type) {
	if(fav > 4 || fav < 1 || act == fav) { return false; }
    if(!cache[fav]) {
    	$.ajax({
    		type: 'POST',
    		url: '/ajax/favorites-' + (type == 0 ? 'posts' : 'photos') + '.php',
    		data: 'order=' + fav,
			beforeSend: function() { $('#filter_var').css('opacity', 0.8); },
    		success: function(t) {
    			if(t.charAt(0) == '0') {
    				dialogBox.alert('Error', t.substring(1));
    			} else {
    				$('#filter_var').html(t);
                    cache[fav] = t;
    			}
    		},
    		error: function() { alert('few ._.'); },
    		complete: function() { $('#filter_var').css('opacity', 1); }
    	});
    } else {
        $('#filter_var').html(cache[fav]);
    }
	act = fav;
	//alert(cache.fav);
}
function onfocus_input(o){
	if($(o).val()==$(o).attr('title')){
		$(o).val('');
		$(o).removeClass('onblur_effect');
	}
}
var scrollpija = 0;
function ver_mas(id, last, action) {
	$('#pija').remove();
	$('#vp-loading').fadeIn('slow');
	if(!id || !last) { return false; }
	$.ajax({
		type: 'GET',
		url: '/ajax/profile-wall-filter.php',
		data: 'id_user=' + id + '&f=' + last + '&action=' + action,
		success: function(s) {
			$('#ult_comm_muro').html($('#ult_comm_muro').html()+s);
		},
		error: function() { alert('puf'); },
		complete: function() { $('#vp-loading').fadeOut('slow'); }
	});
	++scrollpija;
}

function profile_tab(tab, id) {
	if(tab == currenttab) { return false; }
	$('#vp-loading').fadeIn(800);
	$.ajax({
		beforeSend: function() { $('#perfil-center').fadeOut('medium'); },
		type: 'POST',
		url: '/ajax/profile-tab.php',
		data: 'tab=' + tab + '&user=' + id,
		success: function(e) {
			$('#perfil-center').html(e);
			$('#tab_' + currenttab).removeClass('selected');
			$('#tab_' + tab).addClass('selected');
			currenttab = tab;
			if(history.pushState) { history.replaceState(tab, currenttitle, $('#tab_' + tab + ' a').attr('href')); }
		},
		complete: function() {  $('#vp-loading').fadeOut('slow'); $('#perfil-center').fadeIn('medium'); },
		error: function() { alert('concha'); },
	})
}

function block(id, types) {
	if(!id || !types) { return false; }
	$('#vp-loading').fadeIn('high');
	$.ajax({
		url: '/ajax/block.php',
		type: 'GET',
		data: 'id_user=' + id + '&type=' + types,
		success: function(t) {
			if(t.charAt(0) == '0') {
				dialogBox.alert('Error', t.substring(1));
			} else {
				if(types == 0) {
					$('#bloquear').hide();
					$('#desbloquear').fadeIn(500);
				} else {
					$('#desbloquear').hide();
					$('#bloquear').fadeIn(500);
				}
			}
			$('#vp-loading').fadeOut('high');
		}
	});
}

/* Filtro TOPS */
var filtro_tops_orden = 'creado';
function tops_filtro(accion){
	if(filtro_sec_act == accion) { return false }
	$('#loading').css('display', 'block');
	$('#vp-loading').slideDown('slow');
	$('.icon-noti.comentarios-n').css('display', 'none');
	$('#mostrar').fadeOut('medium');
	$.ajax({
		type: 'GET',
		url: urls.home+'/ajax/tops-filter.php',
		data: 'cat='+currenttcat+'&currenttop='+accion+'&ajax=1&time=' + time,
		success: function(h){
		$('#vp-loading').slideUp('slow');
			switch(h.charAt(0)){
				case '0': //Error
					dialogBox.alert('Error', h.substring(3));
					break;
				default:
				if(accion == 'posts' || accion == 'usuarios'){
					$('#categoriasss').hide();
					$('#postssss').show();
					if($('#categorias').attr('style') == 'display: none;') { $('#categorias').slideDown(500); }
				} else if(accion == 'fotos') {
					$('#postssss').hide();
					$('#categoriasss').show();
					if($('#categorias').attr('style') == 'display: none;') { $('#categorias').slideDown(500); }
				} else {
					$('#categorias').slideUp(500);
				}
				$('#loading').css('display', 'none');
				$('.icon-noti.comentarios-n').css('display', 'block');
				$('#mostrar').html(h);
				$('#top_'+filtro_sec_act).removeClass('selected');
				$('#top_'+accion).addClass('selected');
				donde_actual = accion;
				filtro_sec_act = accion;
			}
		},
		error: function(){
			$('#vp-loading').slideUp('slow');
			dialogBox.error_500("tops_filtro('"+accion+"')");
		},
		complete: function() { $('#mostrar').slideDown('high'); }
	});
}

function savedraft() {
		  var params = 'title=' + encodeURIComponent($('input[name=titulo]').val()) + '&body=' + encodeURIComponent($('#VPeditor').val()) + '&cat=' + encodeURIComponent($('#categorias').val());
          params += '&sticky=' + ($('#sticky').is(':checked') ? 1 : 0);
          params += '&privado=' + ($('#privado').is(':checked') ? 1 : 0);
          params += '&cerrado=' + ($('#cerrado').is(':checked') ? 1 : 0);
          var currentTime = new Date();
          var borrador_ult_guardado = 'Guardado a las ' + currentTime.getHours() + ':' + currentTime.getMinutes() + ':' + currentTime.getSeconds() + ' hs.';
          if($('#borrador').val() != '-1') {
            params += '&id=' + $('#borrador').val();
          }
          var fewfew = $('#few').attr('onclick');
		  $('#few').hide();
          $.ajax({
            type: 'POST',
            data: params,
			dataType: 'json',
            url: '/ajax/draft-save.php',
            beforeSend: function() { $('#few').fadeOut(500).attr('onclick', 'return false;');  $('#vp-loading').css('display', 'block'); },
            success: function(ignacio) {
              if(ignacio.ok == '0') {
                dialogBox.alert('Error', ignacio.id);
              } else {
                $('#success').slideDown(500).html(borrador_ult_guardado);
				$('#borrador').attr('value', ignacio.id);
              }
            },
            error: function() { alert('concha'); },
            complete: function() { $('#few').fadeIn(500).attr('onclick', fewfew); $('#vp-loading').css('display', 'none'); }
          });
}

function spoiler(obj){
    $(obj).toggleClass('show').parent().next().fadeToggle(500);
}
function is_checked(obj){
	return document.getElementById(obj) && document.getElementById(obj).checked;
}
function onblur_input(o){
	if($(o).val()==$(o).attr('title') || $(o).val()==''){
		$(o).val($(o).attr('title'));
		$(o).addClass('onblur_effect');
	}
}
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('19 l={3q:6(a){$(\'#1o\').8(a).D(\'e\').D(\'U\');$(\'#1c\').8(\'\')},15:2l 2m(),3r:6(a){9(a==\'\')B;3s(i=0;i<n.15.2n;i++){9(n.15[i][0]===a){9(n.15[i][1]===\'1\'){$(\'#1o\').D(\'e\').C(\'U\');$(\'#1c\').8(n.15[i][2]).D(\'e\').C(\'U\')}u{$(\'#1o\').D(\'U\').C(\'e\');$(\'#1c\').8(n.15[i][2]).D(\'U\').C(\'e\')}B}}$(\'.1p#1S\').13(\'16\',\'1A\');$.7({o:\'G\',r:H.I+\'/7/E-3t.v\',x:\'r=\'+1a(a),w:6(h){l.15[l.15.2n]=2l 2m(a,h.t(0),h.j(3));$(\'.1p#1S\').13(\'16\',\'1B\');J(h.t(0)){f\'0\':$(\'#1o\').D(\'U\').C(\'e\');$(\'#1c\').8(h.j(3)).D(\'U\').C(\'e\');g;f\'1\':$(\'#1o\').D(\'e\').C(\'U\');$(\'#1c\').8(h.j(3)).D(\'e\').C(\'U\');g}},e:6(){$(\'.1p#1S\').13(\'16\',\'1B\');$(\'#1c\').8(\'F 1d 1T 1q 1U 1V\').D(\'U\').C(\'e\')}})},1W:6(a){9(!a){4.K();4.M(\'3u Z\');4.X(\'&1C;1X&1r;s 1Y 1D 1s 3v a 1E Z?<1t>3w&1r;s 3x 2o 3y!\');4.V(5,5,\'1Z\',\'l.1W(5)\',5,y,5,\'20\',\'4.10()\',5,5);4.R()}u{4.Y(\'3z Z...\');$.7({o:\'G\',r:H.I+\'/7/E-2p.v\',x:\'11=\'+1e+\'&2q=3A\',w:6(h){4.L();J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;f\'1\':4.10();21.2r();g}4.R()},e:6(){4.L();4.S("l.1W()")}})}},22:6(){4.Y(\'23...\',\'2s\');$.7({o:\'G\',r:H.I+\'/7/l.2t.3B.v\',x:\'11=\'+1e,w:6(h){J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;f\'1\':4.M(\'2s Z\');4.X(h.j(3),3C);4.V(5,5,\'3D 3E\',\'l.2u()\',5,5,5);4.R();g}},e:6(){4.S("l.22()");B},17:6(){4.L()}})},2u:6(){4.V(5);4.Y(\'2v...\',\'3F\');$.7({o:\'G\',r:H.I+\'/7/l.2t.v\',x:\'2w=\'+1a($(\'#2w\').A())+\'&2x=\'+1a($(\'#2x\').A())+\'&11=\'+1e,w:6(h){J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;f\'1\':4.z(\'3G 3H\',h.j(3));g;f\'2\':$(\'#2y\').13(\'16\',\'1A\').8(h.j(3));g}},e:6(){4.S("l.22()");B},17:6(){4.L()}})},2z:6(){4.K();4.M(\'2A Z\');4.X(\'&1C;3I 3J 1E Z a 2o 3K?\',3L);4.V(5,5,\'2A\',\'l.2B()\',5,5,5);4.R()},2B:6(){4.V(5);4.Y(\'2v...\',\'3M\');$.7({o:\'G\',r:H.I+\'/7/E-3N.v\',x:\'&11=\'+1e,w:6(h){J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;f\'1\':4.z(\'3O 3P\',h.j(3));g;f\'2\':$(\'#2y\').13(\'16\',\'1A\').8(h.j(3));g}},e:6(){4.S("l.2z()");B},17:6(){4.L()}})},2C:6(a){9(!a){4.K();4.M(\'3Q\');4.X(\'&1C;1X&1r;s 1Y 1D 1s 3R a 1E Z?\');4.V(5,5,\'1Z\',\'l.2C(5)\',5,y,5,\'20\',\'4.10()\',5,5);4.R()}u{4.Y(\'3S...\');$.7({o:\'G\',r:H.I+\'/7/E-2p.v\',x:\'11=\'+1e+\'&2q=3T\',w:6(h){4.L();J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;f\'1\':4.10();21.2r();g}4.R()},e:6(){4.L();4.S("l.1F()")}})}},1F:6(a){9(!a){4.K();4.M(\'3U Z\');4.X(\'&1C;1X&1r;s 1Y 1D 1s 2D 1E Z?\');4.V(5,5,\'1Z\',\'l.1F(5)\',5,y,5,\'20\',\'4.10()\',5,5);4.R()}u{4.Y(\'3V...\');$.7({o:\'G\',r:H.I+\'/7/E-3W.v\',x:\'11=\'+1e,w:6(h){4.L();J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;f\'1\':4.10();3X.21.2E=\'/l/\';g}4.R()},e:6(){4.L();4.S("l.1F()")}})}},2F:6(a,b){4.3Y=\'2F\';4.3Z=5;4.K(5);4.M(\'24\');4.X(\'<1t /><1t />\',40);4.V(5);4.Y(\'23...\',\'24 Z\');4.R();$.7({o:\'G\',r:H.I+\'/7/E-41.v\',x:\'42=\'+a+\'&T=\'+b,w:6(h){J(h.t(0)){f\'0\':4.L();4.z(\'F 43!\',h.j(3));g;f\'1\':9(a==\'1\'){$(\'#1f\').8(W($(\'#1f\').8())+1)}u 9(a==\'-1\'){$(\'#1f\').8(W($(\'#1f\').8())-1)}$(\'#1f\').D().C((W($(\'#1f\').8())<0?\'44\':\'U\'));4.L();4.z(\'24 T!\',h.j(3));g}},e:6(){$(\'#45\').8(\'F 1d 1T 1q 1U 1V\').D(\'U\').C(\'e\')}})},46:6(a){$(\'#1g\').N(1);$(\'#O-P\').Q(\'k\');$.7({o:\'G\',r:H.I+\'/7/E-2G.v\',x:\'7=5&2H=\'+a,w:6(h){$(\'#O-P\').N(\'k\');$(\'#1g\').8(h);$(\'#1g\').Q({25:2I,2J:\'2K\'})}})},47:6(a){$(\'#1g\').N(1);$(\'#O-P\').Q(\'k\');$.7({o:\'G\',r:H.I+\'/7/E-2G.v?11=\'+a,x:\'7=5\',w:6(h){$(\'#O-P\').N(\'k\');$(\'#1g\').8(h);$(\'#1g\').Q({25:2I,2J:\'2K\'})}})},2L:6(a,b){9($(\'#1G\').A()==\'\'){$(\'#1G\').26();B}$("#2M").N(1);$(\'#O-P\').Q(\'k\');$.7({o:\'G\',r:H.I+\'/7/E-48.v\',x:\'X=\'+1a($(\'#1G\').A())+\'&T=\'+a,w:6(h){$(\'#O-P\').N(\'k\');J(h.t(0)){f\'0\':4.z(\'e\',h.j(3));g;f\'1\':$(\'#1H\').8(W($(\'#1H\').8())+1);$(\'#1I\').8(W($(\'#1I\').8())+1);$(\'#2M\').8(h.j(3)).Q(\'k\',6(){$(\'.49\').14(\'k\');$(\'#1G\').A(\'\')});9($(\'#2N\')){$(\'#2N\').14(\'k\')}g}},e:6(){$(\'#O-P\').N(\'k\');4.S("l.2L(\'"+a+"\', \'"+b+"\')")}})},2O:6(a){$(\'#O-P\').2P(\'k\');$.7({o:\'G\',r:H.I+\'/7/E-4a.v\',x:\'11=\'+a,27:y,w:6(h){$(\'#O-P\').28(\'k\');J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;f\'1\':$(\'#2Q\'+a).8(h.j(3));$(\'#2Q\'+a).N(\'k\');$(\'#1H\').8(W($(\'#1H\').8())-1);$(\'#1I\').8(W($(\'#1I\').8())-1);g}},e:6(){$(\'#O-P\').28(\'k\');4.S("l.2O(\'"+a+"\')");B}})},4b:6(c,d){$("#18").N(1);$("#2R").K(\'k\');$.7({o:"1u",r:H.I+\'/7/E-4c-4d.v?11=\'+c+\'&p=\'+d+\'&7=5\',w:6(a){19 b=$(\'#18\').8();$("#18").8(a);$("#18").Q({25:4e});$("#2R").14(\'k\')},e:6(){$(\'#18\').C(\'4f 4g\');$(\'#18\').13(\'4h-4i\',\'4j\');$(\'#18\').8(\'F 1d 1T 1q 1U 1V\');$("#18").Q("k")}})},4k:6(a){9(29!=a){$(\'#2S\'+29).D(\'1J\');$(\'#2S\'+a).C(\'1J\')}29=a;B 5},4l:6(a){$(\'#2a\').K();$(\'#2b\').28(\'k\');$.7({o:\'1u\',r:H.I+\'/7/E-4m.v\',x:\'4n=\'+a+\'&2T=5\',w:6(h){$(\'#2a\').14();$(\'#O-P\').N(\'k\');9(h.t(0)==0){$(\'#1h\').C(\'2U\');$(\'#1h\').8(h.j(3)).Q(\'k\');$(\'#1h\').Q(\'k\')}u 9(h.t(0)==1){$(\'#2b\').8(h.j(3));$(\'#2b\').2P()}},e:6(){$(\'#2a\').14();$(\'#1h\').C(\'2U\');$(\'#1h\').8(2V[\'e 1q\']);$(\'#1h\').Q(\'k\');B},})},4o:6(a,b,c){$(\'#O-P\').Q(\'k\');$(\'#2c\').N(\'k\').C(\'2W\');$(\'#2X\').K(\'1i\');$(\'#1K\'+1L).D(\'2Y\');$(\'#1K\'+a).C(\'2Y\');$(\'#M\'+1L).14(\'1i\');$(\'#M\'+a).K(\'1i\');$(\'#K\'+1L).14(\'1i\');$(\'#K\'+a).K(\'1i\');1L=a;$.7({o:\'G\',r:H.I+\'/7/E-1K.v?p=\'+b,x:\'1K=\'+a+\'&4p=\'+b+\'&2T=5&2H=\'+c,w:6(h){$(\'#O-P\').N(\'k\');$(\'#2X\').14(\'1i\');J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;4q:$(\'#2c\').8(h);$(\'#2c\').Q(\'k\').D(\'2W\')}},e:6(){$(\'#O-P\').N(\'k\');4.S("4r(\'"+4s+"\')")}})},1j:\'1\',1v:0,1w:6(a){9(!a)a=n.1j;u 9(n.1j==a)B;9(n.1j!=a||n.1k)n.1v=0;19 b=\'1l=\'+1l;$(\'#2Z\'+n.1j).D(\'1J\');n.1j=a;$(\'#2Z\'+a).C(\'1J\');b+=\'&7=1&1x=\'+a+\'&p=\'+1m.1v;9(n.1k){b+=\'&q=\'+n.1k}$(\'.1p\').13(\'16\',\'1A\');$.7({o:\'1u\',4t:6(){$(\'#1y\').4u(4v).N()},r:\'/7/E-4w-1x.v\',x:b,w:6(h){J(h.t(0)){f\'0\':$(\'#1y\').8(\'<1M 30="4x">\'+h.j(3)+\'</1M>\');g;f\'1\':$(\'#1y\').8(h.j(3));g}},e:6(){$(\'#1y\').8(\'<1M 30="4y">\'+2V[\'e 1q\']+\'. <a 2E="4z:1m.1w()">4A</a></1M>\')},17:6(){$(\'.1p\').13(\'16\',\'1B\');$(\'#1y\').Q()}})},1k:\'\',4B:6(){n.1k=$.4C($(\'#1k\').A());n.1w()},4D:6(){1m.1v++;n.1w()},4E:6(){1m.1v--;n.1w()},31:6(a){4.Y(\'23...\',\'2d 1d 2e\');$.7({o:\'1u\',r:\'/7/E-32.v\',27:y,x:\'33=\'+a+\'&1l=\'+1l,w:6(h){J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;f\'1\':4.M(\'2d 1d 2e\');4.X(h.j(3),4F);4.V(5,5,\'1N\',"l.2f(\'"+a+"\')",y,y,5,\'2g\',\'10\',5,5);g}4.R()},e:6(){4.S("l.31(\'"+4G+"\')")},17:6(){4.L()}})},4H:6(){9($(\'.1z #2h\').13(\'16\')==\'1B\'){$(\'.1z #2h\').K(\'k\');$(\'.1z #34\').8(\'&4I; 35 4J\')}u{$(\'.1z #2h\').14(\'k\');$(\'.1z #34\').8(\'35 m&1r;s &4K;\')}},36:6(){9(12(\'37\')){9($(\'#1O\').A()==\'\'||(!12(\'38\')&&!12(\'39\'))||(12(\'39\')&&$(\'#3a\').A()==\'\')){4.1n(y,5);B y}u{4.1n(5,5);B 5}}u 9(12(\'3b\')){9($(\'#1O\').A()==\'\'){4.1n(y,5);B y}u{4.1n(5,5);B 5}}u 9(12(\'3c\')){9(4L==$(\'#3d\').A()){4.1n(y,5);B y}u{4.1n(5,5);B 5}}},2f:6(a){9(!n.36())B y;9(12(\'37\'))19 b=\'1\';u 9(12(\'3b\'))19 b=\'3\';u 9(12(\'3c\'))19 b=\'2\';4.Y(\'4M...\');19 c=\'33=\'+a+\'&1l=\'+$(\'#1l\').A()+\'&3e=\'+$(\'#3e\').A()+\'&4N=5\';c+=\'&1x=\'+b;J(b){f\'1\':c+=\'&3f=\'+1a($(\'#1O\').A())+\'&4O=\'+(12(\'38\')?\'0&4P=1\':W($(\'#3a\').A()));g;f\'3\':c+=\'&3f=\'+1a($(\'#1O\').A());g;f\'2\':c+=\'&4Q=\'+$(\'#3d\').A();g}$.7({o:\'1u\',r:\'/7/E-32.v\',27:y,x:c,w:6(h){J(h.t(0)){f\'0\':4.z(\'F\',h.j(3));g;f\'1\':4.M(\'2d 1d 2e\');4.X(h.j(3));4.V(5,5,\'1N\',\'10\',5,5,y);9(b==\'3g\')$(\'#1P\').8(W($(\'#1P\').8())-W(1));u 9(b==\'3h\')$(\'#1P\').8(W($(\'#1P\').8())+W(1));9(b==\'3g\'||b==\'3h\')$(\'#4R\'+a).4S();g}4.R()},e:6(){4.S("1m.2f(\'"+a+"\')")},17:6(){4.L()}})},1Q:6(a){9(!a){4.K();4.M(\'4T T\');4.X(\'4U 1D 1s 4V 3i T?<1t /><1t />2i: <4W o="4X" 11="1b" 4Y="4Z" 50="2i 1R 2j" M="2i 1R 2j" 51="52(n)" 53="54(n)" 55="9(56(57)) 1m.1Q(5)" />\',58);4.V(5,5,\'1N\',"l.1Q(5)",5,y,5,\'2g\',\'10\',5,y);4.R();$(\'#1b\').26()}u{9($(\'#1b\').A()==\'\'||$(\'#1b\').A()==$(\'#1b\').59(\'M\')){$(\'#1b\').26();B}4.Y(\'5a...\');$.7({o:\'G\',r:\'/7/3j-1R.v\',x:\'5b=\'+1a($(\'#1b\').A())+\'&T=\'+T+\'&1x=2D\',w:6(h){9(h.t(0)==0)4.z(\'F\',h.j(2));u 9(h.t(0)==1)4.z(\'3k 2j\',\'3l T 3m 5c 3n\',5)},e:6(){4.S("l.1Q(\'"+a+"\')")},17:6(){4.L()}})}},2k:6(a){9(!a){4.K();4.M(\'5d T\');4.X(\'5e 1s 3o 3i T\');4.V(5,5,\'1N\',"l.2k(5)",5,5,5,\'2g\',\'10\',5,y);4.R()}u{4.Y(\'5f...\');$.7({o:"G",r:\'/7/3j-1R.v\',x:\'T=\'+T+\'&1x=3o\',w:6(h){9(h.t(0)==0)4.z(\'F\',h.j(2));u 9(h.t(0)==1)4.z(\'3k 3p\',\'3l T 3m 3p 3n\',5)},e:6(){4.S("l.2k(\'"+a+"\')")},17:6(){4.L()}})}},}',62,326,'||||dialogBox|true|function|ajax|html|if|||||error|case|break|||substring|slow|comunidades||this|type|||url||charAt|else|php|success|data|false|alert|val|return|addClass|removeClass|groups|Error|POST|urls|home|switch|show|procesando_fin|title|slideUp|vp|loading|slideDown|center|error_500|tema|ok|buttons|parseInt|body|procesando_inicio|comunidad|close|id|is_checked|css|hide|crear_shortname_check_cache|display|complete|comentarios|var|encodeURIComponent|icausa_status|msg_crear_shortname|al|g_com|votos_total|ult_comm|error_tops_com|fast|miembros_list_section_here|miembros_list_search|group|com|buttons_enabled|preview_shortname|gif_cargando|procesar|aacute|deseas|br|GET|miembros_list_pag_actual|miembros_list|action|showResult|suspendido_data|block|none|iquest|que|esta|delete_community|VPeditor|cantcomments|cantcomments2|here|filter|filtro_com|div|Aceptar|t_causa|cont_miembros|del_tema|del|shortname|intentar|lo|solicitado|getout_community|Est|seguro|SI|NO|location|denounce|Cargando|Votar|duration|focus|cache|fadeOut|TopsComTabsHere|loading_tops|box_tops_com|filter_comunidades|Administrar|usuario|admin_users_save|Cancelar|ver_mas|Causa|borrado|react_tema|new|Array|length|tus|join|sa|reload|Denunciar|denunciar|denounce_send|Enviando|razon|comentario|error_data|publicity|Recomendar|publicity_send|join_community|eliminar|href|votar_tema|comments|cat|1000|easing|easeOutBounce|add_comment|return_add_comment|sin_comentarios|del_comment|fadeIn|cmt_|loading_comment|tabTopsCom|_|color_red|lang|opacity|loading_filter|selected|filterBy|class|admin_users|actionuser|uid|vermas|Ver|admin_users_check|r_suspender|r_suspender_dias1|r_suspender_dias2|t_suspender|r_rehabilitar|r_rango|s_rango|currentuser|reason|suspender|rehabilitar|este|topic|Tema|El|fue|satisfactoriamente|reactivar|reactivado|crear_shortname_key|crear_shortname_check|for|checkurl|Abandonar|abandonar|Perder|todos|privilegios|Abandonando|out|form|450|Enviar|denuncia|Denunciando|Denuncia|enviada|Deseas|recomendar|seguidores|350|Publicitando|recomend|Publicitada|exitosamente|Unirse|unirte|Uniendose|add|Eliminar|Eliminando|delgroup|document|class_aux|mask_close|305|vote|voto|detectado|no|votos_total2|update_comments|update_comments_com|addcomment|agregar_comment|deletecomment|comments_pag|comment|page|1900|Globo|GlbRed|margin|bottom|6px|TopsComTabs|TopsComFilter|tops|filter2|filter_com|pag|default|portal_filter|accion|beforeSend|toggle|500|members|redBox|emptyData|javascript|Reintentar|miembros_list_search_set|trim|miembros_list_sig|miembros_list_ant|340|user|admin_users_vermas|laquo|menos|raquo|rango_actual|Guardando|send|time|permanent|newrank|userid_|remove|Borrar|Seguro|borrar|input|text|maxlength|90|value|onfocus|onfocus_input|onblur|onblur_input|onkeypress|keypress_intro|event|370|attr|Borrando|causa|eliminado|Reactivar|Realmente|Reactivando'.split('|'),0,{}))
function filterComms(tab){
	if(filterCommsHere != tab){
		$('#tab'+filterCommsHere).removeClass('here');
		$('#tab'+tab).addClass('here');
	}
	filterCommsHere = tab;
	return true;
}

//Yao, no todo es de la mierda de voope
var activity = {
	filter: function(id, value) {
		$('#last-activity-container').slideUp(250);
		if((value < 1 || value > 14) && value != '-1') { return false; }
		$.ajax({
			type: 'get',
			url: '/Pages/profile-activity.php',
			data: '_=true&id_user=' + id + '&filter=' + value,
			success: function(t) {
				if(t.charAt(0) == '0') { return dialogBox.alert('Error', t.substring(1)); }
				$('#last-activity-container').slideDown(250).html(t.substring(1));
			}
		});
	},
	more: function(id, filter, lastact, i) {
		$('#last-activity-view-more').remove();
		if(!id || !filter || !lastact || !i) { return false; }
		$.ajax({
			url: '/Pages/profile-activity.php',
			type: 'GET',
			data: '_=true&id_user=' + id + '&filter=' + filter + '&lastid=' + lastact + '&idtime=' + i,
			success: function(t) {
				if(t.charAt(0) == '0') { return false; }
				$('#last-activity-container').html($('#last-activity-container').html() + t.substring(1));
			}
		});
	},
	del: function(id, obj) {
		if(!id) { return false; }	
		$.ajax({
			url: '/ajax/activity-delete.php',
			type: 'post',
			data: 'id=' + id,
			success: function(h) {
				if(h.charAt(0) == '0') {
					dialogBox.alert('Error', h.substring(1));
				} else {
					$(obj).parent().parent().slideUp('normal', function(){
						if($(this).siblings('div').length == 0) {
							var datesep = $(this).parent();
							$(this).remove();
							$(datesep).delay(700).slideUp('slow', function(){
								$(this).remove;
							});
						} else {
							$(this).remove();
						}
					});
				}
			}
		});
	},	
}	
/* number_format (php.js) 906.1806 */
function number_format(a,b,e,f){a=a;b=b;var c=function(i,g){g=Math.pow(10,g);return(Math.round(i*g)/g).toString()};a=!isFinite(+a)?0:+a;b=!isFinite(+b)?0:Math.abs(b);f=typeof f==="undefined"?",":f;e=typeof e==="undefined"?".":e;var d=b>0?c(a,b):c(Math.round(a),b);c=c(Math.abs(a),b);var h;if(c>=1E3){c=c.split(/\D/);h=c[0].length%3||3;c[0]=d.slice(0,h+(a<0))+c[0].slice(h).replace(/(\d{3})/g,f+"$1");d=c.join(e)}else d=d.replace(".",e);a=d.indexOf(e);if(b>=1&&a!==-1&&d.length-a-1<b)d+=(new Array(b-(d.length- a-1))).join(0)+"0";else if(b>=1&&a===-1)d+=e+(new Array(b)).join(0)+"0";return d};
function my_number_format(numero){
	return number_format(numero, 0, ',', '.');
	//return Number(numero).toLocaleString();
}

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('c d={e:7(a){3(k 8.9===\'l\'){8.9=f.g}c a=2(a);f.g=(a>0?\'(\'+a+\') \':\'\')+8.9},h:7(){$.b({m:\'/b/n-h.o\',p:\'q\',r:\'s\',u:\'b=v\',w:7(t){3(t.x!=1){y z}d.e((2(t.4)+2(t.5)));3(t.4>0&&t.4!=2($(\'#i\').6())){$(\'#i\').A(B).6(t.4)}3(t.5>0&&t.5!=2($(\'#j\').6())){$(\'#j\').C().6(t.5)}}})},};',39,39,'||parseInt|if|notifications|messages|html|function|this|titleOriginal||ajax|var|live|updateTitle|document|title|update|noti_box_not|noti_box_mp|typeof|undefined|url|user|php|dataType|json|type|post||data|true|success|status|return|false|fadeIn|500|hide'.split('|'),0,{}))