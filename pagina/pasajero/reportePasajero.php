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
        $model=new model();
        $pasajero=$model->getModel($_GET['pasajero'], "pasajeros");
        $empresa_id=$pasajero['empresa_id'];
        $empresa=$model->getModel($empresa_id, "empresas");
        
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
        <title>:: LOTE ::</title>
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

                $.post("../../request/pasajero/ajaxGetViajesPasajeroReporte.php", {selectPasajero:<?php echo $_GET['pasajero'] ?>,desde:"<?php echo $_GET['desde'] ?>",hasta:"<?php echo $_GET['hasta'] ?>"}, function(r){
                    $('#tablaViajes').html(r);
                });

                $.post("../../request/viaje/ajaxGetTotalViajesPasajero.php", {selectPasajero:<?php echo $_GET['pasajero'] ?>,desde:"<?php echo $_GET['desde'] ?>",hasta:"<?php echo $_GET['hasta'] ?>"}, function(r){
                    $('#totalPago').html(r);
                });

                $("a[name='eliminar']").live("click",function(){
                    id=this.id;
                    if(confirm("¿Esta seguro que desea sacar este viaje del lote?")){
                        $.post("../../request/lote/ajaxEliminarViajeLote.php",{id:id},function(r){
                            if(r=="ok"){
                                alert('Operación realizada satisfactoriamente');
                                $("tr[id="+id+"]").remove();
                            }else{
                                alert("No se pudo realizar la operación solicitada");
                            }
                        });
                    }
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
                        <span class="caja">
                            <span class='titulo'><?php echo strtoupper($empresa['nombre']) ?></span><br><br>
                            <strong>RIF :</strong><?php echo strtoupper($empresa['rif'])  ?><br>
                        </span>
                        <span class="caja2">
                            <span class='titulo'>TRANSPORTE ARENAS C.A</span><br><br>
                            <strong>RIF :</strong>J-29642721-6<br>
                            <strong>CONTACTO :</strong>0412-8465713  /  0244-3864346
                        </span>
                    </fieldset>
                </div><br>
                <div>
                    <br>
                    &nbsp;&nbsp;<strong>VIAJES DEL PASAJERO :</strong> <?php echo $model->getDescripcionTable("pasajeros", $_GET['pasajero'], "nombre") ?><br>
                    &nbsp;&nbsp;<strong>Viajes desde:</strong> <?php echo $_GET['desde'] ?>&nbsp;&nbsp;<strong>hasta:</strong> <?php echo $_GET['hasta'] ?>
                </div>
                <br><br>
                <table id="tablaViajes" cellspacing="0" width="1000">
                    <tr>
                        <td colspan="10"></td>
                    </tr>
                    <tr class="tableTitle">
                        <td width="30">ID</td>
                        <td>Fecha</td>
                        <td>Ruta</td>
                        <td>Monto</td>
                    </tr>
                    <tr>
                        <td colspan="10"></td>
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