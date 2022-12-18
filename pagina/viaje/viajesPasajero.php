<?php
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/user.php';
    require_once CLASES.'/conductor.php';
    require_once '../functions.php';
    session_start();

    abrirConexion();
    if(comprobarSession($_SESSION['username'], $_SESSION['password']))
    {
        $user=new User();
        $conductor=new Conductor();
        $user=$_SESSION['user'];
    }else
    {
        cerrarConexion();
        header("location:../login.php");
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>::VIAJES PASAJEROS::</title>
    <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
    <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
    <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
    <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
    <script src="../../js/jquery/jquery-ui-1.8.js"></script>
    <script src="../../js/jquery/colorbox.js"></script>
    <script src="../../js/jquery/jquery.jkey-1.1.js"></script>
    <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>

    <script type="text/javascript">

    $().ready(function(){

            $.validator.addMethod(
                "esDATE",
                function(value, element) {
                    
                    return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
                },
                "Please enter a date in the format dd/mm/yyyy"
            );

            function comparaFecha(fecha, fecha2){
                var fechaIni=fecha.split('/');
                var fechaFin=fecha2.split('/');

                if(parseInt(fechaIni[2],10)>parseInt(fechaFin[2],10)){
                    return(true);
                }else{
                    if(parseInt(fechaIni[2],10)==parseInt(fechaFin[2],10)){
                        if(parseInt(fechaIni[1],10)>parseInt(fechaFin[1],10)){
                            return(true);
                        }
                        if(parseInt(fechaIni[1],10)==parseInt(fechaFin[1],10)){
                            if(parseInt(fechaIni[0],10)>parseInt(fechaFin[0],10)){
                                return(true);
                            }else{
                                return(false);
                            }
                        }else{
                            return(false);
                        }
                    }else{
                        return(false);
                    }
                }
            }

            $('#datepickerDesde').datepicker({dateFormat:'dd/mm/yy',changeYear: true,changeMonth:true,dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dec']});
            $('#datepickerDesde').datepicker();

            $('#datepickerHasta').datepicker({dateFormat:'dd/mm/yy',changeYear: true,changeMonth:true,dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dec']});
            $('#datepickerHasta').datepicker();
            
            $('#btnBuscar').click(function(){
               
                $("#datepickerDesde").rules("add", {
                 required: true,esDATE:true,
                 messages: {
                   required: "Este campo es requerido",
                   esDATE:"Por favor especifique una fecha valida"
                 }});

                $("#datepickerHasta").rules("add", {
                 required: true,esDATE:true,
                 messages: {
                   required: "Este campo es requerido",
                   esDATE:"Por favor especifique una fecha valida"
                 }});

                 if($('#datepickerHasta').val()!=$('#datepickerDesde').val()){
                     if(comparaFecha($('#datepickerHasta').val(),$('#datepickerDesde').val())){
                         if($("#frmConsultarViajes").validate().element('#datepickerDesde') & $("#frmConsultarViajes").validate().element('#datepickerHasta')){
                             $.post("../../request/viaje/ajaxGetViajesPasajero.php", $('#frmConsultarViajes').serialize(), function(r){
                                 if(r!="false"){
                                     $('#tablaViajes').html(r);
                                     $.post("../../request/viaje/ajaxGetTotalViajesPasajero.php", $('#frmConsultarViajes').serialize(), function(r){
                                        $('#totalPago').html(r);
                                     });

                                 }
                             });
                         }
                     }else{
                        alert("La fecha especificada en 'Desde' debe ser menor a la escrita en el campo 'Hasta'");
                        return false; //para que el formulario no haga submit
                    }
                }else{
                    
                }
            });


               
            $('#frmConsultarViajes').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
            }});


            $(window).jkey('f9',function(){
                    $("tr[class='trhide']").show();
                });

            $("a[name='viewviaje']").live("click",function(){
                    $(this).colorbox({open:true,href:"../viaje/viewViaje.php?id="+$(this).attr("id"),transition:'fade', speed:400,width:"620px", height:"595px",onComplete:function(){
                            $("tr[class='trhide']").hide();

                    }});
                });
            
        });
       
    </script>

  </head>
  <body>

    <div id="main">
        <div id="header"><?php require_once HEADER ?></div>
        <br><br>
       
        <div id="contenido">
             <div id="maincontenido">
                 <br><br><br>

                 <span class="titulo">VIAJES PASAJEROS</span><br><br>
                 <form id="frmConsultarViajes"><br>
                    <strong>Desde:</strong>&nbsp;&nbsp;<span><input id="datepickerDesde" name="desde"></span><br>
                    <strong>Hasta:</strong>&nbsp;&nbsp;<span><input id="datepickerHasta" name="hasta"></span><br><br><br>
                    <strong>Pasajero: </strong>&nbsp;&nbsp;
                    <select id="selectPasajero" name="selectPasajero">
                        <?php $conductor->getCombolModel("pasajeros", "nombre")  ?>
                    </select>
                    &nbsp;&nbsp;<input id="btnBuscar" type="button" value="CONSULTAR">
                
                 <br><br><br>
                 <table id="tablaViajes" cellspacing="0" width="750">
                     <tr class="tableTitle">
                        <td width="30">ID</td>
                        <td>Fecha</td>
                        <td>Ruta</td>
                        <td>Conductor</td>
                        <td>Retorno</td>
                        <td>Monto</td>
                        <td>Acciones</td>
                     </tr>
                     <tr>
                         <td colspan="4"></td>
                     </tr>
                 </table><br><br><br>
                 </form><br>
                 <div id="totalPago"></div>
                 <br><br><br><br>
            </div>
        </div>
    </div>
