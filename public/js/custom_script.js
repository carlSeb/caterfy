$(function() {
window.sr = ScrollReveal();
sr.reveal('.logo, .text-intro', {
  duration: 2000,
  origin: 'left',
  distance: '300px'
});

sr.reveal('.intro-btn', {
  duration: 2000,
  delay: 2000,
  origin: 'bottom'
});

sr.reveal('.jumbotron', {
  duration: 2000,
  origin: 'bottom',
  distance: '300px',
  viewFactor: 0.2
});

sr.reveal('.thumbnail', {
  duration: 2000,
  delay: 1000,
  origin: 'bottom'
});

sr.reveal('.about-text', {
  duration: 2000,
  origin: 'bottom',
  viewFactor: 0.2
});

sr.reveal('#contact', {
  duration: 2000,
  origin: 'top',
  distance: '100px'
});
/*sr.reveal('.navbar', {
	duration: 2000,
	origin: 'bottom'
});

sr.reveal('.home-left', {
	duration: 2000,
	origin: 'top',
	distance: '300px'
});

sr.reveal('.home-right', {
	duration: 2000,
	origin: 'right',
	distance: '300px'
});

sr.reveal('.btn-lg', {
	duration: 2000,
	delay: 2000,
	origin: 'bottom',
});

sr.reveal('#about', {
	duration: 2000,
	origin: 'bottom',
	distance: '300px',
	viewFactor: 0.2
});*/

		// jQuery for page scrolling feature - requires jQuery Easing plugin
    $('.page-scroll a').bind('click', function(event) {
      var $anchor = $(this);
      $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top - 50)
      }, 1250, 'easeInOutExpo');
      event.preventDefault();
    });

    // Highlight the top nav as scrolling occurs
    $('body').scrollspy({
      target: '.navbar-fixed-top',
      offset: 51
    });
    
    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function(){ 
      $('.navbar-toggle:visible').click();
    });

    // Offset for Main Navigation
    $('#mainNav').affix({
      offset: {
        top: 100
      }
    });

    // for modals 
    $('.img-thumb').click(function(e){
        e.preventDefault();
        $('.modal-body').empty();
      let title = $(this).parent('a').attr("title");
      $('.modal-title').html(title);
      $($(this).parents('div').html()).appendTo('.modal-body');
      $('#myModal').modal({show:true});
    });

});
