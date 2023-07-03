<?php include'db_connect.php' ;
 
  $qry = $conn->query("SELECT * FROM announcement");
  $count = $qry->num_rows;

  echo $count;
?>