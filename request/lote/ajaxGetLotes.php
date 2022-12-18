<?php
session_start();
require_once '../../rutas.php';
require_once CLASES.'/lista.php';
require_once DB;
abrirConexion();

$r="<tr class='tableTitle'>
    <td>ID</td>
    <td>Descripcion</td>
	<td width='100px'>Fecha</td>
    <td>Nº Factura</td>
    <td>Lote</td>
    <td>Estado</td>
    <td></td>
    <td width='280px'>Acciones</td>
</tr>
";

$lista=new Lista();
$list=$lista->getListCondicional("lotes", 300, "estado=".$_POST['status']." ORDER BY id DESC");

if($list!=false){

    while($row=pg_fetch_array($list)){
        
        extract($row);

        $empresa=$lista->getDescripcionTable("empresas", $empresa_id, "nombre");

        if($estado==1){
            $etiquetaEstado="<td></td>";
            $trPago="<td><input type='checkbox' id='chkPago' name='chkPago[]' value='$id'></td>";

        }else if($estado==3){
            $etiquetaEstado="<td></td>";
            $trPago="<td><input type='checkbox' id='chkPago' name='chkPago[]' value='$id'></td>";
        }else{
            $etiquetaEstado="<td></td>";
            $trPago="<td><a id=$id name='sinPago'>Deshacer</a></td>";
        }


        $r.="<tr id=$id>
        <td>$id</td>
        <td>$descripcion</td>
		<td>".$lista->fechaVE($fecha)."</td>
        <td>$nfactura</td>
        <td>$empresa</td>
        $etiquetaEstado
        $trPago
        <td><a id='".$id."' name='visualizarLote' href='visualizarLote.php?id=$id"."&empresa=$empresa_id'>Visualizar lote</a>&nbsp;&nbsp;&nbsp;<a id='".$id."' name='eliminar'>Eliminar</a>&nbsp;&nbsp;<a id='".$id."' name='editar'>Editar</a></td>
      </tr>";
    }
}
cerrarConexion();
//<a id='".$id."' name='editarDestino' href='../pagina/editUsuario.php?idDestino=".$id."&descripcion=".$descripcion."'>Editar</a>&nbsp;&nbsp;

echo $r;
?>

