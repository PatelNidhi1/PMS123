  <?php require "protection.php"; ?>

  <aside class="main-sidebar sidebar-dark-warning elevation-4">
    <div class="dropdown">
   	<a href="./" class="brand-link">
        <?php if($_SESSION['login_type'] == 1): ?>
        <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
        <?php else: ?>
        <h3 class="text-center p-0 m-0"><b>USER</b></h3>
        <?php endif; ?>

    </a>

      
    </div>
    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          
        <?php if (check ("USR", 1)): ?> 
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
        <?php endif; ?>

        <?php if (check ("USR", 2)): ?> 

          <li class="nav-item">
              <a href="./index.php?page=announcement" class="nav-link nav-announcement">
              <i class="nav-icon fas fa-bullhorn"></i>
                <p>Announcements</p>
              </a>
            </li>
        <?php endif; ?>

        <?php if (check ("USR", 3)): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_project nav-view_project">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Projects
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if($_SESSION['login_type'] != 3): ?>
              <li class="nav-item">
                <a href="./index.php?page=new_project" class="nav-link nav-new_project tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
            <?php endif; ?>
              <li class="nav-item">
                <a href="./index.php?page=project_list" class="nav-link nav-project_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>                         
            <li class="nav-item">
                <a href="./index.php?page=task_list" class="nav-link nav-task_list tree-item">
                  <i class="fas fa-tasks nav-icon"></i>
                  <p>Task</p>
                </a>
            </li>
            
              <li class="nav-item">
                <a href="./index.php?page=gantt" class="nav-link nav-gantt tree-item">
                  <i class="fas fa-chart-line nav-icon"></i>
                  <p>Gantt</p>
                </a>
              </li>             

            </ul>
          </li> 
        <?php endif; ?>

          

              
        <?php if (check ("USR", 4)): ?>
          <?php if($_SESSION['login_type'] != 3): ?>
           <li class="nav-item">
                <a href="./index.php?page=reports" class="nav-link nav-reports">
                  <i class="fas fa-th-list nav-icon"></i>
                  <p>Report</p>
                </a>
          </li>          
          <?php endif; ?>
        <?php endif; ?>

        <?php if (check ("USR", 5)): ?>
          <li class="nav-item">
              <a href="./index.php?page=users" class="nav-link nav-users nav-chat nav-group nav-groupchat">
              <i class="nav-icon fas fa-comments"></i>
                <p>Messages</p>
              </a>
        </li>
        <?php endif; ?>

        <?php if (check ("USR", 6)): ?>
        <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
        <?php endif; ?>
        <?php endif; ?>


        <?php if (check ("USR", 7)): ?>
        <?php if($_SESSION['login_type'] == 3): ?>
           <li class="nav-item">
                <a href="./index.php?page=notes" class="nav-link nav-notes">
                  <i class="fas fa-th-list nav-icon"></i>
                  <p>Notes</p>
                </a>
          </li>
        <?php endif; ?>
        <?php endif; ?>
       
        <?php if (check ("USR", 8)): ?>
        <li class="nav-item">
              <a href="./index.php?page=attendance" class="nav-link nav-attendance">
                <i class="fas fa-hourglass-half nav-icon"></i>
                <p>Timesheet</p>
              </a>
        </li>
        <?php endif; ?>

        <?php if (check ("USR", 9)): ?>
        <li class="nav-item">
              <a href="./index.php?page=events" class="nav-link nav-events">
                <i class="fas fa-calendar nav-icon"></i>
                <p>Events</p>
              </a>
        </li>
        <?php endif; ?>

        <?php if (check ("USR", 10)): ?>
        <li class="nav-item">
              <a href="./index.php?page=leave" class="nav-link nav-leave">
              <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Leave</p>
              </a>
        </li>
        <?php endif; ?>

        <?php if (check ("USR", 11)): ?>
        <li class="nav-item">
              <a href="./index.php?page=work_support" class="nav-link nav-work_support">
              <i class="fas fa-edit nav-icon"></i>
                <p>Work Support</p>
              </a>
        </li>
        <?php endif; ?>

        <?php if (check ("USR", 12)): ?>
        <li class="nav-item">
              <a href="./index.php?page=rolerights" class="nav-link nav-rolerights">
              <i class="fas fa-edit nav-icon"></i>
                <p>Role Rights</p>
              </a>
        </li>
        <?php endif; ?>
        
        <?php if (check ("USR", 13)): ?>
        <li class="nav-item">
              <a href="./index.php?page=settings" class="nav-link nav-settings">
              <i class="fa fa-cog nav-icon"></i>
                <p>Settings</p>
              </a>
        </li>
        <?php endif; ?>

        <?php if (check ("USR", 13)): ?>
        <li class="nav-item">
              <a href="./index.php?page=tickets" class="nav-link nav-settings">
              <i class="fa fa-cog nav-icon"></i>
                <p>Tickets</p>
              </a>
        </li>
        <?php endif; ?>
        </ul>
      </nav>
    </div>
  </aside>
 

  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
     
  	})
  </script>