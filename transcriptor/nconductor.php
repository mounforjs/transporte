<?php
session_start();
require_once '../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevoConductor">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVO CONDUCTOR</span><br><br>
        <form id="frmConductor">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtNombre" name="txtNombre"></td>
                </tr>
                <tr>
                    <td>Teléfono:</td>
                    <td><input id="txtTelefono" name="txtTelefono"></td>
                </tr>
                <tr>
                    <td>Dirección:</td>
                    <td><input id="txtDireccion" name="txtDireccion"></td>
                </tr>
                <tr>
                    <td>Cédula:</td>
                    <td><input id="txtCedula" name="txtCedula"></td>
                </tr>
                <tr>
                    <td>Descripción Vehículo:</td>
                    <td><textarea id="txtVehiculo" name="txtVehiculo" cols="40" rows="5"></textarea></td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>