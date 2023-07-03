<?php if(!isset($conn)){ include 'db_connect.php'; } 

function OnSelectionChange() {
    echo("OK IT WORKS");
}  
?>

<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-body">
			<form action="" id="role-rights">
                <div class="row">    
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="" class="control-label">Role</label>
                        <select class="form-control form-control-sm " id="role_id" name="role_id" onchange="OnSelectionChange()">
                            <option></option>
                            <?php 
                            $roles = $conn->query("SELECT * from roles");
                            while($row= $roles->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['role_id'] ?>" <?php echo isset($roles_id) && $roles_id == $row['role_id'] ? "selected" : '' ?>><?php echo ucwords($row['role_name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                        
                        </div>
                    </div>
                </div> 
                <br/>
                <div class="row">
                    <div class="col-md-3">
                        <input type="checkbox" name="Dashboard" class="get_value" value="1"> Dashboard
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" name="Announcements" class="get_value" value="2"> Announcements
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" name="Projects" class="get_value" value="3"> Projects
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" name="Report" class="get_value" value="4"> Report
                    </div>
                </div>   
                <div class="row">
                    <div class="col-md-3">
                        <input type="checkbox" name="Messages" class="get_value" value="5"> Messages
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" name="Users" class="get_value" value="6"> Users
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" name="Notes" class="get_value" value="7"> Notes
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" name="Timesheet" class="get_value" value="8"> Timesheet
                    </div>
                </div>  
                <div class="row">
                <div class="col-md-3">
                        <input type="checkbox" name="Events" class="get_value" value="9"> Events
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" name="Leave" class="get_value" value="10"> Leave
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" name="WorkSupport" class="get_value" value="11"> Work Support
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" name="WorkSupport" class="get_value" value="12"> Role Rights
                    </div>
                </div>    

                <div class="row">
                <div class="col-md-3">
                        <input type="checkbox" name="Settings" class="get_value" value="13"> Settings
                    </div>
                </div>

                <!-- <input type="submit" value="click" name="submit"> -->
            </form>
        </div>      
        <div class="card-footer border-top border-warning">
    		<div class="d-flex w-100 ">
            
            <!-- <input type="submit" value="click" name="submit"> -->
    			<button class="btn btn-flat  bg-gradient-warning mx-2" form="role-rights">Save</button>
    			
    		</div>
    	</div>   
    </div>         
</div>   


<script>  
 $(document).ready(function(){  

    // var formData = {
    //     role_id: 1,
    //   check_id: 1,      
    // };


      $('#role-rights').submit(function(e){  
        
        e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=add_rolerights',
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
						location.href = 'index.php?page=rolerights'
					},2000)
				}
			}
		})
      });  

    //   $('#role_id').change(function(){
    //         //Selected value
    //         var inputValue = $(this).val();
    //         alert("value in js "+inputValue);

    //         // //Ajax for calling php function
    //         // $.post('submit.php', { dropdownValue: inputValue }, function(data){
    //         //     alert('ajax completed. Response:  '+data);
    //         //     //do after submission operation in DOM
    //         // });
    //     });
 });  
 </script>