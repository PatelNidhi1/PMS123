<?php include'db_connect.php' ;
session_start();
	$querie ="
    SELECT users.firstname , users.lastname , attendance.date, attendance.end_time, attendance.start_time, TIMEDIFF(attendance.end_time, attendance.start_time) as dif FROM `attendance` JOIN `users` on attendance.user_id = users.id 
    where  end_time is null and date < now()
    ORDER by date DESC";

?>

<form method="post"  id="clock_out" enctype="multipart/form-data"> 
<div class="col-lg-12">
	<div class="card card-outline card-warning">
		
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
							</tr>								                             						
					<?php endwhile; ?>				
				</tbody>
			</table>
		</div>
		<hr>
		<div class="col-lg-12 text-right justify-content-center d-flex">
			<button class="btn btn-warning mr-2">Update All</button>
			<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">Cancel</button>
		</div>
		<br/>
				
	</div>
</div>
</form>

<style>
#uni_modal .modal-footer{
	display:none;
}	
</style>

<script>
$(document).ready(function(){
		$('#list').dataTable()		
	})	

	$('#clock_out').submit(function(e){	
    
	e.preventDefault()	
	$.ajax({
		url:'ajax.php?action=update_clock',	
		cache: false,			
		method: 'POST',			
		success:function(resp){            
			if(resp == 1){
				alert_toast('Updated',"success");
				setTimeout(function(){
					location.reload()
				},1500)
				
			} 			
		}
	})
							
})	
</script> 















