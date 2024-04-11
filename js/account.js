var account = {
	tabs: function (a) {
		$('#vp-loading').fadeIn('slow');
		$('#edit-profile-right').toggle(500);
		$.ajax({
			type: 'GET',
			url: urls.home + '/ajax/account.php',
			data: 'tab=' + a + '&_=true',
			success: function (h) {
				if (h.charAt(0) == '0') {
					dialogBox.alert('Error', h.substring(3))
				} else {
					$('#edit-profile-right').html(h)
				}
			},
			complete: function () {
				$('#vp-loading').fadeOut('slow');
				$('#edit-profile-right').slideDown('medium')
			}
		})
	},
	save: function (a) {
		$('#vp-loading').slideDown('slow');
		$('#cargando_paso').fadeIn('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/account-save.php',
			data: $('#save_profile' + a).serialize() + '&ps=' + a,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				$('#cargando_paso').fadeOut('slow');
				if (h.charAt(0) == 0) {
					dialogBox.alert('Error al guardar', h.substring(3))
				} else if (h.charAt(0) == 1) {
					$('#exito_paso' + a).html(h.substring(3));
					$('#exito_paso' + a).slideDown('slow');
					$('#error_paso' + a).slideUp('slow');
					$('input#save_paso' + a).addClass('disabled').attr('disabled', 'disabled');
					sleep(400);
					if(a < 4) { chgsec($('.DesOpt').next()); }
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500('guardar_paso4()');
				return
			}
		})
	},
	edit_avatar: function () {
		var a = 'id_user=' + encodeURIComponent($('input[name="id_user"]').val()) + '&avatar=' + encodeURIComponent($('input[name="avatar"]').val());
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/account-save.php',
			data: '&ps=5&' + a,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#exito').html(h.substring(3));
					$('#exito').slideDown('slow');
					$('#save_perfil').fadeOut('slow');
					load_new_avatar();
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500('accounts.edit_avatar()');
				return
			}
		})
	},
	edit_settings: function () {
		var a = 'id_user=' + encodeURIComponent($('input[name="id_user"]').val()) + '&info=' + encodeURIComponent($('select[name="mostrar_info"]').val()) + '&muro=' + encodeURIComponent($('select[name="recibir_muro"]').val()) + '&amistad=' + encodeURIComponent($('select[name="recibir_amistad"]').val()) + '&mp=' + encodeURIComponent($('select[name="recibir_mp"]').val());
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/account-save.php',
			data: 'ps=7&' + a,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#exito').html(h.substring(3));
					$('#exito').slideDown('slow');
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				mydialog.error_500('accounts.edit_settings()');
				return
			}
		})
	},
	edit_signature: function () {
		var a = 6;
		var b = 'id_user=' + encodeURIComponent($('input[name="id_user"]').val()) + '&firma=' + encodeURIComponent($('textarea[name="firma"]').val());
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/account-save.php',
			data: '&ps=6&' + b,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#exito').html(h.substring(3));
					$('#exito').slideDown('slow');
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500('accounts.edit_signature()');
				return
			}
		})
	},
	new_pass: function () {
		var a = 'id_user=' + encodeURIComponent($('input[name="id_user"]').val()) + '&pass_actual=' + encodeURIComponent($('input[name="pass_actual"]').val()) + '&pass_new=' + encodeURIComponent($('input[name="pass_new"]').val()) + '&pass_verify=' + encodeURIComponent($('input[name="pass_verify"]').val());
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/account-save.php',
			data: 'ps=8&' + a,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					$('#exito').html(h.substring(3));
					$('#exito').slideDown('slow');
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				mydialog.error_500('accounts.new_pass()');
				return
			}
		})
	},
	background: function(remove) {
		var background = $('#background').val();
		var background_color = $('#colorSelector input').val();
		var background_repeat = ($('#repeat').is(':checked') ? 1 : 0);
		$('#wall').slideUp(500);
		$('#loading_few').show();
		$.ajax({
			url: '/ajax/account-backgroundsave.php',
			data: 'background=' + background + '&color=' + background_color + '&repeat=' + background_repeat + '&action=' + (remove === true ? 'remove' : 'save'),
			type: 'post',
			dataType: 'json',
			success: function(data) {
				if(data.status == '0') { 
					dialogBox.alert('Error', data.data); 
				} else if(data.status = '1') {
					$('body, #newcolor').css("background-image", "url('" + data.background + "')").css("background-repeat", data.repeat).css("background-color", data.color );
					if(remove === true) {
						$('#background').val('').focus();
						$('#wallpajero').slideUp(500);
					} else if(background != '') {
						$('#wallpajero').slideDown(500);
					}	
				}
			},
			complete: function() {
				$('#loading_few').hide();
				$('#wall').slideDown(500); 
			}	
		});
	},					
};