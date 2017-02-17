function transaccion()
{

	window.open('form.php','window.open','width= 500px, height= 400px,left=50px,top=60px')
}

function guardar()
{
	var nombre = document.getElementById('nombre').value;
	var descripcion = document.getElementById('descripcion').value;
	
	$(document).ready(function(){
		$(function(){

		$.ajax({
			type: 'POST',
			url: 'transacciones.php',
			data: 'nombre='+nombre+'&descripcion='+descripcion,
			success: function(respuesta){
				$('#mensaje2').html(respuesta);
			}

		});
		return false;

		});

	});
}


function Pagina(parametro)
{

	window.open('form.php?id='+parametro,'window.open','width = 400px, height=400px, margin= 20%');
}

	




