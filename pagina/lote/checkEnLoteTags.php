<?php
session_start();
require_once '../../rutas.php';
require_once DB;
require_once CLASES.'/model.php';
$model=new model();
abrirConexion();
?>
<head>
     
<script>

    $().ready(function(){
        $("#txtTags").attr("readonly","readonly");
    });

</script>

</head>


<div id="divPopUp">
    <div id="divNuevaRuta">
        <br>
        <span class="titulo">&nbsp;&nbsp;VERIFICAR VIAJES EN LOTE</span><br><br>
        <form id="frmViajesTagsCheck">
            <textarea id="txtTags" name="txtTags" cols="80" rows="5"></textarea><br>
            <select id="selectLote" name="selectLote">
                    <?php echo $model->getCombolModelCondicional("lotes", "descripcion","estado=1") ?>
            </select>
        </form>

        <button id="btnRegistrarTags">VERIFICAR</button>
    </div>
</div>