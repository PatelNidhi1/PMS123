<?php 
include 'db_connect.php';
    $qry = $conn->query("SELECT * FROM email_settings ")->fetch_array();
    foreach($qry as $k => $v){
        $$k = $v;
        
    }    
?>
<div class="col-lg-12 tab">
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-email-tab" data-toggle="tab" href="#nav-email" role="tab" aria-controls="nav-email" aria-selected="true">Email</a>
    <a class="nav-item nav-link" id="nav-notification-tab" data-toggle="tab" href="#nav-notification" role="tab" aria-controls="nav-notification" aria-selected="false">Notification</a>
  </div>
</nav>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-email" role="tabpanel" aria-labelledby="nav-email-tab">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <div class="card-tools">
                
                </div>
            </div>
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
  <div class="tab-pane fade" id="nav-notification" role="tabpanel" aria-labelledby="nav-notification-tab">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <div class="card-tools">
                
                </div>
            </div>
            <div class="card-body">
            <table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="35%">
					<!-- <col width="15%"> -->
					<col width="15%">
					<col width="20%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Event</th>
						<!-- <th>Notify to</th> -->
						<th>Category</th>
						<th class="text-center">Enable Email</th>
						<th>Action</th>
						
					</tr>
				</thead>
				<tbody>					
				<?php
					$i = 1;
					
					$qry = $conn->query("SELECT * FROM notification order by event asc");
					while($row= $qry->fetch_assoc()):
						
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td class="click">
							<p><b><?php echo ucwords($row['event']) ?></b></p>							
						</td>
						<!-- <td class="click"><b><?php echo ucwords($row['user_ids']) ?></b></td> -->
						<td class="click"><b><?php echo ucwords($row['category']) ?></b></td>
						<td class="text-center click">
							<?php
							  if($row['enable_email'] =='0')
							  {
							  	echo "<b>False</b>";
							  }
							  else
							  {
								echo "<b>True</b>";
							  }
							?>
						</td>
						
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-warning wave-effect text-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
							<a class="dropdown-item view_notification" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>		                      
		                    </div>
						</td>
						<td class="d-none"><?php echo $row['id'] ?></td>
					</tr>	
				<?php endwhile; ?>
		
				</tbody>
			</table>
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

	$('.view_notification').click(function(){
		uni_modal("<i class='fa fa-id-card'></i> Notification Details","edit_notification.php?id="+$(this).attr('data-id'),'mid-large')
	})
</script>
