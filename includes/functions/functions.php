<?php 
  // redirect the page
  function redirect_to($new_location){
    header("Location: " . $new_location);
    exit;
  }

  function confirm_query($result_set){
    if(!$result_set){
      die("DATABASE QUERY FAILED");
    }
  }
    
  // checks for form errors
  function form_errors($errors=array()) {
    $output = "";
    if(!empty($errors)) {
      $output .= "<div class=\"alert alert-warning\" role=\"alert\">";
      $output .= "Please fix the following errors: ";
      $output .= "<ul>"; 
        foreach($errors as $key => $error){
          $output .= "<li>";
          $output .= htmlentities($error);
          $output .= "</li>";
        }
      $output .= "</ul>";
      $output .= "</div>";
    }
    return $output;
  }
?>