


function Validar_clientes()
{
	var frm=frmclientes;
	var nitj=frm.nit.value;
	var emailj=frm.email.value;
	var telefonoj=frm.telefono.value;
	correo = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	if (frm.nit.value==0) 
		{
			alert("falta ingresar el nit");
			frm.nit.value="";
			frm.nit.focus();
			return false;
		}

		
	if(isNaN(nitj)) 
	{
			frm.nit.focus();
			alert("El nit solo debe de contener numeros");
  			return false;
	}

	if (frm.nombre.value==0) 
		{
			alert("falta ingresar el nombre");
			frm.nombre.value="";
			frm.nombre.focus();
			return false;
		}


	if (frm.email.value==0) 
		{
			alert("falta ingresar el email");
			frm.email.value="";
			frm.email.focus();
			return false;
		}

		if ( !correo.test(emailj) )
		{
        	alert("Error: La dirección de correo " + emailj + " es incorrecta.");
        	frm.email.focus();
			return false;
		}


	if (frm.telefono.value==0) 
		{
			alert("falta ingresar el telefono");
			frm.telefono.value="";
			frm.telefono.focus();
			return false;
		}

	if(isNaN(telefonoj)) 
	{
			alert("El telefono solo debe de contener numeros");
			frm.telefono.focus();
			return false;
	}

	return submit();
}

