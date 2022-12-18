<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevoDepartamento">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVO DEPARTAMENTO</span><br><br>
        <form id="frmDepartamento">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtNombre" name="txtNombre"></td>
                </tr>
                <tr>
                    <td>Código:</td>
                    <td><input id="txtCodigo" name="txtCodigo"></td>
                </tr>
                <tr>
                    <td><strong>Empresa:</strong></td>
                    <td>
                        <select id='selectEmpresa' name='selectEmpresa'>
                            <?php $model->getCombolModel("empresas", "nombre") ?>
                        </select>
                    </td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>