<?php
require_once '../../rutas.php';
require_once CLASES.'/user.php';
session_start();

if($_SESSION['session']!=1)
{
    echo "holaaa";
}else
{
    $user=new User();
    $user=$_SESSION['user'];
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <div id="main">
        <div id="header"><?php require_once HEADER ?></div>
          <div id="contenido">
             <div id="maincontenido">
                <br><br><br>
                <span class="titulo">VIAJE</span>
                <br><br><br><br>
                Se ha registrado el viaje Nº <strong><?php echo $_SESSION['viajeIdEdit'] ?></strong><br>
                <a href="nviaje.php">Click aquí</a> para registrar otro viaje.<br><br>
                Volver al <a href="../index.php">Inicio del Sistema.</a>
                <br><br><br><br>
             </div>
              
         </div>
        </div>
    </body>
</html>
