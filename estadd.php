<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>InvetPC</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/logo-nav.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="logo.png" alt="" height="55">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index_2.php">Inicio</a>
                    </li>
                    <li>
                        <a href="admins.php">Cuentas de Administrador</a>
                    </li>
                    <li>
                        <a href="audadm.php">Auditoria de Administrador</a>
                    </li>
                    <li>
                        <a href="estados.php">Estados de Venta</a>
                    </li>
                    <li>
                        <a href="rsucur.php">Resumen de Sucursales</a>
                    </li>
                    <li>
                        <a href="venta.php">Realizar Venta</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Agregar Estado</h1>

<?php

	$id = $descrip = "";   //DEJA LAS VARIABLES DE ID Y DESCRIPCION VACIAS

	if ($_SERVER["REQUEST_METHOD"] == "POST") {   //PARA RECIBIR LO INGRESADO EN EL FORMULARIO HTML DE MAS ABAJO
		  if (empty($_POST["id"])) {
		    $iderr = "Ingresar ID";
		  }
	  else {
	   	 $id = test_input($_POST["id"]);
	  }
	}
	 if ($_SERVER["REQUEST_METHOD"] == "POST") {   //PARA RECIBIR LO INGRESADO EN EL FORMULARIO HTML DE MAS ABAJO
	  if (empty($_POST["descrip"])) {
	    	$deserr = "Ingresar descripcion";
	  }
	  else {
	   	 $descrip = test_input($_POST["descrip"]);
	  }
	 }


	function test_input($data) {    //FUNCIONES PARA PASAR PARAMETROS DESDE HTML HASTA PHP
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

?>
  <br><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">    <!--FORMULARIO EN HTML PARA INGRESAR DATOS EN HTML-->
  Id: <input type="text" name="id" value="<?php echo $id;?>">

  <br><br>
  Descripcion: <input type="text" name="descrip" value="<?php echo $descrip;?>">

  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>




<?php

	if ($id != ""){
		$conn = oci_connect("invetpc","1234","//localhost/xe");   //CONEXION A ORACLE
		$s = oci_parse($conn, "call pro_mant_estado(:bid, :bds, 'C')");  //VARIABLE CON EL LLAMADO 'CALL' AL PROCEDIMIENTO, EN ESTE CASO VA CON UNA C YA QUE CON ESTA OPCION, SE CREAN DATOS EN LA TABLA
		oci_bind_by_name($s, ":bid", $id);   //NECESARIA PARA PASAR LA VARIABLE 'ID' AL LLAMADO DEL PROCEDIMIENTO, $id PASA A SER :bid
		oci_bind_by_name($s, ":bds", $descrip);
		oci_execute($s);
		echo "Agrregado Correctamente";  //MENSAJE DE EXITO
	}
	else{
		echo "waiting";  //MENSAJE DE ESPERA MIENTRAS NO SE REALICE EL PROCEDIMIENTO
	}
?>   
<br>
            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
