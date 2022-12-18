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
        $user=$_SESSION['user'];
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
        <title>:: DEPARTAMENTOS ::</title>
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


                $.post("../../request/departamento/ajaxGetDepartamentos.php", null, function(r){
                    if(r!="false"){
                        $('#tabladepartamentos').append(r);
                    }
                });

                $('a#nuevodepartamento').colorbox({transition:'fade', speed:800,width:"400px", height:"380px",onComplete:function(){

                    $('#btnRegistrar').click(function(){

                       $("#txtNombre").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtCodigo").rules("add", {
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


                        if($('#frmDepartamento').validate().element("#txtNombre") &
                           $('#frmDepartamento').validate().element("#txtCodigo") &
                               $('#frmDepartamento').validate().element("#selectEmpresa")){
                            $('#btnRegistrar').attr("disabled", "true");
                            $.post("../../request/departamento/ajaxRegistrarDepartamento.php", $('#frmDepartamento').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo registrar el departamento.");
                                    $('#btnRegistrar').removeAttr("disabled");
                                }
                            });
                        }


                    });

                    $('#frmDepartamento').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});


                $("a[name='editar']").live('click',function(){

                   $(this).colorbox({href:"editarDepartamento.php?id="+this.id,transition:'fade', speed:800,width:"400px", height:"380px",onComplete:function(){

                        $('#btnRegistrar').click(function(){

                           $("#txtNombre").rules("add", {
                             required: true,
                             messages: {
                               required: "<br>Este campo es requerido"
                             }
                            });

                            $("#txtCodigo").rules("add", {
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


                            if($('#frmDepartamento').validate().element("#txtNombre") &
                               $('#frmDepartamento').validate().element("#txtCodigo") &
                               $('#frmDepartamento').validate().element("#selectEmpresa")){
                                
                                $.post("../../request/departamento/ajaxModificarDepartamento.php", $('#frmDepartamento').serialize(), function(r){

                                    if(r=="ok")
                                    {
                                        document.location=document.location;
                                    }else
                                    {
                                        alert("No se pudo registrar la modificación.");
                                        
                                    }
                                });
                            }


                        });

                        $('#frmDepartamento').validate({errorPlacement: function(error, element) {
                        error.appendTo(element.parent());

                    }});

                    }});

                });

                $("a[name='eliminar']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar este departamento?")){
                        $.post("../../request/departamento/ajaxEliminarDepartamento.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('departamento eliminado satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                            }else{
                                if(r=="referencia"){
                                    alert("No se pudo eliminar este departamento, porque esta involucrado con viajes ya registrados en el sistema")
                                }else{
                                   alert("No se pudo eliminar este departamento");
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
                <span class="titulo">DEPARTAMENTOS</span>
                <br><br><br>
                <a id="nuevodepartamento" href="ndepartamento.php">Registrar nuevo departamento</a>&nbsp;&nbsp;&nbsp;<a  href="departamentosEmail.php">Notificaciones</a><br><br><br>
                <table id="tabladepartamentos" class="testilo" cellspacing="0" width="900px">

                    <tr >
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Empresa</th>
                        <th>Acciones</th>
                    </tr>

                </table>
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>