<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevaDeuda">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVA DEUDA</span><br><br>
        <form id="frmDeuda">
            <table>
                <input name="idConductor" type="hidden" value="<?php echo $_GET['conductor_id'] ?>">
                <tr>
                    <td>Concepto:</td>
                    <td><input id="txtConcepto" name="txtConcepto"></td>
                </tr>
                <tr>
                    <td>Monto:</td>
                    <td><input id="txtMonto" name="txtMonto"></td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>
