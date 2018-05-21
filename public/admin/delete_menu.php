<?php

  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
  } else {

    // deletes the menu item
    if (isset($_GET['delete_menu'])) {
      $delete_id = $_GET['delete_menu'];
      $delete_query = "DELETE FROM menus WHERE id = {$delete_id} LIMIT 1";
      $result_del = mysqli_query($connection, $delete_query);
      confirm_query($result_del);
      
      if ($result_del && mysqli_affected_rows($connection) == 1) {
        $_SESSION['message'] = "Menu deleted";
        header("Location: index.php?view_menu");
        exit;
      } else {
        //failure
        $_SESSION["message"] = "Menu deletion failed";
        header("Location: index.php?view_menu");
        exit;
      }

    } // end: deletes the menu item

  }

?>