<?php
    $conn2 = oci_connect("invetpc","1234","//localhost/xe");
    $stmt2 = oci_parse($conn2, "select * from venta");			//CUENTA LAS VENTAS QUE EXISTEN
    $r2 = oci_execute($stmt2);
    $nrows2 = oci_fetch_all($stmt2, $results2);
    $rows = oci_num_rows($stmt2);
    $rows = $rows+1; // SUMA 1 A LA CANTIDAD DE VENTAS EXISTENTES
    $conn3 = oci_connect("invetpc","1234","//localhost/xe");
    $stmt3 = oci_parse($conn3, "insert into venta (vent_id, vent_fecha, vent_total, vent_vend, vent_est) values (:bid,sysdate,0,19522551,1)");
    oci_bind_by_name($stmt3, ":bid", $rows);
    $r3 = oci_execute($stmt3);   //LUEGO DE CONTAR LAS VENTAS, CREA UNA NUEVA VENTA CON EL ID DE LA CANTIDAD DE VETAS MAS UNO
    Header('Location: venta2.php');
    exit;
?>