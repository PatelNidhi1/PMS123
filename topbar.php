<?php include'db_connect.php' ;
 
  $qry = $conn->query("SELECT * FROM Announcement");
  $count = $qry->num_rows;
  $_SESSION['s_row_count'] = $count;
?>
<?php include_once "chatHeader.php"; ?>

<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-warning navbar-dark ">
  
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <?php if(isset($_SESSION['login_id'])): ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php endif; ?>
      <li>
        <a class="nav-link text-white"  href="./" role="button"> <large><b>Project Management System</b></large></a> 
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown ">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge new_count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">                  
          <span class="dropdown-item dropdown-header">Notifications</span>                   
                    
          <div class="notification">
          <input type="hidden" class="row_count"  value="<?php echo $count ?>">
          </div>

          <div class="dropdown-divider-new"></div>
          <a href="./index.php?page=announcement" class="dropdown-item dropdown-footer">See All Announcement</a>
        </div>
      </li>
     <li class="nav-item dropdown">
            <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
              <span>
                <div class="d-felx badge-pill">
                  <span class="fa fa-user mr-2"></span>
                  <span><b><?php echo ucwords($_SESSION['login_firstname']) ?></b></span>
                  <span class="fa fa-angle-down ml-2"></span>
                </div>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
              <a class="dropdown-item" href="javascript:void(0)" id="manage_account"><i class="fa fa-cog"></i> Manage Account</a>
              <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
            </div>
      </li>
    </ul>
  </nav>
<!-- /.navbar -->
<script>
    $('#manage_account').click(function(){
      uni_modal('Manage Account','manage_user.php?id=<?php echo $_SESSION['login_id'] ?>')
    })
    
  function view_announcement(id)
  {
    uni_modal("Announcement","view_announcement.php?id="+id,"mid-large")
  }

  
</script>
<script src="assets/dist/js/notification.js"></script>
