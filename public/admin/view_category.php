<?php 
  // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
  } else {
    // select all from categories table
    $query = "SELECT * FROM categories";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $count = mysqli_num_rows($result);
?>
  <h3>Category list (<?php echo htmlentities($count); ?>)</h3>
  <table class="table table-responsive table-striped table-bordered table-hover">
    <thead>
      <tr>
        <th>Category ID</th>
        <th>Category Name</th>
        <th colspan="2"></th>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php  
        // grabs the data from CATEGORIES table for display, edit, and delete
        while ($result_set = mysqli_fetch_assoc($result)) {
          $category_id = $result_set['id'];
          $category_name = $result_set['category_name'];
      ?>
      <tr>
        <td><?php echo htmlentities($category_id); ?></td>
        <td><?php echo htmlentities($category_name); ?></td>
        <td>
          <a href="index.php?edit_category=<?php echo urlencode($category_id); ?>" title="Edit" class="btn btn-primary">
            <span class="fa fa-edit"></span>
          </a>
        </td>
        <td>
          <a href="index.php?delete_category=<?php echo urlencode($category_id); ?>" title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this category?')">
            <span class="fa fa-trash"></span>
          </a>
        </td>
      </tr>
      <?php  
        } // end: grabs the data from CATEGORIES table for display, edit, and delete
        mysqli_free_result($result);
      ?>
    </tbody>
  </table>

<?php 
  } // end: admin must login first before accessing the page
?>