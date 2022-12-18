<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
require_once CLASES.'/viaje.php';
$model=new viaje();
abrirConexion();

?>



<div id="divPopUp">
    <div id="divNuevoPasajero">
        <br><br>
        <span class="titulo">&nbsp;&nbsp;ABONOS DEUDA <?php echo $_GET['id'] ?></span><br><br>

        <table id="tableAbonos" width="500px" cellspacing="0" class="testilo">
            <tr class="tableTitle">
                <td>ID</td>
                <td>Monto</td>
                <td>fecha</td>
            </tr>
        </table><br><br>
            

    </div>
</div>