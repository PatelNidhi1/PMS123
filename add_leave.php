<?php
session_start();
include'db_connect.php';
?>
<div class="col-lg-12">

	<div class="card">
		<div class="card-body">
		<form action="" id="add_leave">	

		
		<?php if($_SESSION['login_type'] == 3){ ?>			
			<input   type="hidden" class="form-control" name="user_id"  id="user_id" value="<?php echo $_SESSION['login_id'] ?>"> 
		<?php } ?>  
		
		<?php if($_SESSION['login_type'] != 3){ ?>	
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="" class="control-label">Select User</label>
					<select name="user_id" required class="form-control">
					<option></option>
					<?php 
						$employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
						while($row= $employees->fetch_assoc()):
						?>
						<option value="<?php echo $row['id'] ?>" ><?php echo ucwords($row['name']) ?></option>
						<?php endwhile; ?>
					</select>
				</div>																
		</div>
		</div>
		<?php } ?>  	
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="" class="control-label">Leave Type</label>
					<select name="leave_id" required class="form-control">
								<option value="">Select Leave</option>
								<option value="4">Sick</option>
								<option value="3">Earned</option>
								<option value="2">Casual</option>
					</select>
				</div>																
		</div>
					
        <div class="col-md-12">
            <div class="form-group">
              <label for="" class="control-label">From Date</label>
			  <input type="date" class="form-control form-control-sm" autocomplete="off" name="leave_from" id="leave_from" value="" required>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="" class="control-label">To Date</label>
			  <input type="date" class="form-control form-control-sm" autocomplete="off" name="leave_to" id="leave_to" value="" required>
            </div>
          </div>

          <div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Leave Description</label>
							<input type="text" name="leave_description" id="leave_description" class="form-control form-control-sm" required value="">
						</div>
																		
					</div>
		  
		  
													
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-warning mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=leave'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
#uni_modal .modal-footer{
	display:none;
}	
</style>

<script>

$('#add_leave').submit(function(e){	
    
		e.preventDefault()	
		$.ajax({
			url:'ajax.php?action=add_leave',
			data:$(this).serialize(),
			cache: false,			
			method: 'POST',			
			success:function(resp){            
				if(resp == 1){
					alert_toast('Leave Added',"success");
                    setTimeout(function(){
						location.reload()
					},1500)
				    
				} 
				else{					
					alert_toast('Failed',"error");
                    setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
								
    })
</script>   


	