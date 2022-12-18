<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
$id=$_GET['id'];
$viaje=$model->getModel($id, "viajes");

?>

<div id="divPopUp">
    <div id="divViajeTerminado">
        <br>
        <span class="titulo">&nbsp;&nbsp;VIAJE TERMINADO</span><br><br>
        <form id="frmViajeTerminado">
            <table>
                <tr>
                    <td>Horas de Espera:</td>
                    <td>
                        <input type="text" name="txtHoras" id="txtHoras" value="<?php echo $viaje['horas_espera'] ?>">
                    </td>
                </tr>
                <tr>
                    <td>Nº Solicitud:</td>
                    <td>
                        <input type="text" name="txtNSolicitud" id="txtNSolicitud">
                    </td>
                </tr>
                
                <tr>
                    <td>Observaciones:</td>
                    <td>
                        <textarea id="txtObservaciones" name="txtObservaciones" cols="30"><?php echo $viaje['observaciones'] ?></textarea>
                    </td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>