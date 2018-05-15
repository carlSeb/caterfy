<!DOCTYPE html>
<html lang="en">
	<!-- head, meta tags, stylesheets  -->
	<?php include 'files/page_struc/head.php'; ?>
	<!-- head, meta tags, stylesheets  -->

	<body id="page-top">
		<!-- Navigation -->
		<?php include 'files/page_struc/nav.php'; ?>
		<!-- Navigation -->
		<!-- intro section -->
		<section class="container">
			<div class="row">
				<div class="col-md-6">
					<img src="img/jumb.png" alt="logo" class="logo img-responsive img-circle">
				</div>
				<div class="col-md-6">
					<div class="text-intro">
						<h1>Welcome to Caterfy</h1>
						<hr class="line-break">
						<h3>We cater to all kinds of party services such as Anniversaries, Weddings and Debut, Birthday Parties, Children’s Party, Junior & Senior Prom, Bridal Shower, Baby Shower, Baptismal Cocktails, Graduations, Reunions, Seminars, Meeting, Workshops, Pack Meal, Food Tray, & others</h3>
						<div class="page-scroll">
							<a href="#menu">
								<button class="intro-btn btn btn-primary btn-lg">
									<span class="animated pulse infinite fa fa-5x fa-chevron-circle-down" aria-hidden="true"></span>
								</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- end of intro section -->

		<!-- menu section -->
		<section id="menu" >
			<div class="jumbotron">
				<a href=""><button class="animated pulse infinite">CREATE YOUR OWN PACKAGE</button></a>
			</div>
		</section>
		<!-- end of intro section -->
	
		<!-- gallery section -->
		<section id="gallery">
			<div class="container">
			  <div class="row">
		      <div class="col-lg-4 col-sm-4 col-xs-12">
		      	<a title="Caterfy" href="#"><img class="thumbnail img-responsive" src="img/gallery/01.jpg"></a>
		      </div>
		      <div class="col-lg-4 col-sm-4 col-xs-12">
		      	<a title="Caterfy" href="#"><img class="thumbnail img-responsive" src="img/gallery/10.jpg"></a>
		      </div>
		      <div class="col-lg-4 col-sm-4 col-xs-12">
		      	<a title="Caterfy" href="#"><img class="thumbnail img-responsive" src="img/gallery/18.jpg"></a>
		      </div>
		      <div class="col-lg-4 col-sm-4 col-xs-12">
		      	<a title="Caterfy" href="#"><img class="thumbnail img-responsive" src="img/gallery/34.jpg"></a>
		      </div>
		      <div class="col-lg-4 col-sm-4 col-xs-12">
		      	<a title="Caterfy" href="#"><img class="thumbnail img-responsive" src="img/gallery/04.jpg"></a>
		      </div>
		      <div class="col-lg-4 col-sm-4 col-xs-12">
		      	<a title="Caterfy" href="#"><img class="thumbnail img-responsive" src="img/gallery/07.jpg"></a>
		      </div>
			  </div>
			</div>
			<?php include 'files/page_struc/modals.php'; ?>
		</section>
		<!-- end gallery section -->

		<section id="about">
			<div class="container">
				<h2 class="text-center about-text">ABOUT US</h2>
				<hr class="line-break about-text">
				<br>
				<p class="about-text"><em>Caterfy</em> - prides itself on its affordable yet incredibly delicious food that works within our clients budget. </p>
				<p class="about-text">We are customer-centered oriented and our catering officers also customized accommodations that will fit your preferred events.</p>
				<p class="about-text"><em>Vision</em> - to become the number one (1) choice catering services in any special ocassion.</p>
			</div>
		</section>
		
		<!-- contact section -->
		<section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2>Contact Us</h2>
            <hr class="line-break">
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
            <form name="sentMessage" id="contactForm" novalidate>
              <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                  <label>Name</label>
                  <input type="text" class="form-control" placeholder="Name" id="name" required>
                </div>
              </div>
              <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                  <label>Email Address</label>
                  <input type="email" class="form-control" placeholder="Email Address" id="email" required>
                </div>
              </div>
              <div class="row control-group">
	              <div class="form-group col-xs-12 floating-label-form-group controls">
                  <label>Phone Number</label>
                  <input type="tel" class="form-control" placeholder="Phone Number" id="phone">
	              </div>
              </div>
              <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                  <label>Message</label>
                  <textarea rows="5" class="form-control" placeholder="Message" id="message" required></textarea>
                </div>
              </div>
              <br>
              <div id="success"></div>
              <div class="row">
                <div class="form-group col-xs-12">
                  <button type="submit" class="btn btn-primary btn-lg">Send</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
		<!-- end contact section -->

		<!-- footer and javascript -->
		<?php include 'files/page_struc/footer.php'; ?>
		<!-- footer and javascript -->
	</body>
</html>
