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
        <title>:: DESTINOS ::</title>
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


                $.post("../../request/destino/ajaxGetDestinos.php", null, function(r){
                    if(r!="false"){
                        $('#tablaDestinos').append(r);
                    }
                });

                $('a#nuevoDestino').colorbox({transition:'fade', speed:400,width:"450px", height:"290px",onComplete:function(){

                    $('#btnRegistrar').click(function(){

                       $("#txtNombreDestino").rules("add", {
                         required: true,remote:{url:"../request/destino/ajaxCheckDestino.php",type:"post",data:{estado:$('#selectEstado').val()}},
                         messages: {
                           required: "<br>Este campo es requerido",
                           remote:"Este destino ya ha sido registrado anteriormente."
                         }
                        });

                        $("#selectEstado").rules("add", {
                             required: true,
                             messages: {
                               required: "<br>Este campo es requerido."
                             }
                        });

                        if($('#frmDestino').validate().element("#txtNombreDestino") &
                           $('#frmDestino').validate().element("#selectEstado")){
                            $('#btnRegistrar').attr("disabled", "true");
                            $.post("../request/destino/ajaxRegistrarDestino.php", $('#frmDestino').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo registrar el destino.");
                                    $('#btnRegistrar').removeAttr("disabled");
                                }
                            });
                        }


                    });

                    $('#frmDestino').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});

                $("a[name='eliminar']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar este destino?")){
                        $.post("../../request/destino/ajaxEliminarDestino.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Destino eliminado satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                                document.location=document.location;
                            }else{
                                alert("No se pudo eliminar este destino");
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
                <span class="titulo">DESTINOS</span>
                <br><br><br>
                <a id="nuevoDestino" href="ndestino.php">Registrar nuevo destino</a>&nbsp;&nbsp;&nbsp;<br><br><br>
                <table id="tablaDestinos" class="testilo" cellspacing="0" width="900px">

                    <tr class="tableTitle">
                        <th>ID</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>

                </table>
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>
