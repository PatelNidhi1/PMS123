<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="new_ticket">				  
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Title</label>
							<input type="text" name="title" class="form-control form-control-sm" required value="">
						</div>
																		
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Type</label>
							<input type="text" name="type" class="form-control form-control-sm" required value="">
						</div>
																		
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="">Status</label>
							<select name="status" id="status" class="custom-select custom-select-sm">
							<option value="Open" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Open</option>
								<option value="Closed" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>Closed</option>
								<option value="In Progress" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>In Progress</option>
							</select>
						</div>
					</div>

                   
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-warning mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=tickets'">Cancel</button>
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

$('#new_ticket').submit(function(e){	
    
		e.preventDefault()	
		$.ajax({
			url:'ajax.php?action=a',
			data:$(this).serialize(),
			cache: false,			
			method: 'POST',			
			success:function(resp){ 
				          
				if(resp == 1){
					alert_toast('Ticket Added',"success");
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


	