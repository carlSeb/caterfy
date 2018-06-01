<?php 
  require '../../includes/functions/db_connect.php';
  require '../../includes/functions/functions.php';
  require '../../includes/functions/validations_functions.php';

  $query = "SELECT * FROM menus WHERE menu_name LIKE '%" .$_POST['search']. "%'";
  $result = mysqli_query($connection, $query);
  confirm_query($result);

  $output = "";
  if (mysqli_num_rows($result) > 0) {
    $output .= '
    <table class="table table-responsive table-striped table-bordered table-hover">
    <h3>Search results:</h3>
    <thead>
      <tr>
        <th>Menu ID</th>
        <th>Image</th>
        <th>Category</th>
        <th>Store Name</th>
        <th>Menu Name</th>
        <th>Menu Price</th>
        <th></th>
      </tr>
    </thead>
    <tbody class="text-center">';
    while ($row = mysqli_fetch_assoc($result)) {
      $menu_id = $row['id'];
      $menu_image = $row['menu_image'];
      $menu_category_id = $row['category_id'];
      $menu_store_id = $row['store_id'];
      $menu_name = $row['menu_name'];
      $menu_price = $row['menu_price'];
      
      $output .= '
        <tr>
          <td>'.$menu_id .'</td>
          <td>
            <img src="menu_images/'.htmlentities($menu_image).'" class="img-rounded" width="64px" height="64px">
          </td>';
          // category name query
          $get_categ_name = "SELECT * FROM categories WHERE id = {$menu_category_id}";
          $categ_result = mysqli_query($connection, $get_categ_name);
          confirm_query($categ_result);
          while ($categ_set = mysqli_fetch_assoc($categ_result)) {
            $categ_name = $categ_set['category_name'];
        
            $output .= '<td>'. htmlentities($categ_name) .'</td>';
          }
          // store name query
          $get_store_name = "SELECT * FROM stores WHERE id = {$menu_store_id}";
          $store_result = mysqli_query($connection, $get_store_name);
          confirm_query($store_result);
          while ($store_set = mysqli_fetch_assoc($store_result)) {
            $store_name = $store_set['store_name'];
          
            $output .= '<td>'. htmlentities($store_name).'</td>';
        
          } // end: store name query

          $output .= '<td>'.htmlentities($menu_name).'</td>';      
          $output .= '<td>'.number_format($menu_price, 2).'</td>'; 
          $output .= '
          <td>
            <a href="index.php?edit_menu='.urlencode($menu_id).'" title="Edit" class="btn btn-primary">
              <span class="fa fa-edit"></span>
            </a>
          </td>
        </tr>';
    }
    $output .= "
      </tbody>
    </table>";
    echo $output;
  } else {
    echo '
    <table class="table table-responsive table-striped table-bordered table-hover">
      <h3>Search results:</h3>
        <tbody class="text-center">
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-close" aria-hidden="true"></span></button>
            <strong>No results found</strong>
          </div>  
        </tbody>
    </table>';
  }

?>