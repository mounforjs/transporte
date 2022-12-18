<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
$id=$_GET['id'];
unset($_SESSION['idPasajero']);
$_SESSION['idPasajero']=$id;
$pasajero=$model->getModel($id, "pasajeros");
?>

<div id="divPopUp">
    <div id="divNuevoPasajero">
        <br>
        <span class="titulo">&nbsp;&nbsp;EDITAR PASAJERO</span><br><br>
        <form id="frmPasajero">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtNombre" name="txtNombre" value="<?php echo $pasajero['nombre'] ?>"></td>
                </tr>
                <tr>
                    <td>Teléfono:</td>
                    <td><input id="txtTelefono" name="txtTelefono" value="<?php echo $pasajero['telefono'] ?>"></td>
                </tr>
                <tr>
                    <td>Dirección:</td>
                    <td><input id="txtDireccion" name="txtDireccion" value="<?php echo $pasajero['direccion'] ?>"></td>
                </tr>
                <tr>
                    <td><strong>Empresa:</strong></td>
                    <td>
                        <select id='selectEmpresa' name='selectEmpresa'>
                            <?php $model->getComboSelected("empresas", "nombre",$pasajero['empresa_id']) ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Departamento:</strong></td>
                    <td>
                        <select id='selectDepartamento' name='selectDepartamento'>
                            <?php $model->getComboSelected("departamentos", "nombre",$pasajero['departamento_id']) ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input id="txtEmail" name="txtEmail" value="<?php echo $pasajero['email'] ?>"></td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>