<?php
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/user.php';
    require_once '../functions.php';
    session_start();

    abrirConexion();
    if(comprobarSession($_SESSION['username'], $_SESSION['password']))
    {
        $user=new User();
        //$user=$_SESSION['user'];
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
        <title>:: PASAJEROS ::</title>
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


                $.post("../../request/pasajero/ajaxGetPasajeros.php", null, function(r){
                    if(r!="false"){
                        $('#tablapasajeros').append(r);
                    }
                });

                $('a#nuevoPasajero').colorbox({transition:'fade', speed:400,width:"550px", height:"520px",onComplete:function(){

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

                        $("#selectEmpresa").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });




                        if($('#frmPasajero').validate().element("#txtNombre") &
                           $('#frmPasajero').validate().element("#txtTelefono") &
                           $('#frmPasajero').validate().element("#txtDireccion") &
                           $('#frmPasajero').validate().element("#selectEmpresa")){
                            $('#btnRegistrar').attr("disabled", "true");
                            $.post("../../request/pasajero/ajaxRegistrarPasajero.php", $('#frmPasajero').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo registrar el pasajero.");
                                    $('#btnRegistrar').removeAttr("disabled");
                                }
                            });
                        }


                    });

                    $('#frmPasajero').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});


                $("a[name='editar']").live('click',function(){

                   $(this).colorbox({href:"editarPasajero.php?id="+this.id,transition:'fade', speed:400,width:"550px", height:"520px",onComplete:function(){

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

   


                            if($('#frmPasajero').validate().element("#txtNombre") &
                               $('#frmPasajero').validate().element("#txtTelefono") &
                               $('#frmPasajero').validate().element("#selectEmpresa")){
                                $('#btnRegistrar').attr("disabled", "true");
                                $.post("../../request/pasajero/ajaxModificarPasajero.php", $('#frmPasajero').serialize(), function(r){

                                    if(r=="ok")
                                    {
                                        document.location=document.location;
                                    }else
                                    {
                                        alert("No se pudo registrar la modificación.");
                                        $('#btnRegistrar').removeAttr("disabled");
                                    }
                                });
                            }


                        });

                        $('#frmPasajero').validate({errorPlacement: function(error, element) {
                        error.appendTo(element.parent());

                    }});

                    }});

                });

                $("a[name='eliminar']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar este pasajero?")){
                        $.post("../../request/pasajero/ajaxEliminarPasajero.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('pasajero eliminado satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                            }else{
                                if(r=="referencia"){
                                    alert("No se pudo eliminar este pasajero, porque esta involucrado con viajes ya registrados en el sistema")
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
        <div id="header"><?php require_once HEADER ?></div>
         <div id="contenido">
             <div id="maincontenido">
                <br><br><br>
                <span class="titulo">PASAJEROS</span>
                <br><br><br>
                <a id="nuevoPasajero" href="npasajero.php">Registrar nuevo pasajero</a>&nbsp;&nbsp;&nbsp;<br><br><br>
                <table id="tablapasajeros" class="testilo" cellspacing="0" width="900px">
                    <tr class="tableTitle">
                        <td>ID</td>
                        <td>Nombre</td>
                        <td>Teléfono</td>
                        <td>Dirección</td>
                        <td>Empresa</td>
                        <td>Departamento</td>
                        <td>Acciones</td>
                    </tr>
                </table>
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>
