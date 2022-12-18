<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevaRuta">
        <br><br>
        <span class="titulo">&nbsp;&nbsp;NUEVA RUTA</span><br><br>
        <form id="frmRuta">
            
            <table>
                <tr>
                    <td>Ruta:</td>
                    <td><textarea id="txtRuta" name="txtRuta" readonly="readonly" cols="70" rows="1" ></textarea><input type="hidden" id="txtRutaID" name="txtRutaID"></td>
                </tr>
                <tr>
                    <td>Destino:</td>
                    <td>
                        <select id='selectDestino' class="selectDestino" name='selectDestino'>
                            <?php $model->getCombolModelASC("destinos", "descripcion") ?>
                        </select>&nbsp;&nbsp;&nbsp;<input id="btnAgregar" type="button" value="AÑADIR">
                    </td>
                </tr>

            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>&nbsp;&nbsp;&nbsp;<button id="btnBorrar">BORRAR</button>
    </div>
</div>