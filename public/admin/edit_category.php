<?php 
  // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
  } else {
    // get the id value and use it to query data
    if (isset($_GET['edit_category'])) {
      $edit_id = $_GET['edit_category'];
      $query = "SELECT * FROM categories WHERE id = {$edit_id}";
      $result = mysqli_query($connection, $query);
      confirm_query($result);

      while ($edit_set = mysqli_fetch_assoc($result)) {
        $update_category_id = $edit_set['id'];
        $update_category_name = $edit_set['category_name'];
      }
      
    }
?>
<!-- edit form category -->
  <h2>Edit Category Item</h2>
  <div class="container">
    <div class="row">
      <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
        <!--CATEGORY NAME-->
        <div class="form-group">
          <label class="col-sm-4 control-label">Category Name</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="category_name" placeholder="Category Name" required autofocus value="<?php echo htmlentities($update_category_name); ?>">
          </div>
        </div>
        
        <!-- SUBMIT BUTTON -->
        <div class="form-group">
          <div class="col-sm-4">
          </div>
          <div class="col-sm-5">
            <button type="submit" name ="update" class="btn btn-primary pull-right"><span class="fa fa-edit"></span> Update Category</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- end: edit form category -->

<?php
    // update data into categories table
    if (isset($_POST['update'])) {
      $update_id = $update_category_id;
      $update_name = htmlentities(trim($_POST['category_name']));

      // validations
      if (!has_presence($update_name)) {
        $_SESSION['errors'] = "Please fill in the field.";
        echo "<script>window.open('index.php?edit_category={$update_id}', '_self')</script>"; 
      } else {
        $safe_category_name = mysqli_real_escape_string($connection, $update_name);

        $update_category = "UPDATE categories SET ";
        $update_category .= "category_name = '{$safe_category_name}' ";
        $update_category .= "WHERE id = {$update_id} ";
        $run_update = mysqli_query($connection, $update_category);
        confirm_query($run_update);

          if ($run_update && mysqli_affected_rows($connection) >= 0) {
            $_SESSION["message"] = "Category updated.";
            echo "<script>window.open('index.php?view_category', '_self')</script>";
          } else {
            $_SESSION['errors'] = "Update failed";
            echo "<script>window.open('index.php?edit_category={$update_id}', '_self')</script>";
          }
      } // end: validations

    } // end: POST update
  } // end: admin must login first before accessing the page
?>