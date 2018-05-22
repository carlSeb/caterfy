<?php  
  require '../../includes/functions/session.php';
  require '../../includes/functions/db_connect.php';
  require '../../includes/functions/functions.php';
  require '../../includes/functions/validations_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
  <!-- head tag includes styling and CSS external links -->
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Caterfy</title>
    
    <!-- stylesheets -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fa/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/animate.css">
    <link rel="stylesheet" type="text/css" href="../css/custom_style.css">
  <!-- stylesheets -->
  </head>
  <!--end:  head tag includes styling and CSS external links -->
  
  <body>
    <!--nav -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <a class="navbar-brand" href="admin_login.php">Caterfy</a>
        </div>
      </div>
    </nav> <!--end: nav -->

    <div class="container">
      <div class="formCont">
        <form method="post" action='admin_login.php' enctype="multipart/form-data">
          <h2>Admin login</h2>
          <div class="form-group">
          <?php
            // show errors
            // echo message();
            echo errors();
          ?>
          </div>
          <div class="form-group">
            <label for="username" class="sr-only">Username</label>
            <input type="text" id="username" class="form-control" name="username" placeholder="Username" required autofocus>
          </div>
          <div class="form-group">
            <label for="password" class="sr-only">Password</label>
            <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
          </div>
          <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">Login</button>
        </form>
      </div>
    </div>
    
    <!-- footer -->
    <footer class="text-center">
      <div class="footer-above">
        <div class="container">
          <div class="row">
            <div class="footer-col col-md-4">
              <h3>Location</h3>
              <p>ACLC Campus
              <br>Real Street, Tacloban City</p>
            </div>
            <div class="footer-col col-md-4">
              <h3>Connect with us</h3>
              <ul class="list-inline">
                <li>
                  <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                </li>
                <li>
                  <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-instagram"></i></a>
                </li>
                <li>
                  <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                </li>
              </ul>
            </div>
              <div class="footer-col col-md-4">
                <h3>Caterfy</h3>
                <p>Email: caterfy@gmail.com</p>
                <p>Contact Number: 09159874954</p>
              </div>
          </div>
        </div>
      </div>
      <div class="footer-below">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              Copyright &copy; Caterfy <?php echo date('Y'); ?>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- end: footer -->

    <!-- javascript files -->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-easing.min.js"></script>
    <script src="../js/scrollreveal.min.js"></script>
    <script src="../js/custom_script.js"></script>   
  </body>
</html>
<?php  
  // form processing
  if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // validations
    if (!has_presence($username) || !has_presence($password)) {
      $_SESSION['errors'] = "Username or Password is blank";
      redirect_to("admin_login.php");
    } 

      $safe_username = mysqli_real_escape_string($connection, $username);
      $safe_password = mysqli_real_escape_string($connection, $password);

      $query = "SELECT * ";
      $query .= "FROM admins ";
      $query .= "WHERE admin_name = '{$safe_username}' ";
      $query .= "AND admin_pass = md5('{$safe_password}') ";
      
      $select_admin = mysqli_query($connection, $query);
      confirm_query($select_admin);

      if(mysqli_num_rows($select_admin) > 0){
        $_SESSION['username'] = $safe_username;
        redirect_to("index.php");
      } else {
        $_SESSION['errors'] = "Username and Password didn't match.";
        redirect_to("admin_login.php");
      }    
  }
  // close the database connection
  if(isset($connection)){
    mysqli_close($connection);
  }
?>