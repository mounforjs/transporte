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
        <title>:: RUTAS ::</title>
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

            var destino="";

            $().ready(function(){


                $.post("../../request/ruta/ajaxGetRutas.php", null, function(r){
                    if(r!="false"){
                        $('#tablaRutas').append(r);
                    }
                });


                $('a#nuevaRuta').colorbox({transition:'fade', speed:800,width:"750px", height:"330px",onComplete:function(){

                    $('#btnAgregar').click(function(){

                            $("#selectDestino").rules("add", {
                             required:true,
                             messages: {
                               required:"Este campo es requerido."
                             }
                            });

                            if($('#frmRuta').validate().element("#selectDestino")){

                                $.post("../../request/ruta/ajaxGetDestino.php", {selectDestino:$('#selectDestino').val()}, function(r){

                                    destino=r;

                                    if($('#txtRuta').val()==""){
                                        $('#txtRuta').val(destino);
                                    }else{
                                        $('#txtRuta').val($('#txtRuta').val()+" - "+destino);
                                    }

                                    if($('#txtRutaID').val()==""){
                                        $('#txtRutaID').val($("#selectDestino").val());
                                    }else{
                                        $('#txtRutaID').val($('#txtRutaID').val()+"-"+$("#selectDestino").val());
                                    }

                                });

                            }


                        });


                    $('#btnRegistrar').click(function(){

                       $("#txtRuta").rules("add", {
                         remote:{url:"../../request/ruta/ajaxCheckRuta.php",type:"post"},
                         messages: {
                           remote:"Esta Ruta ya ha sido registrada anteriormente."
                         }
                        });

                        $("#txtRutaID").rules("add", {
                         required:true,
                         messages: {
                           required:"Debe añadir por lo menos un destino a la ruta."
                         }
                        });


                        if($('#frmRuta').validate().element("#txtRuta") &
                           $('#frmRuta').validate().element("#txtRutaID")){
                           $('#btnRegistrar').attr("disabled", "true");
                            $.post("../../request/ruta/ajaxRegistrarRuta.php", $('#frmRuta').serialize(), function(r){

                                if(r=="ok")
                                {
                                    document.location=document.location;
                                }else
                                {
                                    alert("No se pudo registrar la ruta.");
                                }
                            });
                        }


                    });

                    $('#frmRuta').validate({errorPlacement: function(error, element) {
                    error.appendTo(element.parent());

                }});

                }});

                $("a[name='eliminar']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea eliminar esta ruta?")){
                        $.post("../../request/ruta/ajaxEliminarRuta.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Ruta eliminado satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                            }else{
                                if(r=="referencia"){
                                    alert("No se pudo eliminar esta ruta, porque esta se encuentra incluida en las listas de precio.")
                                }else{
                                   alert("No se pudo eliminar esta ruta");
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
                <span class="titulo">RUTAS</span>
                <br><br><br>
                <a id="nuevaRuta" href="nruta.php">Nueva Ruta</a>&nbsp;&nbsp;&nbsp;<br><br><br>
                <table id="tablaRutas" cellspacing="0" class="testilo" width="900px">

                    <tr >
                        <th>ID</th>
                        <th>Ruta</th>
                        <th>Acciones</th>
                    </tr>

                </table>
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>
