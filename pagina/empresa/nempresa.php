<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevoEMPRESA">
        <br>
        <span class="titulo">&nbsp;&nbsp;NUEVO EMPRESA</span><br><br>
        <form id="frmEmpresa">
            <table>
                <tr>
                    <td>Nombre:</td>
                    <td><input id="txtNombre" name="txtNombre"></td>
                </tr>
                <tr>
                    <td>RIF :</td>
                    <td><input id="txtRif" name="txtRif"></td>
                </tr>
                <tr>
                    <td>Dirección :</td>
                    <td><input id="txDireccion" name="txtDireccion"></td>
                </tr>
            </table>
                
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrar">REGISTRAR</button>
    </div>
</div>