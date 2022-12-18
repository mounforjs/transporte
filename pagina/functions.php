<?php
function comprobarSession($username,$password)
{
    $r=true;

    $query="SELECT username,rol,password FROM users WHERE username ILIKE '".$username."%' and password='".md5($password)."'";
    $result=pg_query($query);
    $arrUser=pg_fetch_array($result);

    if(pg_num_rows($result)<1 || $arrUser['rol']!="Administrador"){
        $r=false;
    }else{
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    }
    return $r;
}


function comprobarSessionTranscriptor($username,$password)
{
    $r=true;

    $query="SELECT username,rol,password FROM users WHERE username ILIKE '".pg_escape_string($username)."%' and password='".md5(pg_escape_string($password))."'";
    $result=pg_query($query);
    $arrUser=pg_fetch_array($result);

    if(pg_num_rows($result)<1 && ($arrUser['rol'] == "Administrador" || $arrUser['rol'] == "Transcriptor"))
    {
        $r = false;
    }else{
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    }
    return $r;
}

function comprobarSessionDepartamento($username,$password)
{
    $r=true;

    $query="SELECT username,rol,password FROM users WHERE username ILIKE '".$username."%' and password='".md5($password)."'";
    $result=pg_query($query);
    $arrUser=pg_fetch_array($result);

    if(pg_num_rows($result)<1){
        $r=false;
    }else{
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    }
    return $r;
}

?>
