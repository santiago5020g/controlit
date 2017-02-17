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


function horas()
{
	var inicio=document.getElementById('hora_inicio').value;
	var fin=document.getElementById('hora_fin').value;

	var hi=inicio.split(":") [0];
	var mi=inicio.split(":") [1];
	var hf=fin.split(":") [0];
	var mf=fin.split(":") [1];

	if(hi==hf)
	{
		if(mi>=mf) {document.getElementById('hora_fin').value=""};
	}

	else if(hi>hf)
	{
		document.getElementById('hora_fin').value="";
	}
}



