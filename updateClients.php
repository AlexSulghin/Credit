<?php
session_start();
require 'connection.php';

$data = json_decode(file_get_contents("php://input"));

if (count(array($data)) > 0) {
    $id = mysqli_real_escape_string($conn, $data->clientId);
    $nume = mysqli_real_escape_string($conn, $data->clientName);
    $prenume = mysqli_real_escape_string($conn, $data->clientSurname);
    $adresa = mysqli_real_escape_string($conn, $data->clientAddress);
    $telefon = mysqli_real_escape_string($conn, $data->clientPhone);
    $contact = mysqli_real_escape_string($conn, $data->clientContact);

    $query = "UPDATE client SET nume = '$nume', prenume = '$prenume',
                  adresa = '$adresa', telefon = '$telefon', contact = '$contact' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "Datele au fost actualizate cu succes!";
    } else {
        echo 'Eroare!';
    }
}
?>
