<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
require_once CLASES.'/viaje.php';
$model = new viaje();
abrirConexion();

date_default_timezone_set("America/Caracas");

$movilizaciones_str = "";
$retorno = "";
$encomienda = "";
$horario = "";
$i = 1;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script>
    

    
            $(document).ready(function()
            {

                $('input').keydown(function (e) {

                if (event.which === 13 || event.keyCode === 13) {
                        event.stopPropagation();
                        event.preventDefault();
                        var position = $(this).index('input');
                        $("input").eq(position+1).focus();
                    }
                       
                 });

                viaje_id=<?php echo $_GET['id'] ?>

                $("#selectRuta").tokenInput("../../request/destino/ajaxGetDestinosAutocomplete.php", {
                                    theme: "facebook",
                                    minChars: 3,
                                    tokenLimit: 4});

                $("#selectRuta").focus();
                

            });

        </script>
    </head>
    <body>
        <div id="divPopUp">
            <div id="divNuevoPasajero">
                <br><br>
                <span class="titulo">&nbsp;&nbsp;NUEVA RUTA</span><br><br>
                <form id="frmNuevaRuta">
                    <table width="500px">
                        
                        <tr>
                            <td><strong>Ruta:</strong></td>
                            <td>
                                <input id="selectRuta" name="selectRuta" type="text">
                                
                            </td>
                         </tr>

                        <tr>
                            <td><strong>Lista:</strong></td>
                            <td>
                                <select id='selectLista' name='selectLista'>
                                <?php 
                                         $lote = $model->getModelCondicionado("lotes", "id=".$_GET['id']);
                                         echo $model->getComboSelectedListas("listas", "descripcion", $lote['default_list'] );
                                         $default = $lote['default_list']
                                ?>

                                 </select>
                                
                            </td>
                        </tr>

                        <tr>
                            <td>Precio:</td>
                            <td><input id="txtPrecio" name="txtPrecio" value=""></td>
                        </tr>
                        <tr>
                            <td>Precio (Pago):</td>
                            <td><input id="txtPrecioPago" name="txtPrecioPago" value=""></td>
                        </tr>
                        


                    </table><br>

                    
                    <br>
                </form>
                <a  id="actionCrearRuta" name="actionCrearRuta" class="boton">REGISTRAR</a>

            </div>
        </div>
    </body>
</html>
