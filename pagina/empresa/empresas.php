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
        <title>:: EMPRESAS ::</title>
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

                $.post("../../request/empresa/ajaxGetEmpresas.php", null, function(r){
                    if(r!="false"){
                        $('#tablaEmpresas').append(r);
                    }
                });



            $("a[name='editar']").live('click',function(){

              $(this).colorbox({href:"editarEmpresa.php?id="+this.id,transition:'fade', speed:800,width:"500px", height:"390px",onComplete:function(){

                    $('#btnRegistrar').click(function(){

                       $("#txtNombre").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtRif").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });



                        if($('#frmEmpresa').validate().element("#txtNombre") &
                           $('#frmEmpresa').validate().element("#txtRif")){
                           $('#btnRegistrar').attr("disabled", "true");
                            $.post("../../request/empresa/ajaxModificarEmpresa.php", $('#frmEmpresa').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo modificar la empresa.");
                                    $('#btnRegistrar').removeAttr("disabled");
                                }
                            });
                        }


                    });

                    $('#frmEmpresa').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});

            });




                $('a#nuevaEmpresa').colorbox({transition:'fade', speed:800,width:"500px", height:"390px",onComplete:function(){

                    $('#btnRegistrar').click(function(){

                       $("#txtNombre").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });

                        $("#txtRif").rules("add", {
                         required: true,
                         messages: {
                           required: "<br>Este campo es requerido"
                         }
                        });


                        if($('#frmEmpresa').validate().element("#txtNombre") &
                           $('#frmEmpresa').validate().element("#txtRif")){
                           $('#btnRegistrar').attr("disabled", "true");
                            $.post("../../request/empresa/ajaxRegistrarEmpresa.php", $('#frmEmpresa').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo registrar la empresa.");
                                    $('#btnRegistrar').removeAttr("disabled");
                                }
                            });
                        }


                    });

                    $('#frmEmpresa').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});

                $("a[name='eliminar']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar esta Empresa?")){
                        $.post("../../request/empresa/ajaxEliminarEmpresa.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Empresa eliminada satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                            }else{

                                if(r=="referencia"){
                                    alert("No se puede eliminar esta empresa porque ya se encuentran viajes asociados en el sistema.");
                                }else{
                                    alert("No se pudo eliminar esta empresa");
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
                <span class="titulo">Empresas</span>
                <br><br><br>
                <a id="nuevaEmpresa" href="nempresa.php">Nueva Empresa</a>&nbsp;&nbsp;&nbsp;<br><br><br>
                <table id="tablaEmpresas" class="testilo" cellspacing="0" width="900px">

                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>RIF</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>

                </table>
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>
