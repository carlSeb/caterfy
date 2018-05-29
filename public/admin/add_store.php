<?php  
   // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
    
  } else {
    // form processing
    if (isset($_POST['submit'])) {
      $new_store = htmlentities(trim($_POST['new_store']));
      $store_photo = htmlentities(trim($_FILES['store_photo']['name']));
      $store_photo_tmp = htmlentities(trim($_FILES['store_photo']['tmp_name']));

      if (!has_presence($new_store) || !has_presence($store_photo)) {
        $_SESSION['errors'] = "Please fill in all the fields";
        redirect_to("index.php?add_category");

      } else {
        $safe_store =  mysqli_real_escape_string($connection, $new_store);
        $safe_image = mysqli_real_escape_string($connection, $store_photo);
        move_uploaded_file($store_photo_tmp, "store_images/{$safe_image}");
        
        $insert_store = "INSERT INTO stores ( ";
        $insert_store .= "store_name, store_photo";
        $insert_store .= ")VALUES ( ";
        $insert_store .= "'{$safe_store}', '{$safe_image}' )";
        $result = mysqli_query($connection, $insert_store);
        confirm_query($result);

        if ($result) {
          $_SESSION['message'] = "A new store has been added";
          redirect_to("index.php?view_store");
          
        } else {
          $_SESSION['errors'] = "Store creation failed";
          redirect_to("index.php?add_store");
        }
      }
    }
?>
  <h2>Add New Store</h2>
  <form class="form-horizontal" action="index.php?add_store" method="POST" enctype="multipart/form-data">
    <!--Store NAME-->
    <div class="form-group">
      <label class="col-sm-4 control-label">Add Store:</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" name="new_store" placeholder="New Store" required autofocus>
        </div>
    </div>
    <!-- Store Photo -->
    <div class="form-group">
      <label class="col-sm-4 control-label">Add Store Photo:</label>
        <div class="col-sm-5">
          <input type="file" name="store_photo" class="form-control" required>
        </div>
    </div>
    <!-- Add store BUTTON -->
    <div class="form-group">
    <div class="col-sm-4"></div>
      <div class="col-sm-5">
        <button type="submit" name ="submit" class="btn btn-primary pull-right">
        <span class="fa fa-plus-circle"></span> Add Store</button>
      </div>
    </div>
  </form>
<?php  
  } //end: admin must login first before accessing the page
?>