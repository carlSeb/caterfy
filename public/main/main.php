<?php
  require '../../includes/functions/session.php';
  require '../../includes/functions/db_connect.php';
  require '../../includes/functions/functions.php';
  require '../../includes/functions/validations_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
  <!-- head tags  -->
  <?php include '../../includes/layout/main_layout/main_head.php'?>
  <!-- end: head tags  -->

  <body>
  <?php include '../../includes/layout/main_layout/main_nav.php'?>
  
  <!-- main content -->
  <main class="container-fluid menus-content">
    <section class="row">
      <?php include 'stores.php'?>
    </section>
  </main>
  <!-- end: main content -->  

  <!-- footer -->
  <?php include '../../includes/layout/main_layout/main_footer.php'?>
  <!-- end: footer -->

  </body>
</html>