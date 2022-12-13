<?php
session_start();
require 'connection.php';

$data = json_decode(file_get_contents("php://input"));

if (count(array($data)) > 0) {
    $den_credit_type_received = mysqli_real_escape_string($conn, $data->credit_type_den);
    $conditions_received = mysqli_real_escape_string($conn, $data->credit_type_conditions);
    $rate_received = mysqli_real_escape_string($conn, $data->credit_type_rate);
    $period_received = mysqli_real_escape_string($conn, $data->credit_type_period);

    $query = "INSERT INTO tip_credit(denumire, conditii, rata, termen) VALUES ('$den_credit_type_received', '$conditions_received','$rate_received','$period_received')";
    if (mysqli_query($conn, $query)) {
        echo "Tipul de credit a fost adaugat cu succes!";
    } else {
        echo 'Eroare!';
    }
}
?>
