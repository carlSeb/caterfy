<?php
  require '../../includes/functions/session.php';
  require '../../includes/functions/db_connect.php';
  require '../../includes/functions/functions.php';
  require '../../includes/functions/validations_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
  <?php include '../../includes/layout/main_layout/main_head.php'?>
<body>
  <?php include '../../includes/layout/main_layout/main_nav.php' ?>

  <!-- main content -->
  <main class="container menus-content">
    <section class="row">
    <?php
    
    if (isset($_GET['store_id'])) {
      $_SESSION['store_id'] = $_GET['store_id'];
      $query_id = urlencode($_SESSION['store_id']);  
      // get store name
      $query_stores = "SELECT * FROM stores WHERE id = {$query_id} ";
      $run_stores = mysqli_query($connection, $query_stores);
      confirm_query($run_stores);
      while ($stores_set = mysqli_fetch_assoc($run_stores)) {
        $store_name = $stores_set['store_name'];
      }
      echo "<h2>" .ucfirst(htmlentities($store_name)). "</h2>";
      // end: get store name    

      echo "<h3> Our Menu </h3>";

      // get the categories for the store
      $query = "SELECT * FROM categories ";
      $run_query = mysqli_query($connection, $query);
      confirm_query($run_query);
      echo "<div class='row text-center'>";
      echo "<div class='btn-group btn-group-lg' role='group'>";
      while ($result_set = mysqli_fetch_assoc($run_query)) {
        $cat_id = $result_set['id'];
        $cat_title = $result_set['category_name'];
        echo "
          <a href='stores_content.php?category=".urlencode($cat_id)."' type='button' class='categ btn btn-default' role='button'>".htmlentities($cat_title)."</a>";
        }
      echo "</div> ";
      echo "</div>";
      // end: get the categories for the store
      
      // get random menus if no category is selected
      $get_menus = "SELECT * FROM menus WHERE store_id = {$query_id} ORDER BY rand() LIMIT 0,8";
      $run_menus = mysqli_query($connection, $get_menus);
      confirm_query($run_menus);    

      // random output
      while ($menus_set = mysqli_fetch_assoc($run_menus)) {
        $menu_id = $menus_set['id'];
        $menu_cat_id = $menus_set['category_id'];
        $menu_name = $menus_set['menu_name'];
        if (strlen($menu_name) > 10) {
          $menu_name = substr($menu_name, 0, 10);
          $menu_name .= " ...";
        }
        $menu_image = $menus_set['menu_image'];
        $menu_price = $menus_set['menu_price'];
        
        echo "<div class='col-xs-6 col-sm-3 col-lg-3 col-md-3'>
                <div class='thumbnail menus-thumbnail'>
                  <img src='../admin/menu_images/".htmlentities($menu_image)."' alt='$menu_name' class='img-responsive img-rounded'>
                  <div class='caption text-center'>
                    <h3>".htmlentities($menu_name)."</h3>
                    <h3> &#8369;". number_format($menu_price, 2)."</h3>
                    <form action='cart.php' method='POST' enctype='multipart/form-data'>
                        <input type='hidden' name='menu_id' value='".$menu_id."'>
                        <button type='submit' name='submit' class='btn btn-block btn-primary'> Add to menu</button>
                    </form>
                  </div>
                </div>
              </div>";

      } // end: random output
      
    } // end: random menus if no category is selected

    if (isset($_GET['category'])) {
      $query_id = urlencode($_SESSION['store_id']);  
      // get store name
      $query_stores = "SELECT * FROM stores WHERE id = {$query_id} ";
      $run_stores = mysqli_query($connection, $query_stores);
      confirm_query($run_stores);
      while ($stores_set = mysqli_fetch_assoc($run_stores)) {
        $store_name = $stores_set['store_name'];
      }
      echo "<h2>" .ucfirst(htmlentities($store_name)). "</h2>";
      // end: get store name    

      echo "<h3> Our Menu </h3>";

      // get the categories for the store
      $query = "SELECT * FROM categories ";
      $run_query = mysqli_query($connection, $query);
      confirm_query($run_query);
      echo "<div class='row text-center'>";
      echo "<div class='btn-group btn-group-lg' role='group'>";
      while ($result_set = mysqli_fetch_assoc($run_query)) {
        $cat_id = $result_set['id'];
        $cat_title = $result_set['category_name'];
        echo "
          <a href='stores_content.php?category=".urlencode($cat_id)."' type='button' class='categ btn btn-default' role='button'>".htmlentities($cat_title)."</a>";
        }
      echo "</div> ";
      echo "</div>";
      // end: get the categories for the store

      $query = "SELECT * FROM menus WHERE store_id = {$query_id} AND category_id = {$_GET['category']}";
      $run_query = mysqli_query($connection, $query);
      confirm_query($run_query);
      $num_menus = mysqli_num_rows($run_query);
        
        if ($num_menus > 0) {
          while ($menus_set = mysqli_fetch_assoc($run_query)) {
            $menu_id = $menus_set['id'];
            $menu_cat_id = $menus_set['category_id'];
            $menu_name = $menus_set['menu_name'];
            if (strlen($menu_name) > 10) {
              $menu_name = substr($menu_name, 0, 10);
              $menu_name .= " ...";
            }
            $menu_image = $menus_set['menu_image'];
            $menu_price = $menus_set['menu_price'];
            
            echo "<div class='col-xs-6 col-sm-3 col-lg-3 col-md-3'>
                    <div class='thumbnail menus-thumbnail'>
                      <img src='../admin/menu_images/".htmlentities($menu_image)."' alt='$menu_name' class='img-responsive img-rounded'>
                      <div class='caption text-center'>
                        <h3>".htmlentities($menu_name)."</h3>
                        <h3> &#8369;". number_format($menu_price, 2)."</h3>
                        <form action='cart.php' method='POST' enctype='multipart/form-data'>
                            <input type='hidden' name='menu_id' value='".$menu_id."'>
                            <button type='submit' name='submit' class='btn btn-block btn-primary'> Add to menu</button>
                        </form>
                      </div>
                    </div>
                  </div>";
  
          }
          
        } else {
          echo "
          <div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span class='fa fa-close' aria-hidden='true'></span></button>
            <strong>We have no menus listed for this category yet</strong>
          </div>";
        }
          
      }
    

    // close database connection
    if (isset($connection)) {
      mysqli_close($connection);
    }
    ?>
    </section>
  </main>
  <!-- end: main content -->  

  <?php include '../../includes/layout/main_layout/main_footer.php' ?>
</body>
</html>