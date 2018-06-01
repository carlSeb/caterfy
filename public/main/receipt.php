<?php  
  require '../pdf/fpdf.php';
  require '../../includes/functions/session.php';
  require '../../includes/functions/db_connect.php';
  require '../../includes/functions/functions.php';
  require '../../includes/functions/validations_functions.php';
  $cartTotal = 0;

  /*
  A4 width: 219mm
  default margin: 10mm each side
  writable horizontal: 219 (10*2) = 189mm
  */

  $pdf = new FPDF('P','mm', 'A4');
  $pdf -> AddPage();

  // set font arial to bold 14pt
  $pdf -> SetFont('Arial', 'B', 14);

  // Cell (width, height, text, border, end line, [align = L C R])
  $pdf -> Cell(130, 5, "Caterfy", 0, 0);
  $pdf -> Cell(59, 5, "Invoice", 0, 1); //end of line
  // set font to arial regular 12pt
  $pdf ->SetFont('Arial','', 12);
  $pdf -> Cell(130, 5, "Real Street", 0, 0);
  $pdf -> Cell(59, 5, "", 0, 1); //end of line

  $pdf -> Cell(130, 5, "Tacloban City", 0, 0);
  $pdf -> Cell(25, 5, "Date: ", 0, 0); 
  $pdf -> Cell(34, 5, date('d-M-Y'), 0, 1); //end of line

  $pdf -> Cell(130, 5, "Contact: 09159874954", 0, 0);
  $pdf -> Cell(25, 5, "Email us: ", 0, 0); 
  $pdf -> Cell(34, 5, "caterfy@gmail.com", 0, 1); //end of line

  $pdf -> Cell(130, 5, "Fax: [...] ", 0, 0);
  $pdf -> Cell(25, 5, "Customer ID: ", 0, 0); 
  $pdf -> Cell(34, 5, "[...]", 0, 1); //end of line

  // make a dummy empty cell as a vertical spacer
  $pdf -> Cell(189, 10, '', 0, 1);
  
  // billing address
  $pdf -> Cell(100, 10, 'Bill to: ', 0, 1);

  // add dummy cell at beginning of each line for indentation
  if (isset($_GET['id'])) {
    $id = urlencode($_GET['id']);
    $query = "SELECT * FROM checkout_details WHERE id = {$id} LIMIT 1";
    $query_result = mysqli_query($connection, $query);
    confirm_query($query_result);

    while ($result_set = mysqli_fetch_assoc($query_result)) {
      $customer_name = $result_set['customer_name'];
      $customer_address = $result_set['customer_address'];
      $customer_email = $result_set['customer_email'];
      $customer_contact = $result_set['customer_contact'];

      $pdf -> Cell(10, 5, '', 0, 0);
      $pdf -> Cell(90, 5, $customer_name, 0, 1);
      
      $pdf -> Cell(10, 5, '', 0, 0);
      $pdf -> Cell(90, 5, $customer_address, 0, 1);
      
      $pdf -> Cell(10, 5, '', 0, 0);
      $pdf -> Cell(90, 5, $customer_email, 0, 1);
      
      $pdf -> Cell(10, 5, '', 0, 0);
      $pdf -> Cell(90, 5, $customer_contact, 0, 1);
    }
  }

  // make a dummy empty cell as a vertical spacer
  $pdf -> Cell(189, 10, '', 0, 1); //end line

  // invoice contents
  $pdf -> SetFont('Arial', 'B', 12);

  $pdf -> Cell(130, 5, 'Description: ', 1, 0);
  $pdf -> Cell(25, 5, 'Price: ', 1, 0);
  $pdf -> Cell(34, 5, 'Amount: ', 1, 1);
  $pdf -> SetFont('Arial', '', 12);

  // Numbers are right aligned so we give 'R' after new line parameter
  if (isset($_SESSION['cart_array'])) {
    foreach($_SESSION['cart_array'] as $each_item) {
      $item_id = $each_item['item_id'];
      $sql = "SELECT * FROM menus WHERE id = {$item_id} LIMIT 1";
      $itemQuery = mysqli_query($connection, $sql);
      confirm_query(itemQuery);
      while ($row = mysqli_fetch_assoc($itemQuery)) {
        $menu_name = $row['menu_name'];
        $menu_image = $row['menu_image'];
        $price = $row['menu_price'];
      }
      $priceTotal = $price * $each_item["quantity"];
      $cartTotal = $priceTotal + $cartTotal;
      $pdf -> Cell(130, 5, $menu_name . " x " . $each_item['quantity'] , 1, 0);
      $pdf -> Cell(25, 5, number_format($price, 2), 1, 0);
      $pdf -> Cell(34, 5, number_format($priceTotal, 2), 1, 1, 'R'); //end line
    }
  
  /* $pdf -> Cell(130, 5, 'Super Clean Dishwasher', 1, 0);
  $pdf -> Cell(25, 5, '-', 1, 0);
  $pdf -> Cell(34, 5, '1,200', 1, 1, 'R'); //end line

  $pdf -> Cell(130, 5, 'Something Else', 1, 0);
  $pdf -> Cell(25, 5, '-', 1, 0);
  $pdf -> Cell(34, 5, '1,200', 1, 1, 'R'); */ //end line

  // summary
  /* $pdf -> Cell(130, 5, '', 0, 0);
  $pdf -> Cell(25, 5, 'Subtotal: ', 0, 0);
  $pdf -> Cell(4, 5, 'P', 0, 0);
  $pdf -> Cell(30, 5, '1,200', 1, 1, 'R'); //end line

  $pdf -> Cell(130, 5, '', 0, 0);
  $pdf -> Cell(25, 5, 'Taxable: ', 0, 0);
  $pdf -> Cell(4, 5, 'P', 0, 0);
  $pdf -> Cell(30, 5, '0', 1, 1, 'R'); //end line

  $pdf -> Cell(130, 5, '', 0, 0);
  $pdf -> Cell(25, 5, 'Tax Rate: ', 0, 0);
  $pdf -> Cell(4, 5, 'P', 0, 0);
  $pdf -> Cell(30, 5, '10%', 1, 1, 'R'); */ //end line

  $pdf -> Cell(130, 5, '', 0, 0);
  $pdf -> Cell(25, 5, 'Total Due: ', 0, 0);
  $pdf -> Cell(4, 5, 'P', 0, 0);
  $pdf -> Cell(30, 5, number_format($cartTotal, 2), 1, 1, 'R'); //end line
  } else {
    $pdf -> Cell(130, 5, 'Something went wrong please try again' , 0, 0);
    $pdf -> Cell(25, 5, '', 0, 0);
    $pdf -> Cell(34, 5, '', 0, 1, 'R'); //end line
  }

  $pdf -> Output();
  unset($_SESSION['cart_array']);

?>