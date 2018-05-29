<?php 
  // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
  } else {
    // select all from stores table
    $query = "SELECT * FROM stores";
    $result = mysqli_query($connection, $query);
    confirm_query($result);
    $count = mysqli_num_rows($result);
?>
  <h3>Stores list (<?php echo htmlentities($count); ?>)</h3>
  <table class="table table-responsive table-striped table-bordered table-hover">
    <thead>
      <tr>
        <th>Store ID</th>
        <th>Store Image</th>
        <th>Store Name</th>
        <th colspan="2"></th>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php  
        // grabs the data from STORES table for display, edit, and delete
        while ($result_set = mysqli_fetch_assoc($result)) {
          $store_id = $result_set['id'];
          $store_name = $result_set['store_name'];
          $store_photo = $result_set['store_photo'];
      ?>
      <tr>
        <td><?php echo htmlentities($store_id); ?></td>
        <td>
          <img src="store_images/<?php echo htmlentities($store_photo);?>" class="img-rounded" width="64px" height="64px">
        </td>
        <td><?php echo htmlentities($store_name); ?></td>
        <td>
          <a href="index.php?edit_store=<?php echo urlencode($store_id); ?>" title="Edit" class="btn btn-primary">
            <span class="fa fa-edit"></span>
          </a>
        </td>
        <td>
          <a href="index.php?delete_store=<?php echo urlencode($store_id); ?>" title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this store?')">
            <span class="fa fa-trash"></span>
          </a>
        </td>
      </tr>
      <?php  
        } // end: grabs the data from STORES table for display, edit, and delete
        mysqli_free_result($result);
      ?>
    </tbody>
  </table>

<?php 
  } // end: admin must login first before accessing the page
?>