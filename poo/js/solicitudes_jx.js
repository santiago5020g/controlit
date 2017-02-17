function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function Pagina(next_page,item,max,back_page){
	//donde se mostrará los registros
	divContenido = document.getElementById('contenido');
	var dato2 = document.getElementById('clientes').value;
	var tecnico = document.getElementById('tecnico').value;
	var fecha_inicio_programado = document.getElementById('fecha_inicio_programado').value;
	var fecha_inicio2_programado = document.getElementById('fecha_inicio2_programado').value;
	var fecha_fin_programado = document.getElementById('fecha_fin_programado').value;
	var fecha_fin2_programado = document.getElementById('fecha_fin2_programado').value;
	var estado = document.getElementsByName('chkestado[]');

var estado2 = "";
for (var i=0, n=estado.length;i<n;i++) {
  if (estado[i].checked) 
  {
  estado2 += ","+estado[i].value;
  }
}
if (estado2) {estado2 = estado2.substring(1);}

	

	
	ajax=objetoAjax();
	//uso del medoto GET
	//indicamos el archivo que realizará el proceso de paginar
	//junto con un valor que representa el nro de pagina

	if(back_page!=1)
	{
		ajax.open("POST", "index.php?next_page="+next_page+"&item="+item+"&max="+max+"&idclientejx="+dato2+"&tecnicojx="+tecnico+"&estadojx="+estado2+"&fecha_inicio_programadojx="+fecha_inicio_programado+"&fecha_inicio2_programadojx="+fecha_inicio2_programado+"&fecha_fin_programadojx="+fecha_fin_programado+"&fecha_fin2_programadojx="+fecha_fin2_programado);
	}
	else
	{
		ajax.open("POST", "index.php?back_page="+next_page+"&item="+item+"&max="+max+"&idclientejx="+dato2+"&tecnicojx"+tecnico+"&estadojx="+estado2+"&fecha_inicio_programadojx="+fecha_inicio_programado+"&fecha_inicio2_programadojx="+fecha_inicio2_programado+"&fecha_fin_programadojx="+fecha_fin_programado+"&fecha_fin2_programadojx="+fecha_fin2_programado);
	}

	/*

	var estilo='<head><link rel="stylesheet" href="espera.css" type="text/css" media="screen"></head><div class="overlay"> \
	<div class="overlayContent"><h2>Cargando...</h2><img src="Loading.gif" alt="Cargando" border="0" /></div>';

		divContenido.innerHTML= estilo;

	*/

	divContenido.innerHTML= '<img src="Loading.gif">';

 
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			divContenido.innerHTML = ajax.responseText
		}
	}
	//como hacemos uso del metodo GET
	//colocamos null ya que enviamos 
	//el valor por la url ?pag=nropagina
	ajax.send(null)
}


function filtro_date()
{
    if (document.getElementById('filtro_fecha').value==1) 
    document.getElementById('fecha_inicio2_programado').style.display='none'; 
    else 
    document.getElementById('fecha_inicio2_programado').style.display='block'; 
	if (document.getElementById('filtro_fecha2').value==1) 
    document.getElementById('fecha_fin2_programado').style.display='none'; 
    else 
    document.getElementById('fecha_fin2_programado').style.display='block'; 
} 


function sedes2()
{
    var clientes = document.getElementById('clientes').value;
    var solicitud = document.getElementById('solicitudd').innerHTML;
    divContenido2 = document.getElementById('sede1');
    

	ajax2=objetoAjax();
	//uso del medoto GET
	//indicamos el archivo que realizará el proceso de paginar
	//junto con un valor que representa el nro de pagina

		ajax2.open("POST", "ds.php?clientesjx="+clientes+"&sedes='sede1'"+"&solicitud="+solicitud);
		
	

	/*

	var estilo='<head><link rel="stylesheet" href="espera.css" type="text/css" media="screen"></head><div class="overlay"> \
	<div class="overlayContent"><h2>Cargando...</h2><img src="Loading.gif" alt="Cargando" border="0" /></div>';

		divContenido.innerHTML= estilo;

	*/

	//divContenido2.innerHTML= '<img src="Loading.gif">';

 
	ajax2.onreadystatechange=function() {
		if (ajax2.readyState==4) {
			//mostrar resultados en esta capa
			divContenido2.innerHTML = ajax2.responseText
		}
	}
	//como hacemos uso del metodo GET
	//colocamos null ya que enviamos 
	//el valor por la url ?pag=nropagina
	ajax2.send(null)

} 


function dtval(d,e) {
var pK = e ? e.which : window.event.keyCode;
if (pK == 8) {d.value = substr(0,d.value.length-1); return;}
var dt = d.value;
var da = dt.split('/');
for (var a = 0; a < da.length; a++) {if (da[a] != +da[a]) da[a] = da[a].substr(0,da[a].length-1);}
if (da[0] > 31) {da[1] = da[0].substr(da[0].length-1,1);da[0] = '0'+da[0].substr(0,da[0].length-1);}
if (da[1] > 12) {da[2] = da[1].substr(da[1].length-1,1);da[1] = '0'+da[1].substr(0,da[1].length-1);}
if (da[2] > 9999) da[1] = da[2].substr(0,da[2].length-1);
dt = da.join('/');
if (dt.length == 2 || dt.length == 5) dt += '/';
d.value = dt;
}


function hour(d,e) {
var borre = 0;
var pK = e ? e.which : window.event.keyCode;
if (pK == 8) {d.value = substr(0,d.value.length-1); return;}
var dt = d.value;
var da = dt.split(':');
for (var a = 0; a < da.length; a++) {if (da[a] != +da[a]) da[a] = da[a].substr(0,da[a].length-1);}
if (da[0] > 23) {da[0] = "";}
if (da[1] > 60) {da[1] = ""; da[0] = ""; borre=1;}
//if (da[2] > 9999) da[1] = da[2].substr(0,da[2].length-1);
if(borre==0)
{
dt = da.join(':');
}
else{dt = da.join('');}
if (dt.length == 2) dt += ':';
d.value = dt;
}


var nav4 = window.Event ? true : false; 
function acceptNum(evt){  
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57  
var key = nav4 ? evt.which : evt.keyCode;  
return (key <= 13 || (key >= 48 && key <= 57) || key==46); 
} 

var nav4 = window.Event ? true : false; 
function onlynum(evt){  
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57  
var key = nav4 ? evt.which : evt.keyCode;  
return (key <= 13 || (key >= 48 && key <= 57)); 
} 



function nueva_ventana(info)
{


	popupWindow = window.open(
		info,'popUpWindow','height=600,width=1100,left=100,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');


}


function Update_solicitudes()
{
    var clientes = document.getElementById('clientes').value;
    var solicitud = document.getElementById('solicitudd').innerHTML;
    var asunto =document.getElementById('asunto').value;
    var estado1 = document.getElementById('estado1').value;
    var prioridad =document.getElementById('prioridad').value;
    var contacto =document.getElementById('contacto').value;
    var correo =document.getElementById('correo').value;
    var sede1 =document.getElementById('sede1').value;
    var descripcion =document.getElementById('descripcion').value;
    var propietario =document.getElementById('propietario').value;
    var fecha_inicio_programado =document.getElementById('fecha_inicio_programado').value;
    var hora_inicio_programado =document.getElementById('hora_inicio_programado').value;
    var fecha_fin_programado =document.getElementById('fecha_fin_programado').value;
    var hora_fin_programado =document.getElementById('hora_fin_programado').value;
    var tiempo_cotizado_horas =document.getElementById('tiempo_cotizado_horas').value;
    var valor_cotizacion =document.getElementById('valor_cotizacion').value;
    var proyecto =document.getElementById('proyecto').value;
    var verificacion =document.getElementById('verificacion').value;
    var causas =document.getElementById('causas').value;
    var solucion =document.getElementById('solucion').value;
    divContenido3 = document.getElementById('mensaje');
   

    var tipo ='POST';
    var archivo = 'ingresar.php?';
    var parametros ='idsolicitud='+encodeURI(solicitud)+
    '&cliente='+encodeURI(clientes)+
    '&asunto='+encodeURI(asunto)+
    '&prioridad='+encodeURI(prioridad)+
    '&contacto='+encodeURI(contacto)+
    '&sede1='+encodeURI(sede1)+
    '&estado1='+encodeURI(estado1)+
    '&descripcion='+encodeURI(descripcion)+
    '&propietario='+encodeURI(propietario)+
    '&correo='+ encodeURI(correo)+
    '&fecha_inicio_programado='+encodeURI(fecha_inicio_programado)+
    '&hora_inicio_programado='+encodeURI(hora_inicio_programado)+
    '&fecha_fin_programado='+encodeURI(fecha_fin_programado)+
    '&hora_fin_programado='+encodeURI(hora_fin_programado)+
    '&tiempo_cotizado_horas='+encodeURI(tiempo_cotizado_horas)+
    '&valor_cotizacion='+encodeURI(valor_cotizacion)+
    '&proyecto='+encodeURI(proyecto)+
    '&verificacion='+encodeURI(verificacion)+
    '&causas='+encodeURI(causas)+
    '&solucion='+encodeURI(solucion);



	ajax3=objetoAjax();
	//uso del medoto GET
	//indicamos el archivo que realizará el proceso de paginar
	//junto con un valor que representa el nro de pagina

		ajax3.open(tipo, archivo+parametros);
		
	

	/*

	var estilo='<head><link rel="stylesheet" href="espera.css" type="text/css" media="screen"></head><div class="overlay"> \
	<div class="overlayContent"><h2>Cargando...</h2><img src="Loading.gif" alt="Cargando" border="0" /></div>';

		divContenido.innerHTML= estilo;

	*/

	//divContenido2.innerHTML= '<img src="Loading.gif">';

 
	ajax3.onreadystatechange=function() {
		if (ajax3.readyState==4) {
			//mostrar resultados en esta capa
			divContenido3.innerHTML = ajax3.responseText
		}
	}
	//como hacemos uso del metodo GET
	//colocamos null ya que enviamos 
	//el valor por la url ?pag=nropagina
	ajax3.send(null)

} 



	function cargar_solicitud(solicitud)
	{
			$(document).ready(function(){
			$(function() {
				$.ajax({ 
				type: 'POST', 
				url: 'solicitudes_modificacion.php', 
				data:'id='+solicitud,
				success: function(respuesta) { 
				$('#solicitud').html(respuesta);

			} 
				}); 
				return false;
			}); 
		});
	}



	function cargar_tarea(solicitud)
	{
			$(document).ready(function(){
			$(function() {
				$.ajax({ 
				type: 'POST', 
				url: 'tarea_modificacion.php', 
				data:'id='+solicitud,
				success: function(respuesta) { 
				$('#tareas').html(respuesta);

			} 
				}); 
				return false;
			}); 
		});
	}



	function Paginaa(URL,variables,contenido,next_page,item,max,back_page)
	{
		var parametros = "";
		var parametro = "";
		var cadena = "";
		var array1='';
		var validador = 0;
		if(variables.split(',').length>1)
		{
		variables = variables.split(',');
        variables = "'" + variables.join("','") + "'"; //Resultado: '1', '2', '3'
        variables = variables.split(',');


        for(x = 0; x<variables.length; x++)
        {

        	if(variables[x].indexOf('[]') != -1)
        	{
        		cadena = "document.getElementsByName("+variables[x]+")";
	        	parametro = eval(cadena);

				for (var i=0, n=parametro.length;i<n;i++) 
				{
				  if (parametro[i].checked) 
				  {
				  array1 += ","+parametro[i].value;
				  }
				}
				if (array1) {array1 = array1.substring(1);}
				if(array1!=0 && array1!='')
				{parametros += "&"+variables[x].substr(1,variables[x].length-2)+"jx="+array1;
				array1 = '';}
			}

			else    		
	        {
	        	cadena = "document.getElementById("+variables[x]+").value";
	        	parametro = eval(cadena);
	        	if(parametro!='' && parametro!=0)
	        	{

		        	parametros += "&"+variables[x].substr(1,variables[x].length-2)+"jx="+parametro;


	            }

	        }

	        if(x == variables.length -1)
		    {
		    	if(parametros!=""){parametros+="&"; validador =1;}
			    
		    }
	             
        }
    }
//'next_page=9&item=0&max=10';'next_page='+next_page+'&item='+item+'&max='+max;
else if(variables.split('-').length==2){variables = variables.split('-'); parametros+=variables[0]+"="+variables[1]+"&";}
    if(back_page!=1)
				{
					parametros +=  'next_page='+next_page+'&item='+item+'&max='+max;
				}
				else
				{

					parametros +=  'back_page='+next_page+'&item='+item+'&max='+max;
				}

		 if(validador==1)
          {parametros = parametros.substr(1);}
      parametros = parametros.replace('[]', '');
 			$(document).ready(function(){
			$(function() {
				$.ajax({ 
				type: 'GET', 
				url: URL, 
				data: encodeURI(parametros),
				success: function(respuesta) { 
				$('#'+contenido).html(respuesta);

			} 
				}); 
				return false;
			}); 
		});
		
	}

