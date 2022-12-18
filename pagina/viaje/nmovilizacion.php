<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevaMovilizacion">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVA MOVILIZACIÓN</span><br><br>
        <form id="frmMovilizacion">
            <table>
                <tr>
                    <td>Descripcrición:</td>
                    <td>
                        <textarea id="txtDescripcion" name="txtDescripcion" cols="60"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Precio:</td>
                    <td>
                        <input id="txtPrecio" name="txtPrecio">
                    </td>
                </tr>
                <tr>
                    <td>Pago(Conductor):</td>
                    <td>
                        <input id="txtPago" name="txtPago">
                    </td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrarMovilizacion">REGISTRAR MOVILIZACIÓN</button>
    </div>
</div>