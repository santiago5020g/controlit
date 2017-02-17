<?php //require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="es">
    <head> 
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>Jose Aguilar - Paginación de resultados con jQuery, Ajax y PHP</title> 
        <link type="text/css" href="css/styles.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$('.paginate').live('click', function(){
		
		$('#content').html('<div class="loading"><img src="images/loading.gif" width="70px" height="70px"/></div>');

		var page = $(this).attr('data');		
		var dataString = 'page='+page;
		
		$.ajax({
            type: "GET",
            url: "includes/pagination.php",
            data: dataString,
            success: function(data) {
				$('#content').fadeIn(1000).html(data);
            }
        });
    });              
});    
</script>
        
    </head>
<body>
        <div id="central">
            <div class="service_category">Artículos</div>
            <div id="content"><?php require('includes/pagination.php'); ?></div>
					
        </div>
        
           

</body>
</html>
































sc_lookup(tarea,"select max(idtareas) from tbltareas");
$tarea1 = {tarea[0][0]};
$link = "idtarea=".urlencode($tarea1);


echo"<style>
#my-div
{
    width    : 100px;
    height   : 100px;
    overflow : hidden;
   
}
  
#my-iframe
{
    position : absolute;
    top      : 50%;
    left     : 0%;
    width    : 100%;
    height   : 100%;
}
</style> 
<div id=my-div>
<iframe src=../mis_librerias/correos/usuarios_notificaciones.php?".$link."id=my-iframe></iframe>
</div>
";
sc_alert("Guardado");