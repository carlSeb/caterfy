<?php 
  if (!isset($_GET['category_id'])) {
    $get_menus = "SELECT * FROM menus ORDER BY rand() LIMIT 0, 8";
    $run_menus = mysqli_query($connection, $get_menus);
    confirm_query($run_menus);

    echo "<h2> Create your custom menu </h2>";
    
    while ($menus_set = mysqli_fetch_assoc($run_menus)) {
      $menu_id = $menus_set['id'];
      $menu_cat_id = $menus_set['category_id'];
      $menu_name = $menus_set['menu_name'];
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
    
  } elseif (isset($_GET['category_id'])) {
    $cat_id =  urlencode($_GET['category_id']);
    $query = "SELECT * FROM menus WHERE category_id = {$cat_id}";
    $run_query = mysqli_query($connection, $query);
    confirm_query($run_query);
    $number_of_items = mysqli_num_rows($run_query);

    $get_cat = "SELECT category_name FROM categories WHERE id = {$cat_id}";
    $run_cat_name = mysqli_query($connection, $get_cat);
    confirm_query($run_cat_name);

    while ($query_set = mysqli_fetch_assoc($run_cat_name)) {
      $cat_name = $query_set['category_name'];
      echo "<h2>".htmlentities($cat_name)."</h2>";
    }

    // will show the menus related to the category selected
    // else it will output a warning
    if ($number_of_items > 0) {
      while ($query_set = mysqli_fetch_assoc($run_query)) {
        $menu_id = $query_set['id'];
        $menu_cat_id = $query_set['category_id'];
        $menu_name = $query_set['menu_name'];
        $menu_image = $query_set['menu_image'];
        $menu_price = $query_set['menu_price'];

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
          <strong>Sorry, we have no menus listed for this category yet</strong>
        </div>";
        
    } // end: will show the menus related to the category selected

  } //end: if isset category_id GET variable

  // close database connection
  if (isset($connection)) {
    mysqli_close($connection);
  }
?>