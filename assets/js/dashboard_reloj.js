;( function ( document, window, index )
{
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
	});
}( document, window, 0 ));


let actualizarHora = function(){
	let fecha = new Date(),
		horas = fecha.getHours(),
		ampm,
		minutos = fecha.getMinutes(),
		segundos = fecha.getSeconds()

    if (horas >= 12) {
        horas = horas - 12;
        ampm = 'PM';
    } else {
        ampm = 'AM';
    }
    if (minutos < 10){ minutos = "0" + minutos; }
	if (segundos < 10){ segundos = "0" + segundos; }
    if(document.querySelector('.reloj') != null){
        document.querySelector('.reloj').innerHTML =horas+":"+minutos+":"+segundos+"<span class='ampm'>&nbsp;"+ampm+"</span>";
    }
};

actualizarHora();
let intervalo = setInterval(actualizarHora, 1000);


const $tiempoRestante = document.querySelector("#tiempoRestante");
let idInterval = null, diferenciaTemporal = 0,
fechaFuturo = null;

const iniciarTemporizador = (minutos, segundos) => {
	if (fechaFuturo) {
		fechaFuturo = new Date(new Date().getTime() + diferenciaTemporal);
		diferenciaTemporal = 0;
	} else {
		const milisegundos = (segundos + (minutos * 60)) * 1000;
		fechaFuturo = new Date(new Date().getTime() + milisegundos);
	}
	clearInterval(idInterval);
	idInterval = setInterval(() => {
		const tiempoRestante = fechaFuturo.getTime() - new Date().getTime();
		if (tiempoRestante <= 0) {
			diferenciaTemporal = fechaFuturo.getTime() - new Date().getTime();
			clearInterval(idInterval);
				location.href = base_url+"sesion-expirada";
		} else {
			$tiempoRestante.textContent = milisegundosAMinutosYSegundos(tiempoRestante);
		}
	}, 50);
};

const detenerTemporizador = () => {
		clearInterval(idInterval);
		fechaFuturo = null;
		diferenciaTemporal = 0;
		init(0,0);
};

const agregarCeroSiEsNecesario = valor => {
	if (valor < 10) {
		return "0" + valor;
	} else {
		return "" + valor;
	}
}
const milisegundosAMinutosYSegundos = (milisegundos) => {
	const minutos = parseInt(milisegundos / 1000 / 60);
	milisegundos -= minutos * 60 * 1000;
	segundos = (milisegundos / 1000);
	return `${agregarCeroSiEsNecesario(minutos)}:${agregarCeroSiEsNecesario(segundos.toFixed(1))}`;
};

const init = (minutos,segundos) => {
	minutos = "";
	segundos = "";
};

var idaa = window.setInterval(function () {
	document.onmousemove = function () {
		detenerTemporizador();
		iniciarTemporizador(10, 00);
	};
}, 1200);

iniciarTemporizador(10, 00);
init(0,0);