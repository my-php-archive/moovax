/* Acciones Area administrativa */
var admin = {
	add_web: function() {
		dialogBox.procesando_inicio('Cargando...', 'Agregar web');
		$.ajax({
			type: 'POST',
			url: '/ajax/admin-webs-form.php',
			data: 'add=true',
			success: function(t) {
				dialogBox.title('Agregar web');
				dialogBox.body(t, 450);
				dialogBox.buttons(true, true, 'Agregar web', 'admin.add_web_send()', true, true, true);
				dialogBox.center();
			},
			complete: function() { dialogBox.procesando_fin(); },
			error: function() { alert('loco1'); }
		});
	},
	add_ip: function() {
		var ip = $('#ip').val();
		var type = $('#type').val();
		if(!ip || !type) { return false; }
		$.ajax({
			beforeSend: function() { $('#ip_add').css('opacity', 0.3); },
			type: 'POST',
			url: '/ajax/admin-add-ip.php',
			data: 'ip=' + ip + '&type=' + type,
			success: function(ignacio) {
				if(ignacio.charAt(0) == 0) {
					dialogBox.alert('Error', ignacio.substring(1));
				} else {
					$('#ip_add').fadeOut('medium');
					$('#success').slideDown(500);
					$('#add_new').fadeIn(500).html(ignacio);
				}
			},
			complete: function() { $('#ip_add').css('opacity', 1); }
		});
	},
	del_ip: function(id) {
		if(!id) return false;
		$.ajax({
			type: 'POST',
			url: '/ajax/admin-del-ip.php',
			data: 'id=' + id,
			success: function(ignacioviglo) {
				if(ignacioviglo.charAt(0) == 0) {
					//Dialogbox
					dialogBox.alert('Error', ignacioviglo.substring(1));
				} else {
					$('#ip' + id).fadeOut(500);
				}
			}
		});
	},
	delcontact: function(id) {
		if(!id) { return false }
		$('#vp-loading').slideDown('slow');
		$.ajax({
			type: 'POST',
			url: '/ajax/admin-del-contact.php',
			data: 'id=' + id,
			success: function(t) {
				if(t.charAt(0) == 0) {
					dialogBox.alert('Error', t.substring(3));
				} else if(t.charAt(0) == 1) {
					$('#not' + id).show('slow');
					$('#not' + id).addClass('redBox');
					$('#delete' + id).fadeOut(500);
				}
			},
			error: function() { alert('Ocurrio un error inesperado'); },
			complete: function() { $('#vp-loading').slideUp('high'); }
		});
	},
	add_web_send: function() {
		/* con ese movimiento me pone mal eeeer34 */
		var url = $('#web').val();
		var name = $('#name').val();
		dialogBox.procesando_inicio('Cargando...', 'Agregando...');
		if(!url) { return false; }
		$.ajax({
			type: 'POST',
			url: '/ajax/admin-webs.php',
			data: 'url=' + url + '&name=' + name,
			success: function(h) {
				switch(h.charAt(0)) {
					case '0':
						dialogBox.alert('Error', h.substring(1));
						break;
					case '1':
						$('#new_few').fadeIn(900).html(h.substring(1));
						dialogBox.close();
						break;
				}
			},
			error: function() { alert('uhh'); },
			complete: function() { dialogBox.procesando_fin(); },
		});
	},

	delete_web: function(id) {
		if(!id) { return false; }
		$.ajax({
			type: 'POST',
			url: '/ajax/admin-delete-url.php',
			data: 'id=' + id,
			success: function(t) {
				if(t.charAt(0) == 0) {
					dialogBox.alert('Error', t.substring(1));
				} else {
					$('#url' + id).fadeOut(800); //Sapeeeee
					$('#new_few').fadeOut(800); //uhh
				}
			},
			error: function() { alert('Hubo un error al intentar procesar la solicitud q3'); }
		});
	},
    load_settings: function() {
      $('#new').slideUp(1900);
      $('#load-ajax').toggle(500);
      var params = $('form[id="new"]').serialize();
      $.ajax({
        type: 'POST',
        url: '/ajax/admin-config.php',
        data: params,
        success: function(q) {
          if(q.charAt(0) == 0) {
            dialogBox.alert('Error', q.substring(3));
            $('#new').slideDown('slow');
          } else if(q.charAt(0) == 1) {
            $('#success').fadeIn(1900).html(q.substring(3));
            $('.BtnPurple').fadeOut(1500);
          }
        },
        complete: function() { $('#load-ajax').toggle('slow'); },
        error: function() { alert('concha'); }
      });
    },
	censor_words: function () {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Palabras censuradas');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-words-form.php',
			data: '',
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.title('Palabras censuradas');
					dialogBox.body(h.substring(3), 450);
					dialogBox.buttons(true, true, 'Guardar cambios', 'admin.censor_words_save()', true, true, true);
					dialogBox.center();
					break
				}
			},
			error: function () {
				dialogBox.error_500("admin.censor_words()");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	censor_words_save: function () {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Enviando...', 'Guardando');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-words.php',
			data: 'censurar=' + encodeURIComponent($('#censurar').val()),
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Cambios guardados', h.substring(3));
					break
				}
			},
			error: function () {
				dialogBox.error_500("admin.censor_words()");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	add_points: function () {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Puntos');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-points-add.php',
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.title('Enviar puntos');
					dialogBox.body(h.substring(3), 450);
					dialogBox.buttons(true, true, 'Enviar', 'admin.add_points_send()', true, true, true);
					dialogBox.center();
					break
				}
			},
			error: function () {
				dialogBox.error_500("admin.sponsors()");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	add_points_send: function () {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Enviando...', 'Guardando');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-points-add.php',
			data: 'user=' + encodeURIComponent($('#user').val()) + '&cantidad=' + encodeURIComponent($('#cantidad').val()),
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Cambios guardados', h.substring(3));
					break
				}
			},
			error: function () {
				dialogBox.error_500("admin.manage_news()");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},



	filter_denuncias: function (section) {
		$('#vp-loading').slideDown('slow');
		$('#get_filter').slideUp('slow');
		$('#section').html(section);
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-complaints.php',
			data: 'sec=' + section,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				switch (h.charAt(0)) {
				case '0':
					$('#error_filter').show('slow');
					$('#error_filter').addClass('redBox').html(h.substring(3));
					break;
				case '1':
					$('#error_filter').slideUp('slow');
					$('#get_filter').slideDown('slow');
					$('#get_filter').html(h.substring(3));
					break
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("admin.filter_denuncias('" + section + "')");
				return
			}
		})
	},
	del_grade: function(id) {
		if(!id) { return false; }
		$('#vp-loading').slideDown('slow');
		dialogBox.procesando_inicio('Cargando...', 'Borrar rango');
		$.ajax({
			url: urls.home + '/ajax/admin-del-rank.php',
			type: 'POST',
			data: 'id_r=' + id,
			success: function(h) {
				if(h.charAt(0) == 0) {
					dialogBox.alert('Error', h.substring(1));
				} else {
					dialogBox.title('Borrar rango');
					dialogBox.body(h, 450);
					dialogBox.buttons(true, true, 'Ok', 'admin.del_grade_send(' + id + ')', true, true, true);
					dialogBox.center();
				}
			},
			complete: function() {
				$('#vp-loading').slideUp('slow');
				dialogBox.procesando_fin();
			}
		})
	},

	del_grade_send: function(id_r) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Enviando...', 'Banear usuario');
		var newrango = $('#newrango').val();
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-del-rank.php',
			data: 'id_r=' + id_r + '&newrango=' + newrango,
			success: function(g) {
					if(g.charAt(0) == 0) {
						dialogBox.alert('Error', g.substring(1));
					} else {
						dialogBox.alert('YEAH!', g.substring(1));
					}
			},
			error: function() {
				alert('ERRRORRR RORORORORORORORO -LOCO1');
			},
			complete: function() {
				dialogBox.procesando_fin();
			}
		})
	},

	acc_denuncia: function (id) {
		if(!id) { return false; }
		$('#vp-loading').slideDown('slow');
		dialogBox.procesando_inicio('Cargando...', 'Aceptar denuncia');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-accept-form.php',
			data: 'id=' + id,
			success: function(g) {
				switch(g.charAt(0)) {
					default:
						dialogBox.alert('Error', g.substring(1));
						break;
					case '1':
						dialogBox.title('Aceptar denuncia');
						dialogBox.body(g.substring(2), 450);
						dialogBox.buttons(true, true, 'Ok', 'admin.acc_denuncia_send(' + id + ')', true, true, true);
						dialogBox.center();
					}
				},
			complete: function() {
				$('#vp-loading').slideUp('slow');
				dialogBox.procesando_fin();
			}
		})
	},
	acc_denuncia_send: function (id) {
		$('#vp-loading').slideDown('slow');
		dialogBox.procesando_inicio('Cargando...', 'Aceptar denuncia');
		dialogBox.close_button = false;
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-accept.php',
			data: 'id=' + id + '&cause=' + encodeURIComponent($('#cause').val()),
			success: function (h) {
				if (h.charAt(0) == 0) {
					dialogBox.alert('Error', h.substring(3))
				} else if (h.charAt(0) == 1) {
					dialogBox.close();
					$('#den_' + id).css('background', '#E9FCE4');
					$('#acc_img_' + id).fadeOut('fast')
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("admin.acc_denuncia('" + id + "')");
				return
			},
			complete: function() {
				$('#vp-loading').slideUp('slow');
				dialogBox.procesando_fin();
			}
		})
	},
	del_denuncia: function (id) {
		$('#vp-loading').slideDown('slow');
		dialogBox.close_button = false;
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-del-complaint.php',
			data: 'id=' + id,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				if (h.charAt(0) == 0) {
					dialogBox.alert('Error', h.substring(3))
				} else if (h.charAt(0) == 1) {
					$('#den_' + id).addClass('eliminado');
					$('#del_img_' + id).fadeOut('fast')
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("admin.del_denuncia('" + id + "')");
				return
			}
		})
	},
	reactivar: function (id, tipo) {
		$('#vp-loading').slideDown('slow');
		dialogBox.close_button = false;
		$.ajax({
			type: 'GET',
			url: urls.home + '/ajax/admin-reactivar.php',
			data: 'id=' + id + '&tipo=' + tipo,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				if (h.charAt(0) == 0) {
					dialogBox.alert('Error', h.substring(3))
				} else if (h.charAt(0) == 1) {
					$('#post_' + id).css('background', '#E9FCE4');
					$('#rct_img_' + id).fadeOut('fast');
					$('#spr_img_' + id).fadeOut('fast')
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("admin.rct_post('" + id + "')");
				return
			}
		})
	},
	suprimir: function (id, tipo) {
		$('#vp-loading').slideDown('slow');
		dialogBox.close_button = false;
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-suprimir.php',
			data: 'id=' + id + '&type=' + tipo,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				if (h.charAt(0) == 0) {
					dialogBox.alert('Error', h.substring(3))
				} else if (h.charAt(0) == 1) {
					$('#post_' + id).addClass('eliminado');
					$('#rct_img_' + id).fadeOut('fast');
					$('#spr_img_' + id).fadeOut('fast')
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("admin.spr_post('" + id + "')");
				return
			}
		})
	},
	ban_form: function (id, nick) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Banear usuario');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-ban.php',
			data: 'id=' + nick,
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.title('Banear usuario');
					dialogBox.body(h.substring(3), 450);
					dialogBox.buttons(true, true, 'Banear', 'admin.ban_send(\'' + id + '\', \'' + nick + '\')', true, true, true);
					dialogBox.center();
					break
				}
			},
			error: function () {
				dialogBox.error_500("admin.ban_form('" + id + "')");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	ban_send: function (id, nick) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Enviando...', 'Banear usuario');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-ban.php',
			data: 'razon=' + encodeURIComponent($('#razon').val()) + '&id=' + nick + '&banip=' + ($('#banip').is(':checked') ? 1 : 0),
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Banear usuario', h.substring(3));
					$('#user_' + id).addClass('eliminado');
					$('#banear_' + id).fadeOut('fast');
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
				dialogBox.error_500("posts.ban_form('" + id + "')");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	unban: function (id) {
		$('#vp-loading').slideDown('slow');
		dialogBox.close_button = false;
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-unban.php',
			data: 'id=' + id,
			success: function (h) {
				$('#vp-loading').slideUp('slow');
				if (h.charAt(0) == 0) {
					dialogBox.alert('Error', h.substring(3))
				} else if (h.charAt(0) == 1) {
					$('#user_' + id).css('background', '#E9FCE4');
					$('#banear_' + id).fadeIn('fast').attr("src", "/media/images/banear.png");

					dialogBox.alert('Hecho', h.substring(3))
				}
			},
			error: function () {
				$('#vp-loading').slideUp('slow');
				dialogBox.error_500("admin.desbanear('" + id + "')");
				return
			}
		})
	},

	ver_mp: function (id) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Mensaje enviado');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-show-pm.php',
			data: 'id=' + id,
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Ver mensaje enviado', h.substring(3), false, 600);
					break
				}
			},
			error: function () {
				dialogBox.error_500("admin.ver_mp('" + id + "')");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	del_mp: function (id) {
		$('#kst-loading').slideDown('slow');
		dialogBox.close_button = false;
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-del-pm.php',
			data: 'id=' + id,
			success: function (h) {
				$('#kst-loading').slideUp('slow');
				if (h.charAt(0) == 0) {
					dialogBox.alert('Error', h.substring(3));
					dialogBox.body(h.substring(3), 300);
					dialogBox.buttons(true, true, 'Aceptar', 'dialogBox.close()', true, true);
					dialogBox.center()
				} else if (h.charAt(0) == 1) {
					$('#msg_' + id).html(h.substring(3));
					$('#del_mp_' + id).fadeOut('slow')
				}
			},
			error: function () {
				$('#kst-loading').slideUp('slow');
				dialogBox.error_500("admin.del_mp('" + id + "')");
				return
			}
		})
	},
	new_grade: function () {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Nuevo rango');
		$.ajax({
			url: urls.home + '/ajax/admin-new-rank.php',
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.title('Nuevo rango');
					dialogBox.body(h.substring(3), 550);
					dialogBox.buttons(true, true, 'Guardar rango', 'admin.new_grade_send()', true, true, true);
					dialogBox.center();
					break
				}
			},
			error: function () {
				dialogBox.error_500("admin.new_grade()");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	new_grade_send: function () {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Enviando...', 'Editar rango');
		var lol = $('#datos *').serialize();
		
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-new-rank.php',
			data: lol,
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Cambios guardados', h.substring(3), true);
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
				dialogBox.error_500("admin.new_grade()");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	edit_grade: function (id) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Editar rango');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-edit-rank.php',
			data: 'id=' + id,
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.title('Editar rango');
					dialogBox.body(h.substring(3), 500);
					dialogBox.buttons(true, true, 'Guardar cambios', 'admin.edit_grade_send(' + id + ')', true, true, true);
					dialogBox.center();
					break
				}
			},
			error: function () {
				dialogBox.error_500("admin.edit_grade('" + id + "')");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},

	edit_grade_send: function (id) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Enviando...', 'Editar rango');
		var lol = $('#datos *').serialize();
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-edit-rank-submit.php',
			data: lol + '&id=' + id,
			success: function (h) {
				switch (h.charAt(0)) {
				default:
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Cambios guardados', 'Tus cambios han sido guardados');
					$('#rango_' + id).css('background', '#E9FCE4');
					$('#rango_' + id).html(h.substring(3));
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
				dialogBox.error_500("posts.edit_grade('" + id + "')");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	user_grade: function (id) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Asignar rango');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-user-rank.php',
			data: 'id=' + id,
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.title('Asignar rango');
					dialogBox.body(h.substring(3), 450);
					dialogBox.buttons(true, true, 'Guardar cambios', 'admin.user_grade_send(' + id + ')', true, true, true);
					dialogBox.center();
					break
				}
			},
			error: function () {
				dialogBox.error_500("admin.user_grade('" + id + "')");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	edit_user: function(id) {
	    if(!id) { return false; }
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Editar usuario');
		$.ajax({
			type: 'get',
			url: urls.home + '/ajax/admin-edit-user.php',
			data: 'id=' + id + '&_=load',
			success: function(h) {
				if(h.charAt(0) == '0') {
					dialogBox.alert('Error', h.substring(1));
					alert('few');
				} else {
					dialogBox.title('Editar usuario');
					dialogBox.body(h.substring(1), 450);
					dialogBox.buttons(true, true, 'Guardar cambios', 'admin.edit_user_send(' + id + ')', true, true, true);
					dialogBox.center();
				}
            },
			complete: function () {
				dialogBox.procesando_fin()
			}
        })
    },
	edit_user_send: function(id) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Enviando...', 'Editar usuario');
		$.ajax({
			url: urls.home + '/ajax/admin-edit-user.php',
			type: 'POST',
			data: 'id=' + id + '&nick=' + encodeURIComponent($('#nick').val()) + '&name=' + encodeURIComponent($('#name').val()) + '&message=' + encodeURIComponent($('#message').val()),
			success: function(g) {
				switch(g.charAt(0)) {
					case '0':
						dialogBox.alert('Error', g.substring(1));
						break;
					case '1':
						dialogBox.alert('Cambios guardados', g.substring(1));
						break;
				}
            },
			complete: function() {
				dialogBox.procesando_fin();
			}
        })
    },
	user_grade_send: function (id) {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Enviando...', 'Asignar rango');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/admin-user-rank.php',
			data: 'user=' + encodeURIComponent($('#user').val()) + '&rango=' + encodeURIComponent($('#rango').val()) + '&id=' + id,
			success: function (h) {
				switch (h.charAt(0)) {
				case '0':
					dialogBox.alert('Error', h.substring(3));
					break;
				case '1':
					dialogBox.alert('Cambios guardados', h.substring(2));
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
				dialogBox.error_500("posts.user_grade('" + id + "')");
				return
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	news: function() {
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Noticias');
		$.ajax({
			url: '/ajax/admin-news.php',
			type: 'POST',
			success: function(h) {
				if(h.charAt(0) == '0') {
					dialogBox.alert('Error', h.substring(1));
				} else {
					dialogBox.title('Noticias');
					dialogBox.body(h.substring(1), 450);
					dialogBox.buttons(true, true, 'OK!', 'admin.news_save()', true, true, true);
					dialogBox.center();
				}
			},
			complete: function() { dialogBox.procesando_fin(); },
		});		
	},
	news_save: function() {
		var datos = $('#form *').serialize(); 
		$('#mostrame').slideUp(600).removeClass();
		if(!$('#action').val()) { dialogBox.close(); }
		$.ajax({
			type: 'POST',
			url: '/ajax/admin-news.php',
			data: datos,
			success: function(ignacio) {
				$('#mostrame').slideDown(800).addClass((ignacio.charAt(0) == '0' ? 'redBox' : 'greenBox')).html(ignacio.substring(1));
				//$('.mBtn btnOk').attr('value', (ignacio.charAt(0) == '0' ? 'Reintentar' : 'Ok')).attr('onclick', (ignacio.charAt(0) == '0' ? 'admin.news_save()' : 'dialogBox.close();')); 
			},
		});
	},	
	news_del: function(id) {
		if(!id) { return false; }
		$.ajax({
			url: '/ajax/admin-news.php',
			data: 'action=delete&id=' + id, 
			type: 'POST',
			success: function(t) {
				if(t.charAt(0) == '0') { 
					alert(t.substring(1)); 
				} else {
					$('#result' + id).hide(800);
				}
			},
		});
	},
	news_edit: function(id) {
		$('#result' + id + ' a').hide();
		$.ajax({	
			url: '/ajax/admin-news.php',
			type: 'POST',
			data: 'action=edit&id=' + id + '&text=' + $('#result' + id + ' input[type="text"]').val(),
			success: function(ignacio) {
				if(ignacio.charAt(0) == '0') {
					dialogBox.alert('Error', ignacio.substring(1));
				} else {
					$('#result' + id).addClass('greenBox');
				}
			}
		});
	},	
	mail: function(id, s) {
		if(!id) { return false; }
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Mail');
		$.get('/ajax/admin-mailsend.php', 'replyTo=' + id, function(g) {
			dialogBox.procesando_fin();	
			if(g.charAt(0) == 0) { 
				dialogBox.alert('Error', g.substring(1));
			} else {
				dialogBox.title('Mail');
				dialogBox.body(g, 850);
				dialogBox.buttons(true, true, 'OK!', 'admin.mailsend(' + id + ', ' + s + ')', true, true, true);
				dialogBox.center();	
			}	
		});	
	},
	mailsend: function(id, s) {
		var body = $('#body').val();
		var title = $('#title').val(); //no es obligatorio
		var mail = $('#mail').val();
		if(!id || !body || !mail) { 
			$('.greenBox').removeClass().addClass('redBox').html('Debes completar todos los campos'); 
			return false;
		}
		dialogBox.close_button = false;
		dialogBox.procesando_inicio('Cargando...', 'Mail');
		$.get('/ajax/admin-mailsend.php', 'body=' + encodeURIComponent(body) + '&title=' + encodeURIComponent(title) + '&ok=' + s + '&replyTo=' + id + '&mail=' + encodeURIComponent(mail) + '&send=true', function(t) {
			dialogBox.procesando_fin();	
			if(t.charAt(0) == 2) { 
				dialogBox.title('Advertencia');
				dialogBox.body(t.substring(1), 450);
				dialogBox.buttons(true, true, 'OK!', 'admin.mail(' + id + ', 1)', true, true, true);
				dialogBox.center();
			} else {
				dialogBox.alert(t.charAt(0) == 0 ? 'Error' : '&Eacute;xito', t.substring(1));
			}	 
		});	
	},	
}	