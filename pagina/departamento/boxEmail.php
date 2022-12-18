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


        <script type="text/javascript">

            $().ready(function(){






            });
            
        </script>
    </head>
    <body>

     <div>
        <br>
        <div style="margin-left: 10px">
            <span class="titulo">NOTIFICACIÓN POR EMAIL</span><br><br>
            <form id="frmEmails">
            <table id="tabladepartamentos" class="testilo" cellspacing="0" width="840px">
                <tr>
                    <th>ID</th>
                    <th width="150px">Nombre</th>
                    <th>Codigo</th>
                    <th>Empresa</th>
                    <th>Acciones</th>
                </tr>
            </table>
            </form>
        </div>
        <br><br><br>
     </div>

    </body>
</html>