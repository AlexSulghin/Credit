<?php
session_start();
require 'connection.php';

$data = json_decode(file_get_contents("php://input"));

if (count(array($data)) > 0) {
    $id = mysqli_real_escape_string($conn, $data->id);
    $query = "UPDATE credit SET status = 'FINISHED' where id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "Succes!";
    } else {
        echo 'Eroare!';
    }
}
?>
