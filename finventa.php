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
                <h1>Detalle final de Venta</h1>
<?php
    $conn2 = oci_connect("invetpc","1234","//localhost/xe");
    $stmt2 = oci_parse($conn2, "select * from venta");			//CUENTA LAS VENTAS QUE EXISTEN
    $r2 = oci_execute($stmt2);
    $nrows2 = oci_fetch_all($stmt2, $results2);
    $rows = oci_num_rows($stmt2);
?>           


<?php
    $conn2 = oci_connect("invetpc","1234","//localhost/xe");
    $stmt3 = oci_parse($conn2, "select sum(vco_tot) from vent_comp where vco_ven=:his");          //CUENTA LAS VENTAS QUE EXISTEN
    oci_bind_by_name($stmt3, ":his", $rows);
    $r3 = oci_execute($stmt3);
    while (oci_fetch($stmt3)){
        $tot = oci_result($stmt3, 'SUM(VCO_TOT)');}
?>  


<?php
        $s = oci_parse($conn2, "update venta set vent_total = :btt where vent_id = :bbb");  //VARIABLE CON EL LLAMADO 'CALL' AL PROCEDIMIENTO, EN ESTE CASO VA CON UNA C YA QUE CON ESTA OPCION, SE CREAN DATOS EN LA TABLA
        oci_bind_by_name($s, ":btt", $tot);   //NECESARIA PARA PASAR LA VARIABLE AL LLAMADO DEL PROCEDIMIENTO, $tot PASA A SER :btt
        oci_bind_by_name($s, ":bbb", $rows);
        oci_execute($s);

?>


<?php
    $conn = oci_connect("invetpc","1234","//localhost/xe");
    $stmt = oci_parse($conn, "select * from venta where vent_id = :hid ");
    oci_bind_by_name($stmt, ":hid", $rows);
    $r = oci_execute($stmt);
    $nrows = oci_fetch_all($stmt, $results);
    if($nrows>0){
        echo "<table border><tr><th>ID</th><th>Fecha</th><th>Total</th><th>Vendedor</th><th>Estado</th></tr>";
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
<br><br>
<a href="accven.php">Aceptar Venta</a><br><a href="rejven.php">Rechazar venta</a>


 </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>





