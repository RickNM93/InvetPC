<?php
/* Set oracle user login and password info */
$db = oci_connect("invetpc","1234","//localhost/xe");
if (!$db)  {
    echo "An error occurred connecting to the database"; 
    exit; 
}

$user = $_POST['user'];
$pass = $_POST['pass'];

$sql_login = "SELECT adm_nom , adm_pass FROM administrador WHERE adm_nom like '%".$user."%'"; 

$login_stmt = oci_parse($db, $sql_login);

if(!$login_stmt)
{
    echo "An error occurred in parsing the sql string.\n"; 
    exit; 
}

oci_execute($login_stmt);

while(oci_fetch_array($login_stmt)){
    $password = oci_result($login_stmt,'ADM_PASS');
}

if ($pass == $password)
{
	header('Location: index_2.php');
	exit;}
else
{
   echo 'Usuario o Contraseña Incorrectos';
}


?>