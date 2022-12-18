<?php
session_start();
require_once '../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
$id=$_GET['id'];
unset($_SESSION['idLista']);
$_SESSION['idLista']=$id;
$lista=$model->getModel($id, "listas");
?>

<div id="divPopUp">
    <div id="divNuevoLista">
        <br>
        <span class="titulo">&nbsp;&nbsp;EDITAR LISTA</span><br><br>
        <form id="frmLista">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtDescripcion" name="txtDescripcion" value="<?php echo $lista['descripcion'] ?>"></td>
                </tr>
            </table>
                
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>