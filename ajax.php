<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}

if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'save_notes'){	
	$saveNotes = $crud->save_notes();
	if($saveNotes)
		echo $saveNotes;		
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'save_project'){
	$save = $crud->save_project();
	if($save)
		echo $save;
}

if($action == 'save_notification'){
	$save = $crud->save_notification();
	if($save)
		echo $save;
}

if($action == 'delete_project'){
	$save = $crud->delete_project();
	if($save)
		echo $save;
}
if($action == 'save_task'){
	$save = $crud->save_task();
	if($save)
		echo $save;
}
if($action == 'task_timer'){
	$task_timer = $crud->task_timer();
	if($task_timer)
		echo $task_timer;
}
if($action == 'add_event'){
	$add_event = $crud->add_event();
	if($add_event)
		echo $add_event;
}
if($action == 'task_comment'){
	$task_comment = $crud->task_comment();
	if($task_comment)
		echo $task_comment;
}
if($action == 'delete_task'){
	$save = $crud->delete_task();
	if($save)
		echo $save;
}
if($action == 'save_progress'){
	$save = $crud->save_progress();
	if($save)
		echo $save;
}
if($action == 'delete_progress'){
	$save = $crud->delete_progress();
	if($save)
		echo $save;
}
if($action == 'get_report'){
	$get = $crud->get_report();
	if($get)
		echo $get;
}
if($action == 'start_time'){
	$save = $crud->start_timer();
	if($save)
		echo $save;
}
if($action == 'add_leave'){
	$add_leave = $crud->add_leave();
	if($add_leave)
		echo $add_leave;
}
if($action == 'update_leave'){
	$update_leave = $crud->update_leave();
	if($update_leave)
		echo $update_leave;
}

if($action == 'check_attendance'){
	$check_attendance = $crud->check_attendance();
	if($check_attendance)
		echo $check_attendance;
}

if($action == 'update_clock'){
	$update_clock = $crud->update_clock();
	if($update_clock)
		echo $update_clock;
}

if($action == 'add_group'){
	$add_group = $crud->add_group();
	if($add_group)
		echo $add_group;
}

if($action == 'add_ticket'){
	$add_ticket = $crud->add_ticket();
	if($add_ticket)
		echo $add_ticket;
}

if($action == 'add_announcement'){
	$add_announcement = $crud->add_announcement();
	if($add_announcement)
		echo $add_announcement;
}

if($action == 'add_link'){
	$add_link = $crud->add_link();
	if($add_link)
		echo $add_link;
}

if($action == 'add_issue'){
	$add_issue = $crud->add_issue();
	if($add_issue)
		echo $add_issue;
}

if($action == 'add_rolerights'){
	$add_rolerights = $crud->add_rolerights();
	if($add_rolerights)
		echo $add_rolerights;
}


if($action == 'save_email_settings'){
	$save_email_settings = $crud->save_email_settings();
	if($save_email_settings)
		echo $save_email_settings;
}

if($action == 'send_email'){
	$send_email = $crud->send_email();
	if($send_email)
		echo $send_email;
}




ob_end_flush();
?>
