  <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header page-scroll">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="../">Caterfy</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="hidden">
            <a></a>
          </li>
          <li>
            <a href="cart.php">
              <span class="badge"><?php echo isset($_SESSION['cart_array']) ? count($_SESSION['cart_array']) : 0; ?></span> Your menu list
            </a>
          </li>
        </ul>
      </div>
        <!-- /.navbar-collapse -->
    </div>
      <!-- /.container-fluid -->
  </nav>