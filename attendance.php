<?php include'db_connect.php' ;

$UserID = $_SESSION['login_id'];
$BtnTimerNamae = 'Start Timer' ;
$disabled = 'false';
$querie = '' ;

$qry = $conn->query("SELECT * FROM attendance WHERE user_id= '$UserID' and  date_format(date , '%Y-%m-%d') = date_format(now(), '%Y-%m-%d')  LIMIT 1");
if($qry->num_rows > 0){	

	$BtnTimerNamae = 'Stop Timer' ;
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
	if($BtnTimerNamae == 'Start Timer' )
	{
		$qry = $conn->query("INSERT into attendance ( user_id , date, start_time ) VALUES ( '$UserID' , now() ,now() ) ");
		$BtnTimerNamae = 'Stop Timer' ;
	}
	else if($BtnTimerNamae == 'Stop Timer')
	{
		$qry = $conn->query("UPDATE attendance set end_time = now() where user_id = '$UserID' and  date_format(date , '%Y-%m-%d') = date_format(now(), '%Y-%m-%d') ");
		$BtnTimerNamae = 'Start Timer' ;
		$disabled = 'true';

	}		
 }
 
?>

<form method="post"  enctype="multipart/form-data"> 
<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-header">
        <!-- <?php if($_SESSION['login_type'] == 3): ?>        
                <div class="card-tools">
                <button class="btn btn-warning bg-gradient-warning btn-sm" type="timer" <?php if($disabled == 'true'){ ?> disabled <?php } ?>  name="timer" id="timer"><i class="fa fa-plus"></i> <?php echo( $BtnTimerNamae ); ?></button>                
                </div>
        <?php endif; ?> -->
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
                        <?php if($_SESSION['login_type'] != 3): ?>
                            <th>User Name</th>
                        <?php endif; ?>
						<th>Date</th>                        
						<th>Start Time</th>
						<th>End Time</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>					
					<?php																		 
							$i = 1;						
							$qry = $conn->query($querie);
							while($row= $qry->fetch_assoc()):
							?>
							<tr>
							
								<th class="text-center"><?php echo $i++ ?></th>
								<?php if($_SESSION['login_type'] != 3): ?>
									<td> <?php echo ucwords($row['firstname'])  ?>  &nbsp <?php echo ucwords($row['lastname']) ?>  </td>
								<?php endif; ?>
								<td><b><?php echo ucwords($row['date']) ?></b></td>
								<td><b><?php echo ucwords($row['start_time']) ?></b></td>
								<td><b><?php echo ucwords($row['end_time']) ?></b></td>
								<td class="text-center">
									<b><?php echo ucwords($row['dif']) ?></b>
								</td>	
							</tr>								                             						
					<?php endwhile; ?>				
				</tbody>
			</table>
		</div>
	</div>
</div>
</form>
<script>
$(document).ready(function(){
		$('#list').dataTable();
		$('#list').ddTableFilter();	
	})	
</script> 















