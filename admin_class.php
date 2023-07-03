<?php
session_start();
ini_set('display_errors', 1);
include "email.php";
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where email = '".$email."' and password = '".md5($password)."'  ");
		if($qry->num_rows > 0){
				
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}

			$userid = $_SESSION['login_id'];
			
			$update = $this->db->query("Update users set status = 'Active now' where id = $userid");

		// 	$_SESSION['user'] = $userid;
			$_SESSION['user']['permissions'] = [];
			
		    $role_id = $_SESSION['login_role_id'];
			
		//    $qry2 = $this->db->query("SELECT * FROM roles_permissions");			
			
		//    while($row= $qry2->fetch_assoc()){
		// 	if (!isset($_SESSION['user']['permissions'][$row['perm_mod']])) {
		// 		$_SESSION['user']['permissions'][$row['perm_mod']] = [];
		// 		}
		// 		$_SESSION['user']['permissions'][$row['perm_mod']][] = $row['perm_id'];	
		// 	}
																  
		$get = $this->db->query("SELECT * FROM roles_permissions where role_id = $role_id");

		while($row= $get->fetch_assoc()){
			if (!isset($_SESSION['user']['permissions'][$row['perm_mod']])) {
			$_SESSION['user']['permissions'][$row['perm_mod']] = [];
			}
			$_SESSION['user']['permissions'][$row['perm_mod']][] = $row['perm_id'];	
		}	
		
		return 1;

		}else{
			return 2;
		}
	}
	function logout(){
		$userid = $_SESSION['login_id'];
			
		$update = $this->db->query("Update users set status = 'Offline now' where id = $userid");

		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function login2(){
		extract($_POST);
			$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM students where student_code = '".$student_code."' ");
		if($qry->num_rows > 0){
			

			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['rs_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function save_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(!empty($password)){
					$data .= ", password=md5('$password') ";

		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$ran_id = rand(time(), 100000000);
			$data .= ", avatar = '$fname' , unique_id = '$ran_id' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function save_notes(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass')) && !is_numeric($k)){				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}	

		   $delete =  $this->db->query(" delete from notes where user_id={$_SESSION['login_id']}"); 

		    $data .= ", user_id={$_SESSION['login_id']} ";					

			$save = $this->db->query("INSERT INTO notes set $data");
		

		if($save){			
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass')) && !is_numeric($k)){
				if($k =='password'){
					if(empty($v))
						continue;
					$v = md5($v);

				}
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}

		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");

		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			if(empty($id))
				$id = $this->db->insert_id;
			foreach ($_POST as $key => $value) {
				if(!in_array($key, array('id','cpass','password')) && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
					$_SESSION['login_id'] = $id;
				if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}

	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table','password')) && !is_numeric($k)){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
			$data .= ", avatar = '$fname' ";

		}
		if(!empty($password))
			$data .= " ,password=md5('$password') ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if(isset($_FILES['img']) && !empty($_FILES['img']['tmp_name']))
					$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function save_system_settings(){
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(!is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if($_FILES['cover']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
			$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/uploads/'. $fname);
			$data .= ", cover_img = '$fname' ";

		}
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set $data where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set $data");
		}
		if($save){
			foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					$_SESSION['system'][$k] = $v;
				}
			}
			if($_FILES['cover']['tmp_name'] != ''){
				$_SESSION['system']['cover_img'] = $fname;
			}
			return 1;
		}
	}
	function save_image(){
		extract($_FILES['file']);
		if(!empty($tmp_name)){
			$fname = strtotime(date("Y-m-d H:i"))."_".(str_replace(" ","-",$name));
			$move = move_uploaded_file($tmp_name,'assets/uploads/'. $fname);
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
			$hostName = $_SERVER['HTTP_HOST'];
			$path =explode('/',$_SERVER['PHP_SELF']);
			$currentPath = '/'.$path[1]; 
			if($move){
				return $protocol.'://'.$hostName.$currentPath.'/assets/uploads/'.$fname;
			}
		}
	}
	function save_project(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','user_ids')) && !is_numeric($k)){
				if($k == 'description')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(isset($user_ids)){
			$data .= ", user_ids='".implode(',',$user_ids)."' ";
		}
		// echo $data;exit;
		if(empty($id)){
			$save = $this->db->query("INSERT INTO project_list set $data");
		}else{
			$save = $this->db->query("UPDATE project_list set $data where id = $id");
		}
		if($save){
			//sendEmail();
			$id =  $this->test();
			return 1;
		}
	}

    function test(){
		$i = 123;

		return i;
	}

	function send_email(){
		// extract($_POST);
		// $data = "";
		// foreach($_POST as $k => $v){
		// 	if(!in_array($k, array('id','user_ids')) && !is_numeric($k)){
		// 		if($k == 'description')
		// 			$v = htmlentities(str_replace("'","&#x2019;",$v));
		// 		if(empty($data)){
		// 			$data .= " $k='$v' ";
		// 		}else{
		// 			$data .= ", $k='$v' ";
		// 		}
		// 	}
		// }
		
		sendEmail();
	  		
	}


	function save_notification(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','user_ids' , 'enable_email')) && !is_numeric($k) ){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(isset($user_ids)){
			$data .= ", user_ids='".implode(',',$user_ids)."' ";
		}

		if(isset($enable_email)){
			$data .= ", enable_email= 1 ";
		}
		else{
			$data .= ", enable_email= 0 ";
		}

		// echo $data;exit;
		
			$save = $this->db->query("UPDATE notification set $data where id = $id");
		
		if($save){
			return 1;
		}
	}


	function save_email_settings(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){		
			if(empty($data)){
				$data .= " $k='$v' ";
			}else{
				$data .= ", $k='$v' ";
			}
		}
		
		$save = $this->db->query("UPDATE email_settings set $data ");
		
		if($save){
			return 1;
		}
	}

	function delete_project(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM project_list where id = $id");
		if($delete){
			return 1;
		}
	}
	function save_task(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'description')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO task_list set $data");
		}else{
			$save = $this->db->query("UPDATE task_list set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}

	


	function delete_task(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM task_list where id = $id");
		if($delete){
			return 1;
		}
	}
	function save_progress(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id')) && !is_numeric($k)){
				if($k == 'comment')
					$v = htmlentities(str_replace("'","&#x2019;",$v));
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$dur = abs(strtotime("2020-01-01 ".$end_time)) - abs(strtotime("2020-01-01 ".$start_time));
		$dur = $dur / (60 * 60);
		$data .= ", time_rendered='$dur' ";
		// echo "INSERT INTO user_productivity set $data"; exit;
		if(empty($id)){

			

			$data .= ", user_id={$_SESSION['login_id']} ";
			
			$save = $this->db->query("INSERT INTO user_productivity set $data");
		}else{
			$save = $this->db->query("UPDATE user_productivity set $data where id = $id");
		}
		if($save){
			return 1;
		}
	}
	function delete_progress(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM user_productivity where id = $id");
		if($delete){
			return 1;
		}
	}
	function get_report(){
		extract($_POST);
		$data = array();
		$get = $this->db->query("SELECT t.*,p.name as ticket_for FROM ticket_list t inner join pricing p on p.id = t.pricing_id where date(t.date_created) between '$date_from' and '$date_to' order by unix_timestamp(t.date_created) desc ");
		while($row= $get->fetch_assoc()){
			$row['date_created'] = date("M d, Y",strtotime($row['date_created']));
			$row['name'] = ucwords($row['name']);
			$row['adult_price'] = number_format($row['adult_price'],2);
			$row['child_price'] = number_format($row['child_price'],2);
			$row['amount'] = number_format($row['amount'],2);
			$data[]=$row;
		}
		return json_encode($data);

	}

	function task_timer(){
		extract($_POST);


		$qry = $this->db->query("SELECT * FROM `task_timesheet` WHERE date = CURRENT_DATE() and is_timer_start = 1 and task_id = $id and user_id = $user_id");
		if($qry->num_rows > 0){
			$update = $this->db->query("update task_timesheet set end_time = now() , reson = '$reason', is_timer_start = false WHERE date = CURRENT_DATE() and is_timer_start = 1 and task_id = $id and user_id = $user_id");
			if($update){
				return 2;
			}
		}else{
			$insert = $this->db->query("INSERT into task_timesheet ( task_id , user_id , date, start_time , is_timer_start ) VALUES ( '$id', '$user_id' , now() ,now() , true ) ");
			if($insert){
				return 1;
			}
		}


		
	}
	function task_comment(){
		extract($_POST);
           $id = $_POST['task_id'];
		   $user_id = $_POST['user_id'];
		   $comment = $_POST['comment'];

			$insert = $this->db->query("INSERT into task_comment ( task_id , user_id  , comment ) VALUES ( $id ,$user_id ,'$comment' ) ");
			if($insert){
				return 1;
			} 
	}
	function add_event(){
		extract($_POST);
		$x = 0 ;
		$_date = $date;

		$insert;
		do {
			$insert = $this->db->query("INSERT into `events` ( created , date , title ) VALUES ( now() , cast( '$_date' as date) , '$eventName' );");
			
			$_date = date('Y-m-d', strtotime($_date. ' + ' . $repeatDay . 'days'));
			$x++;
		  } while ($x <= $repeatNumber);
		
		  if($insert){
			return 1;
		}

	}

	function add_leave(){
		extract($_POST);				
		$insert = $this->db->query("insert into `leave`(leave_id,leave_from,leave_to,employee_id,leave_description,leave_status) values('$leave_id', cast( '$leave_from' as date) ,cast( '$leave_to' as date),'$user_id','$leave_description',1)");							
		if($insert){
			return 1;
		}
		else{
			return 2;
		}
	}

	function update_leave(){
		extract($_POST);
		$id = $_POST['_id'];
		$status = $_POST['s_id'];		  

		$update = $this->db->query(" update `leave` set leave_status='$status' where id='$id'");
		if($update){
			return 1;
		} 

	}

	function check_attendance(){
		$qry = $this->db->query("SELECT * FROM `attendance` WHERE end_time is null and date < now()");
		if($qry->num_rows > 0){			
			return 1;
		}else{
			return 2;
		}				
	}

	function update_clock(){
		$qry = $this->db->query(" UPDATE attendance set end_time = '19:00:00' where  end_time is null and date < now()");
		if($qry){			
			return 1;
		}				
	}

	function add_group(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','user_ids')) && !is_numeric($k)){
				
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}


			}
		}

		$ran_id = rand(time(), 100000000);
		$data .= ",  unique_id = '$ran_id' ";
		
		if(isset($user_ids)){
			
			$usersID = implode(',',$user_ids);
			$usersID .= ','. $_SESSION['login_id'];
			//$data .= ", user_ids='".implode(',',$user_ids)."' ";
			$data .= ", user_ids='$usersID' ";
			
		}

		

		// echo $data;exit;
		if(empty($id)){
			$save = $this->db->query("INSERT INTO `group` set $data");
		}
		// }else{
		// 	$save = $this->db->query("UPDATE project_list set $data where id = $id");
		// }
		if($save){
			return 1;
		}
	}

	function add_announcement(){
		extract($_POST);
		$data = "";

		foreach($_POST as $k => $v){							
			if(empty($data)){
				$data .= " $k='$v' ";
			}else{
				$data .= ", $k='$v' ";
			}			
		}

		$insert = $this->db->query("INSERT into `announcement` set $data");								 		
		  if($insert){
			return 1;
		}

	}

	function add_ticket(){
		extract($_POST);
		$data = "";

		foreach($_POST as $k => $v){							
			if(empty($data)){
				$data .= " $k='$v' ";
			}else{
				$data .= ", $k='$v' ";
			}			
		}

		$insert = $this->db->query("INSERT into `tickets` set $data");								 		
		  if($insert){
			return 1;
		}

	}

	function add_link(){
		extract($_POST);
		$data = "";

		foreach($_POST as $k => $v){							
			if(empty($data)){
				$data .= " $k='$v' ";
			}else{
				$data .= ", $k='$v' ";
			}			
		}

		$insert = $this->db->query("INSERT into `links` set $data");								 		
		  if($insert){
			return 1;
		}

	}
	
	function add_issue(){
		extract($_POST);
		$data = "";

		foreach($_POST as $k => $v){							
			if(empty($data)){
				$data .= " $k='$v' ";
			}else{
				$data .= ", $k='$v' ";
			}			
		}

		$insert = $this->db->query("INSERT into `issues` set $data");								 		
		  if($insert){
			return 1;
		}

	}

	function add_rolerights(){
		extract($_POST);		
		$role_id = $_POST['role_id'];

				

		$delete = $this->db->query("delete from roles_permissions where role_id = $role_id");


		if (isset($_POST['Dashboard'])){

			$check_id = $_POST['Dashboard'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

		if (isset($_POST['Announcements'])){

			$check_id = $_POST['Announcements'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

		if (isset($_POST['Projects'])){

			$check_id = $_POST['Projects'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

		if (isset($_POST['Report'])){

			$check_id = $_POST['Report'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}


		if (isset($_POST['Messages'])){

			$check_id = $_POST['Messages'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

		if (isset($_POST['Users'])){

			$check_id = $_POST['Users'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

		if (isset($_POST['Notes'])){

			$check_id = $_POST['Notes'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

		if (isset($_POST['Timesheet'])){

			$check_id = $_POST['Timesheet'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

	

		if (isset($_POST['Events'])){

			$check_id = $_POST['Events'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

		if (isset($_POST['Leave'])){

			$check_id = $_POST['Leave'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

		if (isset($_POST['WorkSupport'])){

			$check_id = $_POST['WorkSupport'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}

		if (isset($_POST['Settings'])){

			$check_id = $_POST['Settings'];
			$insert = $this->db->query("insert into `roles_permissions` (role_id,perm_mod, perm_id) values ($role_id,'USR', $check_id)");
		}
		
	   if($delete){
		 	return 1;
		}

	}
	
}

