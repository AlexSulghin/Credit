<?php
session_start();
require 'connection.php';

$data = json_decode(file_get_contents("php://input"));

if (count(array($data)) > 0) {
    $name_received = mysqli_real_escape_string($conn, $data->client_name);
    $surname_received = mysqli_real_escape_string($conn, $data->client_surname);
    $address_received = mysqli_real_escape_string($conn, $data->client_address);
    $phone_received = mysqli_real_escape_string($conn, $data->client_phone);
    $contact_received = mysqli_real_escape_string($conn, $data->client_contact);

    $query = "INSERT INTO client(nume, prenume, adresa, telefon, contact) VALUES ('$name_received', '$surname_received','$address_received','$phone_received', '$contact_received')";
    if (mysqli_query($conn, $query)) {
        echo "Clientul a fost adaugat cu succes!";
    } else {
        echo 'Eroare!';
    }
}
?>