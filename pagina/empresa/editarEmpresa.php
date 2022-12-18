<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
$id=$_GET['id'];
unset($_SESSION['idEmpresa']);
$_SESSION['idEmpresa']=$id;
$empresa=$model->getModel($id, "empresas");
?>

<div id="divPopUp">
    <div id="divNuevoEmpresa">
        <br>
        <span class="titulo">&nbsp;&nbsp;EDITAR EMPRESA</span><br><br>
        <form id="frmEmpresa">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtNombre" name="txtNombre" value="<?php echo $empresa['nombre'] ?>"></td>
                </tr>
                <tr>
                    <td>RIF :</td>
                    <td><input id="txtRif" name="txtRif" value="<?php echo $empresa['rif'] ?>"></td>
                </tr>
                <tr>
                    <td>Dirección :</td>
                    <td><input id="txDireccion" name="txtDireccion" value="<?php echo $empresa['direccion'] ?>"></td>
                </tr>
            </table>
                
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>