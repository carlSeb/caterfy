<?php 
  require '../../includes/functions/session.php';
  require '../../includes/functions/db_connect.php';
  require '../../includes/functions/functions.php';
  require '../../includes/functions/validations_functions.php';

  if (!isset($_SESSION['cart_array'])) {
    redirect_to("main.php");
  }

  if (isset($_POST['proceed'])) {
    $customer_name = htmlentities(trim($_POST['customer_name']));
    $customer_address = htmlentities(trim($_POST['customer_address']));
    $customer_email = htmlentities(trim($_POST['customer_email']));
    $customer_contact = htmlentities(trim($_POST['customer_contact']));

    if (!has_presence($customer_name) || !has_presence($customer_address) ||
      !has_presence($customer_email) || !has_presence($customer_contact)) {
      $_SESSION['errors'] = "Please fill up the fields.";
      redirect_to("checkout_form.php");

    } else {
      $customer_name = mysqli_real_escape_string($connection, ucwords($customer_name));
      $customer_address = mysqli_real_escape_string($connection, $customer_address);
      $customer_email = mysqli_real_escape_string($connection, $customer_email);
      $customer_contact = mysqli_real_escape_string($connection, $customer_contact);
      
      $query = "INSERT INTO checkout_details ( ";
      $query .= "customer_name, customer_address, ";
      $query .= "customer_email, customer_contact ";
      $query .= ") VALUES ( ";
      $query .= "'{$customer_name}', '{$customer_address}', ";
      $query .= "'{$customer_email}', '{$customer_contact}') ";
      $query_result = mysqli_query($connection, $query);
      confirm_query($query_result);

      if ($query_result) {
        $query = "SELECT * FROM checkout_details";
        $query_result = mysqli_query($connection, $query);
        if (confirm_query($query_result)) {
          $_SESSION['errors'] = "Checkout failed";
          redirect_to("checkout_form.php");
        }

        while ($result_set = mysqli_fetch_assoc($query_result)) {
          $checkout_id = $result_set['id'];
        } 
      
        redirect_to("receipt.php?id=" . urlencode($checkout_id));
      }
    }
  } 

?>
<!DOCTYPE html>
<html lang="en">
  <!-- head tags -->
  <?php include '../../includes/layout/main_layout/main_head.php'; ?>
  <!-- end: head tags -->
<body>
  <!-- nav -->
  <?php include '../../includes/layout/main_layout/main_nav.php';?>
  <!-- end: nav -->

  <main class="container-fluid checkout-area">

  <div class="row">
    <div class="col-md-offset-3 col-md-6">
      <div class="checkout-header">
        <h2>Checkout</h2>
      </div>
      <?php echo errors(); ?>
      <form class="form-horizontal" role="form" action="checkout_form.php" method="POST">

        <!-- Form Name -->
        <legend>Customer Details</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="textinput">Name</label>
          <div class="col-sm-10">
            <input type="text" placeholder="Full Name" class="form-control" name="customer_name" required>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="textinput">Address</label>
          <div class="col-sm-10">
            <input type="text" placeholder="Address" class="form-control" name="customer_address" required>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="textinput">Email</label>
          <div class="col-sm-4">
            <input type="email" placeholder="Email address" class="form-control" name="customer_email" required>
          </div>

          <label class="col-sm-2 control-label" for="textinput">Contact</label>
          <div class="col-sm-4">
            <input type="number" placeholder="Contact Number" class="form-control" name="customer_contact" required>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="pull-right">
              <button type="reset" class="btn btn-default" title="Clear"><span class="fa fa-eraser"></span></button>
              <button type="submit" class="btn btn-primary" name="proceed">Proceed</button>
            </div>
          </div>
        </div>

      </form>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row -->

  </main>
  
  <!-- footer -->
  <?php include '../../includes/layout/main_layout/main_footer.php'; ?>
  <!-- end: footer -->
</body>
</html>