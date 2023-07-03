<?php include'db_connect.php' ;

?>
<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-header">  
		
	
		<div class="card-tools">
		<button class="btn btn-warning bg-gradient-warning btn-sm" type="button" name="addLeave" id="addLeave"><i class="fa fa-plus"></i> Add Leave</button>                
		</div>

		 
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="5%">
					<col width="20%">
					<col width="14%">
					<col width="14%">
					<col width="20%">
					<col width="18%">					
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>ID</th>
						<th>USER NAME</th>
						<th>FROM</th>
						<th>TO</th>
						<th>DESCRIPTION</th>
						<th>LEAVE STATUS</th>						
					</tr>
				</thead>
				<tbody>					
				<?php
					$i = 1;

					if($_SESSION['login_type']==1){ 
						$sql_text="select `leave`.*,  CONCAT( users.firstname , ' ' , users.lastname ) as name ,users.id as eid 
						from `leave`,users where `leave`.employee_id=users.id order by `leave`.id desc";
					}else{
						$eid=$_SESSION['login_id'];
						$sql_text="select `leave`.*, CONCAT( users.firstname , ' ' , users.lastname ) as name ,users.id as eid from `leave`,users where `leave`.employee_id='$eid' and `leave`.employee_id=users.id order by `leave`.id desc";
					}
					
					$qry = $conn->query($sql_text);
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
                                       <td><?php echo $i?></td>
									   <td><?php echo $row['id']?></td>
									   <td><?php echo $row['name']?></td>
                                       <td><?php echo $row['leave_from']?></td>
									   <td><?php echo $row['leave_to']?></td>
									   <td><?php echo $row['leave_description']?></td>
									   <td>
										   <?php
											if($row['leave_status']==1){
												echo "Applied";
											}if($row['leave_status']==2){
												echo "Approved";
											}if($row['leave_status']==3){
												echo "Rejected";
											}
										   ?>
										   <?php if($_SESSION['login_type']==1){ ?>
										   <select class="form-control" onchange="update_leave_status('<?php echo $row['id']?>',this.options[this.selectedIndex].value)">
											<option value="">Update Status</option>
											<option value="2">Approved</option>
											<option value="3">Rejected</option>
										   </select>
										   <?php } ?>
									   </td>									  									   
                                    </tr>	
				<?php endwhile; ?>		
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important
	}
</style>
<script>
$(document).ready(function(){
	$('#list').dataTable() ;
	$('#list').ddTableFilter();

});

$('#addLeave').click(function(e){
uni_modal("Add Event","add_leave.php" ,'mid-large');

})	


function update_leave_status(id,select_value)
{	
	var formData = {
      _id: id,
      s_id: select_value,      
    };
	$.ajax({
			url:'ajax.php?action=update_leave',
			data:formData,
			cache: false,			
			method: 'POST',			
			success:function(resp){
				if(resp == 1){
					alert_toast('Leave updated',"success");
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else{
					alert(resp);
					alert_toast('Failed',"error");
				}
			}
		})		
}

	
</script>