// ==UserScript==
// @name           Comentar shouts
// @namespace      IgnacioViglo
// @author         Ignacio Daniel
// @description    Esta pija comenta en los shouts asi los trolos de taringa se ponen a llorar sin parar.
// @include        http://*taringa.net/*
// @include        http://*www.taringa.net/*
// ==/UserScript==
var $ = unsafeWindow.jQuery, localStorage = unsafeWindow.localStorage, mydialog = unsafeWindow.mydialog;
// php.js

$(document).ready(function(){
	if(!localStorage['hosts'] || location.pathname == '/404/'){
		mydialog.alert('Escribe tu BBCode para los posts a publicar (el spam, tipo "unete a Moovax..."): <br /><textarea class="ui-corner-all form-input-text box-shadow-soft" onblur="localStorage[\'bbcode_karma_temp\']=this.value"></textarea>', 'BBCode', function(){ localStorage['hosts'] = localStorage['bbcode_karma_temp']; });
		return false;
	}
	if(/^\/mi\/publico\/$/i.test(location.pathname)){
		location.href=$('div.s-action-list > a.button-action-comentar').attr('href');
	} else if(/^\/(.+)\/mi\/(.+)$/i.test(location.pathname)){
		if($('div.action > i.hastipsy').attr('title') != 'Desarrollador' && $('div.action > i.hastipsy').attr('title') != 'Moderador' && $('#markItUpBody_comm').html() && localStorage['lasturl'] != location.pathname) {
			$('textarea[id=body_comm]').val(localStorage['hosts']);
			$("#comment-button-text").click().fadeOut(4100, function() {
				window.location = '/mi/publico/';
			});
			localStorage['lasturl'] = location.pathname; 
		} else {
			location.href='/mi/publico/';
		}	
	}
});