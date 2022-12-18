<?php
session_start();
require_once '../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model = new model();
abrirConexion();
?>


<div id="divPopUp">
    <div id="divNuevoItem">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVO ITEM</span><br><br>
        <form id="frmItem">

         <select class="js-example-basic-multiple" multiple="multiple">
                  <option value="AL">Alabama</option>
                    ...
                  <option value="WY">Wyoming</option>
                </select>
            <table>
                <tr>
                    <td>Destino:</td>
                    <td>
                        <select id='selectRuta' class="selectDestino" name='selectRuta'>
                            <?php $model->getCombolModel("rutas", "descripcion") ?>
                        </select>
                    </td>
                </tr>


            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>