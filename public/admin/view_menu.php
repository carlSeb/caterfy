<?php  
  // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
  } else {
    // select * from menus
    $query = "SELECT * FROM menus";
    $result =  mysqli_query($connection, $query);
    confirm_query($result);
    $count = mysqli_num_rows($result);
?>
  <h3>Menu list (<?php echo htmlentities($count); ?>)</h3>
  <table class="table table-responsive table-striped table-bordered table-hover">
    <thead>
      <tr>
        <th>Menu ID</th>
        <th>Image</th>
        <th>Category</th>
        <th>Menu Name</th>
        <th>Menu Price</th>
        <th colspan="2"></th>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php  
        // grabs the data from menus table for display, edit and delete
        while ($result_set = mysqli_fetch_assoc($result)) {
          $menu_id = $result_set['id'];
          $menu_category_id = $result_set['category_id'];
          $menu_image = $result_set['menu_image'];
          $menu_name = $result_set['menu_name'];
          $menu_price = $result_set['menu_price'];
      ?>
      <tr>
        <td><?php echo htmlentities($menu_id) ;?></td>
        <td>
          <img src="menu_images/<?php echo htmlentities($menu_image);?>" class="img-rounded" width="64px" height="64px">
        </td>
        <?php 
          // category name query
          $get_categ_name = "SELECT * FROM categories WHERE id = {$menu_category_id}";
          $categ_result = mysqli_query($connection, $get_categ_name);
          confirm_query($categ_result);
          while ($categ_set = mysqli_fetch_assoc($categ_result)) {
            $categ_name = $categ_set['category_name'];
        ?>
            <td><?php echo htmlentities($categ_name); ?></td>
        
        <?php
          } // end: category name query
        ?>
        <td><?php echo htmlentities($menu_name); ?></td>
        <td> &#8369; <?php echo htmlentities($menu_price); ?></td>
        <td>
          <a href="index.php?edit_menu=<?php echo urlencode($menu_id); ?>" title="Edit" class="btn btn-primary">
            <span class="fa fa-edit"></span>
          </a>
        </td>
        <td>
          <a href="index.php?delete_menu=<?php echo urlencode($menu_id); ?>" title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this item?')">
            <span class="fa fa-trash"></span>
          </a>
        </td>
      </tr>
      <?php  
        } // end: grabs the data from menus table for display, edit and delete
        mysqli_free_result($result);
      ?>
    </tbody>
  </table>
<?php  
  } //end: admin must login first before accessing the page
?>