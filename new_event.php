<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="new_event">				  
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Event Name</label>
							<input type="text" name="eventName" class="form-control form-control-sm" required value="">
						</div>
																		
					</div>
					
                    <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Select Date</label>
			  <input type="date" class="form-control form-control-sm" autocomplete="off" name="date" id="date" value="" required>
            </div>
          </div>
		  
		  <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Days to be repeated</label>
			  <input type="number" class="form-control form-control-sm" autocomplete="off" min="0" name="repeatDay" id="repeatDay" value="0" required>
            </div>
          </div> 
		  <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Number of times </label>
			  <input type="number" class="form-control form-control-sm" autocomplete="off" min="0" name="repeatNumber" id="repeatNumber"  value="0" required>
            </div>
          </div>
													
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-warning mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">Cancel</button>
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

$('#new_event').submit(function(e){	
    
		e.preventDefault()	
		$.ajax({
			url:'ajax.php?action=add_event',
			data:$(this).serialize(),
			cache: false,			
			method: 'POST',			
			success:function(resp){ 
				          
				if(resp == 1){
					alert_toast('Event Added',"success");
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


	