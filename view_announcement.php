<?php 
include 'db_connect.php';
session_start();
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM announcement where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>

<div class="container-fluid">
<form action="" id="task-form">
<div class="row">
  <div class="col-12">
  <input type="hidden" class="form-control" name="id" id="id"  value="<?php echo $_GET['id'] ?>">  
    <dl>
		<dt><b class="border-bottom border-primary">Title</b></dt>
		<dd><?php echo ucwords($title) ?></dd>
	</dl>	
	<dl>
		<dt><b class="border-bottom border-primary">Announcement</b></dt>
		<dd><?php echo html_entity_decode($text) ?></dd>
	</dl>	
   </div>
</di>
<br>
<div class="float-right">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
</div>
<form>
</div>


<style>
#uni_modal .modal-footer{
	display:none;
}

</style>

