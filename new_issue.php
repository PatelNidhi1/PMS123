<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="new_issue">				  
				<div class="row">
				<input   type="hidden" class="form-control" name="user_id"  id="user_id" value="<?php echo $_SESSION['login_id'] ?>"> 
				<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Issue</label>
							<input type="text" name="issue" class="form-control form-control-sm" required value="">
						</div>
																		
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Enter Solution</label>
                            <textarea name="solution" id="solution" cols="30" rows="4" class="summernote form-control"></textarea>
						</div>
																		
					</div>
					
                    
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-warning mr-2">Post</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=work_support'">Cancel</button>
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

$('#new_issue').submit(function(e){	
    
		e.preventDefault()	
		$.ajax({
			url:'ajax.php?action=add_issue',
			data:$(this).serialize(),
			cache: false,			
			method: 'POST',			
			success:function(resp){ 
				          
				if(resp == 1){
					alert_toast('Issue Added',"success");
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


	