<?php
    require_once '../rutas.php';
    require_once DB;
    require_once CLASES.'/user.php';
    require_once '../pagina/functions.php';
    session_start();

    abrirConexion();
    if(comprobarSessionTranscriptor($_SESSION['username'], $_SESSION['password']))
    {
        $user=new User();
       // $user=$_SESSION['user'];
        cerrarConexion();
    }else
    {
        cerrarConexion();
        header("location:../login.php");
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>:: CONDUCTORES ::</title>
            <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
            <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
            <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
            <script src="../../js/jquery/jquery-ui-1.8.js"></script>
            <script src="../../js/jquery/colorbox.js"></script>
            <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>
            <script src="../../js/jquery/jquery.jkey-1.1.js"></script>
            <link href="../../css/jquery.tagsinput.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery.tagsinput.js"></script>
            <script src="../../js/jquery/init.js"></script>
            <script src="../../js/jquery/sessvars.js"></script>
        <script type="text/javascript">

            $().ready(function(){


                $.post("../request/conductor/ajaxGetConductores.php", null, function(r){
                    if(r!="false"){
                        $('#tablaConductores').append(r);
                    }
                });

                $('a#nuevoConductor').colorbox({transition:'fade', speed:400,width:"560px", height:"530px",onComplete:function(){

                    $('#btnRegistrar').click(function(){

                       $("#txtNombre").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtTelefono").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtDireccion").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtCedula").rules("add", {
                         required: true,number:true,
                         messages: {
                           required: "<br>Este campo es requerido",
                           number:"<br>Este campo solo debe contener caracteres numéricos"
                         }
                        });

                        $("#txtVehiculo").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });


                        if($('#frmConductor').validate().element("#txtNombre") &
                           $('#frmConductor').validate().element("#txtTelefono") &
                           $('#frmConductor').validate().element("#txtDireccion") &
                           $('#frmConductor').validate().element("#txtVehiculo") &
                           $('#frmConductor').validate().element("#txtCedula")){
                            $('#btnRegistrar').attr("disabled", "true");
                            $.post("../request/conductor/ajaxRegistrarConductor.php", $('#frmConductor').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo registrar el conductor.");
                                    $('#btnRegistrar').removeAttr("disabled");
                                }
                            });
                        }


                    });

                    $('#frmConductor').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});

                $("a[name='ver']").live('click',function(){
                    document.location="visualizarConductor.php?idConductor="+this.id;
                });


                $("a[name='editar']").live('click',function(){

                  id=this.id;
                  url=this.href;

                  $(this).colorbox({open:"true",href:"/pagina/conductor/editarConductor.php?id="+id,transition:'fade', speed:400,width:"560px", height:"530px",onComplete:function(){

                    $('#btnRegistrar').click(function(){

                       $("#txtNombre").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtTelefono").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtDireccion").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtCedula").rules("add", {
                         required: true,number:true,
                         messages: {
                           required: "<br>Este campo es requerido",
                           number:"<br>Este campo solo debe contener caracteres numéricos"
                         }
                        });

                        $("#txtVehiculo").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });


                        if($('#frmConductor').validate().element("#txtNombre") &
                           $('#frmConductor').validate().element("#txtTelefono") &
                           $('#frmConductor').validate().element("#txtDireccion") &
                           $('#frmConductor').validate().element("#txtVehiculo")){
                            $('#btnRegistrar').attr("disabled", "true");
                            $.post("../request/conductor/ajaxModificarConductor.php", $('#frmConductor').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudieron registrar las modificaciones.");
                                    $('#btnRegistrar').removeAttr("disabled");
                                }
                            });
                        }


                    });

                    $('#frmConductor').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});


                });


                $("a[name='eliminar']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar este conductor?")){
                        $.post("../request/conductor/ajaxEliminarConductor.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('conductor eliminado satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                            }else{
                                if(r=="referencia"){
                                    alert("No se pudo eliminar este conductor, porque esta involucrado con viajes ya registrados en el sistema")
                                }else{
                                   alert("No se pudo eliminar este conductor");
                                }
                                
                            }
                        });
                    }
                });

            });
            
        </script>
    </head>
    <body>
        <div id="main">
        <div id="header"><?php require_once HEADER_TRANSCRIPTOR ?></div>
         <div id="contenido">
             <div id="maincontenido">
                <br><br><br>
                <span class="titulo">CONDUCTORES</span>
                <br><br><br>
                <a id="nuevoconductor" href="nconductor.php">Registrar nuevo conductor</a>&nbsp;&nbsp;&nbsp;<br><br><br>
                <table id="tablaConductores" class="testilo" cellspacing="0" width="900px">

                    <tr class="tableTitle">
                        <th>ID</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Vehículo</th>
                        <th>Acciones</th>
                    </tr>

                </table>
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>
