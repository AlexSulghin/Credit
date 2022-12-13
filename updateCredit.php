<?php
session_start();
require 'connection.php';
 
 $data = json_decode(file_get_contents("php://input"));  
 
 if(count(array($data)) > 0)  
 
 {  
    $idCredit = mysqli_real_escape_string($conn, $data->id);
      $suma = mysqli_real_escape_string($conn, $data->suma);

      $query = "UPDATE credit SET suma_ramasa = suma_ramasa - cast('$suma' as decimal) WHERE id = '$idCredit'";

      if(mysqli_query($conn, $query))
      {  
           echo "Succes!";
      }  
      else  
      {  
           echo 'Eroare!';
      }  
 }  
 ?>  
