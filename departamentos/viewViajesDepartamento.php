<?php
require_once '../rutas.php';
require_once DB;
require_once CLASES . '/user.php';
require_once CLASES . '/model.php';
require_once '../pagina/functions.php';
session_start();

abrirConexion();
if (comprobarSessionDepartamento($_SESSION['username'], $_SESSION['password'])) {
    $user = new User();
    $user = $_SESSION['user'];
  
} else {
    cerrarConexion();
    header("location:../pagina/login.php");
}

$model = new model();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>:: VIAJES POR DEPARTAMENTO ::</title>
        <link href="../css/colorbox.css" type="text/css" rel="stylesheet">
        <link href="estilo.css" type="text/css" rel="stylesheet">
        <link href="../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
        <script src="../js/jquery/jquery-1.4.2.min.js"></script>
        <script src="../js/jquery/jquery-ui-1.8.js"></script>
        <script src="../js/jquery/colorbox.js"></script>
        <script src="../js/jquery/jquery.jkey-1.1.js"></script>
        <script src="../js/jquery/jquery-validate/jquery.validate.js"></script>
        <script type="text/javascript">

            $().ready(function(){

                departamento=<?php echo "'".ucwords($_GET['d'])."'" ?>;
                    
                $.post("requests/ajaxGetViajesDepartamento.php", {departamento:departamento}, function(r){
                    c=new Array();
                    c=r.split("&&&");
                    $('#tablaViajes').html(c[0]);
                    //$('#total').html(c[1]);
                });


                         
            });
            
        </script>
    </head>
    <body>
        <div id="main">
            <div id="header"><div id="header-titulo">
                    <div style="float:right"><a href="/transporte/pagina/login.php">Cerrar Sesion</a></div>
                    <div id="fecha">
                        <script>
                            var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                            var f=new Date();
                            document.write(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
                        </script>
                    </div>
                </div></div>
            <div id="contenido">
                <div id="maincontenido">
                    <div class="titulo-2">VIAJES POR  DEPARTAMENTO</div>
                    <br><br>
                    <div class="titulo marleft30"><?php echo strtoupper($_GET['d']) ?></div>
                    <br>
                    <div class="departamento-data">
                    <form id="frmViajesLote">
                        
                        <table id="tablaViajes" cellspacing="0" width="900px" class="testilo">

                        </table>
                    </form>
                        </div>
                    <br><br>
                    <div id="total"></div>
                    <br><br>
                    <br><br><br>
                </div>
            </div>
        </div>
    </body>
</html>