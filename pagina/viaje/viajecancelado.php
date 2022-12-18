<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divViajeCancelado">
        <br>
        <span class="titulo">&nbsp;&nbsp;VIAJE CANCELADO</span><br><br>
        <form id="frmViajeCancelado">
            <table>
                <tr>
                    <td>Motivos:</td>
                    <td>
                        <textarea id="txtObservaciones" name="txtObservaciones" cols="40"></textarea>
                    </td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>