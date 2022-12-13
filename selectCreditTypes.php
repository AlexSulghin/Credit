<?php
session_start();
require 'connection.php';

$output = array();

$query = "SELECT * FROM tip_credit";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $output[] = $row;
    }
    echo json_encode($output);
}
?>
