<?php include'db_connect.php' ?>
<div class="col-lg-12 tab">
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-links-tab" data-toggle="tab" href="#nav-links" role="tab" aria-controls="nav-links" aria-selected="true">Links</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Employee Issues</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-links" role="tabpanel" aria-labelledby="nav-links-tab">
    <div class="card card-outline card-warning">
		<div class="card-header">	
                Useful Links For Users
				<div class="card-tools">
					<button id="link" type="button" class="btn btn-block btn-sm btn-default btn-flat border-warning"><i class="fa fa-plus"></i> Post Link</button>
				<!-- <a class="btn btn-block btn-sm btn-default btn-flat border-warning" href="./index.php?page=new_user"><i class="fa fa-plus"></i> Post Link</a> -->
			</div>
		</div>
		<div class="card-body">            
      <?php
                    $i = 1;
					$qry = $conn->query("SELECT * FROM links order by date_created desc");
					while($row= $qry->fetch_assoc()):						
					?>
        <dl>
          <dt><?php  echo($row['title']) ?>
          </dt>

          <?php

                // Given URL
                $url = $row['url'];
                  
                // Search substring 
                $key = 'http:';
                  
                if (strpos($url, $key) == false) {
                    $url = '//' . $url ;
                }                
          ?>

          <dd>
          <a href="<?php  echo($url) ?>" target="_blank"><?php  echo($row['url']) ?></a>
          </dd>        
        </dl> 
        <hr/>
			<?php endwhile; ?>
		</div>
    </div>  
  </div>

  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <div class="card card-outline card-warning">
		<div class="card-header">	
                Issues with Solution
				<div class="card-tools">
					<button id="issue" type="button" class="btn btn-block btn-sm btn-default btn-flat border-warning"><i class="fa fa-plus"></i> Post</button>
				
			</div>
		</div>
		<div class="card-body">            
      <?php
                    $i = 1;
					$qry = $conn->query("SELECT * FROM issues order by date_created desc");
					while($row= $qry->fetch_assoc()):						
					?>
        <dl>
          <dt><?php  echo($row['issue']) ?>
          </dt>
        
          <dd>
          <?php  echo($row['solution']) ?>
          </dd>        
        </dl> 
        <hr/>
			<?php endwhile; ?>
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
		$('#link').click(function(e){
			uni_modal("Add Link","new_link.php" ,'mid-large');
			});

      $('#issue').click(function(e){
			uni_modal("Add issue","new_issue.php" ,'mid-large');
			});


	})
</script>