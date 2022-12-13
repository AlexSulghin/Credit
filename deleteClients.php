 <?php
 session_start();
 require 'connection.php';

 $data = json_decode(file_get_contents("php://input"));
 if(count(array($data)) > 0)
 {  
      $ids = $data->array;
      $count=0;
      foreach($ids as $id) {
          $query = "DELETE FROM client WHERE id='$id'";
          if(mysqli_query($conn, $query)) {
              $count++;
          }
      }
      if($count == count(array($ids)))
      {  
           echo 'Clientii selectati au fost stersi cu succes!';
      }  
      else  
      {  
           echo 'Eroare';
      }  
 }  
 ?>  
