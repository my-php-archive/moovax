var registro = {
	banned_passwords: ["111111", "11111111", "112233", "121212", "123123", "123456", "1234567", "12345678", "131313", "232323", "654321", "666666", "696969", "777777", "7777777", "8675309", "987654", "aaaaaa", "abc123", "abc123", "abcdef", "abgrtyu", "access", "access14", "action", "albert", "alexis", "amanda", "amateur", "andrea", "andrew", "angela", "angels", "animal", "anthony", "apollo", "apples", "arsenal", "arthur", "asdfgh", "asdfgh", "ashley", "asshole", "august", "austin", "badboy", "bailey", "banana", "barney", "baseball", "batman", "beaver", "beavis", "bigcock", "bigdaddy", "bigdick", "bigdog", "bigtits", "birdie", "bitches", "biteme", "blazer", "blonde", "blondes", "blowjob", "blowme", "bond007", "bonnie", "booboo", "booger", "boomer", "boston", "brandon", "brandy", "braves", "brazil", "bronco", "broncos", "bulldog", "buster", "butter", "butthead", "calvin", "camaro", "cameron", "canada", "captain", "carlos", "carter", "casper", "charles", "charlie", "cheese", "chelsea", "chester", "chicago", "chicken", "cocacola", "coffee", "college", "compaq", "computer", "cookie", "cooper", "corvette", "cowboy", "cowboys", "crystal", "cumming", "cumshot", "dakota", "dallas", "daniel", "danielle", "debbie", "dennis", "diablo", "diamond", "doctor", "doggie", "dolphin", "dolphins", "donald", "dragon", "dreams", "driver", "eagle1", "eagles", "edward", "einstein", "erotic", "extreme", "falcon", "fender", "ferrari", "firebird", "fishing", "florida", "flower", "flyers", "football", "forever", "freddy", "freedom", "fucked", "fucker", "fucking", "fuckme", "fuckyou", "gandalf", "gateway", "gators", "gemini", "george", "giants", "ginger", "golden", "golfer", "gordon", "gregory", "guitar", "gunner", "hammer", "hannah", "hardcore", "harley", "heather", "helpme", "hentai", "hockey", "hooters", "horney", "hotdog", "hunter", "hunting", "iceman", "iloveyou", "internet", "iwantu", "jackie", "jackson", "jaguar", "jasmine", "jasper", "jennifer", "jeremy", "jessica", "johnny", "johnson", "jordan", "joseph", "joshua", "junior", "justin", "killer", "knight", "ladies", "lakers", "lauren", "leather", "legend", "letmein", "letmein", "little", "london", "lovers", "maddog", "madison", "maggie", "magnum", "marine", "marlboro", "martin", "marvin", "master", "matrix", "matthew", "maverick", "maxwell", "melissa", "member", "mercedes", "merlin", "michael", "michelle", "mickey", "midnight", "miller", "mistress", "monica", "monkey", "monkey", "monster", "morgan", "mother", "mountain", "muffin", "murphy", "mustang", "naked", "nascar", "nathan", "naughty", "ncc1701", "newyork", "nicholas", "nicole", "nipple", "nipples", "oliver", "orange", "packers", "panther", "panties", "parker", "password", "password", "password1", "password12", "password123", "patrick", "peaches", "peanut", "pepper", "phantom", "phoenix", "player", "please", "pookie", "porsche", "prince", "princess", "private", "purple", "pussies", "qazwsx", "qwerty", "qwertyui", "rabbit", "rachel", "racing", "raiders", "rainbow", "ranger", "rangers", "rebecca", "redskins", "redsox", "redwings", "richard", "robert", "rocket", "rosebud", "runner", "rush2112", "russia", "samantha", "sammy", "samson", "sandra", "saturn", "scooby", "scooter", "scorpio", "scorpion", "secret", "sexsex", "shadow", "shannon", "shaved", "sierra", "silver", "skippy", "slayer", "smokey", "snoopy", "soccer", "sophie", "spanky", "sparky", "spider", "squirt", "srinivas", "startrek", "starwars", "steelers", "steven", "sticky", "stupid", "success", "suckit", "summer", "sunshine", "superman", "surfer", "swimming", "sydney", "taylor", "tennis", "teresa", "tester", "testing", "theman", "thomas", "thunder", "thx1138", "tiffany", "tigers", "tigger", "tomcat", "topgun", "toyota", "travis", "trouble", "trustno1", "tucker", "turtle", "twitter", "united", "vagina", "victor", "victoria", "viking", "voodoo", "voyager", "walter", "warrior", "welcome", "whatever", "william", "willie", "wilson", "winner", "winston", "winter", "wizard", "xavier", "xxxxxx", "xxxxxxxx", "yamaha", "yankee", "yankees", "yellow", "zxcvbn", "zxcvbnm", "zzzzzz", "pass"],
	banned_nicks: ["admin", "administrador", "moderador", "kasirit", "gaysirit", "kasigay", "google", "yahoo", "microsoft", "messenger", "facebook", "twitter", "argentina", "guatemala", "espaÃ±a", "feisbuck", "j0n4th4ntub3", "j0n4th4nr3d", "smierdate", "voopero", "voomierda", "vooshit", "fuck", "fucker", "voobitch", "lammer", "spammer", "mierda", "puta", "puto", "puta", "concha", "pija", "pene", "gayssar", "gaysar", "drdexter", "voope", "taringa", "casitaweb", "uimpi", "sanigalia", "downfull", "truchinga", "poringa", "forocuak", "spirate", "smallpirate", "comunidades", "posts", "fotos", "static", "mensajes", "perfil", "rss", "recuperar-pass", "favoritos", "home", "media", "web", "estados", "users-online", "notificaciones", "mod-history", "buscador", "registro", "contactanos", "denuncia-publica", "taringuero", "taringaclon", "vupete", "voopete", "gayssar", "kasiritero", "satanas"],
	dialog: true,
	muestro_progreso: false,
	progresar: 0,
	progreso: new Array(),
	logprogreso: 0,
	chequeos: 10,
	paso_actual: 1,
	datos: new Array(),
	datos_status: new Array(),
	datos_text: new Array(),
	no_requerido: new Array(),
	errores: new Array(),
	cache: new Array(),
	times: new Array(),
	times_sets: new Array(),
	focus: function (el) {
		var name = $(el).attr('name');
		switch (name) {
		case 'password':
			$(el).select();
			var el2 = $('#RegistroForm #password2');
			this.hide_status(el2, 'empty', 'El campo es requerido');
			$(el2).val('');
			break
		}
		$(el).addClass('selected');
		this.show_status(el, 'info', $(el).attr('title'), true)
	},
	blur: function (el) {
		var name = $(el).attr('name');
		switch (name) {
		case 'nick':
		case 'email':
			this.clear_time(name);
			$(el).removeClass('selected');
			this.check_campo(el, false, true);
			break;
		default:
			$(el).removeClass('selected');
			this.check_campo(el, false, true);
			break
		}
	},
	set_time: function (name) {
		if (this.times_sets[name]) return false;
		this.times_sets[name] = true;
		this.times[name] = setTimeout("registro.time('" + name + "')", 1000)
	},
	clear_time: function (name) {
		if (!this.times_sets[name]) return false;
		this.times_sets[name] = false;
		clearTimeout(this.times[name])
	},
	time: function (name) {
		var el = $('#RegistroForm #' + name);
		if (empty($(el).val())) this.show_status(el, 'info', $(el).attr('title'), true);
		else this.check_campo(el, false, true)
	},
	check_campo: function (el, no_empty, force_check) {
		var campo = $(el).attr('name');
		var value = $(el).val();
		switch (campo) {
		case 'nick':
			if (!force_check && this.datos[campo] === value) if (this.datos_status[campo] == 'empty') return no_empty ? this.show_status(el, this.datos_status[campo], this.datos_text[campo]) : this.hide_status(el, this.datos_status[campo], this.datos_text[campo]);
			else return this.show_status(el, this.datos_status[campo], this.datos_text[campo]);
			this.datos[campo] = value;
			if (empty(value)) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			if (value.length < 4 || value.length > 16) return this.show_status(el, 'error', 'Debe tener entre 4 y 16 caracteres');
			if (!/[^0-9]/.test(value)) return this.show_status(el, 'error', 'No puede contener solo numeros');
			if (/[^a-zA-Z0-9_]/.test(value)) return this.show_status(el, 'error', 'S&oacute;lo se permiten letras, n&uacute;meros y guiones(_)');
			if ($.inArray(value.toLowerCase(), this.banned_nicks) != -1) return this.show_status(el, 'error', 'Este nick est&aacute; prohibido');
			var value_lower = value.toLowerCase();
			if (!this.cache[campo]) {
				this.cache[campo] = new Array();
				this.cache[campo][value_lower] = new Array()
			} else if (this.cache[campo][value_lower]) {
				if (this.cache[campo][value_lower]['status']) return registro.show_status(el, 'ok', this.cache[campo][value_lower]['text']);
				else return registro.show_status(el, 'error', this.cache[campo][value_lower]['text'])
			}
			this.show_status(el, 'loading', 'Comprobando nick...');
			$.ajax({
				type: 'POST',
				url: urls.home + '/ajax/register-check-nick.php',
				data: 'nick=' + encodeURIComponent(value) + '&_=true',
				success: function (h) {
					registro.cache[campo][value_lower] = new Array();
					registro.cache[campo][value_lower]['text'] = h.substring(3);
					switch (h.charAt(0)) {
					case '0':
						registro.cache[campo][value_lower]['status'] = false;
						registro.show_status(el, 'error', h.substring(3));
						break;
					case '1':
						registro.cache[campo][value_lower]['status'] = true;
						registro.show_status(el, 'ok', h.substring(3));
						registro.add_progreso((registro.progresar + 9), campo);
						registro.progresar = 10;
						registro.progreso[campo] = true;
						break
					}
				},
				error: function () {
					registro.show_status(el, 'error', 'Hubo un error al intentar procesar lo solicitado');
					registro.datos[campo] = ''
				}
			});
			break;
		case 'password':
			if (!force_check && this.datos[campo] === value) if (this.datos_status[campo] == 'empty') return no_empty ? this.show_status(el, this.datos_status[campo], this.datos_text[campo]) : this.hide_status(el, this.datos_status[campo], this.datos_text[campo]);
			else return this.show_status(el, this.datos_status[campo], this.datos_text[campo]);
			this.datos[campo] = value;
			if (empty(value)) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			if ($.inArray(value.toLowerCase(), this.banned_passwords) != -1) return this.show_status(el, 'error', 'Ingresa una contrase&ntilde;a m&aacute;s segura');
			if (value === this.datos['nick']) return this.show_status(el, 'error', 'La contrase&ntilde;a no puede ser igual al nick');
			if (value.length < 6 || value.length > 35) return this.show_status(el, 'error', 'Debe tener entre 6 y 35 caracteres');
			registro.add_progreso((registro.progresar + 10), campo);
			registro.progresar += 10;
			registro.progreso[campo] = true;
			return this.show_status(el, 'ok', 'OK');
			break;
		case 'password2':
			if (empty(value)) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			if (value !== this.datos['password']) {
				this.show_status($('#RegistroForm #password'), 'error', 'Las contrase&ntilde;as deben ser iguales');
				return this.show_status(el, 'error', 'Las contrase&ntilde;as deben ser iguales')
			}
			this.datos[campo] = value;
			registro.add_progreso((registro.progresar + 10), campo);
			registro.progresar += 10;
			registro.progreso[campo] = true;
			return this.show_status(el, 'ok', 'OK');
			break;
		case 'email':
			value = value.toLowerCase();
			if (!force_check && this.datos[campo] === value) if (this.datos_status[campo] == 'empty') return no_empty ? this.show_status(el, this.datos_status[campo], this.datos_text[campo]) : this.hide_status(el, this.datos_status[campo], this.datos_text[campo]);
			else return this.show_status(el, this.datos_status[campo], this.datos_text[campo]);
			this.datos[campo] = value;
			if (empty(value)) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			if (value.length > 35) return this.show_status(el, 'error', 'El email es demasiado largo');
			if (!/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/.exec(value)) return this.show_status(el, 'error', 'El formato es incorrecto');
			if (!this.cache[campo]) {
				this.cache[campo] = new Array();
				this.cache[campo][value] = new Array()
			} else if (this.cache[campo][value]) {
				if (this.cache[campo][value]['status']) return registro.show_status(el, 'ok', this.cache[campo][value]['text']);
				else return registro.show_status(el, 'error', this.cache[campo][value]['text'])
			}
			this.show_status(el, 'loading', 'Comprobando email...');
			$.ajax({
				type: 'POST',
				url: urls.home + '/ajax/register-check-email.php',
				data: 'email=' + encodeURIComponent(value),
				success: function (h) {
					registro.cache[campo][value] = new Array();
					registro.cache[campo][value]['text'] = h.substring(3);
					switch (h.charAt(0)) {
					case '0':
						registro.cache[campo][value]['status'] = false;
						registro.show_status(el, 'error', h.substring(3));
						break;
					case '1':
						registro.cache[campo][value]['status'] = true;
						registro.show_status(el, 'ok', 'OK');
						registro.add_progreso((registro.progresar + 10), campo);
						registro.progresar += 10;
						registro.progreso[campo] = true;
						break
					}
				},
				error: function () {
					registro.show_status(el, 'error', 'Hubo un error al intentar procesar lo solicitado');
					registro.datos[campo] = ''
				}
			});
			break;
		case 'dia':
		case 'mes':
		case 'anio':
			this.datos['dia'] = $('#RegistroForm #dia').val();
			this.datos['mes'] = $('#RegistroForm #mes').val();
			this.datos['anio'] = $('#RegistroForm #anio').val();
			if (empty(value)) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			if (!empty(this.datos['dia']) && !empty(this.datos['mes']) && !empty(this.datos['anio'])) {
				if (!checkdate(this.datos['mes'], this.datos['dia'], this.datos['anio'])) return this.show_status(el, 'error', 'La fecha es incorrecta');
				this.add_progreso((registro.progresar + 10), campo);
				this.progresar += 10;
				registro.progreso['dia'] = true;
				registro.progreso['mes'] = true;
				registro.progreso['anio'] = true;
				return this.show_status(el, 'ok', 'OK')
			} else {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			break;
		case 'sexo':
				if(!$('#RegistroForm #sexo_f') && !$('#RegistroForm #sexo_m'))
					value = '';
				else if($('#RegistroForm #sexo_f').is(':checked'))
					value = 'f';
				else
					value = 'm';

			if (this.datos[campo] === value) if (this.datos_status[campo] == 'empty') return no_empty ? this.show_status(el, this.datos_status[campo], this.datos_text[campo]) : this.hide_status(el, this.datos_status[campo], this.datos_text[campo]);
			else return this.show_status(el, this.datos_status[campo], this.datos_text[campo]);
			this.datos[campo] = value;
			if (empty(value)) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			this.add_progreso((registro.progresar + 10), campo);
			this.progresar += 10;
			this.progreso[campo] = true;
			return this.show_status(el, 'ok', 'OK');
			break;
		case 'pais':
			if (!force_check && this.datos[campo] === value) if (this.datos_status[campo] == 'empty') return no_empty ? this.show_status(el, this.datos_status[campo], this.datos_text[campo]) : this.hide_status(el, this.datos_status[campo], this.datos_text[campo]);
			else return this.show_status(el, this.datos_status[campo], this.datos_text[campo]);
			this.datos[campo] = value;
			if (empty(value)) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			this.add_progreso((registro.progresar + 10), campo);
			this.progresar += 10;
			this.progreso[campo] = true;
			this.show_status(el, 'ok', 'OK');
			break;
		case 'ciudad':
			if (this.no_requerido[campo]) {
				this.hide_status(el, this.datos_status[campo], this.datos_text[campo]);
				return true
			}
			//value = value.toLowerCase();
			if (!force_check && value == this.datos[campo + '_text'] && this.datos[campo] === this.datos[campo + '_id']) if (this.datos_status[campo] == 'empty') return no_empty ? this.show_status(el, this.datos_status[campo], this.datos_text[campo]) : this.hide_status(el, this.datos_status[campo], this.datos_text[campo]);
			else return this.show_status(el, this.datos_status[campo], this.datos_text[campo]);
			if (empty(value)) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			this.add_progreso((registro.progresar + 10), campo);
			this.progresar += 10;
			this.progreso[campo] = true;
			this.datos[campo] = value;
			registro.show_status(el, 'ok', 'OK');
			break;
		case 'terminos':
			var value = $(el);
			if (!force_check && this.datos[campo] === value) if (this.datos_status[campo] == 'empty') return no_empty ? this.show_status(el, this.datos_status[campo], this.datos_text[campo]) : this.hide_status(el, this.datos_status[campo], this.datos_text[campo]);
			else return this.show_status(el, this.datos_status[campo], this.datos_text[campo]);
			this.datos[campo] = value;
			if (!value) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			this.add_progreso((registro.progresar + 10), campo);
			this.progresar += 10;
			this.progreso[campo] = true;
			this.datos[campo] = value;
			registro.show_status(el, 'ok', 'OK');
			break;
		case 'recaptcha_challenge_field':
			return true;
			break;
		case 'recaptcha_response_field':
			if (!force_check && this.datos[campo] === value && this.datos['recaptcha_challenge_field'] == $('#RegistroForm .pasoDos #recaptcha_challenge_field').val()) if (this.datos_status[campo] == 'empty') return no_empty ? this.show_status(el, this.datos_status[campo], this.datos_text[campo]) : this.hide_status(el, this.datos_status[campo], this.datos_text[campo]);
			else return this.show_status(el, this.datos_status[campo], this.datos_text[campo]);
			this.datos[campo] = value;
			this.datos['recaptcha_challenge_field'] = $('#RegistroForm .pasoDos #recaptcha_challenge_field').val();
			if (empty(value)) {
				var status = 'empty';
				var text = 'El campo es requerido';
				if (no_empty) return this.show_status(el, status, text);
				else return this.hide_status(el, status, text)
			}
			this.add_progreso((registro.progresar + 10), campo);
			this.progresar += 10;
			this.progreso[campo] = true;
			return registro.show_status(el, 'ok', 'OK');
			break
		}
	},
	show_status: function (el, status_aux, text, no_cache_data) {
		var campo = $(el).attr('name');
		var status = (status_aux == 'empty') ? 'error': status_aux;
		if (campo == 'recaptcha_response_field') el = $('#RegistroForm .pasoDos .infoTip.recaptcha');
		else {
			do {
				el = $(el).next()
			} while (!$(el).is('.infoTip'))
		}
		$(el).removeClass('ok').removeClass('error').removeClass('info').removeClass('loading').addClass(status).show().children().children().html(text);
		if (!no_cache_data) {
			this.datos_status[campo] = status_aux;
			this.datos_text[campo] = text
		}
		return (status == 'ok')
	},
	hide_status: function (el, status, text) {
		var campo = $(el).attr('name');
		if (campo == 'recaptcha_response_field') el = $('#RegistroForm .pasoDos .infoTip.recaptcha');
		else {
			do {
				el = $(el).next()
			} while (!$(el).is('.infoTip'))
		}
		$(el).hide();
		this.datos_status[campo] = status;
		this.datos_text[campo] = text;
		return (status == 'ok')
	},
	check_paso: function () {
		switch (this.paso_actual) {
		case 1:
			var ok = true;
			var inputs = $('#RegistroForm .pasoUno :input');
			inputs.each(function () {
				if (!registro.check_campo(this, true)) {
					ok = false
				}
			});
			return ok;
			break;
		case 2:
			var ok = true;
			var inputs = $('#RegistroForm .pasoDos :input');
			inputs.each(function () {
				if (!registro.check_campo(this, true)) {
					ok = false
				}
			});
			return ok;
			break
		}
		return true
	},
	change_paso: function (paso, no_focus) {
		if (paso > this.paso_actual && !this.check_paso()) return false;
		switch (paso) {
		case 1:
			$('#RegistroForm .pasoDos').hide();
			$('#RegistroForm .pasoUno').show();
			if (!no_focus) $('#RegistroForm .pasoUno input:first').focus();
			break;
		case 2:
			$('#RegistroForm .pasoUno').hide();
			$('#RegistroForm .pasoDos').show();
			dialogBox.buttons(true, true, 'Terminar', 'registro.submit()', true, true, true);
			if (!no_focus) $('#RegistroForm .pasoDos input:first').focus();
			break
		}
		dialogBox.center();
		this.paso_actual = paso
	},
	submit: function () {
		$('#RegistroForm .infoTip').hide();
		var params = '';
		var amp = '';
		for (var campo in this.datos) {
			params += amp + campo + '=' + encodeURIComponent(this.datos[campo]);
			amp = '&'
		}
		dialogBox.procesando_inicio('Enviando...', 'Registro');
		$.ajax({
			type: 'POST',
			url: urls.home + '/ajax/register-submit.php',
			data: params,
			success: function (h) {
				if (h.substring(0, strpos(h, ':')) != '1') {
					registro.datos['recaptcha_response_field'] = '';
					Recaptcha.reload('t')
				}
				switch (h.substring(0, strpos(h, ':'))) {
				case '0':
					break;
				case 'nick':
					registro.change_paso(1, true);
					registro.show_status($('#RegistroForm #nick'), 'error', h.substring(strpos(h, ':') + 2));
					break;
				case 'password':
					registro.change_paso(1, true);
					registro.show_status($('#RegistroForm #password'), 'error', h.substring(strpos(h, ':') + 2));
					registro.datos['password'] = '';
					break;
				case 'email':
					registro.change_paso(1, true);
					registro.show_status($('#RegistroForm #email'), 'error', h.substring(strpos(h, ':') + 2));
					break;
				case 'nacimiento':
					registro.change_paso(1, true);
					registro.show_status($('#RegistroForm #anio'), 'error', h.substring(strpos(h, ':') + 2));
					break;
				case 'sexo':
					registro.change_paso(2, true);
					registro.show_status($('#RegistroForm #sexo_f'), 'error', h.substring(strpos(h, ':') + 2));
					break;
				case 'pais':
					registro.change_paso(2, true);
					registro.show_status($('#RegistroForm #pais'), 'error', h.substring(strpos(h, ':') + 2));
					break;
				case 'ciudad':
					registro.change_paso(2, true);
					registro.show_status($('#RegistroForm #ciudad'), 'error', h.substring(strpos(h, ':') + 2));
					break;
				case 'recaptcha':
					registro.change_paso(2, true);
					registro.show_status($('#RegistroForm #recaptcha_response_field'), 'error', h.substring(strpos(h, ':') + 2));
					break;
				case 'terminos':
					registro.change_paso(2, true);
					registro.show_status($('#RegistroForm #terminos'), 'error', h.substring(strpos(h, ':') + 2));
					break;
				case '1':
					dialogBox.body(h.substring(strpos(h, ':') + 2));
					dialogBox.buttons(true, true, 'Aceptar', 'dialogBox.close()', true, true);
					dialogBox.center();
					break
				default: dialogBox.body(h);
				}

			},
			error: function () {
				dialogBox.error_500("registro.submit()")
			},
			complete: function () {
				dialogBox.procesando_fin()
			}
		})
	},
	add_progreso: function (cant, campo) {
		if (this.progreso[campo]) return;
		this.logprogreso++;
		var progreso_total = Math.round((this.logprogreso * 100) / (this.chequeos));
		$('#RegistroForm .barra_progreso .progreso').animate({
			'width': Math.round(progreso_total) + '%'
		});
		if (progreso_total > 9) $('#progreso').html(progreso_total + '%')
	}
}