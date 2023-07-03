<?php 
include 'db_connect.php';
session_start();
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM task_list where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}

$UserID = $_SESSION['login_id'];
$BtnTimerNamae = 'Start Timer' ;
$querie = '' ;
$task_id = $_GET['id'];
$qry1 = $conn->query("SELECT * FROM task_timesheet WHERE user_id= '$UserID' and task_id =  '$task_id' and is_timer_start = true ");
if($qry1->num_rows > 0){	

	$BtnTimerNamae = 'Stop Timer' ;
}

 
?>

<div class="container-fluid">
<form action="" id="task-form">
<div class="row">
  <div class="col-8">
  <input type="hidden" class="form-control" name="id" id="id"  value="<?php echo $_GET['id'] ?>">
  <input type="hidden" class="form-control" name="reason" id="reason"  value="Lunch">
  <input   type="hidden" class="form-control" name="user_id"  id="user_id" value="<?php echo $_SESSION['login_id'] ?>">
		<dl>
		<dt><b class="border-bottom border-primary">Task</b></dt>
		<dd><?php echo ucwords($task) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Status</b></dt>
		<dd>			        	
		<?php 
        	if($status == 1){
		  		echo "<span class='badge badge-secondary'>Pending</span>";
        	}elseif($status == 2){
		  		echo "<span class='badge badge-primary'>On-Progress</span>";
        	}elseif($status == 3){
		  		echo "<span class='badge badge-success'>Done</span>";
        	}
        	?>
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Description</b></dt>
		<dd><?php echo html_entity_decode($description) ?></dd>
	</dl>
	<dl>
	<dt><b class="border-bottom border-primary">Comment</b></dt>
	<dd>
		<div class="row">
			<div class="col-md-8">
			<input type="text" class="form-control form-control-sm" placeholder="if any" name="cmmt" id="cmmt">
		</div>
		<div class="col-md-4">
		<button class="btn btn-warning bg-gradient-warning btn-sm" type="button" name="comment" id="comment">Add Comment</button>    
		</div>
		</div>
		
		            
	</dd>
	</dl>
</div>
<div class="col-4">
<dl>
		<dt><b class="border-bottom border-primary">Milestone:</b></dt>
		<dd><?php echo html_entity_decode($milestone) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Start Date:</b></dt>
		<dd>
		<?php 
		
		$qry1 = $conn->query("SELECT * FROM `task_timesheet` WHERE user_id = '$UserID' and task_id = '$task_id' order by date asc limit 1");
		if($qry1->num_rows > 0){	
		
			$row= $qry1->fetch_assoc();
			echo $row['date'] ;
		}
		else{
			echo "Not Started";
		}
		
		
		
		?>
		
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Deadline:</b></dt>
		<dd><?php echo html_entity_decode($deadline) ?></dd>
	</dl>
	<!-- <dl>
		<dt><b class="border-bottom border-primary">Collaborators:</b></dt>
		<dd></dd>          	
	</dl> -->
	<?php if($_SESSION['login_type'] == 3): ?>        
		
                <div class="card-tools">
                <button class="btn btn-warning bg-gradient-warning btn-sm" type="submit"  name="timer" id="timer"><?php echo($BtnTimerNamae); ?></button>                
                </div>
     <?php endif; ?>
		
</div>
</div>
</form>
<hr>
<?php 
$task_id = $_GET['id'];
$task_id = $_GET['id'];
$qry = $conn->query("SELECT firstname , lastname,  comment , task_comment.date_created FROM `task_comment` join users on task_comment.user_id = users.id where  user_id = $UserID and task_id = '$task_id'");
while($row= $qry->fetch_assoc()):

?>

<dl>
	<dt><b><?php echo $row['firstname'] ?> <?php echo $row['lastname'] ?></b><small style="display:inline"> <?php echo $row['date_created'] ?></small></dt>
	<dd><?php echo $row['comment'] ?></dd>
	</dl>


<?php endwhile; ?>
</div>	
<br>
<div class="float-right">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
<style>
#uni_modal .modal-footer{
	display:none;
}

</style>

<script>
$('#comment').click(function(e){	
	
	e.preventDefault()
	if( $("#cmmt").val() == ""){
		alert_toast('Enter Comment',"info");
		return;	
	}

	var formData = {
      task_id: $("#id").val(),
      user_id: $("#user_id").val(),
      comment: $("#cmmt").val(),
    };
	$.ajax({
			url:'ajax.php?action=task_comment',
			data:formData,
			cache: false,			
			method: 'POST',			
			success:function(resp){
				if(resp == 1){
					alert_toast('Comment added',"success");
					// setTimeout(function(){
					// 	location.reload()
					// },1500)
					uni_modal("Task Details","view_task.php?id="+$("#id").val(),"mid-large")
				}
				else{
					alert(resp);
					alert_toast('Failed',"error");
				}
			}
		})



});
$('#task-form').submit(function(e){	
		e.preventDefault()

		if($("#timer").text() == "Stop Timer")
		{
			uni_modal("Select reason ","reason.php?task_id=" + $("#id").val() ,'mid-large');
		}
		else {
		$.ajax({
			url:'ajax.php?action=task_timer',
			data:$(this).serialize(),
			cache: false,			
			method: 'POST',			
			success:function(resp){
				if(resp == 1){
					alert_toast('Timer  Start',"success");
				    $("#timer").html("Stop Timer");
					// setTimeout(function(){
					// 	location.reload()
					// },1500)
				} else if (resp == 2) {
                    alert_toast('Timer Stop',"success");
					$("#timer").html("Start Timer");
				}
				else{
					alert_toast('Failed',"error");
				}
			}
		})
		}						
    })
</script>