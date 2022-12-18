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
                    <td><strong>Empresa:</strong></td>
                    <td>
                        <select id='selectEmpresa' name='selectEmpresa'>
                            <?php $model->getCombolModel("empresas", "nombre") ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><strong>Departamento:</strong></td>
                    <td>
                        <select id='selectDepartamento' name='selectDepartamento'>
                            <?php $model->getCombolModelAlias("departamentos", "(nombre || ' - ' || codigo) as departamento","departamento") ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input id="txtEmail" name="txtEmail"></td>
                </tr>

            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>