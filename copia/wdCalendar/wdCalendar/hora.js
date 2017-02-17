function checkTime(X) {
Str=X.value;
StrLen=Str.length;
StrT=Str.slice(StrLen-1,StrLen);
var StrRE1 = /^\d/;
var StrRE2 = /^[0-2]/;
var StrRE3 = /^:/;

if(StrT.match(StrRE1) && StrLen>1 && StrLen<6) {
if(Str.length==2)Str+=":";
X.value=Str;
if(Str.length==6){X.blur();return false;}
else return true;
}
else if (StrT.match(StrRE2) && StrLen==1){
return true;
}
else if (StrT.match(StrRE3) && StrLen==3){
return true;
}

else {
Str=Str.slice(0,StrLen-1);
X.value=Str;
return true;
} 
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



