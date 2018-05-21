<?php
  // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
    
  } else {
    // inserting data to menus table
    if (isset($_POST['submit'])) {
      $menu_name = htmlentities(trim($_POST['menu_name']));
      $menu_category_id = htmlentities(trim($_POST['cat']));
      $menu_price = (int) htmlentities(trim($_POST['menu_price']));
      $menu_image = htmlentities(trim($_FILES['menu_image']['name']));
      $menu_image_tmp = htmlentities(trim($_FILES['menu_image']['tmp_name']));

      if (!has_presence($menu_name) || !has_presence($menu_category_id) || !has_presence($menu_price) || !has_presence($menu_image)) {
        $_SESSION['errors'] = "Please fill in all the fields";
        redirect_to("index.php?add_menu");
        
      } else {
        $safe_menu_name = mysqli_real_escape_string($connection, $menu_name);
        $safe_cat_id = mysqli_real_escape_string($connection, $menu_category_id);
        $safe_price = mysqli_real_escape_string($connection, $menu_price);
        $safe_image = mysqli_real_escape_string($connection, $menu_image);

        move_uploaded_file($menu_image_tmp, "menu_images/{$safe_image}");

        $insert_menu = "INSERT INTO menus ( ";
        $insert_menu .= "category_id, menu_name, menu_image, menu_price ";
        $insert_menu .= ")VALUES ( ";
        $insert_menu .= "{$safe_cat_id}, '{$safe_menu_name}', '{$safe_image}', {$safe_price})";
        $result = mysqli_query($connection, $insert_menu);
        confirm_query($result);

        if ($result) {
          $_SESSION['message'] = "Menu has been added";
          redirect_to("index.php?view_menu");
        } else {
          $_SESSION['errors'] = "Menu creation failed";
          redirect_to("index.php?add_menu");
        }

      }
    } 
?>
  <h3>Add New Menu</h3>
  <!-- show errors if any -->
  <?php echo errors(); ?>
  <form class="addInven form-horizontal" action="index.php?add_menu" method="POST" enctype="multipart/form-data">
    <!--PRODUCT NAME-->
    <div class="form-group">
      <label class="col-sm-4 control-label">Menu Name</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="menu_name" placeholder="Menu Name" required autofocus>
      </div>
    </div>
    <!--CATEGORY-->
    <div class="form-group">
      <label class="col-sm-4 control-label"> Select Category </label>
      <div class="col-sm-5">
        <select name="cat" required>
          <option value="null">Select a Category</option>
            <?php
              //show categories
              $get_categ = "SELECT * FROM categories";
              $run_categ = mysqli_query($connection, $get_categ);
              confirm_query($run_categ);

              while($categ_row = mysqli_fetch_assoc($run_categ)) {
                $cat_id = $categ_row['id'];
                $cat_title = $categ_row['category_name'];
                echo "<option value=\"$cat_id\">{$cat_title}</option>";
              }
            ?>
        </select>
      </div>
    </div>
    <!-- PRICE -->
    <div class="form-group">
      <label class="col-sm-4 control-label">Menu Price</label>
      <div class="col-sm-5">
        <input type="text" class="form-control" name="menu_price" placeholder="Menu Price" required autofocus>
      </div>
    </div>
    <!-- IMAGE -->
    <div class="form-group">
      <label class="col-sm-4 control-label">Menu Image</label>
      <div class="col-sm-5">
        <input type="file" class="form-control" name="menu_image" placeholder="Menu Image" required autofocus>
      </div>
    </div>
    <!-- SUBMIT BUTTON -->
    <div class="form-group">
      <div class="col-sm-4">
      </div>
      <div class="col-sm-5">
        <button type="submit" name ="submit" class="btn btn-primary pull-right"><span class="fa fa-plus-circle"></span> Add Menu</button>
      </div>
    </div>
  </form
<?php 
  } //end: admin must login first before accessing the page
?>