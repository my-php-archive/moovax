var live = {
	vel: 0, //Velocidad de impresion en milisegundos
	velActual: 0, //Velocidad que se esta mostrando actualmente
	lastId: 0, //Guardo el ultimo ID que obtuve por ajax
	cant: 50, //Cantidad de acciones en la lista
	play: true, //Indica si esta en play (true) o en pause (false)

	stats: {'time': 0, 'total': 0, 'filtros': {}},
	filtros: {},
	time: [0, 0, 0],

	inicializar: function(){
		//Obtengo el template
		this.template = $('#live #template-liveBoard').html();
		this.template = this.template.substring(4, (this.template.length - 3)); //Borro comentarios html
		$('#live #template-liveBoard').remove();

		//Obtengo el ultimo ID
		if(live_data.length > 0)
			this.lastId = live_data[0]['id'];

		//Imprimo toda la primer lista
		this.print(this.cant);

		//En 60 segundos hace update por ajax
		setTimeout(function(){ live.update(); }, 5000); // #update 60000->1000->5000

		//Inicializo el reloj de tiempo visualizando el sitio
		setInterval(function(){ live.calcTime() }, 1000);

		//Seteo control de Play / Pause
		$('#live #PlayPause').click(function(){
			if(live.play)
				$(this).html('<img src="/media/images/icon_play.png" alt="" />');
			else
				$(this).html('<img src="/media/images/icon_pause.png" alt="" />');
			live.play = !live.play;
		});
	},

	changeFiltro: function(accionObjeto, accionTipo){
	/* Habilita/deshabilita la visualizacion de un objeto y tipo de accion
		accionObjeto[string] = Objeto al que pertenece la accion
		accionTipo[string] = El tipo de accion que se quiere filtrar
		return[void]
	*/
		//Invierto la seleccion del filtro para el objeto y tipo especificado, si todavia no existe lo creo
		if(typeof this.filtros[accionObjeto] === 'undefined')
			this.filtros[accionObjeto] = {};
		if(typeof this.filtros[accionObjeto][accionTipo] === 'undefined')
			this.filtros[accionObjeto][accionTipo] = false;
		else
			this.filtros[accionObjeto][accionTipo] = !this.filtros[accionObjeto][accionTipo];
	},

	calcVel: function(vel){
	/* Calcula la velocidad en la que tiene que imprimir cada accion. Usar al obtener el ajax
		return[void]
	*/
		if(!vel){
			//Si live_data.length es == 0, intento imprimir cada 1 segundo. Se va a solucionar cuando el update consiga datos
			if(live_data.length == 0)
				this.vel = 1000;
			else
				//Le doy 65 segundos para tener 5 segundos de sobra por lo que pueda tardar el ajax
				this.vel = Math.ceil(10000 / live_data.length); // #update 65000->5000
		}else
			this.vel = vel;
	},

	calcVelActual: function(){
	/* Calculo la velocidad actual a mostrar y la imprimo
		return[void]
	*/
		//Velocidad a imprimir
		var velActual_aux = (Math.round((1000 / this.vel) * 100) / 100);
		var max = velActual_aux + 0.25;
		var min = velActual_aux - 0.25;

		//Calculo a cuanto muevo la velocidad actual
		if(live_data.length == 0)
			this.velActual = 0;
		else if(this.velActual == 0)
			this.velActual = velActual_aux;
		else if(this.velActual < min)
			this.velActual += 0.01
		else if(this.velActual > max)
			this.velActual -= 0.01;
		else if(this.velActual == min){
			var rand = Math.floor(Math.random() * 2);
			if(rand == 1)
				this.velActual += 0.01;
		}else if(this.velActual == max){
			var rand = Math.floor(Math.random() * 2);
			if(rand == 1)
				this.velActual -= 0.01;
		}else{
			var rand = Math.floor(Math.random() * 3);
			if(rand == 1)
				this.velActual += 0.01;
			else if(rand == 2)
				this.velActual -= 0.01;
		}

		//Muestro velocidad actual (acciones / segundo)
		$('#live #estadisticass #velocidad').html( number_format(this.velActual, 2, ',', '.') + ' a/s' );
	},

	print: function(inicial){
	/* Imprime una accion en la lista
		inicial[boolean] = true -> Es la primera vez que entra, completa la lista y recalcula la vel de impresion
											 false -> Imprime una sola accion
		return[void]
	*/
		//Si no hay acciones para imprimir
		if(live_data.length == 0){
			setTimeout(function(){ live.print(); }, this.vel);
			return;
		}

		//Obtengo la accion mas vieja y la elimino del array
		var accion = live_data[live_data.length - 1];
		live_data.splice(live_data.length - 1, 1);

		//Incremento e imprimo el contador de acciones totales
		this.stats['total']++;
		$('#live #estadisticass #total').html(number_format(this.stats['total'], 0, '', '.'));

		//Incremento (y creo si todavia no existe) e imprimo el contador del filtro de esta accion
		if(typeof this.stats['filtros'][accion['accionObjeto']] === 'undefined')
			this.stats['filtros'][accion['accionObjeto']] = {};
		if(typeof this.stats['filtros'][accion['accionObjeto']][accion['accionTipo']] === 'undefined')
			this.stats['filtros'][accion['accionObjeto']][accion['accionTipo']] = 1;
		else
			this.stats['filtros'][accion['accionObjeto']][accion['accionTipo']]++;
		$('#live #filtros .accionObjeto_' + accion['accionObjeto'] + ' .accionTipo_' + accion['accionTipo']).html(number_format(this.stats['filtros'][accion['accionObjeto']][accion['accionTipo']], 0, '', '.'));

		//Especifico si tengo que imprimir o no, dependiendo del play y de los filtros
		var imprimir = (this.play && (typeof this.filtros[accion['accionObjeto']] === 'undefined' || typeof this.filtros[accion['accionObjeto']][accion['accionTipo']] === 'undefined' || this.filtros[accion['accionObjeto']][accion['accionTipo']]));

		//Actualizo la velocidad actual
		this.calcVelActual();

		//Genero el html a imprimir
		if(imprimir)
			var html = this.template.replace(/__class__/g, accion['accionObjeto'] + ' ' + accion['accionTipo']).replace(/__nick__/g, accion['nick']).replace(/__accion_name__/g, accion['accion_name']).replace(/__url__/g, accion['url']).replace(/__titulo__/g, accion['titulo']);

		//Si no esta inicializando la lista
		if(!inicial){
			if(imprimir){
				//Elimino la ultima accion
				$('#live #liveBoard tbody tr:last').remove();

				//Agrego a la lista
				$('#live #liveBoard tbody').prepend(html);

				//Agrego opacity a las ultimas acciones
				var list = $('#live #liveBoard tbody tr');
				var opacity = 0.9;
				for(var i=this.cant - 9; i<this.cant; ++i){
					$(list[i]).css('opacity', opacity);
					opacity -= 0.1;
				}
			}

			//Imprimo a la vel especificada
			setTimeout(function(){ live.print(false); }, this.vel);
		}
		//Si esta inicializando la lista
		else{
			//Agrego a la lista
			$('#live #liveBoard tbody').prepend(html);

			//Si este era el ultimo de la inicializacion
			if(inicial == 1){
				//Imprimo a la velocidad especificada
				setTimeout(function(){ live.print(false); }, this.vel);
			}else{
				//Imprimo el siguiente elemento
				live.print(inicial - 1);
			}
		}
	},

	update: function(){
	/* Actualiza live_data haciendo ajax
		return[void]
	*/
		$.ajax({
			type: 'POST',
			url: '/ajax/live.php',
			dataType: 'json',
			data: 'id=' + this.lastId,
			success: function(h){
				//Agrego la nueva lista al array de live_data
				live_data = $.merge(h, live_data);

				//Calculo velocidad de impresion
				live.calcVel();

				//Obtengo el ultimo ID
				if(live_data.length > 0)
					live.lastId = live_data[0]['id'];
			},
			error: function(){

			},
			complete: function(){
				setTimeout(function(){ live.update(); }, 5000); // #update
			}
		});
	},

	calcTime: function(){
	/* Calcula el tiempo en que se esta visualizando la pagina
		return[void]
	*/
		//Incremento y vuelvo a 0 todo lo necesario (horas, minutos y segundos)
		if(this.time[2] == 59){
			if(this.time[1] == 59){
				this.time[0]++
				this.time[1] = 0;
			}else
				this.time[1]++;
			this.time[2] = 0;
		}else
			this.time[2]++;

		//Numeros de dos digitos con 0 inicial
		var h = ((this.time[0] < 10) ? '0' : '') + this.time[0];
		var m = ((this.time[1] < 10) ? '0' : '') + this.time[1];
		var s = ((this.time[2] < 10) ? '0' : '') + this.time[2];

		//Imprimo contador
		$('#live #estadisticass #time').html(h + ':' + m + ':' + s);
	}
}