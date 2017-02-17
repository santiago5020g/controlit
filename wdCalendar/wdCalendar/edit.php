<?php
include_once("../../conexion/dbconfig_calendar.php");
include_once("php/functions.php");

require("solicitudes.php");
$obj_solicitudes= new Solicitudes();
$usuarios=$obj_solicitudes->getSolicitudes();
$clientes=$obj_solicitudes->getClientes();
$categorias=$obj_solicitudes->getCategorias();
$disposicion=$obj_solicitudes->getDisposicion();
$liberacion=$obj_solicitudes->getLiberacion();



if(isset($_REQUEST["serviciosjx"]))
{
   $serviciosjx=$_REQUEST["serviciosjx"];
   $servicios=$obj_solicitudes->getServicios($serviciosjx);
}

function getCalendarByRange($id){
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "select ta.propietario as tarea_propietario,ta.idso as tarea_so,ta.idEstado as tarea_idestado,ta.fecha_inicio as tarea_fecha_inicio,ta.hora_inicio as tarea_hora_inicio,ta.hora_fin as tarea_hora_fin,ta.tiempo_efectivo as tarea_tiempo_efectivo,ta.Color as tarea_color,ta.disposicion as tarea_disposicion,ta.gastos_transporte as tarea_gastos_transporte,ta.observaciones as tarea_observaciones,ta.pendientes as tarea_pendientes,ta.idtareas as tarea_idtareas,ca.categoriaid as categoria_categoriaid,se.id as sede_id,so.id as solicitud_id,so.Idcliente as solicitud_Idcliente from tbltareas ta inner join tblsolicitudes so on ta.idso=so.id
    inner join tblclientes cli on cli.id_cli=so.Idcliente
    inner join vista_categorias ca on ca.categoriaid=ta.idcategoria
    inner join tblsede se on se.id=ta.idsitio where ta.idtareas = " . $id;
    $handle = mysql_query($sql);
    //echo $sql;
    $row = mysql_fetch_object($handle);
}catch(Exception $e){
}
return $row;
}




if($_GET["id"]){
  $event = getCalendarByRange($_GET["id"]);

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>    
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">


    <title>Calendar Details</title> 
    <link href="css/main.css?v=6" rel="stylesheet" type="text/css" />       
    <link href="css/dp.css?v=1" rel="stylesheet" />    
    <link href="css/dropdown.css?v=1" rel="stylesheet" />    
    <link href="css/colorselect.css?v=1" rel="stylesheet" />   

    <script src="src/jquery.js?v=1" type="text/javascript"></script>    
    <script src="src/Plugins/Common.js?v=1" type="text/javascript"></script>        
    <script src="src/Plugins/jquery.form.js?v=1" type="text/javascript"></script>     
    <script src="src/Plugins/jquery.validate.js?v=1" type="text/javascript"></script>     
    <script src="src/Plugins/datepicker_lang_US.js?v=1" type="text/javascript"></script>        
    <script src="src/Plugins/jquery.datepicker.js?v=1" type="text/javascript"></script>     
    <script src="src/Plugins/jquery.dropdown.js?v=1" type="text/javascript"></script>     
    <script src="src/Plugins/jquery.colorselect.js?v=1" type="text/javascript"></script>    
    <script type="text/javascript" src="ev.js?v=1"></script>


    <script type="text/javascript" src="cmb_jx.js?v=2"></script>
    <script src="hora.js?v=2" type="text/javascript"></script>   


    <script type='text/javascript' src='../../calendar/tcal.js?v=4'></script>
    <link rel=stylesheet type=text/css href='../../calendar/tcal.css?v=4' />


    <script type="text/javascript">
    if (!DateAdd || typeof (DateDiff) != "function") {
        var DateAdd = function(interval, number, idate) {
            number = parseInt(number);
            var date;
            if (typeof (idate) == "string") {
                date = idate.split(/\D/);
                eval("var date = new Date(" + date.join(",") + ")");
            }
            if (typeof (idate) == "object") {
                date = new Date(idate.toString());
            }
            switch (interval) {
                case "y": date.setFullYear(date.getFullYear() + number); break;
                case "m": date.setMonth(date.getMonth() + number); break;
                case "d": date.setDate(date.getDate() + number); break;
                case "w": date.setDate(date.getDate() + 7 * number); break;
                case "h": date.setHours(date.getHours() + number); break;
                case "n": date.setMinutes(date.getMinutes() + number); break;
                case "s": date.setSeconds(date.getSeconds() + number); break;
                case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
            }
            return date;
        }
    }
    function getHM(date)
    {
     var hour =date.getHours();
     var minute= date.getMinutes();
     var ret= (hour>9?hour:"0"+hour)+":"+(minute>9?minute:"0"+minute) ;
     return ret;
 }
 $(document).ready(function() {
            //debugger;
            var DATA_FEED_URL = "php/datafeed.php";
            var arrT = [];
            var tt = "{0}:{1}";
            for (var i = 0; i < 24; i++) {
                arrT.push({ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "00"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "05"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "10"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "15"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "20"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "25"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "30"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "35"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "40"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "45"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "50"]) },{ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "55"]) } ); 
            }
            $("#timezone").val(new Date().getTimezoneOffset()/60 * -1);
            $("#stparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
                selectedchange: function() { },
                items: arrT
            });
            $("#etparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
                selectedchange: function() { },
                items: arrT
            });
            var check = $("#IsAllDayEvent").click(function(e) {
                if (this.checked) {
                    $("#stparttime").val("00:00").hide();
                    $("#etparttime").val("00:00").hide();
                }
                else {
                    var d = new Date();
                    var p = 60 - d.getMinutes();
                    if (p > 30) p = p - 30;
                    d = DateAdd("n", p, d);
                    $("#stparttime").val(getHM(d)).show();
                    $("#etparttime").val(getHM(DateAdd("h", 1, d))).show();
                }
            });
            if (check[0].checked) {
                $("#stparttime").val("00:00").hide();
                $("#etparttime").val("00:00").hide();
            }
            $("#Savebtn").click(function() { $("#fmEdit").submit(); });
            $("#Closebtn").click(function() { CloseModelWindow(); });
            $("#Deletebtn").click(function() {
             if (confirm("Are you sure to remove this event")) {  
                var param = [{ "name": "calendarId", value: 8}];                
                $.post(DATA_FEED_URL + "?method=remove",
                    param,
                    function(data){
                      if (data.IsSuccess) {
                        alert(data.Msg); 
                        CloseModelWindow(null,true);                            
                    }
                    else {
                        alert("Error occurs.\r\n" + data.Msg);
                    }
                }
                ,"json");
            }
        });
            
            $("#stpartdate,#etpartdate").datepicker({ picker: "<button class='calpick'></button>"});    
            var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            $("#calendarcolor").colorselect({ title: "Color", index: cv, hiddenid: "colorvalue" });
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() {
                    return true;
                },
                dataType: "json",
                success: function(data) {
                    alert(data.Msg);
                    if (data.IsSuccess) {

                        $(document).ready(function(){
                            $(function() {
                                $.ajax({ 
                                    type: 'POST', 
                                    url: '../../correos/usuarios_notificaciones.php', 
                                    data:'idtarea='+data.idtarea,
                                    success: function(respuesta) { 
                                        $('#resultado').html(respuesta);

                                    } 
                                }); 
                                return false;
                            }); 
                        });

                        if(data.programacion_modificada=='si')
                        {
                            var user = "<?php echo $_REQUEST['usuario']; ?>";
                               $(document).ready(function(){
                                $(function() {
                                    $.ajax({ 
                                        type: 'POST', 
                                        url: '../../correos/programacion_modificada.php', 
                                        data:'idtarea='+data.idtarea+'&fecha_primera='+data.fecha_primera+'&hora_primera='+data.hora_primera+'&fecha_inicio2='+data.fecha_inicio2+'&hora_inicio2='+data.hora_inicio2+'&usuario='+user,
                                        success: function(respuesta) { 
                                            $('#resultado2').html(respuesta);

                                        } 
                                    }); 
                                    return false;
                                }); 
                            });   
                        }


                        //CloseModelWindow(null,true);  
                    }
                }
            };
            $.validator.addMethod("date", function(value, element) {                             
                var arrs = value.split(i18n.datepicker.dateformat.separator);
                var year = arrs[i18n.datepicker.dateformat.year_index];
                var month = arrs[i18n.datepicker.dateformat.month_index];
                var day = arrs[i18n.datepicker.dateformat.day_index];
                var standvalue = [year,month,day].join("-");
                return this.optional(element) || /^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3-9]|1[0-2])[\/\-\.](?:29|30))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3,5,7,8]|1[02])[\/\-\.]31)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:16|[2468][048]|[3579][26])00[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1-9]|1[0-2])[\/\-\.](?:0?[1-9]|1\d|2[0-8]))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?:\d{1,3})?)?$/.test(standvalue);
            }, "Invalid date format");
$.validator.addMethod("time", function(value, element) {
    return this.optional(element) || /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(value);
}, "Invalid time format");
$.validator.addMethod("safe", function(value, element) {
    return this.optional(element) || /^[^$\<\>]+$/.test(value);
}, "$<> not allowed");
$("#fmEdit").validate({
    submitHandler: function(form) { $("#fmEdit").ajaxSubmit(options); },
    errorElement: "div",
    errorClass: "cusErrorPanel",
    errorPlacement: function(error, element) {
        showerror(error, element);
    }
});
function showerror(error, target) {
    var pos = target.position();
    var height = target.height();
    var newpos = { left: pos.left, top: pos.top + height + 2 }
    var form = $("#fmEdit");             
    error.appendTo(form).css(newpos);
}
});
</script>      
<style type="text/css">     
.calpick     {        
    width:16px;   
    height:16px;     
    border:none;        
    cursor:pointer;        
    background:url("sample-css/cal.gif") no-repeat center 2px;        
    margin-left:-22px;    
}    


/*cmb(<?php echo isset($event)?$event->solicitud_id:-1 ?>,'clientes','servicios2','servicios2');*/

/*cmb2(<?php echo isset($event)?$event->sede_id:-1 ?>,'clientes','sedes2','sedes2');*/

</style>



</head>
<body onload="cmb2(<?php echo isset($event)?$event->solicitud_id:-1 ?>,'clientes','servicios2','servicios2'); " >    
    <div>      
      <div class="toolBotton">           
        <a id="Savebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Save"  title="Save the calendar">Save(<u>S</u>)
          </span>          
      </a>                           
      <?php if(isset($event)){ ?>
      <a id="Deletebtn" class="imgbtn" href="javascript:void(0);">                    
          <span class="Delete" title="Cancel the calendar">Delete(<u>D</u>)
          </span>                
      </a>             
      <?php } ?>            
      <a id="Closebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Close" title="Close the window" >Close
          </span></a>            
      </a> 

      <div id='resultado'></div>
      <div id='resultado2'></div>

  </div>                  
  <div style="clear: both">         
  </div>        
  <div class="infocontainer">            
    <form action="php/datafeed.php?method=adddetails<?php echo isset($event)?"&id=".$event->tarea_idtareas:""; ?>" class="fform" id="fmEdit" method="post" name="form_tareas">
        <div id="calendarcolor">
        </div>
    <div class="bloque1_form">
        <span>Cliente</span>
        <select name='clientes' id='clientes' onchange="cmb2(<?php echo isset($event)?$event->solicitud_id:-1 ?>,'clientes','servicios2','servicios2'); " >;
            <?php for($i2=0;$i2<sizeof($clientes);$i2++)
            { ?>
            <option value="<?php echo $clientes[$i2]["id_cli"] ?>" <?php if(isset($event)){if($event->solicitud_Idcliente==$clientes[$i2]["id_cli"]){echo "selected";}} ?> ><?php echo $clientes[$i2]["nombre_empresa"]; ?></option>
            <?php }?>
        </select>
    </div>


    <div class="bloque1_form" id='servicios'>

        <span>Solicitud</span>
        <select name='servicios' id='servicios2'>

        </select>

    </div>

<div class="bloque1_form">
    <span>Usuario </span>
    <select name='usuarios'  id='usuarios'>;
        <?php for($i2=0;$i2<sizeof($usuarios);$i2++)
        { ?>
        <option value="<?php echo $usuarios[$i2]["login"] ?>" <?php if(isset($event)){if($event->tarea_propietario==$usuarios[$i2]["login"]){echo "selected";}} ?>><?php echo $usuarios[$i2]["name"]; ?></option>
        <?php }?>
    </select>
</div>
<?php if(isset($event)){
  $sarr = date('d/m/Y',strtotime($event->tarea_fecha_inicio));
  $hora_in = explode(" ", php2JsTime(mySql2PhpTime(date('H:i',strtotime($event->tarea_hora_inicio)))));
  $hora_fi = explode(" ", php2JsTime(mySql2PhpTime(date('H:i',strtotime($event->tarea_hora_fin)))));
}?>                    

<div class="bloque1_form">
    <span>Fecha inicio </span>    
    <input MaxLength="10" name="fecha_inicio" id="fecha_inicio" class="tcal" required onkeydown="dtval(this,event)" onkeyup="dtval(this,event)" type="text" value="<?php echo isset($event)?$sarr:date('d/m/Y'); ?>"  /> 
</div>

<input type = "hidden" name="fecha_primera" value="<?php echo isset($event)?$sarr:'1'; ?>" />
<input type = "hidden" name="hora_primera" value="<?php echo isset($event)?$hora_in[1]:'1'; ?>" />

<div class="bloque1_form" > 
  <span>Hora Inicio</span>                     
  <input MaxLength="5" name="hora_inicio" id="hora_inicio" type="text" required value="<?php echo isset($event)?$hora_in[1]:date('H:i'); ?>" onkeydown="hour(this,event)" onkeyup="hour(this,event)" onChange="horas()" />                   
</div>
<div class="bloque1_form">
  <span>Hora fin</span>                     
  <input MaxLength="5"  name="hora_fin" id="hora_fin"  type="text" required value="<?php echo isset($event)?$hora_fi[1]:""; ?>" onkeydown="hour(this,event)" onkeyup="hour(this,event)" onChange="horas()" />
</div>  
<div class="bloque1_form">
    <span>Disposicion</span>
    <?php for($i2=0;$i2<sizeof($disposicion);$i2++) { ?>
    <input type="radio" name="disposicion" required id="disposicion" value="<?php echo $disposicion[$i2]["Descripcion"] ?>" <?php if (isset($event)) {if($event->tarea_disposicion==$disposicion[$i2]["Descripcion"]) {echo "checked";}} ?> /> <?php echo $disposicion[$i2]["Descripcion"];?>
    <?php } ?>
</div>
<div class="bloque1_form">
    <span>Estado liberacion</span>
    <select name='liberacion' id='liberacion'>;
        <?php for($i2=0;$i2<sizeof($liberacion);$i2++)
        { ?>
        <option value="<?php echo $liberacion[$i2]["idliberacion"] ?>" <?php if(isset($event)){if($event->tarea_idestado==$liberacion[$i2]["idliberacion"]){echo "selected";}} ?> ><?php echo $liberacion[$i2]["descripcion_liberacion"]; ?></option>
        <?php }?>
    </select>
</div>


<div class="bloque1_form">
    <span>Tarea</span>
    <label><?php echo isset($event)?$event->tarea_idtareas:""; ?></label>
</div>
                                                      
    <input id="colorvalue" name="colorvalue" type="hidden" value="<?php echo isset($event)?$event->tarea_color:"" ?>" />                               

 <div class="bloque2_form">               
    <span> Detalles:</span>                    
    <textarea name="observaciones"><?php echo isset($event)?$event->tarea_observaciones:""; ?></textarea>
</div>            
                
<div class="bloque2_form">                  
    <span>Pendientes</span>                    
    <textarea name="pendientes"><?php echo isset($event)?$event->tarea_pendientes:""; ?></textarea>                
</div> 
<div class="bloque1_form">
    <label class="checkp"> 
        <input id="IsAllDayEvent" name="IsAllDayEvent" type="checkbox" value="1"/>   All Day Event                      
    </label>  
</div>

 <div class="bloque1_form"> 
    <input id="timezone" name="timezone" type="hidden" value="" />   
</div>        
</form>         
</div>         
</div>


</body>
</html>