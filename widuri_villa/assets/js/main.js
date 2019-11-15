function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var imgId = '#preview-'+$(input).attr('id');
      $(imgId).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("input[type='file'].FotoUpload").change(function(){
  readURL(this);
});
function toggleToolTip(originalTitle, newTitle) {
  var lastTitle = $(this).attr('data-original-title');
  $(this).attr('data-original-title',lastTitle === originalTitle ? newTitle : originalTitle);
  $(this).tooltip('show');
};

var isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
		BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
		iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
		Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
		Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
		any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
};


$(window).stellar({
  responsive: true,
  parallaxBackgrounds: true,
  parallaxElements: true,
  horizontalScrolling: false,
  hideDistantElements: false,
  scrollProperty: 'scroll'
});


var fullHeight = function() {

	$('.js-fullheight').css('height', $(window).height());
	$(window).resize(function(){
		$('.js-fullheight').css('height', $(window).height());
	});

};
fullHeight();

// loader
var loader = function() {
	setTimeout(function() { 
		if($('#ftco-loader').length > 0) {
			$('#ftco-loader').removeClass('show');
		}
	}, 1);
};
loader();

// Scrollax
 $.Scrollax();

var carousel = function() {
	$('.carousel-testimony').owlCarousel({
		center: true,
		loop: true,
		items:1,
		margin: 30,
		stagePadding: 0,
		nav: false,
		navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
		responsive:{
			0:{
				items: 1
			},
			600:{
				items: 2
			},
			1000:{
				items: 3
			}
		}
	});

};
carousel();

$('nav .dropdown').hover(function(){
	var $this = $(this);
	// 	 timer;
	// clearTimeout(timer);
	$this.addClass('show');
	$this.find('> a').attr('aria-expanded', true);
	// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
	$this.find('.dropdown-menu').addClass('show');
}, function(){
	var $this = $(this);
		// timer;
	// timer = setTimeout(function(){
		$this.removeClass('show');
		$this.find('> a').attr('aria-expanded', false);
		// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').removeClass('show');
	// }, 100);
});


$('#dropdown04').on('show.bs.dropdown', function () {
  console.log('show');
});

// scroll
var scrollWindow = function() {
	$(window).scroll(function(){
		var $w = $(this),
				st = $w.scrollTop(),
				navbar = $('.ftco_navbar'),
				sd = $('.js-scroll-wrap');

		if (st > 150) {
			if ( !navbar.hasClass('scrolled') ) {
				navbar.addClass('scrolled');	
			}
		} 
		if (st < 150) {
			if ( navbar.hasClass('scrolled') ) {
				navbar.removeClass('scrolled sleep');
			}
		} 
		if ( st > 350 ) {
			if ( !navbar.hasClass('awake') ) {
				navbar.addClass('awake');	
			}
			
			if(sd.length > 0) {
				sd.addClass('sleep');
			}
		}
		if ( st < 350 ) {
			if ( navbar.hasClass('awake') ) {
				navbar.removeClass('awake');
				navbar.addClass('sleep');
			}
			if(sd.length > 0) {
				sd.removeClass('sleep');
			}
		}
		// scroll popup
		if ($(this).scrollTop() > 500) {
			$('#scroll-ca').fadeIn();
		} else {
			$('#scroll-ca').fadeOut();
		}
	});
};
scrollWindow();

$('#scroll-ca').on('click',function(){
  if($('#scroll-ca.scroll-ca').hasClass('animated pulse infinite')){
      $('#scroll-ca.scroll-ca').removeClass('animated pulse infinite');
  }
  $('.modal').on('click', function(){
      $('#scroll-ca.scroll-ca').addClass('animated pulse infinite');
  });
});

var isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
		BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
		iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
		Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
		Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
		any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
};

var counter = function() {
	
	$('#section-counter, .hero-wrap, .ftco-counter').waypoint( function( direction ) {

		if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

			var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
			$('.number').each(function(){
				var $this = $(this),
					num = $this.data('number');
					console.log(num);
				$this.animateNumber(
				  {
				    number: num,
				    numberStep: comma_separator_number_step
				  }, 7000
				);
			});
			
		}

	} , { offset: '95%' } );

}
counter();


var contentWayPoint = function() {
	var i = 0;
	$('.ftco-animate').waypoint( function( direction ) {

		if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {
			
			i++;

			$(this.element).addClass('item-animate');
			setTimeout(function(){

				$('body .ftco-animate.item-animate').each(function(k){
					var el = $(this);
					setTimeout( function () {
						var effect = el.data('animate-effect');
						if ( effect === 'fadeIn') {
							el.addClass('fadeIn ftco-animated');
						} else if ( effect === 'fadeInLeft') {
							el.addClass('fadeInLeft ftco-animated');
						} else if ( effect === 'fadeInRight') {
							el.addClass('fadeInRight ftco-animated');
						} else {
							el.addClass('fadeInUp ftco-animated');
						}
						el.removeClass('item-animate');
					},  k * 50, 'easeInOutExpo' );
				});
				
			}, 100);
			
		}

	} , { offset: '95%' } );
};
contentWayPoint();

// Scrolled navbar
$('#ftco-nav ul li a[href*="#"]:not([href="#"])').click(function() {
  if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
    var target = $(this.hash);
    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    if (target.length) {
      $('html, body').animate({
        scrollTop: (target.offset().top - 0)
      }, 1000, "easeInOutExpo");
      return false;
    }
  }
});
// scrolled footer
$('.ftco-footer-widget.foo-index ul li a[href*="#"]:not([href="#"])').click(function() {
  if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
    var target = $(this.hash);
    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    if (target.length) {
      $('html, body').animate({
        scrollTop: (target.offset().top - 0)
      }, 1000, "easeInOutExpo");
      return false;
    }
  }
});
// hide responsive
$('.nav-link').click(function() {
  $('.navbar-collapse').collapse('hide');
});
// add class active
$('body').scrollspy({
  target: '#ftco-nav',
  offset: 56
});

// light popup gallery
$("#my-gallery").lightGallery({
	selector: 'a,img',
	thumbnail:false,
  animateThumb: false,
  showThumbByDefault: false,
  mode: 'lg-zoom-out-in'
}); 

var goHere = function() {

	$('.mouse-icon').on('click', function(event){
		
		event.preventDefault();

		$('html,body').animate({
			scrollTop: $('.goto-here').offset().top
		}, 500, 'easeInOutExpo');
		
		return false;
	});
};
goHere();

// toggle class rezise window
$(window).on('load', function(){
  var win = $(this); //this = window
  // if (win.height() >= 820) { /* ... */ }
  if (win.width() <= 766) {
  	$('.label-form-ck').removeClass('col').addClass('col-md-12');
  }else{
  	$('.label-form-ck').removeClass('col-md-12').addClass('col');
  };
  if(win.width() <=767){
  	$('.form-tamu-inpt').removeClass('pr-0');
  }else{
  	$('.form-tamu-inpt').addClass('pr-0');
  }
});
$("#contentOne").focusin(function() {
  $("#contentOne").addClass('shadow-content');
  $("#contentOne").css('transition', 'all 0.30s');
});
$("#contentOne").focusout(function() {
  $("#contentOne").css('transition', 'all 0.30s');
  $("#contentOne").removeClass('shadow-content');
});
$("#contentTwo").focusin(function() {
  $("#contentTwo").addClass('shadow-content');
  $("#contentOne").css('transition', 'all 0.30s');
});
$("#contentTwo").focusout(function() {
  $("#contentTwo").css('transition', 'all 0.30s');
  $("#contentTwo").removeClass('shadow-content');
});
$("#contentTree").focusin(function() {
  $("#contentTree").addClass('shadow-content');
  $("#contentTree").css('transition', 'all 0.30s');
});
$("#contentTree").focusout(function() {
  $("#contentTree").css('transition', 'all 0.30s');
  $("#contentTree").removeClass('shadow-content');
});
$("#zz").focusin(function() {
  $("#zz").addClass('shadow-content');
  $("#zz").css('transition', 'all 0.30s');
});
$("#zz").focusout(function() {
  $("#zz").css('transition', 'all 0.30s');
  $("#zz").removeClass('shadow-content');
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
jQuery.fn.extend({
  toggleText: function (a, b){
    var isClicked = false;
    var that = this;
    this.click(function (){
      if (isClicked) { that.text(a); isClicked = false; }
      else { that.text(b); isClicked = true; }
    });
    return this;
  }
});