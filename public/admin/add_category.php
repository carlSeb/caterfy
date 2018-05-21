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
      $new_category = htmlentities(trim($_POST['new_cat']));

      if (!has_presence($new_category)) {
        $_SESSION['errors'] = "Please fill in all the fields";
        redirect_to("index.php?add_category");

      } else {
        $safe_category =  mysqli_real_escape_string($connection, $new_category);
        
        $insert_category = "INSERT INTO categories ( ";
        $insert_category .= "category_name ";
        $insert_category .= ")VALUES ( ";
        $insert_category .= "'{$new_category}' )";
        $result = mysqli_query($connection, $insert_category);
        confirm_query($result);

        if ($result) {
          $_SESSION['message'] = "A new category has been added";
          redirect_to("index.php?view_category");
          
        } else {
          $_SESSION['errors'] = "Category creation failed";
          redirect_to("index.php?add_category");
        }
      }
    }
?>
  <h2>Add New Category</h2>
  <form class="form-horizontal" action="index.php?add_category" method="POST" enctype="multipart/form-data">
    <!--CATEGORY NAME-->
    <div class="form-group">
      <label class="col-sm-4 control-label">Add Category:</label>
        <div class="col-sm-5">
          <input type="text" class="form-control" name="new_cat" placeholder="New Category" required autofocus>
        </div>
    </div>
    <!-- insert_cat BUTTON -->
    <div class="form-group">
    <div class="col-sm-4"></div>
      <div class="col-sm-5">
        <button type="submit" name ="submit" class="btn btn-primary pull-right">
        <span class="fa fa-plus-circle"></span> Add Category</button>
      </div>
    </div>
  </form>
<?php  
  } //end: admin must login first before accessing the page
?>