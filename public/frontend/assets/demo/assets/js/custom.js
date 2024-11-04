/* -----------------------------------------------------------------------------

File:           JS Core
Version:        1.0
Author:         

-------------------------------------------------------------------------------- */
(function() {

	"use strict";

	var Appilo = {
		init: function() {
			this.Basic.init();  
		},

		Basic: {
			init: function() {
				this.preloader();
				this.BackgroundImage();
				this.Animation();
				this.PageTab();
				this.ReviewSlide();
				this.scrollTop();
			},

			preloader: function (){
				jQuery(window).on('load', function(){
					jQuery('#preloader').fadeOut('slow',function(){jQuery(this).remove();});
				});
			},
			BackgroundImage: function (){
				$('[data-background]').each(function() {
					$(this).css('background-image', 'url('+ $(this).attr('data-background') + ')');
				});
				jQuery(window).on('scroll', function() {
					if (jQuery(window).scrollTop() > 100) {
						jQuery('.header-section').addClass('sticky-menu')
					} else {
						jQuery('.header-section').removeClass('sticky-menu')
					}
				})
				$('.str-open_mobile_menu').on("click", function() {
					$('.str-mobile_menu_wrap').toggleClass("mobile_menu_on");
				});
				$('.str-open_mobile_menu').on('click', function () {
					$('body').toggleClass('mobile_menu_overlay_on');
				});
				if($('.str-mobile_menu li.dropdown ul').length){
					$('.str-mobile_menu li.dropdown').append('<div class="dropdown-btn"><span class="fa fa-angle-down"></span></div>');
					$('.str-mobile_menu li.dropdown .dropdown-btn').on('click', function() {
						$(this).prev('ul').slideToggle(500);
					});
				}
			},
			Animation: function (){
				AOS.init({
					once:true,
					duration:1000,
				});
				if($('.wow').length){
					var wow = new WOW(
					{
						boxClass:     'wow',
						animateClass: 'animated',
						offset:       0,
						mobile:       true,
						live:         true
					}
					);
					wow.init();
				}
			},
			PageTab:  function (){
				jQuery(window).on('load', function(){
					$('.filtr-container').imagesLoaded ( function(){});
					var filterizd = $('.filtr-container');

					if(filterizd.length) {
						filterizd.filterizr({

						});
						$('.filtr-button').on('click', function() {

							$('.filtr-button.filtr-active').removeClass('filtr-active');
							$(this).addClass('filtr-active');
						});
					}
				});
			},
			ReviewSlide: function (){
				$('#ln-review-slide').owlCarousel({
					margin: 30,
					responsiveClass:true,
					nav: false,
					dots: true,
					autoplay: false,
					smartSpeed: 500,
					responsive:{
						0:{
							items:1,
						},
						400:{
							items:1,
						},
						600:{
							items:2,
						},
						700:{
							items:2,
						},
						1000:{
							items:3,

						}
					},
				})
			},
			scrollTop: function (){
				$(window).on("scroll", function() {
					if ($(this).scrollTop() > 200) {
						$('.scrollup').fadeIn();
					} else {
						$('.scrollup').fadeOut();
					}
				});

				$('.scrollup').on("click", function()  {
					$("html, body").animate({
						scrollTop: 0
					}, 800);
					return false;
				});

			},

/* End Of js
================================================*/
}
}
jQuery(document).ready(function (){
	Appilo.init();

	$('.counter').counterUp({
		delay: 10,
		time: 500
	  });
});

$(window).on('load',function(){

	setInterval(function(){ 
		$("#banner .tm-banners").addClass("animated");
		$("#banner .tm-banners-right-side").addClass("animated");
	}, 1000);
   
});

})();