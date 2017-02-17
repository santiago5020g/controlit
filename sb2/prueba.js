function confirmation(uno,dos,tres) {


if(tres==1)
{

if(confirm("Esta seguro de eliminar el archivo")) {

document.location.href= "eliminar.php?id="+uno+"&p="+dos+"&tres="+tres;

}

}


else
{
 if(confirm("Esta seguro de eliminar el archivo")) {

document.location.href= "eliminar.php?id="+uno+"&p="+dos+"&tres="+tres;

}
   
}

} 
