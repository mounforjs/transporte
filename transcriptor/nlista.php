<?php
session_start();
require_once '../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevoLista">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVA LISTA</span><br><br>
        <form id="frmLista">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtDescripcion" name="txtDescripcion"></td>
                </tr>

            </table>
                
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>