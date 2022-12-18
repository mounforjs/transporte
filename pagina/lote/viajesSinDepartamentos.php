<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>

<div id="divPopUp">
    <div id="divNuevoLote">
        <br>
        <span class="titulo">&nbsp;&nbsp;VIAJES SIN DEPARTAMENTO</span><br><br>
        <form id="frmViajesSinDepartamento">
            <table id="good" width="700px" cellspacing="0">

            </table>
        </form>

        &nbsp;&nbsp;&nbsp;<button id="btnRegistrarSinDepartamentos">REGISTRAR</button>
    </div>
</div>