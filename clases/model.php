<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model
 *
 * @author aarenas
 */
class model
{
    function begin()
    {
        pg_query("begin");
    }

    function commit()
    { 
        pg_query("commit");
    }

    function rollback()
    {
        pg_query("rollback");
    }

    function getId($tabla,$campo,$descripcion)
    {
        $query="SELECT id FROM ".$tabla." WHERE $campo=".$descripcion;
        $result=pg_query($query);
        $id=pg_fetch_array($result);
        $id=$id['id'];
        return $id;
    }

    function getModel($id,$tabla)
    {
        $query="SELECT * FROM ".$tabla." WHERE id=$id";
        //echo $query;

        $result=pg_query($query);
        if(pg_num_rows($result)>=1){
            $arrModel=pg_fetch_assoc($result);
            return $arrModel;
        }else{
            return false;
        }
        
    }

    function getModelCondicionadoId($id,$tabla,$condiciones)
    {
        $query="SELECT * FROM ".$tabla." WHERE id=$id and ".$condiciones;
        $result=pg_query($query);
        $arrModel=pg_fetch_array($result);
        return $arrModel;
    }

    function getModelCondicionado($tabla,$condiciones)
    {
        $query="SELECT * FROM ".$tabla." WHERE ".$condiciones;
        //echo $query;
        $result=pg_query($query);
        if($result){
            $arrModel=pg_fetch_array($result);
            return $arrModel;
        }else{
            return false;
        }
        
    }

    function getTotal($tabla,$campoTotal,$id,$campo)
    {
        $query="SELECT SUM($campoTotal) as total FROM ".$tabla." WHERE $campo=".$id;
        $result=pg_query($query);
        //echo $query;
        $total=pg_fetch_array($result);
        $total=$total['total'];
        return $total;
    }

    function getTotalCondicionado($tabla,$campoTotal,$condiciones)
    {
        $query="SELECT SUM($campoTotal) as total FROM ".$tabla." WHERE ".$condiciones;
        $result=pg_query($query);
        //echo $query;
        $total=pg_fetch_array($result);
        $total=$total['total'];
        return $total;
    }


    function getList($tabla,$limit){
        $query="SELECT * FROM ".$tabla." LIMIT ".$limit;
        //echo $query;
        $result=pg_query($query);
        if(pg_num_rows($result)>=1){
            return $result;
        }else{
            return false;
        }
            
    }

    function getListCondicional($tabla,$limit,$condicion){
        $query="SELECT * FROM ".$tabla." WHERE $condicion LIMIT ".$limit;
      
        $result=pg_query($query);
        if(pg_num_rows($result) >= 1){

            return $result;
        }else{
            return false;
        }

    }

    public function getOrdererList($tabla, $limit, $order)
    {
        $query="SELECT * FROM ".$tabla." $order LIMIT ".$limit;
      
        $result=pg_query($query);
        if(pg_num_rows($result)>=1){

            return $result;
        }else{
            return false;
        }
    }

    function proximoId($tabla)
    {
        $query="SELECT max(id) as id FROM ".$tabla;
        $result=pg_query($query);
        $id=pg_fetch_array($result);
        $id=$id['id']++;
        return $id;
    }

    function getComboSelected($tabla,$campo,$id)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla;
        $result=pg_query($query);
        $r="";

        while($reg=pg_fetch_array($result)){

            if($id==$reg['id'])
                $r.="<option value=".$reg['id']." selected>".$reg[$campo]."</option>";
            else
                $r.="<option value=".$reg['id'].">".$reg[$campo]."</option>";
        }

        echo $r;
    }

        function getCombolModelAlias($tabla,$campo,$alias)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla;
        $result=pg_query($query);

        $r="";
        while($reg=pg_fetch_array($result)){
            $r.="<option value=".$reg['id'].">".$reg[$alias]."</option>";
        }

        echo $r;
    }

    function getCombolModel($tabla,$campo)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla." ORDER BY($campo) DESC";
        $result=pg_query($query);
        
        $r="";
        //$r.="<option></option>";
        while($reg=pg_fetch_array($result)){
            $r.="<option value=".$reg['id'].">".$reg[$campo]."</option>";
        }

        echo $r;
    }

    function getCombolModelASC($tabla,$campo)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla." ORDER BY($campo) ASC";
        $result=pg_query($query);
        
        $r="";
        //$r.="<option></option>";
        while($reg=pg_fetch_array($result)){
            $r.="<option value=".$reg['id'].">".$reg[$campo]."</option>";
        }

        echo $r;
    }

    function getCombolModelListas($tabla,$campo)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla." ORDER BY(id) DESC";
        $result=pg_query($query);
        
        $r="";
        //$r.="<option></option>";
        while($reg=pg_fetch_array($result)){
            $r.="<option value=".$reg['id'].">".$reg['id']." - ".$reg[$campo]."</option>";
        }

        echo $r;
    }

    function getComboSelectedListas($tabla,$campo,$id)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla." ORDER BY(id) DESC";
        $result=pg_query($query);
        $r="";

        while($reg=pg_fetch_array($result)){

            if($id==$reg['id'])
                $r.="<option value=".$reg['id']." selected>".$reg['id']." - ".$reg[$campo]."</option>";
            else
                $r.="<option value=".$reg['id'].">".$reg['id']." - ".$reg[$campo]."</option>";
        }

        echo $r;
    }

     function getCombolModelReturn($tabla,$campo)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla." ORDER BY($campo) ASC";
        $result=pg_query($query);

        $r="";
        //$r.="<option></option>";
        while($reg=pg_fetch_array($result)){
            $r.="<option value=".$reg['id'].">".$reg[$campo]."</option>";
        }

        return $r;
    }

    function getCombolModelViajeDepartamento($tabla,$campo,$idViaje)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla." ORDER BY($campo) ASC";
        $result=pg_query($query);

        $r="";
        //$r.="<option></option>";
        while($reg=pg_fetch_array($result)){
            $r.="<option value='$idViaje"."-".$reg['id']."'>".$reg[$campo]."</option>";
        }

        return $r;
    }

    function getCombolModelCondicional($tabla,$campo,$condicion)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla." WHERE $condicion ORDER BY($campo) ASC";
        $result=pg_query($query);
		//echo $query;
        $r="";
        //$r.="<option></option>";
        while($reg=pg_fetch_array($result)){
            $r.="<option value='".$reg['id']."'>".$reg[$campo]."</option>";
        }

        return $r;
    }

    function getCombolModelDESC($tabla,$campo)
    {
        $query="SELECT id, ".$campo." FROM ".$tabla."  ORDER BY id DESC";
        $result=pg_query($query);
        //echo $query;
        $r="";
        //$r.="<option></option>";
        while($reg=pg_fetch_array($result)){
            $r.="<option value='".$reg['id']."'>".$reg[$campo]."</option>";
        }

        return $r;
    }

    function getDescripcionTable($table,$id,$campo)
    {
        $query="SELECT ".$campo." FROM ".$table." WHERE id=".$id;
//      echo $query;
        $result=pg_query($query);
        $descripcion=pg_fetch_array($result);
        $descripcion=$descripcion[$campo];
        return $descripcion;
    }

    function getDescripcionTableCondicional($table,$condiciones,$campo)
    {
        $query="SELECT ".$campo." FROM ".$table." WHERE ".$condiciones;
        $result=pg_query($query);
		
		if($result){
			$descripcion=pg_fetch_array($result);
	        $descripcion=$descripcion[$campo];
	        return $descripcion;
		}else{
		
			return false;
		}
		
        
    }

    function existe($tabla,$campo,$valor)
    {
        $r=false;

        $query="SELECT * FROM ".$tabla." WHERE $campo=".$valor;
        $result=pg_query($query);
        if(pg_num_rows($result)>=1)
        {
           $r=true;
        }

        return $r;
    }

    function existeCondiciones($tabla,$campo,$valor,$condiciones)
    {
        $r=false;

        $query="SELECT * FROM ".$tabla." WHERE $campo=".$valor." and $condiciones";
        $result=pg_query($query);
        if(pg_num_rows($result)>=1)
        {
           $r=true;
        }

        return $r;
    }

    function delete($tabla,$campo,$valor)
    {
        $query="DELETE FROM ".$tabla." WHERE $campo=".$valor;
        //echo $query;
        $result=pg_query($query);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    function jsRedirect($url)
    {
	echo "<script language='JavaScript' type='text/javascript'>location.href='$url';</script>";
    }

    function getIp()
    {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip=getenv('HTTP_X_FORWARDED_FOR');
        }
        else {
                $ip=getenv('REMOTE_ADDR');
        }
        return $ip;
    }

    function superGlobals()
    {

	echo "<br><br>_GET";
	foreach($_GET as $clave=>$valor)
	{
		echo $clave." = ".$valor."<br>";
	}
	echo "<br><br>_POST";
	foreach($_POST as $clave=>$valor)
	{
		echo $clave." = ".$valor."<br>";
	}
	echo "<br><br>_SESSION";
	foreach($_SESSION as $clave=>$valor)
	{
		echo $clave." = ".$valor."<br>";
	}
    }

    function save($tabla,$datos)
    {
        
        $keys=array_keys($datos);
        $i = 0;
        $keysArr = "";
        $datosArr = "";

        foreach($keys as $key)
        {
            if($i==0)
                $keysArr.=$key;
            else
                $keysArr.=",".$key;
           $i++;
        }

        $i=0;
        foreach($datos as $valor)
        {
            if($i==0)
                $datosArr.=$valor;
            else
                $datosArr.=",".$valor;
           $i++;
        }
        
        $query="INSERT INTO $tabla ($keysArr) values ($datosArr)";
        //echo $query;
        $result = pg_query($query);

        

        if($result){
            return true;
        }else{
            return false;
        }

    }

    function saveId($tabla,$datos)
    {
        
        $keys=array_keys($datos);
        $i=0;
        $keysArr="";
        $datosArr="";

        foreach($keys as $key)
        {
            if($i==0)
                $keysArr.=$key;
            else
                $keysArr.=",".$key;
           $i++;
        }

        $i=0;
        foreach($datos as $valor)
        {
            if($i==0)
                $datosArr.=$valor;
            else
                $datosArr.=",".$valor;
           $i++;
        }
        
        $query="INSERT INTO $tabla ($keysArr) values ($datosArr) RETURNING id";
        //echo $query;
        $result =  pg_query($query);
        $r = pg_fetch_object($result);
        

        if($r){
            return $r;
        }else{
            return false;
        }

    }

    function update($tabla,$campo,$datos,$id)
    {
        $i=0;
        $r="";
        
        foreach($datos as $indice=>$valor)
        {
            if($i==0)
                $r.=$indice."=".$valor;
            else
                $r.=", ".$indice."=".$valor;
           $i++;
        }

        $query="UPDATE $tabla SET $r  WHERE $campo=$id";
        //echo $query;
        $result=pg_query($query);

        if($result){
            
            return true;
        }else{
            return false;
        }
       
    }

    function convertFechaSQLPostgres($fecha)
    {
        if($fecha==""){
            return "DEFAULT";
        }else{
            return "to_timestamp('".$fecha."','DD/MM/YYYY')";
        }
    }
    
    function convertFechaSQLPostgresEN($fecha)
    {
        if($fecha==""){
            return "DEFAULT";
        }else{
            return "to_timestamp('".$fecha."','YYYY/MM/DD')";
        }
    }

    function fechaVE($fecha){

        if(!empty($fecha))
        {
            $fechaArr = explode('-',$fecha);
            list($año,$mes,$dia)=$fechaArr;
            $r=$dia."-".$mes."-".$año;
            return $r;
        }else{
            return "";
        }
        
    }

    function fechaPostgres($fecha){
        $fechaArr = explode('/',$fecha);
        list($año,$mes,$dia)=$fechaArr;
        $r=$año."-".$mes."-".$dia;
        return "'".$r."'";
    }

    function printArray($arr)
    {
       echo "<pre>";
       print_r($arr);
       echo "</pre>";
    }

    function count($tabla,$campo,$condiciones){
        $query="SELECT COUNT($campo) as total FROM ".$tabla." WHERE ".$condiciones;
        $result=pg_query($query);
        //echo $query;
        $total=pg_fetch_array($result);
        $total=$total['total'];
        if($total==""){
            $total=0;
        }

        return $total;
    }
}
?>
