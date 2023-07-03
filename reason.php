<?php 
include 'db_connect.php';
session_start();
?>
<form action="" id="reason-form">
<input type="hidden" class="form-control" name="id" id="id"  value="<?php echo $_GET['task_id'] ?>">
  <input   type="hidden" class="form-control" name="user_id"  id="user_id" value="<?php echo $_SESSION['login_id'] ?>">
   
  <input   type="text" class="form-control" name="reason"  id="reason" value="" placeholder="Enter reason" required>
  <hr>
  <div class="float-right">
				<button type="submit" class="btn btn-warning" id="submit">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
</form>

<style>
#uni_modal .modal-footer{
	display:none;
}

</style>
<script>
	
$('#reason-form').submit(function(e){	
		e.preventDefault()

	
		$.ajax({
			url:'ajax.php?action=task_timer',
			data:$(this).serialize(),
			cache: false,			
			method: 'POST',			
			success:function(resp){
				if(resp == 1){
					alert_toast('Timer  Start',"success");
                    setTimeout(function(){
						location.reload()
					},1500)
				    
				} else if (resp == 2) {
                    alert_toast('Timer Stop',"success");
					setTimeout(function(){
						location.reload()
					},1500)
				}
				else{
					
					alert_toast('Failed',"failed");
                    setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
								
    })
</script>