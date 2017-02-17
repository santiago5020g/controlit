	function facturar()
	{

		var numero_factura = document.getElementById('numero_factura').value;
		var fecha_facturacion = document.getElementById('fecha_facturacion').value;
		var solicitudes = document.getElementById('solicitudes').value;
		var valor_hora_pc = document.getElementById('valor_hora_pc').value;
		var valor_hora_servidor = document.getElementById('valor_hora_servidor').value;
		var cliente = document.getElementById('cliente').value;
			$(document).ready(function(){
			$(function() {
				$.ajax({ 
				type: 'POST', 
				url: 'proceso.php', 
				data:'fecha_facturacion='+fecha_facturacion+"&numero_factura="+numero_factura+"&solicitudes="+solicitudes+"&actualiza=1&valor_hora_pc="+valor_hora_pc+'&valor_hora_servidor='+valor_hora_servidor,
				success: function(respuesta) { 
				$('#mensaje').html(respuesta);

			} 
				}); 
				return false;
			}); 
		});


var i = 0;
var limite = 7;
		for(i=0; i<limite;i++)
		{
			if(numero_factura!='' && fecha_facturacion!='')
				{
						$(document).ready(function(){
						$(function() {
							$.ajax({ 
							type: 'POST', 
							url: 'reportes_tecnico.php', 
							data: 'solicitudespp='+solicitudes,
							success: function(respuesta) { 
							$('#mensaje').html(respuesta);

						} 
							}); 
							return false;
						}); 
					});
				}
		}	


			if(numero_factura!='' && fecha_facturacion!='')
			{
					$(document).ready(function(){
					$(function() {
						$.ajax({ 
						type: 'POST', 
						url: 'cron.php', 
						data: 'id_solicitud='+solicitudes+'&numero_factura='+numero_factura+'&fecha_facturacion='+fecha_facturacion+"&cliente="+cliente,
						success: function(respuesta) { 
						$('#mensaje2').html(respuesta);

					} 
						}); 
						return false;
					}); 
				});
			}

	}

		function recalculo_pc()
	{

		var numero_factura = document.getElementById('numero_factura').value;
		var fecha_facturacion = document.getElementById('fecha_facturacion').value;
		var solicitudes = document.getElementById('solicitudes').value;
		var valor_hora_pc = document.getElementById('valor_hora_pc').value;
			$(document).ready(function(){
			$(function() {
				$.ajax({ 
				type: 'POST', 
				url: 'proceso.php', 
				data:'fecha_facturacion='+fecha_facturacion+"&numero_factura="+numero_factura+"&solicitudes="+solicitudes+"&actualiza=0&valor_hora_pc="+valor_hora_pc+"&pc=1&servidor=1&valor_hora_servidor="+valor_hora_servidor,
				success: function(respuesta) { 
				$('#valor_total_pc').val(respuesta);
				var valor_total_pc = parseInt(document.getElementById('valor_total_pc').value);
				var valor_total_servidor = parseInt(document.getElementById('valor_total_servidor').value);
				document.getElementById('valorT').value = valor_total_pc + valor_total_servidor;
			} 
				}); 
				return false;
			}); 
		});

	}

			function recalculo_servidor()
	{

		var numero_factura = document.getElementById('numero_factura').value;
		var fecha_facturacion = document.getElementById('fecha_facturacion').value;
		var solicitudes = document.getElementById('solicitudes').value;
		var valor_hora_servidor = document.getElementById('valor_hora_servidor').value;
			$(document).ready(function(){
			$(function() {
				$.ajax({ 
				type: 'POST', 
				url: 'proceso.php', 
				data:'fecha_facturacion='+fecha_facturacion+"&numero_factura="+numero_factura+"&solicitudes="+solicitudes+"&actualiza=0&valor_hora_servidor="+valor_hora_servidor+"&servidor=1&pc=0&valor_hora_pc="+valor_hora_pc,
				success: function(respuesta) { 
				$('#valor_total_servidor').val(respuesta);
				var valor_total_pc = parseInt(document.getElementById('valor_total_pc').value);
				var valor_total_servidor = parseInt(document.getElementById('valor_total_servidor').value);
				document.getElementById('valorT').value = valor_total_pc + valor_total_servidor;

			} 
				}); 
				return false;
			}); 
		});

			
	}


		function reporte()
	{

		var solicitudes = document.getElementById('solicitudes').value;
			$(document).ready(function(){
			$(function() {
				$.ajax({ 
				type: 'POST', 
				url: 'cron.php', 
				data: "solicitudes="+solicitudes,
				success: function(respuesta) { 
				$('#valor_total_servidor').val(respuesta);
				var valor_total_pc = parseInt(document.getElementById('valor_total_pc').value);
				var valor_total_servidor = parseInt(document.getElementById('valor_total_servidor').value);
				document.getElementById('valorT').value = valor_total_pc + valor_total_servidor;

			} 
				}); 
				return false;
			}); 
		});
	
	}