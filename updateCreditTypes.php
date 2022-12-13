<?php
session_start();
require 'connection.php';

$data = json_decode(file_get_contents("php://input"));

if (count(array($data)) > 0) {
    $id = mysqli_real_escape_string($conn, $data->creditTypeId);
    $denumire = mysqli_real_escape_string($conn, $data->creditTypeDen);
    $conditii = mysqli_real_escape_string($conn, $data->creditTypeConditions);
    $rata = mysqli_real_escape_string($conn, $data->creditTypeRate);
    $termen = mysqli_real_escape_string($conn, $data->creditTypePeriod);

    $query = "UPDATE tip_credit SET denumire = '$denumire', conditii = '$conditii',
                  rata = '$rata', termen = '$termen' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "Datele au fost actualizate cu succes!";
    } else {
        echo 'Eroare!';
    }
}
?>
