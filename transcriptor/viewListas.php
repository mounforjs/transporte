<?php
require_once '../rutas.php';
require_once DB;
require_once CLASES . '/user.php';
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
        <title>:: LISTAS ::</title>
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

                $.post("./request/ajaxGetListas.php", null, function(r){
                    if(r!="false"){
                        $('#tablaListas').append(r);
                    }
                });



                $("a[name='editar']").live('click',function(){

                    $(this).colorbox({href:"editarLista.php?id="+this.id,transition:'fade', speed:800,width:"500px", height:"200px",onComplete:function(){

                            $('#btnRegistrar').click(function(){

                                $("#txtDescripcion").rules("add", {
                                    required: true,
                                    messages: {
                                        required: "<br>Este campo es requerido"
                                    }
                                });




                                if($('#frmLista').validate().element("#txtDescripcion")){
                                    $('#btnRegistrar').attr("disabled", "true");
                                    $.post("../request/lista/ajaxModificarLista.php", $('#frmLista').serialize(), function(r){

                                        if(r=="ok")
                                        {
                                            document.location=document.location;
                                        }else
                                        {
                                            alert("No se pudo modificar la lista.");
                                            $('#btnRegistrar').removeAttr("disabled");
                                        }
                                    });
                                }


                            });

                            $('#frmLista').validate({errorPlacement: function(error, element) {
                                    error.appendTo(element.parent());

                                }});

                        }});

                });





                $('a#nuevaLista').colorbox({transition:'fade', speed:400,width:"590px", height:"390px",onComplete:function(){

                        $('#btnRegistrar').click(function(){

                            $("#txtDescripcion").rules("add", {
                                required: true,
                                messages: {
                                    required: "<br>Este campo es requerido"
                                }
                            });




                            if($('#frmLista').validate().element("#txtDescripcion")){
                                $('#btnRegistrar').attr("disabled", "true");
                                $.post("../request/lista/ajaxRegistrarLista.php", $('#frmLista').serialize(), function(r){

                                    if(r=="ok")
                                    {
                                        document.location=document.location;
                                    }else
                                    {
                                        alert("No se pudo registrar la lista.");
                                        $('#btnRegistrar').removeAttr("disabled");
                                    }
                                });
                            }


                        });

                        $('#frmLista').validate({errorPlacement: function(error, element) {
                                error.appendTo(element.parent());

                            }});

                    }});

                $("a[name='eliminar']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar esta lista?")){
                        $.post("../request/destino/ajaxEliminarDestino.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Lista eliminado satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                            }else{
                                alert("No se pudo eliminar esta lista");
                            }
                        });
                    }
                });

                $("a[name='estado']").live("click",function(){
                        id=$(this).attr("id");
                        $.post("../request/lista/ajaxCambiarEstado.php",{id:id},function(r){
                            if(r=="true"){
                                alert('Estado de lista cambiado satisfactoriamente');
                                document.location=document.location;
                            }else{
                                alert("No se pudo cambiar el estado de la lista");
                            }
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
                    <span class="titulo">LISTAS</span>
                    <br><br><br>
                    <a id="nuevaLista" href="nlista.php">Nueva Lista</a>&nbsp;&nbsp;&nbsp;<br><br><br>
                    <table id="tablaListas" cellspacing="0" class="testilo" width="900px">

                        <tr>
                            <th>ID</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>

                    </table>
                    <br><br><br>
                </div>
            </div>
        </div>
    </body>
</html>
