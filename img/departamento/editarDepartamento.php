<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
$id=$_GET['id'];
unset($_SESSION['idDepartamento']);
$_SESSION['idDepartamento']=$id;
$departamento=$model->getModel($id, "departamentos");
?>

<div id="divPopUp">
    <div id="divEditarDepartamento">
        <br>
        <span class="titulo">&nbsp;&nbsp;EDITAR DEPARTAMENTO</span><br><br>
        <form id="frmDepartamento">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtNombre" name="txtNombre" value="<?php echo $departamento['nombre'] ?>"></td>
                </tr>
                <tr>
                    <td>Código:</td>
                    <td><input id="txtCodigo" name="txtCodigo" value="<?php echo $departamento['codigo'] ?>"></td>
                </tr>
                <tr>
                    <td><strong>Empresa:</strong></td>
                    <td>
                        <select id='selectEmpresa' name='selectEmpresa'>
                            <?php $model->getComboSelected("empresas", "nombre", $departamento['empresa_id']) ?>
                        </select>
                    </td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>