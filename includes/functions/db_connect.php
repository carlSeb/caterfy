<?php 
  // Error reporting
  ini_set("display_errors", "On");
  error_reporting(E_ALL);

  // Create database connection
  define("DB_SERVER", "localhost");
  define("DB_USER", "caterfy_admin");
  define("DB_PASS", "caterfy123");
  define("DB_NAME", "caterfy");

  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

  // test if connection occured
  if (mysqli_connect_errno()) {
    die("Database connection failed ". mysqli_connect_error() . 
    "(" . mysqli_connect_errorno() . ")");
  }
  
?>