<?php include'db_connect.php' ?>
<div class="col-lg-12">
<div class="card card-outline card-warning">
       
<div class="card-header">
    <div class="card-tools">
    <?php if($_SESSION['login_type'] != 3): ?> 
        <button class="btn btn-warning bg-gradient-warning btn-sm" type="button" name="announcement" id="announcement">
        <i class="fa fa-plus"></i>Add Announcement</button>
        <?php endif; ?>                
    </div>
</div>

<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="35%">
					<col width="60%">					
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						
						<th class="text-left">Title</th>						
						<th class="text-left">Announcement</th>	
						<th class="d-none">id</th>					
					</tr>
				</thead>

				<tbody>					
				<?php
                    $i = 1;
					$qry = $conn->query("SELECT * FROM announcement order by date_created desc");
					while($row= $qry->fetch_assoc()):						
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>		
															
						<td class="text-left"><b><?php  echo($row['title']) ?></b></td>																		
						<td class="text-left"><b><?php  echo($row['text']) ?></b></td>
						<td class="d-none"><?php echo($row['id']) ?></td>																		
					</tr>	
				<?php endwhile; ?>
		
				</tbody>
			</table>
		</div>
        </div>
        </div>
<style>
table p{
margin: unset !important;
}
table td{
vertical-align: middle !important
}
table#list tbody  tr {
cursor : pointer;
}
</style>				
<script>
$(document).ready(function(){
$('#list').dataTable();
$('#list').ddTableFilter();

//Click method on row
$( "#list tbody tr" ).on( "click", function( event ) {
 
 // get back to where it was before if it was selected :
 
 var id=$(this).find("td").eq(2).html();
 
 uni_modal("Announcement","view_announcement.php?id="+id,"mid-large")
 
});



$('#announcement').click(function(e){
uni_modal("Add Announcement","new_announcement.php" ,'mid-large');
});

});

</script> 