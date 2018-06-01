<?php
  require '../../includes/functions/session.php';
  require '../../includes/functions/db_connect.php'; 
  require '../../includes/functions/functions.php';

  if(isset($_POST['menu_id'])) {
    $product_id = $_POST['menu_id'];
    $wasFound = false;
    $i = 0;
    // if the cart is empty or not set
    if (!isset($_SESSION['cart_array']) OR count($_SESSION['cart_array']) < 1) {
      //run the cart if it is empty and not set
      $_SESSION['cart_array'] = array(
        0 => array("item_id"=> $product_id, "quantity"=> 1)
      );

    } else {
      //run the cart if it has atleast one item in it
      foreach ($_SESSION['cart_array'] as $each_item) {
        $i++;
        while (list($key, $value)= each($each_item)) {
          if($key== "item_id" AND $value== $product_id) {
            array_splice($_SESSION['cart_array'], $i-1, 1, array(
              array("item_id"=> $product_id, "quantity"=> $each_item['quantity']+ 1)
              )
            );
            $wasFound =true;
          }
        }
      }
        if($wasFound == false) {
          array_push($_SESSION['cart_array'], array("item_id"=> $product_id, "quantity" => 1));
        }
      }
        header("location:cart.php");
        exit();
    }
    // to empty shopping cart
    if(isset($_GET['cmd']) AND $_GET['cmd']=='emptycart'){
      unset($_SESSION['cart_array']);
    }

    //adjust item quantity
    if(isset($_POST['item_to_adjust']) && isset($_POST['item_to_adjust']) != "") {
      $item_to_adjust = $_POST['item_to_adjust'];
      $quantity = $_POST['quantity'];
      $quantity = preg_replace('#[^0-9]#i','',$quantity);

      if ($quantity >= 100) {
        $quantity = 99;
      }

      if ($quantity < 1) {
        $quantity = 1;
      }

      $i=0;
      foreach($_SESSION['cart_array'] as $each_item) {
        $i++;
        while (list($key, $value)= each($each_item)) {
          if($key== "item_id" AND $value== $item_to_adjust) {
            array_splice($_SESSION['cart_array'], $i-1, 1, array(
              array("item_id"=> $item_to_adjust, "quantity"=> $quantity)
              )
            );
          }
        }
      }
    }

    //deletes an item from the cart
    if(isset($_POST["index_to_remove"]) && $_POST["index_to_remove"] !="") {
      $key_to_remove  = $_POST["index_to_remove"];
      if(count($_SESSION["cart_array"]) <=1) {
        unset($_SESSION["cart_array"]);
      } else {
        unset($_SESSION["cart_array"]["$key_to_remove"]);
        sort($_SESSION["cart_array"]);
      }
    }

    //render the cart for the user to view
    $cartOutput = "";
    $cartTotal = NULL;
                    
    if(!isset($_SESSION['cart_array']) OR count($_SESSION['cart_array']) < 1) {
      $cartOutput = "<div class='alert alert-warning alert-dismissible text-center' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span class='fa fa-close' aria-hidden='true'></span></button>
                    <p><strong>Your menu list is empty</strong></p>
                </div>";
    } else {
    $i = 0;
    foreach($_SESSION['cart_array'] as $each_item) {
      $item_id = $each_item['item_id'];
      $sql = "SELECT * FROM menus WHERE id = {$item_id} LIMIT 1";
      $itemQuery = mysqli_query($connection, $sql);
      while($row = mysqli_fetch_assoc($itemQuery)){
        $product_name = $row['menu_name'];
        $product_image = $row['menu_image'];
        $price = $row['menu_price'];
      }
        $priceTotal = $price * $each_item["quantity"];
        $cartTotal = $priceTotal + $cartTotal;

       /*  setlocale(LC_MONETARY,"en_US");
        $priceTotal = money_format('%10.2n', $priceTotal); */
        //table row products
        $cartOutput .="<tr>";
        $cartOutput .= "<td>". $product_name ."</td>";
        $cartOutput .= "<td>";
        $cartOutput .= "<img src='../admin/menu_images/$product_image' width='80px' height='80px' class='img-rounded'>";
        $cartOutput .= "</td>";
        $cartOutput .= "<td>&#8369;". number_format($price, 2) ."</td>";
        $cartOutput .= "<td>Servings:";
        $cartOutput .= "<form  action=\"cart.php\" method=\"POST\">";
        $cartOutput .= "<input name=\"quantity\" type=\"text\" value=\"".$each_item['quantity']."\" size=\"1\" maxlength=\"2\">";
        $cartOutput .= "<button name=\"adjustBtn\"".$item_id."\"  class=\"btn btn-primary\" type=\"submit\">";
        $cartOutput .= "<span class=\"fa fa-edit\"></span>";
        $cartOutput .= "</button>";
        $cartOutput .= "<input name=\"item_to_adjust\" type=\"hidden\" value=\"". $item_id . "\">";
        $cartOutput .= "</form>";
        $cartOutput .= "</td>";          
  
       // $cartOutput .= "<td> Quantity: ". $each_item['quantity'] ."</td>";
        $cartOutput .= "<td> Total: ". number_format($priceTotal, 2)."</td>";
        $cartOutput .= '<td>';
        $cartOutput .= '<form action="cart.php" method="POST">';
        $cartOutput .= '<button name="deleteBtn'.$item_id.'" title="Remove" class="btn btn-danger" type="submit" onclick="return confirm(\'Remove this item?\')">';
        $cartOutput .= '<span class="fa fa-close"></span>';
        $cartOutput .= '</button>';
        $cartOutput .= '<input name="index_to_remove" type="hidden" value="'. $i .'">';
        $cartOutput .= '</form>';
        $cartOutput .= '</td>';
        $cartOutput .= "</tr>";
        
        $i++;
    }
    /* setlocale(LC_MONETARY,"en_US");
    $cartTotal = money_format('%10.2n', $cartTotal); */
    $cartTotal = "Total Amount: <span class='label label-default label-success'> &#8369;  ".number_format($cartTotal, 2)."</span>";
  }
?>

<!DOCTYPE html>
<html lang="en">
  <!-- head -->
  <?php include '../../includes/layout/main_layout/main_head.php'?>
  <!-- end: head -->

  <body>
  <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header page-scroll">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="main.php">Caterfy</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="hidden">
            <a></a>
          </li>
          <?php 
            // dynamic categories bar
            $query_stores = "SELECT * FROM stores";
            $run_stores = mysqli_query($connection, $query_stores);
            confirm_query($run_stores);
            while ($stores_set = mysqli_fetch_assoc($run_stores)) {
              $store_id = $stores_set['id'];
              $store_name = $stores_set['store_name'];
              echo "<li class=\"page-scroll\">
                      <a href='stores_content.php?store_id=".urlencode($store_id)."'>"
                        .htmlentities($store_name)."
                      </a>
                    </li>";
            }
          ?>
        </ul>
      </div>
        <!-- /.navbar-collapse -->
    </div>
      <!-- /.container-fluid -->
  </nav>

  <main class="container menus-content">
    <section class="row">
      <div class='col-md-offset-2 col-md-8'>
        <!--show the values in the cart-->
        <div class="cart-btn">
          <h2>Your list</h2>
          <a href="cart.php?cmd=emptycart" class='btn btn-danger pull-right' onclick="return confirm('Are you sure you want to empty your cart?')" title="Empty your list">
          <span class='fa fa-trash'></span>
          </a>
        
          <a href="<?php echo !isset($_SESSION['cart_array']) ? '' :  'checkout_form.php'; ?>" class='btn btn-primary' title="Buy Me"> CHECK OUT</a>

        </div>
        
        <table class="table table-responsive animated fadeIn table-list">
          <tbody>
            <?php echo $cartOutput;?>
          </tbody>
        </table>
        <h3 class="pull-right"><?php echo $cartTotal; ?></h3>
        <!-- end: show the values in the cart-->
      </div>
    </section>
  </main>

  <!-- footer -->
  <?php include '../../includes/layout/main_layout/main_footer.php'; ?>
  <!-- end: footer -->
  </body>
</html>