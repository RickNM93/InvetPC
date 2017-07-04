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
                <h1>Eliminar Estado</h1>
<?php

	$conn = oci_connect("invetpc","1234","//localhost/xe");
    $stmt = oci_parse($conn, "select * from administrador");
    $r = oci_execute($stmt);
    $nrows = oci_fetch_all($stmt, $results);
    if($nrows>0){
        echo "<table border><tr><th>Nombre</th><th>RUT</th><th>Contraseña</th><th>Correo</th></tr>";
		for ($i = 0; $i < $nrows; $i++){
			echo "<tr>\n";
			foreach ($results as $data) {
				echo "<td>$data[$i]</td>\n";
			}
		echo "</tr>\n";
		}
		echo "</table>";
	}



	$rut = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		  if (empty($_POST["rut"])) {
		    $iderr = "Ingresar Rut";
		  }
	  else {
	   	 $rut = test_input($_POST["rut"]);
	  }
	}
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}


?>




  <br><br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Ingrese RUT del Administrador a eliminar: <input type="text" name="rut" value="<?php echo $rut;?>">

  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>


<?php

	if ($rut != ""){
	 //	$conn = oci_connect("invetpc","1234","//localhost/xe");
		$s = oci_parse($conn, "call pro_mant_administrador('E', 'n', :bid, 'no', 'B')");
		oci_bind_by_name($s, ":bid", $rut);
		oci_execute($s);
		echo "Eliminado Correctamente";
	}
	else{
		echo "waiting";
	}
?>   

            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
