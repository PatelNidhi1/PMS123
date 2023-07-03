<?php 
  
  include_once "chatPHP/config.php";

?>
<?php include_once "chatHeader.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $group_id = mysqli_real_escape_string($conn, $_GET['group_id']);
          $sql = mysqli_query($conn, "SELECT * FROM `group` WHERE unique_id = {$group_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: index.php?page=user");
          }
        ?>
        <a href="./index.php?page=users" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="assets/uploads/1606978560_avatar.jpg" alt="">
        <div class="details">
          <span><?php echo $row['name'] ?></span>         
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $group_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="assets/dist/js/chatJS/groupchat.js"></script>

</body>
</html>
