<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-body">
			<form action="" id="frm-group">
		    <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">Group Name</label>
                        <input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">Project Team Members</label>
                        <select class="form-control form-control-sm select2"  multiple="multiple" name="user_ids[]">
                        <option></option>
                        <?php 
						$id = $_SESSION['login_id'];
                        $employees = $conn->query(" SELECT *,concat(firstname,' ',lastname) as name FROM users where id != $id order by concat(firstname,' ',lastname) asc ");
                        while($row= $employees->fetch_assoc()):
                        ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
				<div class="col-lg-12 text-right justify-content-right d-flex">
					<button class="btn btn-warning mr-2" >Add</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=users'">back</button>
				</div>
            </form>
          	
		</div>		                             
    </div>
</div>
    	

<script>
	$('#frm-group').submit(function(e){
	
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=add_group',
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
						location.href = 'index.php?page=users'
					},2000)
				}
			}
		})
	})
</script>
