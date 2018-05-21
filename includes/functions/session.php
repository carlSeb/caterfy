<?php
  session_start();

  function message() {
    if(isset($_SESSION["message"])) {
      $output = "<div class='alert alert-info' role='alert'>";
      $output .= "<strong>".htmlentities($_SESSION["message"])."</strong>";
      $output .= "</div>";
      //clear message after use
      $_SESSION["message"] = NULL;
      return $output;
    }
  }

    function errors() {
      if(isset($_SESSION["errors"])) {
        $err = htmlentities($_SESSION["errors"]);
        $errorMsg = "<div class=\"alert alert-danger\" role=\"alert\"> ";
        $errorMsg .= "<strong>".$err."</strong>";
        $errorMsg .= "</div>";

        //clear message after use
        $_SESSION["errors"] = NULL;
        return $errorMsg;
      }
    }
?>