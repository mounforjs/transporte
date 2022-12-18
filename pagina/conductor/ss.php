<?php
    require_once '../../rutas.php';
    require_once DB;
        require_once CLASES.'/user.php';
    require_once CLASES.'/model.php';
    require_once '../functions.php';
    session_start();

    abrirConexion();
    if(comprobarSession($_SESSION['username'], $_SESSION['password']))
    {
        $user=new User();
        $user=$_SESSION['user'];
        
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
            <title>:: VIAJES SIN SOLICITUD ::</title>
            <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
            <link href="../../css/reportes.css" type="text/css" rel="stylesheet">
            <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
            <script src="../../js/jquery/jquery-ui-1.8.js"></script>
            <script src="../../js/jquery/colorbox.js"></script>
            <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>


              <style type="text/css">
              body {
                background-color: white }

              .caja2{
                float:left;
                padding-top: 4px;
                width: 300px;
              }
              .caja{
                float:right;
                padding-top: 4px;
                width: 300px;
                }
              </style>



        <script type="text/javascript">
            $().ready(function(){

                $.post("../../request/conductor/ajaxGetViajesSSReporte.php", null, function(r){
                    $('#tablaViajes').html(r);
                });
            });
        </script>
    </head>
    <body>
        <div id="main">
     
         <div>
             <div>
                <br>
               
                <div id="divLoteDescripcion">
                    
                    <fieldset>
                        <span class="caja2">
                            <span class='titulo'>TRANSPORTE ARENAS C.A</span><br><br>
                            <strong>RIF :</strong>J-29642721-6<br>
                            <strong>CONTACTO :</strong>0412-8465713  /  0244-3864346
                        </span>
                    </fieldset>
                </div><br>
                <div>
                    <br>
                    &nbsp;&nbsp;<strong>VIAJES SIN SOLICITUD DE SERVICIO</strong><br>
                    </div>
                <br><br>
                <table id="tablaViajes" cellspacing="0" width="1000">
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr class='tableTitle'>
                        <td>ID</td>
                        <td>Conductor</td>
                        <td>Fecha</td>
                        <td>Ruta</td>
                      </tr>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                </table>
                <br><br>
                <div id="totalPago">
                    
                </div>
             </div>
         </div>
        </div>
    </body>
</html>