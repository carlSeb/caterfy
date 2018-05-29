<h2>Select a store</h2>    
<?php 
  // dynamic stores bar
  $query_stores = "SELECT * FROM stores";
  $run_stores = mysqli_query($connection, $query_stores);
  confirm_query($run_stores);
  while ($stores_set = mysqli_fetch_assoc($run_stores)) {
    $store_id = $stores_set['id'];
    $stores_name = $stores_set['store_name'];
    if (strlen($stores_name) > 10) {
      $stores_name = substr($stores_name, 0, 10);
      $stores_name .= " ...";
    }
    $stores_photo = $stores_set['store_photo'];
    
    echo "
    <div class='col-xs-6 col-sm-2 col-lg-4 col-md-4'>
      <div class='thumbnail menus-thumbnail'>
        <a href='stores_content.php?store_id=".urlencode($store_id)."'>
          <img src='../admin/store_images/".htmlentities($stores_photo)."' alt='$stores_name' class='img-responsive img-rounded'>
          <div class='caption text-center'>
            <h3>".htmlentities($stores_name)."</h3>
          </div>
        </a>
      </div>
    </div>";
  }
?>