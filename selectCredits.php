<?php
session_start();
require 'connection.php';

$output = array();

$query = "SELECT cr.id as id, cl.nume as nume, cl.prenume as prenume, tc.denumire as tipCredit, tc.rata as rata, tc.termen as termen, cr.suma as suma, cr.data_emit as dataEmit, cr.refNr as refNr, cr.status as status, cr.suma_ramasa as sumaRamasa FROM credit cr 
    join client cl on cr.id_client = cl.id
    join tip_credit tc on cr.id_tip_credit = tc.id";


$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $output[] = $row;
    }
    echo json_encode($output);
}
?>
