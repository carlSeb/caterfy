<?php 
  require '../../includes/functions/session.php';
  // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    $_SESSION['errors'] = "Please log in to access the page";
    header("Location: admin_login.php");
    exit;
    
  } else {
    session_destroy();
    header("Location: admin_login.php");
    exit;
  
  }
  // close the database connection
  if(isset($connection)){
    mysqli_close($connection);
  }
?>