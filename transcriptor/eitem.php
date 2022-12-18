<?php
session_start();
require_once '../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();

$id=$_GET['id'];
$item=$model->getModel($id, "listas_rutas");

?>

<div id="divPopUp">
    <div id="divNuevoItem">
        <br>
        <span class="titulo">&nbsp;&nbsp;ACTUALIZAR PRECIOS</span><br><br>
        <form id="frmItem">
            <table>
                <tr>
                    <td>Destino:</td>
                    <td>
                        <select id='selectRuta' class="selectDestino" name='selectRuta'>
                            <?php $model->getComboSelected("rutas", "descripcion", $item['ruta_id']) ?>
                        </select>
                    </td>
                </tr>
            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">ACTUALIZAR</button>
    </div>
</div>