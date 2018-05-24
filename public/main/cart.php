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
    $checkOutForm ="";
    $checkOutFormBtn = "";
    $echoPurchase = "";
                    
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
        $cartOutput .= "<img src='../admin/menu_images/$product_image' width='80px' height='80px'>";
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
        //for checkout form , get product purchased
        $checkOutForm .= '<input type="hidden" name="purchase_id" value="'.$item_id.'">';
        $checkOutForm .= '<input type="hidden" name="product_name" value="'.$product_name.'">';
        $checkOutForm .= '<input type="hidden" name="product_quantity" value="'.$each_item['quantity'].'">';
        $checkOutForm .= '<input type="hidden" name="product_price" value="'.$price.'">';
        $checkOutForm .= '<input type="hidden" name="product_priceTotal" value="'.$priceTotal.'">';
        $checkOutForm .= '<input type="hidden" name="product_cartTotal" value="'.$cartTotal.'">';

        $echoPurchase .= '<tr>';
        $echoPurchase .= '<td>'.$product_name.'</td>';
        $echoPurchase .= '<td>'.$each_item['quantity'].'</td>';
        $echoPurchase .= '<td>'.$price.'</td>';
        $echoPurchase .= '<td>'.$priceTotal.'</td>';
        $echoPurchase .= '</tr>';
        
        $i++;
    }
    /* setlocale(LC_MONETARY,"en_US");
    $cartTotal = money_format('%10.2n', $cartTotal); */
    $cartTotal = "Total: <span class='label label-default label-success'> &#8369;  ".number_format($cartTotal, 2)."</span>";
}
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
            $query_categories = "SELECT * FROM categories";
            $run_categories = mysqli_query($connection, $query_categories);
            confirm_query($run_categories);
            while ($cat_set = mysqli_fetch_assoc($run_categories)) {
              $category_id = $cat_set['id'];
              $category_name = $cat_set['category_name'];
              echo "<li class=\"page-scroll\">
                      <a href='main.php?category_id=". urlencode($category_id)."'>"
                        .htmlentities($category_name)."
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
      <div class='col-sm-10 col-md-offset-2 col-md-8'>
        <!--show the values in the cart-->
        <div class="cart-btn">
          <h2>Your list</h2>
          <a href="cart.php?cmd=emptycart" class='btn btn-danger btn-lg pull-right' onclick="return confirm('Are you sure you want to empty your cart?')" title="Empty your list">
          <span class='fa fa-trash'></span>
          </a>
        
          <button data-toggle='modal' data-target='#shoeboxModal' class='btn btn-primary btn-lg' title="Buy Me"> CHECK OUT</button>
        </div>
        
        <table class="table table-responsive animated fadeIn table-list">
          <tbody>
            <?php echo $cartOutput;?>
          </tbody>
        </table>
        <h3><?php echo $cartTotal; ?></h3>
        <!-- end: show the values in the cart-->
      </div>
    </section>
  </main>

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