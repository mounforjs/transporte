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
        header("location:../login.php");
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>:: VIAJES ::</title>
            <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
            <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
            <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
            <script src="../../js/jquery/jquery-ui-1.8.js"></script>
            <script src="../../js/jquery/colorbox.js"></script>
            <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>

        <script type="text/javascript">

            $().ready(function(){
                $('#btnBuscar').click(function(){

                    if($('#txtBuscar').val()!=""){
                        $.post("../../request/viaje/ajaxGetViajeID.php", {id:$('#txtBuscar').val()}, function(r){
                            if(r!="false"){
                                $('#tablaViajes').html(r);
                            }
                        });
                    }else{
                        alert("Por favor introduzca un ID valido");
                        $('#txtBuscar').focus();
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
                <span class="titulo">BUSCAR VIAJE POR ID</span>
                <br><br><br>

                <form id="frmViajes">

                    <strong>VIAJE ID</strong>&nbsp;&nbsp;<input id="txtBuscar" type="text" size="7">&nbsp;&nbsp;&nbsp;<input id="btnBuscar" type="button" value="BUSCAR VIAJE">
                    <br><br>
                    <table id="tablaViajes" cellspacing="0" width="800">
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr class="tableTitle">
                            <td>ID</td>
                            <td>Fecha</td>
                            <td>Conductor</td>
                            <td>Ruta</td>
                            <td>Lote</td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                    </table>
                    <br><br><br><br>
               </form>
             </div>
         </div>
        </div>
    </body>
</html>