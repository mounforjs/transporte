<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevoDestino">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVO DESTINO</span><br><br>
        <form id="frmDestino">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtNombreDestino" name="txtNombreDestino"></td>
                </tr>
                <tr>
                    <td>Estado:</td>
                    <td>
                        <select id='selectEstado' name='selectEstado'>
                            <?php $model->getCombolModel("estados", "nombre") ?>
                        </select>
                    </td>
                </tr>

            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>