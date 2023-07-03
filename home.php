<?php include('db_connect.php');
$UserID = $_SESSION['login_id'];
$BtnTimerNamae = 'Clock-in' ;
$disabled = 'false';
$querie = '' ;
$qry = $conn->query("SELECT * FROM attendance WHERE user_id= '$UserID' and  date_format(date , '%Y-%m-%d') = date_format(now(), '%Y-%m-%d')  LIMIT 1");
if($qry->num_rows > 0){	

	$BtnTimerNamae = 'Clock-out' ;
}


$qry2 = $conn->query("SELECT * FROM attendance WHERE user_id= '$UserID' and date_format(date , '%Y-%m-%d') = date_format(now(), '%Y-%m-%d') and end_time is not null LIMIT 1");
if($qry2->num_rows > 0){	

	$disabled = 'true' ;
	
}


if($_SESSION['login_type'] == 3)
{
	$querie ="SELECT *, TIMEDIFF(attendance.end_time, attendance.start_time) as dif FROM `attendance` WHERE user_id = '$UserID' ORDER by date DESC" ;
}
else
{
	$querie ="SELECT users.firstname , users.lastname , attendance.date, attendance.end_time, attendance.start_time, TIMEDIFF(attendance.end_time, attendance.start_time) as dif FROM `attendance` JOIN `users` on attendance.user_id = users.id ORDER by date DESC";
}


if(isset($_POST['timer'])){ 	
	if($BtnTimerNamae == 'Clock-in' )
	{
		$qry = $conn->query("INSERT into attendance ( user_id , date, start_time ) VALUES ( '$UserID' , now() ,now() ) ");
		$BtnTimerNamae = 'Clock-out' ;
	}
	else if($BtnTimerNamae == 'Clock-out')
	{
		$qry = $conn->query("UPDATE attendance set end_time = now() where user_id = '$UserID' and  date_format(date , '%Y-%m-%d') = date_format(now(), '%Y-%m-%d') ");
		$BtnTimerNamae = 'Clock-in' ;
		$disabled = 'true';

	}		
 }
 
?>

<?php
$twhere ="";
if($_SESSION['login_type'] != 1)
  $twhere = "  ";
?>
<!-- Info boxes -->

 <div class="col-12">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['login_name'] ?>!
            </div>
          </div>
          <form method="post">
          <?php if($_SESSION['login_type'] == 3): ?>        
                <div class="card-tools">
                <button class="btn btn-warning bg-gradient-warning btn-sm" type="timer" <?php if($disabled == 'true'){ ?> disabled <?php } ?>  name="timer" id="timer"><i class="fa fa-plus"></i> <?php echo( $BtnTimerNamae ); ?></button>                
                </div>
        <?php endif; ?>
        </form>
  </div>
  <hr>     
  <?php 


$where = "";
if($_SESSION['login_type'] == 2){
  $where = " where manager_id = '{$_SESSION['login_id']}' ";
}elseif($_SESSION['login_type'] == 3){
  $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
}
 $where2 = "";
if($_SESSION['login_type'] == 2){
  $where2 = " where p.manager_id = '{$_SESSION['login_id']}' ";
}elseif($_SESSION['login_type'] == 3){
  $where2 = " where concat('[',REPLACE(p.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
}
?>


      <div class="row">
        <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
          <div class="card card-outline card-warning">
            <div class="card-header">
              <b>Project Progress</b>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0 table-hover">
                <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Project</th>
                  <th>Progress</th>
                  <th>Status</th>
                  <th></th>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $stat = array("Pending","Started","In-Progress","On-Hold","Over Due","Done");
                $where = "";
                if($_SESSION['login_type'] == 2){
                  $where = " where manager_id = '{$_SESSION['login_id']}' ";
                }elseif($_SESSION['login_type'] == 3){
                  $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
                }
                $qry = $conn->query("SELECT * FROM project_list $where order by name asc");
                while($row= $qry->fetch_assoc()):
                  $prog= 0;
                $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
                $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
                $prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
                $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
                if($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
                if($prod  > 0  || $cprog > 0)
                  $row['status'] = 2;
                else
                  $row['status'] = 1;
                elseif($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
                $row['status'] = 4;
                endif;
                  ?>
                  <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['name']) ?>
                          </a>
                          <br>
                          <small>
                              Due: <?php echo date("Y-m-d",strtotime($row['end_date'])) ?>
                          </small>
                      </td>
                      <td class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                              </div>
                          </div>
                          <small>
                              <?php echo $prog ?>% Complete
                          </small>
                      </td>
                      <td class="project-state">
                          <?php
                            if($stat[$row['status']] =='Pending'){
                              echo "<span class='badge badge-secondary'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Started'){
                              echo "<span class='badge badge-primary'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='In-Progress'){
                              echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='On-Hold'){
                              echo "<span class='badge badge-warning'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Over Due'){
                              echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Done'){
                              echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
                            }
                          ?>
                      </td>
                      <td>
                        <a class="btn btn-primary btn-sm" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>">
                              <i class="fas fa-folder">
                              </i>
                              View
                        </a>
                      </td>
                  </tr>
                <?php endwhile; ?>

                
                </tbody>  
              </table>
            </div>
          </div>
        </div>

              </div>
              <?php if($_SESSION['login_type'] == 3): ?>
              <div class="col-md-6">
              
                <div class="card card-outline card-warning">
                  <div class="card-header">
                    <b>My timesheet</b>
                  </div>
                  <div class="card-body p-0">
                    <div id="myfirstchart" style="height: 250px;"></div>
                  </div>
                </div>
              </div>
              <?php endif; ?>

              <div class="col-md-12">

                  <!-- Leave list -->
                        
        <div class="card card-outline card-warning">

<div class="card-header">
  <b>Leave</b>
</div>

<div class="card-body p-0">
  <div class="table-responsive">
  <table class="table m-0 table-hover">
      <colgroup>
          <col width="5%">
          <col width="30%">
          <col widht="25%">
          <col width="20%">
          <col width="20%">
          
      </colgroup>
      <thead>
          <th>#</th>
          <th>User Name</th>
          <th>Description</th>  
          <th>Form Date</th>  
          <th>To Date</th>                  
      </thead>
      <tbody>
      <?php
      $i = 1;
      
      $qry = $conn->query("SELECT * FROM `leave` 
      join `users`
      on `leave`.`employee_id` = `users`.`id`
      WHERE MONTH(leave_to) = MONTH(CURRENT_DATE()) AND YEAR(leave_to) = YEAR(CURRENT_DATE()) and DAY(leave_to) >= DAY(CURRENT_DATE()) ");
      while($row= $qry->fetch_assoc()):
      
          ?>
          <tr>
              <td>
              <?php echo $i++ ?>
              </td>
              <td>                          
                  <?php echo ucwords($row['firstname']) ?> <?php echo ucwords($row['lastname']) ?>                                                                             
              </td>
              <td>                          
                  <?php echo ucwords($row['leave_description']) ?>                                                                            
              </td>
              <td>                                                                                 
                  <?php echo date("Y-m-d",strtotime($row['leave_from'])) ?>                          
              </td> 
              <td>                                                                                 
                  <?php echo date("Y-m-d",strtotime($row['leave_to'])) ?>                          
              </td>                                                          
          </tr>
      <?php endwhile; ?>                
      </tbody>  
      </table>
  </div>
  </div>    
</div>          

<!-- Leave list end -->


              </div>

          </div>
        
        </div>
        <div class="col-md-4">
          <div class="row">
          <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM project_list $where")->num_rows; ?></h3>

                <p>Total Projects</p>
              </div>
              <div class="icon">
                <i class="fa fa-layer-group"></i>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT t.*,p.name as pname,p.start_date,p.status as pstatus, p.end_date,p.id as pid FROM task_list t inner join project_list p on p.id = t.project_id $where2")->num_rows; ?></h3>
                <p>Total Tasks</p>
              </div>
              <div class="icon">
                <i class="fa fa-tasks"></i>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-12">
          <div class="card card-outline card-warning">
            <div class="card-header">
              <b>Events</b>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0 table-hover">
                <colgroup>
                  <col width="5%">
                  <col width="45%">
                  <col width="50%">
                  
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Eevent</th>
                  <th>Date</th>                  
                </thead>
                <tbody>
                <?php
                $i = 1;
               
                $qry = $conn->query("SELECT * FROM `events` WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) and DAY(date) >= DAY(CURRENT_DATE())");
                while($row= $qry->fetch_assoc()):
                
                  ?>
                  <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>                          
                          <?php echo ucwords($row['title']) ?>                                                                             
                      </td>
                      <td>                                                                                 
                           <?php echo date("Y-m-d",strtotime($row['date'])) ?>                          
                      </td>                                                          
                  </tr>
                <?php endwhile; ?>                
                </tbody>  
              </table>
            </div>
          </div>
          </div>

          <div class="col-12 col-sm-6 col-md-12">
          <div class="card card-outline card-warning">
            <div class="card-header">
              <b>Birthday</b>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0 table-hover">
                <colgroup>
                  <col width="5%">
                  <col width="45%">
                  <col width="50%">
                  
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>User Name</th>
                  <th>Date</th>                  
                </thead>
                <tbody>
                <?php
                $i = 1;
               
                $qry = $conn->query("SELECT * FROM `users` WHERE MONTH(birthday) = MONTH(CURRENT_DATE()) ");
                while($row= $qry->fetch_assoc()):
                
                  ?>
                  <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>                          
                          <?php echo ucwords($row['firstname']) ?> <?php echo ucwords($row['lastname']) ?>                                                                             
                      </td>
                      <td>                                                                                 
                           <?php echo date("Y-m-d",strtotime($row['birthday'])) ?>                          
                      </td>                                                          
                  </tr>
                <?php endwhile; ?>                
                </tbody>  
              </table>
            </div>
          </div>
          </div>
      </div>
        </div>
      </div>
<script>

$(document).ready(function(){

	var id= "<?php echo $_SESSION['login_type'];?>"	;

  if (id == 1 || id ==2){
    $.ajax({
			url:'ajax.php?action=check_attendance',
			cache: false,			
			method: 'POST',			
			success:function(resp){
				if(resp == 1){
					uni_modal("Attendance","update_clock_out.php" ,'mid-large');
					
				}
			
			}
		})

  }
})

new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [

    <?php
        include 'db_connect.php';                
      $UserID = $_SESSION['login_id']; 
      $querie ="SELECT date , 
                TIMEDIFF(attendance.end_time, attendance.start_time)  as dif,
                Hour(TIMEDIFF(attendance.end_time, attendance.start_time))  as hr,
                minute(TIMEDIFF(attendance.end_time, attendance.start_time))  as min            
                FROM `attendance`
                WHERE user_id = '$UserID' 
                AND date_format(date , '%Y-%m-%d') != date_format(now(), '%Y-%m-%d')
                ORDER by date DESC" ;         
      $qry = $conn->query($querie); 
                                
      if($qry->num_rows > 0){
        while($row = $qry->fetch_assoc()){  
          
          echo "{day:'" . $row['date'] . "', time: " . $row['hr'] . "." . $row['min'] . "},";
         
        }
      }
      
    ?>   
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'day',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['time'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['time']
});






</script>