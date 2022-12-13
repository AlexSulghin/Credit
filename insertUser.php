<?php
session_start();
require 'connection.php';

$data = json_decode(file_get_contents("php://input"));

if (count(array($data)) > 0) {
    $login = mysqli_real_escape_string($conn, $data->login);
    $password = mysqli_real_escape_string($conn, $data->parola);

    $query = "SELECT * FROM users WHERE login = '$login'";

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo 'Acest utilizator deja exista!';
    } else {
        $query = "INSERT INTO users(login, password) VALUES ('$login', md5('$password'))";
        if (mysqli_query($conn, $query)) {
            echo "Utilizatorul a fost adaugat cu succes!";
        } else {
            echo 'Eroare!';
        }
    }
}
?>