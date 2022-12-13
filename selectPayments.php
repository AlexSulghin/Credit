<?php
session_start();
require 'connection.php';

$output = array();

$query = "SELECT cr.id as creditId, cr.refNr as refNr, cl.id as clientId, cl.nume as nume, cl.prenume as prenume, p.suma as suma, p.data_plata as dataPlata 
FROM payments p 
    join credit cr on p.id_credit = cr.id 
    join client cl on cr.id_client = cl.id";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $output[] = $row;
    }
    echo json_encode($output);
}
?>
