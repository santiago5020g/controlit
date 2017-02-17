<?php


echo "<script type='text/javascript' src='poo/js/jquery-1.11.1.min.js'></script>";
echo "<script type='text/javascript'>


$(document).ready(function(){
	$('#button').click(function() {
		$.ajax({ 
		type: 'POST', 
		url: 'pruebas2.php', 
		data:'id_solicitud=1221&cliente_solicitud=1212',
		success: function(respuesta) { 
		$('#resultado').html(respuesta);

	} 
		}); 
		return false;
	}); 
});

</script>



<input type='button' id='button' value='aqui' />
<div id='resultado'></div>";

 ?>

