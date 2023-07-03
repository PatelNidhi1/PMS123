
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user">	
          <?php if($_SESSION['login_type'] != 3): ?>
            <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">Select Project</label>
                    <select name="project_name" id="project_name" class="custom-select custom-select-sm">
                    <option value="" selected>Select Project</option>
                    <?php include 'db_connect.php';             
                      $qry = $conn->query("SELECT * FROM project_list");
                        
                      if($qry->num_rows > 0){
                        while($row = $qry->fetch_assoc()){
                          echo "<option value='". $row['id'] . "'>". $row['name'] ."</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">Select user</label>
                    <select name="user_name" id="user_name" class="custom-select custom-select-sm">
                    <option value="" selected>Select User</option>
                    <?php include 'db_connect.php';             
                      $qry = $conn->query("SELECT * FROM `users` WHERE type = 3");
                        
                      if($qry->num_rows > 0){
                        while($row = $qry->fetch_assoc()){
                          echo "<option value='". $row['id'] ."'>". $row['firstname'] . " " . $row['lastname']."</option>";
                        }
                      }
                      ?>
                    </select>
                  
                  </div>
                </div>
            </div>
            
            <hr/>
            <br/>
              
          <?php endif; ?>
          <div id="chart_div"></div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

function getCookie(cname) {
  let name = cname + "=";
  let ca = document.cookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

var Uid = getCookie("GUserID");
$('#user_name option[value="' + Uid + '"]').attr('selected', 'selected');

var Uid = getCookie("GProjectID");
$('#project_name option[value="' + Uid + '"]').attr('selected', 'selected');


// Function to create the cookie
function createCookie(name, value, days) {
  var expires;
    
  if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toGMTString();
  }
  else {
      expires = "";
  }
    
  document.cookie = escape(name) + "=" + 
  escape(value) + expires + "; path=/";
}

<?php 
  $where = "";
?>

$('#user_name').change(function() {
  var val = this.value;  

  createCookie("GUserID", val, "10");
  createCookie("GProjectID", "", "10");

  <?php  
  
    if(isset($_COOKIE["GUserID"])){
      if($_COOKIE["GUserID"] != "") {
      $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_COOKIE["GUserID"]}]%' ";}
    }
  
  ?>

  location.reload();
  
  
});


$('#project_name').change(function() {
  var val = this.value;  

  createCookie("GProjectID", val, "10");
  createCookie("GUserID", "", "10");

  <?php  
  
    if(isset($_COOKIE["GProjectID"])){
      if($_COOKIE["GProjectID"] != "") {
      $where = " where id = {$_COOKIE["GProjectID"]} ";}
    }
  
  ?>

  location.reload();
  
  
});


google.charts.load('current', {'packages':['gantt']});
google.charts.setOnLoadCallback(drawChart1);


function drawChart1() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Task ID');
    data.addColumn('string', 'Task Name');
    data.addColumn('string', 'Resource');
    data.addColumn('date', 'Start Date');
    data.addColumn('date', 'End Date');
    data.addColumn('number', 'Duration');
    data.addColumn('number', 'Percent Complete');
    data.addColumn('string', 'Dependencies');

    data.addRows([
    <?php
      include 'db_connect.php';                
    $UserID = $_SESSION['login_id'];   
    
    if($_SESSION['login_type'] == 3) {
      $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$UserID}]%' ";
    }

    $qry = $conn->query(" SELECT id, name , description ,  year(start_date) as SYY, month(start_date) as SMM, day(start_date) as SDD,year(end_date) as EYY,month(end_date) as EMM,day(end_date) as EDD from project_list $where"); 
                              
    if($qry->num_rows > 0){
      while($row = $qry->fetch_assoc()){  
        
        $prog= 0;
        $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
        $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
        $prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
        $prog = $prog > 0 ?  number_format($prog,2) : $prog;

        echo "['" . $row['name'] . "','" . $row['name'] . "','" . $row['description'] . "', new Date(" . $row['SYY'] . "," . $row['SMM'] . "," . $row['SDD'] . "), new Date(" . $row['EYY'] . "," . $row['EMM'] . "," . $row['EDD'] . "),null," .  $prog . ", null ]," ;                        
        
      }
    }
    
    ?>

    ]);

    var options = {
      height: 600,
      gantt: {
        trackHeight: 30
      }
    };

    var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

    chart.draw(data, options);
  }    
</script>