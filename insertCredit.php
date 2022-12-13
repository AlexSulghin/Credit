<?php
session_start();
require 'connection.php';

$data = json_decode(file_get_contents("php://input"));

if (count(array($data)) > 0) {
    $id_client = mysqli_real_escape_string($conn, $data->clientId);
    $id_credit_type = mysqli_real_escape_string($conn, $data->creditTypeId);
    $suma = mysqli_real_escape_string($conn, $data->suma);

    $refNr = $id_client + $id_credit_type + $suma + 1234;

    $query = "INSERT INTO credit(id_tip_credit, id_client, suma, status, suma_ramasa, refNr) VALUES ('$id_credit_type', '$id_client','$suma','IN PROGRESS', '$suma', '$refNr')";
    if (mysqli_query($conn, $query)) {
        echo "Creditul a fost adaugat cu succes!";
    } else {
        echo 'Eroare!';
    }
}
?>
