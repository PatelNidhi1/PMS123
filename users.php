<?php   
  include_once "chatPHP/config.php";  
?>
<?php include_once "chatHeader.php"; ?>
<body>
  <div class="wrapper">
    <section class="users">
   
      <header>
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['login_unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
          <img src="assets/uploads/<?php echo $row['avatar']?>" alt="img">
          <div class="details">
            <span><?php echo $row['firstname']. " " . $row['lastname'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
          <br/>                              
        </div>  
        
        <a href="./index.php?page=group" class="btn btn-flat btn-sm bg-gradient-warning btn-warning "><i class="fa fa-users"></i> Add Group</a>             
        
      </header>
      <div class="search">
        <span class="text">Select a user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script src="assets/dist/js/chatJS/users.js"></script>

</body>
</html>

<script>
$('#addGroup').click(function(){
  uni_modal("Add Group","group.php" ,'mid-large');
});
</script>
