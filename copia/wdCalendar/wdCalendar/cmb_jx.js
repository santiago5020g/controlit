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



function cmb(validate,origen,id1){
	//donde se mostrará los registros

	var vali= validate;
	var parametro1 = document.getElementById(origen).value;
	divContenido = document.getElementById(id1);

	//divContenido = id1;
	
	
	ajax=objetoAjax();
	//uso del medoto GET
	//indicamos el archivo que realizará el proceso de paginar
	//junto con un valor que representa el nro de pagina

	if(vali!=-1)
	{
	ajax.open("POST", "cmb_jx.php?serviciosjx="+parametro1+"&selectedjx="+vali);
	}

	else
	{
	ajax.open("POST", "cmb_jx.php?serviciosjx="+parametro1);
	}

	/*

	var estilo='<head><link rel="stylesheet" href="espera.css" type="text/css" media="screen"></head><div class="overlay"> \
	<div class="overlayContent"><h2>Cargando...</h2><img src="Loading.gif" alt="Cargando" border="0" /></div>';

		divContenido.innerHTML= estilo;

	*/

	//divContenido.innerHTML= '<img src="Loading.gif">';

 
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


