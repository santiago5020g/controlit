document.write("<script type='text/javascript' src='js/jquery-1.11.1.min.js'></script>");
function Pagina(next_page,item,max,back_page)
{

	var dato2 = document.getElementById('paises').value;
	var tecnico = document.getElementById('tecnico').value;
	var fecha_inicio_programado = document.getElementById('fecha_inicio_programado').value;

var estado = document.getElementsByName('chkestado[]');
	var estado2 = "";
	for (var i=0, n=estado.length;i<n;i++) {
	  if (estado[i].checked) 
	  {
	  estado2 += ","+estado[i].value;
	  }
	}
	if (estado2) {estado2 = estado2.substring(1);}

		if(back_page=!1)
		{


		       $.ajax({
		            url: 'index.php', 
		            data: "next_page="+next_page+"&item="+item+"&max="+max+"&idclientejx="+dato2+"&tecnicojx="+tecnico+"&estadojx="+estado2+"&fecha_inicio_programadojx="+fecha_inicio_programado,
		            type: 'GET',

		            success: function(data) {
		                $("#contenido").html(data);

		            }
		        });
		 }

		 else

		{

		       $.ajax({
		            url: 'index.php', 
		            data: 'back_page='+next_page+'&item='+item+'&max='+max+'&idclientejx='+dato2+'&tecnicojx='+tecnico+'&estadojx='+estado2+'&fecha_inicio_programadojx='+fecha_inicio_programado,
		            type: 'GET',

		            success: function(data) {
		                $("#contenido").html(data);

		            }
		        });

		 }
}
