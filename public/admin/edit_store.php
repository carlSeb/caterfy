<?php 
  // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
  } else {
    // get the id value and use it to query data
    if (isset($_GET['edit_store'])) {
      $edit_id = $_GET['edit_store'];
      $query = "SELECT * FROM stores WHERE id = {$edit_id}";
      $result = mysqli_query($connection, $query);
      confirm_query($result);

      while ($edit_set = mysqli_fetch_assoc($result)) {
        $update_store_id = $edit_set['id'];
        $update_store_name = $edit_set['store_name'];
        $update_store_photo = $edit_set['store_photo'];
      }
      
    }
?>
<!-- edit form stores -->
  <h2>Edit Store Item</h2>
  <div class="container">
    <div class="row">
      <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
        <!--STORE NAME-->
        <div class="form-group">
          <label class="col-sm-4 control-label">Edit Store Name</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="store_name" placeholder="Store Name" required autofocus value="<?php echo htmlentities($update_store_name); ?>">
          </div>
        </div>
        <!-- Store Photo -->
        <div class="form-group">
          <label class="col-sm-4 control-label">Add Store Photo:</label>
            <div class="col-sm-5">
              <input type="file" name="store_photo" class="form-control" required>
              <img src="store_images/<?php echo htmlentities($update_store_photo); ?>" width = "150px" height ="150px" class="img-rounded">
            </div>
        </div>
        
        <!-- SUBMIT BUTTON -->
        <div class="form-group">
          <div class="col-sm-4">
          </div>
          <div class="col-sm-5">
            <button type="submit" name ="update" class="btn btn-primary pull-right"><span class="fa fa-edit"></span> Update Store</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- end: edit form category -->

<?php
    // update data into categories table
    if (isset($_POST['update'])) {
      $update_id = $update_store_id;
      $update_name = htmlentities(trim($_POST['store_name']));
      $update_photo = htmlentities(trim($_FILES['store_photo']['name']));
      $store_photo_tmp = htmlentities(trim($_FILES['store_photo']['tmp_name']));

      // validations
      if (!has_presence($update_name) || !has_presence($update_photo)) {
        $_SESSION['errors'] = "Please fill in the field.";
        echo "<script>window.open('index.php?edit_store={$update_id}', '_self')</script>"; 
      } else {
        $safe_store_name = mysqli_real_escape_string($connection, $update_name);
        $safe_image = mysqli_real_escape_string($connection, $update_photo);
        move_uploaded_file($store_photo_tmp, "store_images/{$safe_image}");

        $update_store = "UPDATE stores SET ";
        $update_store .= "store_name = '{$safe_store_name}', ";
        $update_store .= "store_photo = '{$safe_image}' ";
        $update_store .= "WHERE id = {$update_id} ";
        $run_update = mysqli_query($connection, $update_store);
        confirm_query($run_update);

          if ($run_update && mysqli_affected_rows($connection) >= 0) {
            $_SESSION["message"] = "Store updated.";
            echo "<script>window.open('index.php?view_store', '_self')</script>";
          } else {
            $_SESSION['errors'] = "Update failed";
            echo "<script>window.open('index.php?edit_store={$update_id}', '_self')</script>";
          }
      } // end: validations

    } // end: POST update
  } // end: admin must login first before accessing the page
?>