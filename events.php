<?php 
// Include calendar helper functions 
include_once 'functions.php'; 
?>
<?php if($_SESSION['login_type'] != 3): ?>        
<div class="card-header">
    <div class="card-tools">
        <!-- <a class="btn btn-block btn-sm btn-default btn-flat border-warning" href="./index.php?page=new_event">
        <i class="fa fa-plus"></i> Add Event</a> -->
        <button class="btn btn-warning bg-gradient-warning btn-sm" type="button" name="addEvent" id="addEvent">
        <i class="fa fa-plus"></i>Add Event</button>                
    </div>
</div>
<?php endif; ?>

<div id="calendar_div">
    <?php echo getCalender(); ?>
</div>

<script>
$('#addEvent').click(function(e){
    uni_modal("Add Event","new_event.php" ,'mid-large');

})
</script> 
