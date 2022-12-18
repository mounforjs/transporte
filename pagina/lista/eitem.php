<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';

$model = new model();
abrirConexion();

$id = $_GET['id'];
$item = $model->getModel($id, "listas_rutas");

?>

<script type="text/javascript">

$(document).ready(function(){


        $("#inputRuta").autocomplete({

            source: "../../request/general/autocomplete_rutas_all.php?lista="+localStorage.getItem("lista_id"),
            minLength: 2,
            select: function(event,ui){
                
                $("#inputPasajero").text(ui.item.label)
                
            }
        });

});

</script>

<div id="divPopUp">
    <div id="divNuevoItem">
        <br>
        <span class="titulo">&nbsp;&nbsp;ACTUALIZAR PRECIOS</span><br><br>
        <form id="frmItem">
            <table>

                <tr>
                    <td>Ruta:</td>
                    <td><input id="inputRuta" name="inputRuta" value="<?php echo $item['ruta_id'] ?>"><br><?php echo $item['ruta'] ?></td>
                </tr>

                <!--
                <tr>
                    <td>Destino:</td>
                    <td>
                        <select id='selectRuta' class="selectDestino" name='selectRuta'>
                            <?php $model->getComboSelected("rutas", "descripcion", $item['ruta_id']) ?>
                        </select>
                    </td>
                </tr> -->
                <tr>
                    <td>Precio:</td>
                    <td><input id="txtPrecio" name="txtPrecio" value="<?php echo $item['precio'] ?>"></td>
                </tr>
                <tr>
                    <td>Precio (Pago):</td>
                    <td><input id="txtPrecioPago" name="txtPrecioPago" value="<?php echo $item['precio_conductores'] ?>"></td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">ACTUALIZAR</button>
    </div>
</div>