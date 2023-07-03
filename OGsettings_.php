<?php 
include 'db_connect.php';
// session_start(); 

	$qry = $conn->query("SELECT * FROM email_settings ")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
        
	}
    

?>

<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-body">
			<form action="" id="email-settings">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">Email sent from address</label>
                        <input type="text" class="form-control form-control-sm" name="email" value="<?php echo html_entity_decode($email) ?>" required>
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">Email sent from name</label>
                        <input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>" required>
                    </div>
                </div>          	
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">SMTP Host</label>
                        <input type="text" class="form-control form-control-sm" name="host" value="<?php echo isset($host) ? $host : '' ?>" required>
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">SMTP Port</label>
                        <input type="text" class="form-control form-control-sm" name="port" value="<?php echo isset($port) ? $port : '' ?>" required>
                    </div>
                </div>          	
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">SMTP User</label>
                        <input type="text" class="form-control form-control-sm" name="user" value="<?php echo isset($user) ? $user : '' ?>" required>
                    </div>
                </div> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">SMTP Password</label>
                        <input type="password" class="form-control form-control-sm" name="password" value="<?php echo isset($password) ? $password : '' ?>" required>
                    </div>
                </div>          	
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Security Type</label>
                        <select name="SecurityType" id="SecurityType" class="custom-select custom-select-sm">					
                        <option value="TLS" <?php echo isset($SecurityType) && $SecurityType == 'TLS' ? 'selected' : '' ?>>TLS</option>   
                        <option value="SSL" <?php echo isset($SecurityType) && $SecurityType == 'SSL' ? 'selected' : '' ?>>SSL</option>   
                        
                        </select>
                    </div>
                </div>                    	
            </div>

        </div>
        <div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-warning mx-2" form="email-settings">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=settings'">Cancel</button>
    		</div>
    	</div>
    </div>
</div>
<script>
	$('#email-settings').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_email_settings',
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
