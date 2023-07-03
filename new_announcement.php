<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="new_announcement">				  
				<div class="row">
				<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Title</label>
							<input type="text" name="title" class="form-control form-control-sm" required value="">
						</div>
																		
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Enter Announcement</label>
                            <textarea name="text" id="text" cols="30" rows="10" class="summernote form-control"></textarea>
						</div>
																		
					</div>
					
                    
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-warning mr-2">Post</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=announcement'">Cancel</button>
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

$('#new_announcement').submit(function(e){	
    
		e.preventDefault()	
		$.ajax({
			url:'ajax.php?action=add_announcement',
			data:$(this).serialize(),
			cache: false,			
			method: 'POST',			
			success:function(resp){ 
				          
				if(resp == 1){
					alert_toast('Announcement Added',"success");
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


	