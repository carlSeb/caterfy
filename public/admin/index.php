<?php
  require '../../includes/functions/session.php';
  require '../../includes/functions/db_connect.php';
  require '../../includes/functions/functions.php';
  require '../../includes/functions/validations_functions.php';
  // admin must login first before accessing the page
  if (!isset($_SESSION['username'])) {
    $_SESSION['errors'] = "Please log in to access the page";
    redirect_to("admin_login.php");
  } else {

?>
<!DOCTYPE html>
<html lang="en">
  <!-- head tags -->
  <?php include '../../includes/layout/admin_layout/admin_head.php'; ?>
  <!-- end: head tags -->
  <body>
    <!-- nav bar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Caterfy - Admin</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="index.php">
                <?php echo ucfirst(htmlentities($_SESSION['username'])); ?>
              </a>
            </li>
            <li>
              <a href="logout.php" onclick="return confirm('Do you want to logout?')">Log out
              </a>
            </li>
          </ul>
          <form class="navbar-form navbar-right" method="POST">
            <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>
    <!-- end: nav bar -->

    <div class="container-fluid">
      <div class="row">

        <!-- sidebar -->
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li>
              <a href="index.php?add_menu">
                <span class="fa fa-plus-circle"></span> Add New Menu
              </a>
            </li>
            <li>
              <a href="index.php?add_category">
                <span class="fa fa-plus-circle"></span> Add New Category
              </a>
            </li>
            <li>
              <a href="index.php?add_store">
                <span class="fa fa-plus-circle"></span> Add New Store
              </a>
            </li>
            <li>
              <a href="index.php?view_menu"><span class="fa fa-eye"></span> View Menus</a>
            </li>
            <li>
              <a href="index.php?view_category">
                <span class="fa fa-eye"></span> View Categories
              </a>
            </li>
            <li>
              <a href="index.php?view_store">
                <span class="fa fa-eye"></span> View Stores
              </a>
            </li>
          </ul>
        </div>
        <!-- end: sidebar -->

        <!-- main content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard
            <small class="text-muted" style="font-size: 12px"><?php echo date('d-M-Y'); ?></small>
          </h1> 

          <!-- search results area-->
          <div id="search-result">
          
          </div>
          <?php  
            // show message or errors
            echo message();
            echo errors();

            if (isset($_GET['add_menu'])) {
              include 'add_menu.php';

            } elseif (isset($_GET['view_menu'])) {
              include 'view_menu.php';

            } elseif (isset($_GET['edit_menu'])) {
              include 'edit_menu.php';

            } elseif (isset($_GET['delete_menu'])) {
              include 'delete_menu.php';
              
            } elseif (isset($_GET['add_category'])) {
              include 'add_category.php';

            } elseif (isset($_GET['view_category'])) {
              include 'view_category.php';

            } elseif (isset($_GET['edit_category'])) {
              include 'edit_category.php';
              
            } elseif (isset($_GET['delete_category'])) {
              include 'delete_category.php';
              
            } elseif (isset($_GET['add_store'])) {
              include 'add_store.php';

            } elseif (isset($_GET['view_store'])) {
              include 'view_store.php';

            } elseif (isset($_GET['edit_store'])) {
              include 'edit_store.php';

            } elseif (isset($_GET['delete_store'])) {
              include 'delete_store.php';

            } else {
          ?>

              <div class="row placeholders">

                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="index.php?add_menu">
                    <img src="admin_img/add_menu.png" width="200" height="200" class="img-responsive" alt="Add a new menu">
                  </a>
                  <h4>Add a new menu</h4>
                </div>

                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="index.php?view_menu">
                    <img src="./admin_img/view_menu.png" width="200" height="200" class="img-responsive" alt="View menus">
                  </a>
                  <h4>View menus</h4>
                </div>

                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="index.php?add_category">
                    <img src="admin_img/add_categ.png" width="200" height="200" class="img-responsive" alt="Add a new category">
                  </a>
                  <h4>Add a new category</h4>
                </div>


                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="index.php?view_category">
                    <img src='./admin_img/view_categ.png' width="200" height="200" class="img-responsive" alt="View categories">
                  </a>     
                  <h4>View categories</h4>
                </div>

                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="index.php?add_store">
                    <img src="./admin_img/add_shop.png" width="200" height="200" class="img-responsive" alt="Add a new store">
                  </a>     
                  <h4>Add a new store</h4>
                </div>

                <div class="col-xs-6 col-sm-3 placeholder">
                  <a href="index.php?view_store">
                    <img src="./admin_img/view_shop.png" width="200" height="200" class="img-responsive" alt="View stores">
                  </a>     
                  <h4>View stores</h4>
                </div>

              </div>
              
          <?php
            }
          ?>
        </div>
        <!-- end: main content -->
      </div>
    </div>
  <?php include '../../includes/layout/admin_layout/admin_footer.php'; ?>
  </body>
</html>

<?php  
  } //end: admin must login first before accessing the page
  
  // close the database connection
  if(isset($connection)) {
    mysqli_close($connection);
  }
?>