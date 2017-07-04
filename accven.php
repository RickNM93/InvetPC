<?php
    $conn2 = oci_connect("invetpc","1234","//localhost/xe");
    $stmt2 = oci_parse($conn2, "select * from venta");			//CUENTA LAS VENTAS QUE EXISTEN
    $r2 = oci_execute($stmt2);
    $nrows2 = oci_fetch_all($stmt2, $results2);
    $rows = oci_num_rows($stmt2);
?>     

<?php
        $s = oci_parse($conn2, "update venta set vent_est = 2 where vent_id = :bbb");  //VARIABLE CON LA ACTUALIZACION DE LA TABLA VENTA
        oci_bind_by_name($s, ":bbb", $rows);
        oci_execute($s);
        Header('Location: venta.php');
    exit;
?>