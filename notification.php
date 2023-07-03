<?php    
    include'db_connect.php' ;
    
    $output  = "";    
    $qry = $conn->query("SELECT * FROM announcement order by date_created desc limit 3");
    while($row= $qry->fetch_assoc()){
        $output .= '<div class="dropdown-divider-new"></div>
        <a href="javascript:view_announcement('. $row['id'] .')" class="dropdown-item">
        <i class="fas fa-bullhorn mr-2"></i>  '. $row['title'] .'
        <span class="float-right text-muted text-sm"></span>
        </a>';
    }    
    echo $output;
    ?>
    
