<?php  
  $errors = [];

  function has_presence($value){
    return isset($value) && $value !== "";
  }

  function validate_presences($required_fields){
    global $errors;
    foreach($required_fields as $fields){
      $value = trim($_POST[$fields]);
      if(!has_presence($value)){
          $errors[$fields] = ucfirst($fields) . " can't be blank"; 
      }
    }
  }
?>