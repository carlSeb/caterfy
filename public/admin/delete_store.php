<?php
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
  } else {

    // deletes the store item
    if (isset($_GET['delete_store'])) {
      // database query
      $delete_id = $_GET['delete_store'];
      
      $query = "SELECT * ";
      $query .= "FROM menus ";
      $query .= "WHERE store_id = {$delete_id} ";
      $query_set = mysqli_query($connection, $query);
      confirm_query($query_set);

      if (mysqli_num_rows($query_set) > 0) {
        $_SESSION["message"] = "Can't delete a store with menus related to it";
        header("Location: index.php?view_store");
        exit;
      }

      $delete_query = "DELETE FROM stores WHERE id = {$delete_id} LIMIT 1";
      $result_del = mysqli_query($connection, $delete_query);
      confirm_query($result_del);

      if ($result_del && mysqli_affected_rows($connection) == 1) {
        $_SESSION['message'] = "Store deleted";
        header("Location: index.php?view_store");
        exit;

      } else {
        //failure
        $_SESSION["message"] = "Store deletion failed";
        header("Location: index.php?view_store");
        exit;
      }

    } // end: deletes the store item

  } // end: if !isset username

?>