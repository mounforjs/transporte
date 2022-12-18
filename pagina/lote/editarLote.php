<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
$id=$_GET['id'];
unset($_SESSION['idLote']);
$_SESSION['idLote']=$id;
$lote=$model->getModel($id, "lotes");
?>

<div id="divPopUp">
    <div id="divNuevoLote">
        <br>
        <span class="titulo">&nbsp;&nbsp;EDITAR LOTE</span><br><br>
        <form id="frmLote">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtDescripcion" name="txtDescripcion" value="<?php echo $lote['descripcion'] ?>"></td>
                </tr>
                <tr>
                    <td>Nº Factura:</td>
                    <td><input id="txtFactura" name="txtFactura" value="<?php echo $lote['nfactura'] ?>"></td>
                </tr>
                 <tr>
                    <td><strong>Empresa:</strong></td>
                    <td>
                        <select id='selectEmpresa' name='selectEmpresa'>
                            <?php $model->getComboSelected("empresas", "nombre",$lote['empresa_id']) ?>
                        </select>
                    </td>
                </tr>
                
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>