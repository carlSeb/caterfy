<?php
  require '../../includes/functions/session.php';
  require '../../includes/functions/db_connect.php';
  require '../../includes/functions/functions.php';
  require '../../includes/functions/validations_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
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

  <body id="page-top">
  <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header page-scroll">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="main.php #page-top">Caterfy</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="hidden">
            <a href="#page-top"></a>
          </li>
          <?php 
            // dynamic categories bar
            $query_categories = "SELECT * FROM categories";
            $run_categories = mysqli_query($connection, $query_categories);
            confirm_query($run_categories);
            while ($cat_set = mysqli_fetch_assoc($run_categories)) {
              $category_id = $cat_set['id'];
              $category_name = $cat_set['category_name'];
              echo "<li class=\"page-scroll\">";
              echo "<a class='active' href='main.php?category_id=". urlencode($category_id)."'>";
              echo htmlentities($category_name);
              echo "</a>";
              echo "</li>";
            }
          ?>
        </ul>
      </div>
        <!-- /.navbar-collapse -->
    </div>
      <!-- /.container-fluid -->
  </nav>
  
  <!-- menu list button -->
  <a href='cart_list.php' id="myMenu" class="btn btn-lg btn-primary animated infinite pulse" title="Your menu list">
    <span class="fa fa-2x fa-list"></span>
  </a>
  <!-- end: menu list button -->
  
  <!-- main content -->
  <main class="container-fluid menus-content">
    <section class="row">
    <?php include '../main/menus_content.php';?>
    </section>
  </main>
  <!-- end: main content -->  

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
	<!-- javascript files -->

  </body>
</html>