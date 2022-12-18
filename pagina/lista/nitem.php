<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';

$model = new model();
abrirConexion();

?>


<script type="text/javascript">

$(document).ready(function(){


        $("#inputRuta").autocomplete({

            source: "../../request/general/autocomplete_rutas_all.php?lista="+localStorage.getItem("lista_id"),
            minLength: 2,
            select: function(event,ui){
                
                
                $("#label-ruta").text(ui.item.label);
            }
        });

});

</script>

<div id="divPopUp">
    <div id="divNuevoItem">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVO ITEM</span><br><br>
        <form id="frmItem">



            <table>
            <tr>
                    <td>Ruta:</td>
                    <td><input id="inputRuta" name="inputRuta"><br><div id="label-ruta"></div></td>
                </tr>

                <!--
                <tr>
                    <td>Destino:</td>
                    <td>
                        <select id='selectRuta' class="selectDestino" name='selectRuta'>
                            <?php $model->getCombolModel("rutas", "descripcion") ?>
                        </select>
                    </td>
                </tr>

                -->
                <tr>
                    <td>Precio:</td>
                    <td><input id="txtPrecio" name="txtPrecio"></td>
                </tr>
                <tr>
                    <td>Precio (Pago):</td>
                    <td><input id="txtPrecioPago" name="txtPrecioPago"></td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>