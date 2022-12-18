<?php
require_once '../rutas.php';
require_once DB;
require_once CLASES . '/model.php';
require_once CLASES . '/user.php';
require_once 'functions.php';
session_start();

abrirConexion();
if (comprobarSession($_SESSION['username'], $_SESSION['password'])) {
    $user = new User();
    //$user = $_SESSION['user'];
    cerrarConexion();
} else {
    cerrarConexion();
    header("location:login.php");
}

abrirConexion();
$model=new model();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>:: INICIO ::</title>
        <link href="../css/colorbox.css" type="text/css" rel="stylesheet">
        <link href="../css/estilo.css" type="text/css" rel="stylesheet">
        <link href="../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
        <link href="../css/jquery.tagsinput.css" type="text/css" rel="stylesheet">
        <script src="../js/jquery/jquery-1.4.2.min.js"></script>
        <script src="../js/jquery/jquery-ui-1.8.js"></script>
        <script src="../js/jquery/colorbox.js"></script>
        <script src="../js/jquery/jquery.jkey-1.1.js"></script>
        <script src="../js/jquery/jquery-validate/jquery.validate.js"></script>
        <script src="../js/jquery/jquery.tagsinput.js"></script>
        <script src="../js/jquery/init.js"></script>
        <script src="../../js/jquery/sessvars.js"></script>
        <script type="text/javascript">

            $().ready(function(){


                $.post("../request/viaje/ajaxGetViajesEnCurso.php", null, function(r){
                    if(r!="false"){
                        $('#tablaViajesEnCurso').append(r);
                    }
                });

                $.post("../request/viaje/ajaxGetViajesPlanificados.php", null, function(r){
                    if(r!="false"){
                        $('#tablaViajesPlanificados').append(r);
                    }
                });

                $("a[name='viajeTerminado']").live("click",function(){
                    
                    url=this.href;
                    id=this.id;
                    
                    $(this).colorbox({open:"true",href:"viaje/viajeterminado.php?id="+id,transition:'fade', speed:800,width:"530px", height:"350px",onComplete:function(){

                            $('#btnRegistrar').click(function(){

                                $("#txtNSolicitud").rules("add", {
                                    required: true,number:true,
                                    messages: {
                                        required: "<br>Este campo es requerido",
                                        number:"<br>Este campo solo acepta caracteres numericos"
                                    }
                                });


                                if($('#frmViajeTerminado').validate().element("#txtNSolicitud")){
                                    $('#btnRegistrar').attr("disabled","true");
                                    $.post("../request/viaje/ajaxViajeTerminado.php", {id:id,txtNSolicitud:$('#txtNSolicitud').val(),txtObservaciones:$('#txtObservaciones').val()}, function(r){

                                        if(r=="ok")
                                        {
                                            document.location=document.location;
                                        }else
                                        {
                                            alert("No se pudo realizar la operación");
                                        }
                                    });
                                }


                            });

                            $('#frmViajeTerminado').validate({errorPlacement: function(error, element) {
                                    error.appendTo(element.parent());

                                }});

                        }});

                });

                $("a[name='eliminar']").live("click",function(){
                    if(confirm("¿Esta seguro de que desea eliminar este viaje?")){
                        $.post("../request/viaje/ajaxEliminarViaje.php", {id:this.id}, function(r){
                            if(r=="ok"){
                                document.location=document.location;
                            }
                        });
                    }
                });

                $("a[name='cancelar']").live("click",function(){

                    id=this.id;
                    $(this).colorbox({open:"true",href:"viaje/viajecancelado.php",transition:'fade', speed:800,width:"550px", height:"280px",onComplete:function(){

                            $('#btnRegistrar').click(function(){

                                $("#txtObservaciones").rules("add", {
                                    required: true,
                                    messages: {
                                        required: "<br>Este campo es requerido"
                                    }
                                });


                                if($('#frmViajeCancelado').validate().element("#txtObservaciones")){

                                    $.post("../request/viaje/ajaxCancelarViaje.php", {id:id,txtObservaciones:$('#txtObservaciones').val()}, function(r){

                                        if(r=="ok")
                                        {
                                            document.location=document.location;
                                        }else
                                        {
                                            alert("No se pudo realizar la operación");
                                        }
                                    });
                                }


                            });

                            $('#frmViajeCancelado').validate({errorPlacement: function(error, element) {
                                    error.appendTo(element.parent());

                                }});

                        }});

                });

                $("a[name='enCurso']").live('click',function(){

                    id=$(this).attr("id");

                    if(confirm("¿Confirma que desea poner en curso este viaje?")){
                        $.post("../request/viaje/ajaxViajeEnCurso.php",{id:id},function(r){

                            if(r=="ok"){
                                document.location=document.location;
                            }else{
                                alert("No se pudo realizar esta operación")
                            }

                        });

                    }
                });

                $(window).jkey('f9',function(){
                    $("tr[class='trhide']").show();
                });

                $("a[name='viewviaje']").live("click",function(){
                    $(this).colorbox({open:true,href:"viaje/viewViaje.php?id="+$(this).attr("id"),transition:'fade', speed:400,width:"620px", height:"595x",onComplete:function(){
                            $("tr[class='trhide']").hide();

                        }});
                });
                
                $("a[name='clonarViaje']").live("click",function(){

                    idViaje=$(this).attr("id");
                    $.colorbox({href:"viaje/clonarViaje.php?id="+$(this).attr("id"),transition:'fade', speed:400,width:"620px", height:"350px",onComplete:function(){

                            $("a[name='actionClonarViaje']").click(function(){
                                $.post("../request/viaje/ajaxClonarViaje.php",$("#frmClonar").serialize()+"&idViaje="+idViaje,function(r){
                                    //document.location="index.php?idClonado="+r;
                                });
                            });

                        }});

                });

                idClonado=<?php if (isset($_GET['idClonado'])
                )echo $_GET['idClonado'];else {
                echo "0";
            } ?>;
                if(idClonado!=0){
                    alert("Viaje Clonado ! ID "+idClonado);
                    $("#"+idClonado+" > td").css("background-color","green");
                }


                $("#selectConductor").change(function(){

                    $.getJSON("../request/conductor/ajaxGetViajesConductorSeleccion.php", {selectConductor:$('#selectConductor').val()}, function(viajes){
                        $("table.testilo tr > td").css("background-color","#ffffff");
                        if(viajes!=1){

                            
                            $.each(viajes, function(i,viaje){
                                $("tr[id='"+viaje.id+"'] > td").css("background-color","#CFCFCF");
                            });
                        }else{
                            alert("Sin resultados");
                        }
                    });
                });




            });

        </script>
    </head>
    <body>
        <div id="main">
            <div id="header"><?php require_once HEADER ?></div>
            <div id="contenido">
                <div id="maincontenido">
                    <br><br><br>
                    <span class="titulo">VIAJES EN CURSO</span>
                    <br><br><br>
                    <a id="nuevoViaje" href="viaje/nviaje.php">Nuevo Viaje</a>&nbsp;&nbsp;&nbsp;<a id="nuevoViaje" href="viaje/nviaje2.php">Nuevo Viaje 2</a>
                    <select id="selectConductor">
                        <option></option>
                        <?php $model->getCombolModel("conductores", "nombre") ?>
                    </select>

                    <br><br><br>
                    <table id="tablaViajesEnCurso" class="testilo" cellspacing="0" width="915px">

                        <tr class="tableTitle">
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Conductor</th>
                            <th>Ruta</th>
                            <th>Empresa</th>
                            <th>Pasajero</th>
                            <th>Acciones</th>
                        </tr>

                    </table>
                    <br><br><br><br><br>
                    <span class="titulo">VIAJES PLANIFICADOS</span>
                    <br><br><br>
                    <table id="tablaViajesPlanificados" class="testilo" cellspacing="0" width="915px">

                        <tr class="tableTitle">
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Conductor</th>
                            <th>Ruta</th>
                            <th>Empresa</th>
                            <th>Pasajero</th>
                            <th>Acciones</th>
                        </tr>

                    </table>
                    <br><br><br>
                </div>
            </div>
        </div>
    </body>
</html>
