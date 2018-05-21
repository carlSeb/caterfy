<?php
  if (!isset($_SESSION['username'])) {
    session_start();
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit();
  } else {

    // deletes the category item
    if (isset($_GET['delete_category'])) {
      // database query
      $delete_id = $_GET['delete_category'];
      
      $query = "SELECT * ";
      $query .= "FROM menus ";
      $query .= "WHERE category_id = {$delete_id} ";
      $query_set = mysqli_query($connection, $query);
      confirm_query($query_set);

      if (mysqli_num_rows($query_set) > 0) {
        $_SESSION["message"] = "Can't delete a category with menus related to it";
        header("Location: index.php?view_category");
        exit;
      }

      $delete_query = "DELETE FROM categories WHERE id = {$delete_id} LIMIT 1";
      $result_del = mysqli_query($connection, $delete_query);
      confirm_query($result_del);

      if ($result_del && mysqli_affected_rows($connection) == 1) {
        $_SESSION['message'] = "Category deleted";
        header("Location: index.php?view_category");
        exit;

      } else {
        //failure
        $_SESSION["message"] = "Category deletion failed";
        header("Location: index.php?view_category");
        exit;
      }

    } // end: deletes the category item

  } // end: if !isset username

?>