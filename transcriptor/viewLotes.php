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
        $user=$_SESSION['user'];
        cerrarConexion();
    }else
    {
        cerrarConexion();
        header("location:../pagina/login.php");
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>:: LOTES ::</title>
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

                $.post("./request/ajaxGetLotes.php", {status:"1"}, function(r){
                        $('#tablaLotes').html(r);
                });




               $("a[name='editar']").live('click',function(){

                $(this).colorbox({href:"/pagina/lote/editarLote.php?id="+this.id,transition:'fade', speed:800,width:"490px", height:"360px",onComplete:function(){

                    $('#btnRegistrar').click(function(){

                       $("#txtDescripcion").rules("add", {
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


                        if($('#frmLote').validate().element("#txtDescripcion") &
                           $('#frmLote').validate().element("#selectEmpresa")){

                            $.post("../request/lote/ajaxModificarLote.php", $('#frmLote').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo modifcar la Lote.");
                                }
                            });
                        }


                    });

                    $('#frmLote').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});

                });


                $('a#nuevoLote').colorbox({transition:'fade', speed:800,width:"570px", height:"350px",onComplete:function(){

                    $('#btnRegistrar').click(function(){

                       $("#txtDescripcion").rules("add", {
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

                


                        if($('#frmLote').validate().element("#txtDescripcion") &
                           $('#frmLote').validate().element("#selectEmpresa")){

                            $.post("request/ajaxRegistrarLote.php", $('#frmLote').serialize(), function(r){

                                if(r == "ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo registrar la Lote.");
                                }
                            });
                        }


                    });

                    $('#frmLote').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});

                $("a[name='eliminar']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar esta Lote?")){
                        $.post("../request/lote/ajaxEliminarLote.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Lote eliminado satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                            }else{
                                alert("No se pudo eliminar esta Lote");
                            }
                        });
                    }
                });

                $('#btnCancelar').click(function(){
                    $.post("../request/lote/ajaxConfirmarPagos.php", $('#frmLotes').serialize(), function(){
                        document.location=document.location;
                    })
                });

                $('#btnEnviar').click(function(){
                    $.post("../request/lote/ajaxConfirmarEnvios.php", $('#frmLotes').serialize(), function(){
                        document.location=document.location;
                    })
                });

                $("a[name='sinPago']").live("click",function(){
                    $.post("../request/lote/ajaxSinPago.php",{id:this.id}, function(){
                        document.location=document.location;
                    });
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
                <span class="titulo">LOTES</span>
                <br><br><br>
                <a id="nuevoLote" href="nlote.php">Nueva Lote</a>&nbsp;&nbsp;&nbsp;<br><br><br>
               
                <div id="divLotes">
                    
                    <form id="frmLotes">
                        <table id="tablaLotes" class="testilo" cellspacing="0" width="1100px">
                            <tr class="tableTitle">
                                <td>ID</td>
                                <td>Descripcion</td>
				                <td width="100px">fecha</td>
                                <td>Nº Factura</td>
                                <td>Lote</td>
                                <td>Estado</td>
                                <td width="10px">Acciones</td>
                                <td>Acciones</td>
                            </tr>
                        </table>
                    </form>
                </div>
                <br><br>
                <input id="btnCancelar" type="button" value="CANCELAR LOTES">&nbsp;&nbsp;&nbsp;<input id="btnEnviar" type="button" value="ENVIAR LOTES">
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>
