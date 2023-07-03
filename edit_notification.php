<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM notification where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
?>


<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-body">
			<form action="" id="manage-project">
			<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Event</label>
					<input type="text" class="form-control form-control-sm" name="event" value="<?php echo isset($event) ? $event : '' ?>" required>
				</div>				
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="" class="control-label">Category</label>
					<input type="text" class="form-control form-control-sm" name="category" value="<?php echo isset($category) ? $category : '' ?>" required>
				</div>
			</div>          	
		</div>		
        <div class="row">
        	
      
		<div class="col-md-12">
            <div class="form-group">
              <label for="" class="control-label">Project Team Members</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">
              	<option></option>
              	<?php 
              	$employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users  order by concat(firstname,' ',lastname) asc ");
              	while($row= $employees->fetch_assoc()):
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
              	<?php endwhile; ?>
              </select>
            </div>
		</div>

		<div class="col-md-3">
			<input type="checkbox" name="enable_email" <?php if($enable_email == 1){ echo "checked" ;} ?>   value="1"> Enable Email
		</div>


        </div>
		
        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-warning mx-2" form="manage-project">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>
    		</div>
    	</div>
	</div>
</div>

<style>
#uni_modal .modal-footer{
	display:none;
}	
</style>

<script>
	$('#manage-project').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_notification',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=settings'
					},2000)
				}
			}
		})
	})
</script>
