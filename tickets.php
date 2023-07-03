<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-header">
			<div class="card-tools">
				<!-- <a class="btn btn-block btn-sm btn-default btn-flat border-warning" ><i class="fa fa-plus"></i> Add ticket</a> -->
				<button class="btn btn-warning bg-gradient-warning btn-sm" type="button" name="ticket" id="ticket">
        <i class="fa fa-plus"></i>Add Ticket</button>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Title</th>
						<th>Type</th>
						<th>Assigned To</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>					
				<?php
					$i = 1;
					// $type = array('',"Admin","Project Manager","Employee");
					$qry = $conn->query("SELECT * from tickets");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['title']) ?></b></td>
						<td><b><?php echo $row['type'] ?></b></td>
						<td><b><?php echo $row['assigned_to'] ?></b></td>
						<td><b><?php echo $row['status'] ?></b></td>
						
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-warning wave-effect text-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
		                    </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){

		$('#ticket').click(function(e){
uni_modal("Add ticket","new_ticket.php" ,'mid-large');
});		
		$('#list').dataTable();
		$('#list').ddTableFilter();
	$('.view_user').click(function(){
		uni_modal("<i class='fa fa-id-card'></i> User Details","view_user.php?id="+$(this).attr('data-id'))
	})
	$('.delete_user').click(function(){
	_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	})
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>

