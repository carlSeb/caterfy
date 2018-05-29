<?php
  // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
  } else {
    // get the id value and use it to query
    if (isset($_GET['edit_menu'])) {
      $edit_id = $_GET['edit_menu'];
      $query = "SELECT * FROM ";
      $query .= "menus WHERE ";
      $query .= "id = {$edit_id} ";
      $edit_result = mysqli_query($connection, $query);
      confirm_query($edit_result);

      while ($edit_set = mysqli_fetch_assoc($edit_result)) {
        $menu_id = $edit_set['id'];
        $menu_categ_id = $edit_set['category_id'];
        $menu_store_id = $edit_set['store_id'];
        $menu_name = $edit_set['menu_name'];
        $menu_image = $edit_set['menu_image'];
        $menu_price = $edit_set['menu_price'];
      }
    }
?>
  <!-- edit form -->
  <h2>Edit Menu Item</h2>
  <div class="container">
    <div class="row">
      <form class="addInven form-horizontal" action="" method="POST" enctype="multipart/form-data">
        <!--CATEGORY NAME-->
        <div class="form-group">
          <label class="col-sm-4 control-label">Menu Name:</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="menu_name" placeholder="Menu Name" required autofocus value="<?php echo htmlentities($menu_name); ?>">
          </div>
        </div>
        <!--CATEGORY-->
        <div class="form-group">
          <label class="col-sm-4 control-label"> Select Category: </label>
          <div class="col-sm-5">
            <select name="cat" required>
              <?php
                // to show the user selected category
                $get_categ = "SELECT * FROM ";
                $get_categ .= "categories WHERE ";
                $get_categ .="id = {$menu_categ_id}";
                $run_categ = mysqli_query($connection, $get_categ);
                confirm_query($run_categ);
                
                while ($categ_row = mysqli_fetch_assoc($run_categ)) {
                  $cat_id = $categ_row['id'];
                  $cat_title = $categ_row['category_name'];
                  echo "<option value=\"$cat_id\">{$cat_title}</option>";
                }

                // shows the available categories for update
                $category = "SELECT * FROM categories";
                $category_result = mysqli_query($connection, $category);
                confirm_query($category_result);

                while ($categ_assoc = mysqli_fetch_assoc($category_result)) {
                  $cat_id_assoc = $categ_assoc['id'];
                  $cat_title_assoc = $categ_assoc['category_name'];
                  echo "<option value=\"$cat_id_assoc\">";
                  echo htmlentities($cat_title_assoc);
                  echo "</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <!-- Store Name -->
        <div class="form-group">
          <label class="col-sm-4 control-label"> Store Name: </label>
          <div class="col-sm-5">
            <select name="store_id" required>
              <?php
                // to show the user selected store
                $get_stores = "SELECT * FROM ";
                $get_stores .= "stores WHERE ";
                $get_stores .="id = {$menu_store_id}";
                $run_stores = mysqli_query($connection, $get_stores);
                confirm_query($run_stores);
                
                while ($stores_row = mysqli_fetch_assoc($run_stores)) {
                  $store_id = $stores_row['id'];
                  $store_title = $stores_row['store_name'];
                  echo "<option value=\"$store_id\">{$store_title}</option>";
                }

                // shows the available stores for update
                $stores_query = "SELECT * FROM stores";
                $stores_result = mysqli_query($connection, $stores_query);
                confirm_query($stores_result);

                while ($stores_assoc = mysqli_fetch_assoc($stores_result)) {
                  $store_id_assoc = $stores_assoc['id'];
                  $store_title_assoc = $stores_assoc['store_name'];
                  echo "<option value=\"$store_id_assoc\">";
                  echo htmlentities($store_title_assoc);
                  echo "</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <!-- PRICE -->
        <div class="form-group">
          <label class="col-sm-4 control-label">Menu Price:</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name="menu_price" placeholder="Menu Price" required autofocus value="<?php echo number_format($menu_price, 2); ?>">
          </div>
        </div>
        <!-- IMAGE -->
        <div class="form-group">
          <label class="col-sm-4 control-label">Menu Image:</label>
          <div class="col-sm-5">
            <input type="file" class="form-control" name="menu_image" placeholder="Menu Image" autofocus required>
            <br>
            <img src="menu_images/<?php echo htmlentities($menu_image); ?>" width = "150px" height ="150px" class="img-rounded">
          </div>
        </div>
        <!-- SUBMIT BUTTON -->
        <div class="form-group">
          <div class="col-sm-4">
          </div>
          <div class="col-sm-5">
            <button type="submit" name ="update" class="btn btn-primary pull-right"><span class="fa fa-edit"></span> Update Menu</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- end: edit form -->
<?php
    // update data into menus table
    if (isset($_POST['update'])) {
      $update_id = $menu_id;
      $menu_name = htmlentities(trim($_POST['menu_name']));
      $menu_category_id = (int) htmlentities(trim($_POST['cat']));
      $stores_id = (int) htmlentities(trim($_POST['store_id']));
      $menu_price = (int) htmlentities(trim($_POST['menu_price']));
      $menu_image = htmlentities(trim($_FILES['menu_image']['name']));
      $menu_image_tmp = htmlentities(trim($_FILES['menu_image']['tmp_name']));

      // validations
      if (!$menu_name|| !$menu_category_id || !$stores_id || !$menu_price || !$menu_image) {
        $_SESSION['errors'] = "Please fill in all the fields.";
        echo "<script>window.open('index.php?edit_menu={$update_id}', '_self')</script>"; 
      } else { 
        $safe_menu_name = mysqli_real_escape_string($connection, $menu_name);
        $safe_cat_id = mysqli_real_escape_string($connection, $menu_category_id);
        $safe_store_id = mysqli_real_escape_string($connection, $stores_id);
        $safe_price = mysqli_real_escape_string($connection, $menu_price);
        $safe_image = mysqli_real_escape_string($connection, $menu_image);

        move_uploaded_file($menu_image_tmp, "menu_images/{$safe_image}");

        $update_menu = "UPDATE menus SET ";
        $update_menu .= "category_id = {$safe_cat_id}, ";
        $update_menu .= "store_id = {$safe_store_id}, ";
        $update_menu .= "menu_name = '{$safe_menu_name}', ";
        $update_menu .= "menu_image = '{$safe_image}', ";
        $update_menu .= "menu_price = {$safe_price} ";
        $update_menu .= "WHERE id = {$update_id} ";
        $run_update = mysqli_query($connection, $update_menu);
        confirm_query($run_update);

          if ($run_update && mysqli_affected_rows($connection) >= 0) {
            $_SESSION["message"] = "Menu updated.";
            echo "<script>window.open('index.php?view_menu', '_self')</script>";
          } else {
            $_SESSION['errors'] = "Update failed";
            echo "<script>window.open('index.php?edit_menu={$update_id}', '_self')</script>";
          }
      } // end: validations

    } // end: POST update

  } // end: admin must login first before accessing the page
?>