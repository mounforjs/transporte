<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevoPasajero">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVO PASAJERO</span><br><br>
        <form id="frmPasajero">
            <table>

                <tr>
                            <td><strong>Pasajero:</strong></td>
                            <td>
                                <input id="selectPasajero" name="selectPasajero" type="text" >
                                <span id="selectPasajeroLabel"></span>
                            </td>
               </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrarPasajero">INCLUIR EN EL VIAJE</button>
    </div>
</div>