function swap(id)
{
var oTRs = document.getElementsByTagName("TR") ;
var iLength = oTRs.length;
for (var i=0; i < iLength; i++)
{
var tr = oTRs[i] ;
if( tr.className == id )
{
if( tr.style.display == "none" )
{
if( document.all )
tr.style.display = "block" ;
else
tr.style.display = "table-row" ;
}
else
{
tr.style.display = "none" ;
}
}
}
}


