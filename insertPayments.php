<?php
session_start();
require 'connection.php';

$data = json_decode(file_get_contents("php://input"));

if (count(array($data)) > 0) {
    $idCredit = mysqli_real_escape_string($conn, $data->creditId);
    $suma = mysqli_real_escape_string($conn, $data->suma);

    $query = "INSERT INTO payments(id_credit, suma) VALUES ('$idCredit', '$suma')";
    if (mysqli_query($conn, $query)) {
        echo "Plata a fost adaugata cu succes!";
    } else {
        echo 'Eroare!';
    }
}
?>
