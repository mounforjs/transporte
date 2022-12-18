<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userclass
 *
 * @author aarenas
 */

require_once CLASES.'/model.php';

class User extends model {

    private $username;
    private $password;

    public function cargarUser($username)
    {
        $id=$this->getId("Users", "username", "'".$username."'");
        $arrUser=$this->getModel($id, "Users");
        $this->username=$arrUser['username'];
        $this->password=$arrUser['password'];
    }

    public function comprobarSession($username,$password)
    {
        $r="true";


        $query="SELECT username,rol,password FROM users WHERE username ILIKE '%".pg_escape_string($username)."%' and password='".md5(pg_escape_string($password))."'";
      

        $result = pg_query($query);
        $arrUser = pg_fetch_array($result);

        if(pg_num_rows($result)<1){
            $r="false";
          
        }else{
            $_SESSION['username']=$username;
            $_SESSION['password']=$password;
            $r.="-".$arrUser['rol']."-".strtolower($arrUser['username']);
        }
        return $r;
    }

    function getUsername()
    {
       return $this->username;
    }

    function setUsername($username)
    {
        $this->username=$username;
    }

    function getPassword()
    {
        return $this->password;
    }

}
?>
