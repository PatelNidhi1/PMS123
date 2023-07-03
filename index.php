
<!DOCTYPE html>
<html lang="en">
<?php session_start() ?>
<?php 
	if(!isset($_SESSION['login_id']))
	    header('location:login.php');
    include 'db_connect.php';
    ob_start();
  if(!isset($_SESSION['system'])){

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  }
  ob_end_flush();
  
	include 'header.php' ;
?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <?php include 'topbar.php' ?>
  <?php include 'sidebar.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	 <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
	    <div class="toast-body text-white">
	    </div>
	  </div>
    <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title ?></h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
            <hr class="border-warning">
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         <?php 
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';

            switch ($page) {
              case "home":
                check_protection(1, $page);
                break;
              case "announcement":
                check_protection(2, $page);
                break;
              case "new_project":
                check_protection(3, $page);
                break;
              case "edit_project":
                check_protection(3, $page);
                break;
              case "project_list":
                check_protection(3, $page);
                break;    
              case "view_project":
                check_protection(3, $page);
                break;         
              case "task_list":
                check_protection(3, $page);
                break;
              case "gantt":
                check_protection(3, $page);
                break;

              case "reports":
                check_protection(4, $page);
                break;

              case "users":
                check_protection(5, $page);
                break;

              case "new_user":
                check_protection(6, $page);
                break;
              case "user_list":
                check_protection(6, $page);
                break;

              case "notes":
                check_protection(7, $page);
                break; 
              case "attendance":
                check_protection(8, $page);
                break; 

              case "events":
                check_protection(9, $page);
                break;   
              
              case "leave":
                check_protection(10, $page);
                break; 
              case "work_support":
                check_protection(11, $page);
                break; 
              case "rolerights":
                check_protection(12, $page);
                break;
              case "settings":
                check_protection(13, $page);
                break;
              case "edit_notification":
                check_protection(13, $page);
                break;
              case "tickets":
                check_protection(13, $page);
                break;
              default:
                include '404.html';
            }

           
            

            function check_protection ($module, $_page) 
            {
              if (!check ("USR", $module))
                {
                  include '404.html';
                }
              else {
                if(!file_exists($_page.".php"))
                {
                    include '404.html';
                }else
                {
                    include $_page.'.php';  
                }
              }
            }
          ?>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer --> 
  <footer class="main-footer">
    <strong>© 2021, Designed by Nidhi </strong>
    
    <div class="float-right d-none d-sm-inline-block">
      <b>Project Management System</b>
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- Bootstrap -->
<?php include 'footer.php' ?>
</body>
</html>
