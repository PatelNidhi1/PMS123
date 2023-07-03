<?php 
include 'db_connect.php';
$text = '';
$UserID = $_SESSION['login_id'];

$qry = $conn->query("SELECT * FROM notes WHERE user_id='$UserID' LIMIT 1");
	
if($qry->num_rows > 0){
	while($row = $qry->fetch_assoc()){
		$text = $row["text"] ;
	}
}

?>

<div class="col-lg-12">
	<div class="card card-outline card-warning">
		<div class="card-body">
		<form action="" id="notes" method="post">
							
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="" class="control-label">Add Notes</label>
						<textarea name="text" id="text" cols="30" rows="10" class="summernote form-control"><?php echo $text ?></textarea>
						
					</div>
				</div>
			</div>
			<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button type="submit" class="btn btn-warning mr-2" >Save</button>					
				</div>
		</form>
		</div>
	</div>
</div>

<script>
$('#notes').submit(function(e){		
		e.preventDefault()		
		$.ajax({
			url:'ajax.php?action=save_notes',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				console.log(resp);
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=notes')
					},750)
				}
			}
		})
	})
</script>

