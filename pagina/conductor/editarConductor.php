<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
$id=$_GET['id'];
unset($_SESSION['idConductor']);
$_SESSION['idConductor']=$id;
$conductor=$model->getModel($id, "conductores");
?>

<div id="divPopUp">
    <div id="divNuevoConductor">
        <br>
        <span class="titulo">&nbsp;&nbsp;EDITAR CONDUCTOR</span><br><br>
        <form id="frmConductor">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtNombre" name="txtNombre" value="<?php echo $conductor['nombre'] ?>"></td>
                </tr>
                <tr>
                    <td>Teléfono:</td>
                    <td><input id="txtTelefono" name="txtTelefono" value="<?php echo $conductor['telefono'] ?>"></td>
                </tr>
                <tr>
                    <td>Dirección:</td>
                    <td><input id="txtDireccion" name="txtDireccion" value="<?php echo $conductor['direccion'] ?>"></td>
                </tr>
                <tr>
                    <td>Cédula:</td>
                    <td><input id="txtCedula" name="txtCedula" value="<?php echo $conductor['cedula'] ?>"></td>
                </tr>
                <tr>
                    <td>Descripción Vehículo:</td>
                    <td><textarea id="txtVehiculo" name="txtVehiculo" cols="40" rows="5"><?php echo $conductor['vehiculo'] ?></textarea></td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>