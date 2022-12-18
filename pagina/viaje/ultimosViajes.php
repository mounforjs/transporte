<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/viaje.php';
$viaje=new viaje();
abrirConexion();
?>

<div id="divPopUp">
    <div id="ultimosViajes">
        <br><br>
        <span class="titulo">ÚLTIMOS 15 VIAJES REGISTRADOS</span>
        <br><br>
        <table id="tablaUltimosViajes" width="600" cellspacing="0" class="43" >
            <tr class="tableTitle" >
                <td>ID</td>
                <td>Fecha</td>
                <td>Ruta</td>
                <td>Estado</td>
                <td>Conductor</td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
            </tr>
        </table>

    </div>
</div>