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
                        <a href="#">Realizar Venta</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Componentes</h1>


<?php

    $conn = oci_connect("invetpc","1234","//localhost/xe");
    $stmt = oci_parse($conn, "select * from componente");
    $r = oci_execute($stmt);
    $nrows = oci_fetch_all($stmt, $results);
    if($nrows>0){
        echo "<table border><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Descripcion</th><th>Sucursal</th><th>Fabricante</th><th>Tipo</th></tr>";
        for ($i = 0; $i < $nrows; $i++){
            echo "<tr>\n";
            foreach ($results as $data) {
                echo "<td>$data[$i]</td>\n";
            }
        echo "</tr>\n";
        }
        echo "</table>";
    }
?>
<?php
    $conn2 = oci_connect("invetpc","1234","//localhost/xe");
    $stmt2 = oci_parse($conn2, "select * from venta");			//CUENTA LAS VENTAS QUE EXISTEN
    $r2 = oci_execute($stmt2);
    $nrows2 = oci_fetch_all($stmt2, $results2);
    $rows = oci_num_rows($stmt2);
    echo $rows;
?>

<br>

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
  Ingrese Id del producto a Vender: <input type="text" name="id" value="<?php echo $id;?>">
  <br>
  Cantidad: <input type="text" name="descrip" value="<?php echo $descrip;?>">
  
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>


<?php

	if ($id != ""){
		$conn = oci_connect("invetpc","1234","//localhost/xe");   //CONEXION A ORACLE
		$s2 = oci_parse($conn, "select comp_precio from componente where comp_id = :hid");
		oci_bind_by_name($s2, ":hid", $id);
		oci_execute($s2);
	    while (oci_fetch($s2)){
		$prec = oci_result($s2, 'COMP_PRECIO');}

		$total = $prec * $descrip;

		$s = oci_parse($conn, "insert into vent_comp (vco_ven, vco_comp, vco_cant, vco_prec, vco_tot) values (:brw, :bid, :bds, :bpr, :btt )");  //VARIABLE CON EL LLAMADO 'CALL' AL PROCEDIMIENTO, EN ESTE CASO VA CON UNA C YA QUE CON ESTA OPCION, SE CREAN DATOS EN LA TABLA
		oci_bind_by_name($s, ":bid", $id);   //NECESARIA PARA PASAR LA VARIABLE 'ID' AL LLAMADO DEL PROCEDIMIENTO, $id PASA A SER :bid
		oci_bind_by_name($s, ":bds", $descrip);
		oci_bind_by_name($s, ":brw", $rows);
		oci_bind_by_name($s, ":bpr", $prec);
		oci_bind_by_name($s, ":btt", $total);
		oci_execute($s);
		echo "Agrregado Correctamente";  //MENSAJE DE EXITO
	}
	else{
		echo "waiting";  //MENSAJE DE ESPERA MIENTRAS NO SE REALICE EL PROCEDIMIENTO
	}
?>   



<?php

    $conn3 = oci_connect("invetpc","1234","//localhost/xe");
    $stmt3 = oci_parse($conn, "select comp_id, comp_nom, vco_cant, vco_prec, vco_tot from componente, vent_comp where  vco_ven = :bid AND vco_comp = comp_id");
    oci_bind_by_name($stmt3, ":bid", $rows);
    $r3 = oci_execute($stmt3);
    $nrows3 = oci_fetch_all($stmt3, $results3);
    if($nrows3>0){
        echo "<table border><tr><th>ID</th><th>Nombre</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr>";
        for ($i = 0; $i < $nrows3; $i++){
            echo "<tr>\n";
            foreach ($results3 as $data3) {
                echo "<td>$data3[$i]</td>\n";
            }
        echo "</tr>\n";
        }
        echo "</table>";
    }
?>
<br><br>
<a href="finventa.php">Finalizar Venta</a>

<br><br>

            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>