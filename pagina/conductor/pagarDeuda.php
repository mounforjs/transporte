<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divPagarDeuda">
        <br>
        <span class="titulo">&nbsp;&nbsp;PAGAR DEUDA</span><br><br>
        <form id="frmPagar">
            <input id="id" name="id" type="hidden" value="<?php echo $_GET['id'] ?>">
            <table>
                <tr>
                    <td>Monto a Cancelar:</td>
                    <td><input id="txtMontoCancelar" name="txtMontoCancelar"></td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>
