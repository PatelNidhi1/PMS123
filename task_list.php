<?php include'db_connect.php' ?>
<div class="col-lg-12 tab">
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">List</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Kanban</a>
  </div>
</nav>

<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
  <div class="card card-outline card-warning">
		<div class="card-header">
			<div class="card-tools">
			<?php if($_SESSION['login_type'] != 3): ?>
				<a class="btn btn-block btn-sm btn-default btn-flat border-warning" href="./index.php?page=new_project"><i class="fa fa-plus"></i> Add New project</a>
			<?php endif; ?>	
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="25%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
					
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>						
						<th>Project</th>
						<th>Task</th>
						<th>Project Started</th>
						<th>Project Due Date</th>
						<th>Project Status</th>
						<th>Task Status</th>
						<th class="d-none">taskid</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$i = 1;
					$where = "";
					if($_SESSION['login_type'] == 2){
						$where = " where p.manager_id = '{$_SESSION['login_id']}' ";
					}elseif($_SESSION['login_type'] == 3){
						$where = " where concat('[',REPLACE(p.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
					}
					
					$stat = array("Pending","Started","In-Progress","On-Hold","Over Due","Done");
					$qry = $conn->query("SELECT t.*,p.name as pname,p.start_date,p.status as pstatus, p.end_date,p.id as pid FROM task_list t inner join project_list p on p.id = t.project_id $where order by p.name asc");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['description']),$trans);
						$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
						$tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['pid']}")->num_rows;
		                $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['pid']} and status = 3")->num_rows;
						$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
		                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
		                $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['pid']}")->num_rows;
		                if($row['pstatus'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
		                if($prod  > 0  || $cprog > 0)
		                  $row['pstatus'] = 2;
		                else
		                  $row['pstatus'] = 1;
		                elseif($row['pstatus'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
		                $row['pstatus'] = 4;
		                endif;

					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>						
						<td>
							<p><b><?php echo ucwords($row['pname']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['task']) ?></b></p>
							<p class="truncate"><?php echo strip_tags($desc) ?></p>
						</td>
						<td><b><?php echo date("M d, Y",strtotime($row['start_date'])) ?></b></td>
						<td><b><?php echo date("M d, Y",strtotime($row['end_date'])) ?></b></td>
						<td class="text-center">
							<?php
							  if($stat[$row['pstatus']] =='Pending'){
							  	echo "<span class='badge badge-secondary'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='Started'){
							  	echo "<span class='badge badge-primary'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='In-Progress'){
							  	echo "<span class='badge badge-info'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='On-Hold'){
							  	echo "<span class='badge badge-warning'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='Over Due'){
							  	echo "<span class='badge badge-danger'>{$stat[$row['pstatus']]}</span>";
							  }elseif($stat[$row['pstatus']] =='Done'){
							  	echo "<span class='badge badge-success'>{$stat[$row['pstatus']]}</span>";
							  }
							?>
						</td>
						<td>
                        	<?php 
                        	if($row['status'] == 1){
						  		echo "<span class='badge badge-secondary'>Pending</span>";
                        	}elseif($row['status'] == 2){
						  		echo "<span class='badge badge-primary'>In-Progress</span>";
                        	}elseif($row['status'] == 3){
						  		echo "<span class='badge badge-success'>Done</span>";
                        	}
                        	?>
                        </td>
						<td class="d-none"><?php echo $row['id'] ?></td>
					</tr>	
				<?php endwhile; ?>		
				</tbody>
			</table>
		</div>
	</div>
  
  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <div class="card card-outline card-warning">
<div class="card-body">
<div class="row">

<div class="col-4">
<div class="card card-outline card-danger">
<div class="card-header">
<h3 class="text-center">To do</h3>
</div>
<div class="card-body">
<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="10%">
					<col width="70%">					
				</colgroup>				
				<tbody>
				<?php
					$i = 1;
					$where = "";
					if($_SESSION['login_type'] == 2){
						$where = " where project_list.manager_id = '{$_SESSION['login_id']}' and task_list.status = 1 ";
					}elseif($_SESSION['login_type'] == 3){
						$where = " where concat('[',REPLACE(project_list.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' and task_list.status = 1";
					}elseif($_SESSION['login_type'] == 1){
						$where = " where  task_list.status = 1";
					}
					
					$stat = array("Pending","Started","In-Progress","On-Hold","Over Due","Done");
					$qry = $conn->query("SELECT task FROM `task_list` JOIN `project_list` ON task_list.project_id=project_list.id $where");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class="text-center"><?php echo $row['task'] ?></td>						
					</tr>	
				<?php endwhile; ?>		
				</tbody>
			</table>
			</div>
			</div>
</div>
<div class="col-4">
<div class="card card-outline card-primary">
<div class="card-header">
<h3 class="text-center">In-progress</h3>
</div>
<div class="card-body">
<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
				<col width="10%">
					<col width="70%">	
				</colgroup>
				
				<tbody>
				<?php
					$i = 1;
					$where = "";
					if($_SESSION['login_type'] == 2){
						$where = " where project_list.manager_id = '{$_SESSION['login_id']}' and task_list.status = 2 ";
					}elseif($_SESSION['login_type'] == 3){
						$where = " where concat('[',REPLACE(project_list.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' and task_list.status = 2";
					}elseif($_SESSION['login_type'] == 1){
						$where = " where  task_list.status = 2";
					}
					
					$stat = array("Pending","Started","In-Progress","On-Hold","Over Due","Done");
					$qry = $conn->query("SELECT task FROM `task_list` JOIN `project_list` ON task_list.project_id=project_list.id $where");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);						
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class="text-center"><?php echo $row['task'] ?></td>						
					</tr>	
				<?php endwhile; ?>		
				</tbody>
			</table>
</div>
</div>
</div>
<div class="col-4">
<div class="card card-outline card-success">
<div class="card-header">
<h3 class="text-center" >Done</h3>
</div>
<div class="card-body">
<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
				<col width="10%">
					<col width="70%">	
				</colgroup>
				
				<tbody>
				<?php
					$i = 1;
					$where = "";
					if($_SESSION['login_type'] == 2){
						$where = " where project_list.manager_id = '{$_SESSION['login_id']}' and task_list.status = 3 ";
					}elseif($_SESSION['login_type'] == 3){
						$where = " where concat('[',REPLACE(project_list.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' and task_list.status = 3";
					}elseif($_SESSION['login_type'] == 1){
						$where = " where  task_list.status = 3";
					}
					
					$stat = array("Pending","Started","In-Progress","On-Hold","Over Due","Done");
					$qry = $conn->query("SELECT task FROM `task_list` JOIN `project_list` ON task_list.project_id=project_list.id $where");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class="text-center"><?php echo $row['task'] ?></td>						
					</tr>	
				<?php endwhile; ?>		
				</tbody>
			</table>

</div>
</div>
</div>

</div>
</div>
</div>
  
  </div>
</div>


	
</div>
<style>
	 .tab a{
        color:#495057;
    }

    .tab .nav-link.active{
        color:#007bff !important;
    }
	
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

		$( "#list tbody tr" ).on( "click", function( event ) {
 
 // get back to where it was before if it was selected :
 
 var id=$(this).find("td").eq(7).html();
 //window.location.href = "view_task.php&id="+id
 uni_modal("Task Details","view_task.php?id="+id,"mid-large")
 
});
       		
	// console.log("pid= " + $(this).attr('data-pid') +  "&tid= " +  $(this).attr('data-tid'));	


	$('.new_productivity').click(function(){
		uni_modal("<i class='fa fa-plus'></i> New Progress for: "+$(this).attr('data-task'),"manage_progress.php?pid="+$(this).attr('data-pid')+"&tid="+$(this).attr('data-tid'),'large')
	})
	})
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_project',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})

	}

</script>