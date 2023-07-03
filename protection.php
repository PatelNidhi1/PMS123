<?php
// // (A) LET'S SAY THAT THIS SCRIPT IS USED TO UPDATE A USER
// $_POST = [
//   "id" => 2,
//   "email" => "joy@doe.com",
//   "name" => "Joy Doe",
//   "password" => "123456",
//   "role" => 1
// ];


// (B) PERMISSIONS CHECK FUNCTION
// Keep this somewhere in your "core library".
function check ($module, $id) {
  return in_array($id, $_SESSION['user']['permissions'][$module]);
}

// // (C) WE WILL CHECK IF THE USER HAS PERMISSIONS TO DO SO FIRST
// require "2a-core.php";
// if (!check ("USR", 3)) {
//   die("NO PERMISSION TO ACCESS!");
// }

// // (D) PROCEED IF OK
// try {
//   $stmt = $pdo->prepare("UPDATE `users` SET `user_email`=?, `user_name`=?, `user_password`=?, `role_id`=? WHERE `user_id`=?");
//   $stmt->execute([$_POST['email'], $_POST['name'], $_POST['password'], $_POST['role'], $_POST['id']]);
// } catch (Exception $ex) {
//   print_r($ex);
//   die();
// }
// echo "UPDATE OK!";