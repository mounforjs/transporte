<?php
    require_once '../../rutas.php';
    require_once DB;
    require_once CLASES.'/lote.php';
    require_once CLASES.'/user.php';
    require_once '../functions.php';
    session_start();

    abrirConexion();
    if(comprobarSession($_SESSION['username'], $_SESSION['password']))
    {
        $user=new User();
       // $user=$_SESSION['user'];
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
        <title>:: LOTE ::</title>
            <link href="../../css/colorbox.css" type="text/css" rel="stylesheet">
            <link href="../../css/reportes.css" type="text/css" rel="stylesheet">
            <link href="../../css/estilo.css" type="text/css" rel="stylesheet">
            <link href="../../css/jquery-ui-1.8.css" type="text/css" rel="stylesheet">
            <script src="../../js/jquery/jquery-1.4.2.min.js"></script>
            <script src="../../js/jquery/jquery-ui-1.8.js"></script>
            <script src="../../js/jquery/colorbox.js"></script>
            <script src="../../js/jquery/jquery-validate/jquery.validate.js"></script>


              <style type="text/css">
              body {
                background-color: white }

              .caja{
                float:left;
                padding-top: 4px;
                width: 300px;
              }
              .caja2{
                float:right;
                padding-top: 4px;
                width: 300px;
                }
              </style>



        <script type="text/javascript">

            $().ready(function(){

                $.post("../../request/lote/ajaxGetViajesLoteEmpresaClasificado.php", {id:<?php echo $_GET['id'] ?>}, function(r){
                        $('#tablaViajes').html(r);
                });

//                $.post("../../request/lote/ajaxGetLoteDescripcionEmpresa.php", {id:<?php echo $_GET['id'] ?>,empresa:<?php echo $_GET['empresa'] ?>}, function(r){
//                        $('#divLoteDescripcion').append(r);
//                });




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
               
                <div id="divLoteDescripcion"></div><br><br>
                <table id="tablaViajes" cellspacing="0" width="1000">
                    <tr>
                        <td colspan=""></td>
                    </tr>
                    <tr class="tableTitle">
                        <td width="10">ID</td>
                        <td width="70">Fecha</td>
                        <td width="70">Dpto.</td>
                        <td>Ruta</td>
                        <td width="150">Pasajeros</td>
                        <td width="15" >H.E.</td>
                        <td width="10">M.</td>
                        <td width="10">Noct.</td>
                        <td width="95">Monto</td>
                        <td width="95">IVA</td>
                        <td width="100">Total</td>
                    </tr>
                    <tr>
                        <td colspan="11"></td>
                    </tr>
                </table>
                <br><br><br>
             </div>
         </div>
        </div>
    </body>
</html>