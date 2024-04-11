// ==UserScript==
// @name           Comentar shouts en chileconpapas
// @namespace      IgnacioViglo
// @author         Ignacio Daniel
// @description    Esta pija comenta en los shouts asi el pete de goro99, ferchu etc lloran
// @include        http://*chilepirata.com/*
// @include        http://*www.chilepirata.com/*
// ==/UserScript==
var $ = unsafeWindow.jQuery, localStorage = unsafeWindow.localStorage, mydialog = unsafeWindow.mydialog, shout = unsafeWindow.shout;
$(document).ready(function(){
	if(!localStorage['SPAM'] || location.pathname == '/404'){
		mydialog.alert('Escribe tu BBCode para los posts a publicar (el spam, tipo "unete a ChilePirata..."): <br /><textarea class="ui-corner-all form-input-text box-shadow-soft" onblur="localStorage[\'bbcode_karma_temp\']=this.value"></textarea>', 'BBCode', function(){ localStorage['SPAM'] = localStorage['bbcode_karma_temp']; });
		return false;
	}
	if(/^\/mi\/publico\/$/i.test(location.pathname)){
		localStorage['last'] = shout.lastId;
		var randomNum = Math.floor(Math.random()*localStorage['last']); /* Pick random number */
		location.href = '/jojofighten/mi/' + randomNum;
	} else if(/^\/jojofighten\/mi\/(.*)$/i.test(location.pathname)){
		if($('#markItUpBody_comm').html()) {
			$('textarea[id=body_comm]').val(localStorage['SPAM']);
			$("#comment-button-text").click().fadeOut(5000, function() {
				window.location = '/mi/publico/';
			});
		} else {
			location.href='/mi/publico/';
		}	
	}
});