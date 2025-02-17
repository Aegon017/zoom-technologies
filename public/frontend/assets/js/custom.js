/* -----------------------------------------------------------------------------

File:           JS Core
Version:        1.0
Author:

-------------------------------------------------------------------------------- */
(function () {

    "use strict";

    var Yle = {
        init: function () {
            this.Basic.init();
        },
        Basic: {
            init: function () {
                this.ylpreloader();
                this.BackgroundImage();
                this.Animation();
                this.ylStickymenu();
                this.ylMobileMenu();
                this.YlVideoBox();
                this.ylSliderMain();
                this.YlDepartment();
                this.YlTestimonial1();
                this.CourseGrid();
                this.CourseGridFilter();
                this.countDown();
                this.Ylblog();
                this.YLcategory();
                this.YlTestimonial12();
                this.YlTeamInstructor();
                this.YlBlog2();
                this.GoogleMap();

            },
            ylpreloader: function () {
                jQuery(window).on('load', function () {
                    jQuery('#zt-preloader').fadeOut('slow', function () { jQuery(this).remove(); });
                });
                $(window).on("scroll", function () {
                    if ($(this).scrollTop() > 200) {
                        $('.scrollup').fadeIn();
                    } else {
                        $('.scrollup').fadeOut();
                    }
                });

                $('.scrollup').on("click", function () {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 800);
                    return false;
                });
                if ($('select').length) {
                    $(document).ready(function () {
                        $('select').niceSelect();
                    });
                };
            },
            BackgroundImage: function () {
                $('[data-background]').each(function () {
                    $(this).css('background-image', 'url(' + $(this).attr('data-background') + ')');
                });
                if ($(".odometer").length) {
                    $('.odometer').appear();
                    $(document.body).on('appear', '.odometer', function (e) {
                        var odo = $(".odometer");
                        odo.each(function () {
                            var countNumber = $(this).attr("data-count");
                            $(this).html(countNumber);
                        });
                    });
                }
                if ($('.search-box-outer').length) {
                    $('.search-box-outer').on('click', function () {
                        $('body').addClass('search-active');
                    });
                    $('.close-search').on('click', function () {
                        $('body').removeClass('search-active');
                    });
                };
                jQuery('#zt-main-slider-3').owlCarousel({
                    items: 1,
                    loop: true,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    navSpeed: 1000,
                    smartSpeed: 2000,
                    navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
                });
                $(window).on('load', function () {
                    $('.zt-top-category-slider').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        nav: true,
                        dots: false,
                        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 2,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 3,

                            },
                            1300: {
                                items: 4,

                            },
                            1900: {
                                items: 4,
                            },
                        },
                    })
                    $('.zt-courses-offered-slider').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        autoplay: true,
                        nav: true,
                        dots: false,
                        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 2,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 3,

                            },
                            1300: {
                                items: 3,

                            },
                            1900: {
                                items: 4,
                            },
                        },
                    })
                    //Upcoming Batch Carousel
                    $('.upcoming-batch-carousel').owlCarousel({
                        margin: 20,
                        responsiveClass: true,
                        nav: true,
                        dots: false,
                        navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 2,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 3,

                            },
                            1300: {
                                items: 3,

                            },
                            1900: {
                                items: 3,
                            },
                        },
                    })
                    //Promo Carousel
                    $('.zt-promo-carousel').owlCarousel({
                        margin: 20,
                        responsiveClass: true,
                        nav: true,
                        dots: false,
                        navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 2,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 2,

                            },
                            1300: {
                                items: 2,

                            },
                            1900: {
                                items: 2,
                            },
                        },
                    })
                    //Client Logo Carousel
                    $('.zt-client-logo-carousel').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        nav: true,
                        dots: true,
                        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
                        loop: true,
                        responsive: {
                            0: {
                                items: 2,
                            },
                            400: {
                                items: 2,
                            },
                            600: {
                                items: 3,
                            },
                            700: {
                                items: 3,
                            },
                            1000: {
                                items: 4,

                            },
                            1300: {
                                items: 5,

                            },
                            1900: {
                                items: 6,
                            },
                        },
                    })
                });
                if ($(".odometer").length) {
                    $('.odometer').appear();
                    $(document.body).on('appear', '.odometer', function (e) {
                        var odo = $(".odometer");
                        odo.each(function () {
                            var countNumber = $(this).attr("data-count");
                            $(this).html(countNumber);
                        });
                    });
                };
                $(window).on('load', function () {
                    $('.testimonial-slider-3').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        nav: false,
                        dots: true,
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 1,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 2,

                            },
                            1300: {
                                items: 3,

                            },
                            1900: {
                                items: 3,
                            },
                        },
                    })
                });
            },
            Animation: function () {
                if ($('.wow').length) {
                    var wow = new WOW(
                        {
                            boxClass: 'wow',
                            animateClass: 'animated',
                            offset: 0,
                            mobile: true,
                            live: true
                        }
                    );
                    wow.init();
                }
            },
            YlVideoBox: function () {
                if ($('.video_box').length) {
                    $('.video_box').fancybox({
                        openEffect: 'fade',
                        closeEffect: 'fade',
                        helpers: {
                            media: {}
                        }
                    });
                }
            },
            ylStickymenu: function () {
                jQuery(window).on('scroll', function () {
                    if (jQuery(window).scrollTop() > 100) {
                        jQuery('.zt-header-main').addClass('zt-sticky-menu');
                        //jQuery('.sticky-bottom-contact-section').addClass('active');
                    } else {
                        jQuery('.zt-header-main').removeClass('zt-sticky-menu');
                        //jQuery('.sticky-bottom-contact-section').removeClass('active');
                    }
                })
            },
            ylMobileMenu: function () {
                $('.zt-open_mobile_menu').on("click", function () {
                    $('.zt-mobile_menu_wrap').toggleClass("mobile_menu_on");
                });
                $('.zt-open_mobile_menu').on('click', function () {
                    $('body').toggleClass('mobile_menu_overlay_on');
                });
                if ($('.zt-mobile_menu li.dropdown ul').length) {
                    $('.zt-mobile_menu li.dropdown').append('<div class="dropdown-btn"><span class="fa fa-angle-down"></span></div>');
                    $('.zt-mobile_menu li.dropdown .dropdown-btn').on('click', function () {
                        $(this).prev('ul').slideToggle(500);
                    });
                }
            },
            ylSliderMain: function () {
                jQuery('#zt-main-slider').owlCarousel({
                    items: 1,
                    loop: true,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    navSpeed: 1000,
                    smartSpeed: 2000,
                    animateOut: 'fadeOut',
                    animateIn: 'fadeIn',
                });
                jQuery('#zt-main-slider-2').owlCarousel({
                    items: 1,
                    loop: true,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    navSpeed: 1000,
                    smartSpeed: 2000,
                    navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
                });
            },
            YlDepartment: function () {
                $(window).on('load', function () {
                    $('#zt-department-slider-id').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        nav: true,
                        dots: false,
                        autoplay: true,
                        navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 1,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 3,

                            },
                            1300: {
                                items: 3,

                            },
                            1900: {
                                items: 3,

                            },
                        },
                    })
                });
            },
            YlTestimonial1: function () {
                $(window).on('load', function () {
                    $('#zt-testimonial-slide').owlCarousel({
                        margin: 0,
                        items: 1,
                        nav: false,
                        dots: true,
                        loop: true,
                        autoplay: true,
                        navSpeed: 1000,
                        smartSpeed: 2000,
                        autoplayHoverPause: true,
                    })
                });
            },
            CourseGrid: function () {
                var $grid = $('.grid').imagesLoaded(function () {
                    $grid.masonry({
                        percentPosition: true,
                        itemSelector: '.grid-item',
                        columnWidth: '.grid-sizer'
                    });
                });
            },
            CourseGridFilter: function () {
                var $grid = $('.grid').imagesLoaded(function () {
                    $grid.masonry({
                        percentPosition: true,
                        itemSelector: '.grid-item',
                        columnWidth: '.grid-sizer'
                    });
                });
                var $grid = $(".grid").isotope({
                    itemSelector: ".grid-item",
                    layoutMode: "fitRows"
                });
                var filterFns = {
                    numberGreaterThan50: function () {
                        var number = $(this)
                            .find(".number")
                            .text();
                        return parseInt(number, 10) > 50;
                    },
                    ium: function () {
                        var name = $(this)
                            .find(".name")
                            .text();
                        return name.match(/ium$/);
                    }
                };
                $(".button-group").on("click", "button", function () {
                    var filterValue = $(this).attr("data-filter");
                    filterValue = filterFns[filterValue] || filterValue;
                    $grid.isotope({ filter: filterValue });
                });

                $(".button-group").each(function (i, buttonGroup) {
                    var $buttonGroup = $(buttonGroup);
                    $buttonGroup.on("click", "button", function () {
                        $buttonGroup.find(".is-checked").removeClass("is-checked");
                        $(this).addClass("is-checked");
                    });
                });
            },
            countDown: function () {
                if ($('.coming-countdown').length > 0) {
                    var deadlineDate = new Date('march 26, 2021 23:59:59').getTime();
                    var countdownDays = document.querySelector('.days .arch-count-down-number');
                    var countdownHours = document.querySelector('.hours .arch-count-down-number');
                    var countdownMinutes = document.querySelector('.minutes .arch-count-down-number');
                    var countdownSeconds = document.querySelector('.seconds .arch-count-down-number');
                    setInterval(function () {
                        var currentDate = new Date().getTime();
                        var distance = deadlineDate - currentDate;
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        countdownDays.innerHTML = days;
                        countdownHours.innerHTML = hours;
                        countdownMinutes.innerHTML = minutes;
                        countdownSeconds.innerHTML = seconds;
                    }, 1000);

                };
            },
            Ylblog: function () {
                $(window).on('load', function () {
                    $('#zt-blog-slider-id').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        nav: true,
                        dots: false,
                        navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 1,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 3,

                            },
                            1300: {
                                items: 3,

                            },
                            1900: {
                                items: 3,
                            },
                        },
                    })
                });
            },
            YLcategory: function () {
                $(window).on('load', function () {
                    $('#zt-category-slide').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        nav: false,
                        dots: true,
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 1,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 3,

                            },
                            1300: {
                                items: 3,

                            },
                            1900: {
                                items: 3,
                            },
                        },
                    })
                });
            },
            YlTestimonial12: function () {
                $(window).on('load', function () {
                    $('#zt-testimonial-slide-2').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        nav: false,
                        dots: true,
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 1,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 3,

                            },
                            1300: {
                                items: 4,

                            },
                            1900: {
                                items: 4,
                            },
                        },
                    })
                });
            },
            YlBlog2: function () {
                $(window).on('load', function () {
                    $('#zt-blog-slider-2').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        nav: false,
                        dots: true,
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 1,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 3,

                            },
                            1300: {
                                items: 3,

                            },
                            1900: {
                                items: 3,
                            },
                        },
                    })
                });
            },
            YlTeamInstructor: function () {
                $(window).on('load', function () {
                    $('#zt-instructor-slider').owlCarousel({
                        margin: 30,
                        responsiveClass: true,
                        nav: true,
                        dots: false,
                        navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
                        loop: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            400: {
                                items: 1,
                            },
                            600: {
                                items: 1,
                            },
                            700: {
                                items: 2,
                            },
                            1000: {
                                items: 3,

                            },
                            1300: {
                                items: 4,

                            },
                            1900: {
                                items: 4,
                            },
                        },
                    })
                });
            },
            GoogleMap: function () {
                if ($('#yl_map').length) {
                    var $lat = $('#yl_map').data('lat');
                    var $lon = $('#yl_map').data('lon');
                    var $zoom = $('#yl_map').data('zoom');
                    var $marker = $('#yl_map').data('marker');
                    var $info = $('#yl_map').data('info');
                    var $markerLat = $('#yl_map').data('mlat');
                    var $markerLon = $('#yl_map').data('mlon');
                    var map = new GMaps({
                        el: '#yl_map',
                        lat: $lat,
                        lng: $lon,
                        scrollwheel: false,
                        scaleControl: true,
                        streetViewControl: false,
                        panControl: true,
                        disableDoubleClickZoom: true,
                        mapTypeControl: false,
                        zoom: $zoom,
                    });
                    map.addMarker({
                        lat: $markerLat,
                        lng: $markerLon,
                        icon: $marker,
                        infoWindow: {
                            content: $info
                        }
                    })
                }
            },

            /* End Of js
            ================================================*/
        }
    }
    jQuery(document).ready(function () {
        Yle.init();
        //One Page Navigation
        /*function scrollToSection(event) {
            event.preventDefault();
            var $section = $($(this).attr('href'));
            $('html, body').animate({
              scrollTop: $section.offset().top
            }, 500);
          }
          $('#scrolltosection li a').on('click', scrollToSection);*/
        $('.onepagenav').onePageNav({
            currentClass: 'current',
            changeHash: false,
            scrollSpeed: 500,
            scrollThreshold: 0.2,
            filter: '',
            easing: 'swing',
        });
    });
    $(document).ready(function () {
        // Add click event to accordion headers
        $('.accordion .accordion-header').click(function () {
            // Hide siblings and toggle the visibility of the content when header is clicked
            //$('.accordion-content').slideUp();
            // Remove 'active' class from all headers except the clicked one
            $(".accordion-header").not(this).removeClass("active");
            // Close all sections except the current one
            //$(".accordion-content").not($(this).next('.accordion-content')).slideUp();
            $(this).next('.accordion-content').slideToggle();
            // Toggle the 'active' class on the clicked header
            $(this).not().toggleClass("active");
        });
    });

})();

//Content Toggle
$(document).ready(function () {
    // define the card height when it is not expanded
    const cardHeight = 100;

    // get all cards
    const cards = document.querySelectorAll(".zt-testimonial-item");

    // loop through cards
    for (let card of cards) {
        const description = card.querySelector(".zt-testimonial-item .user-review");
        const readMore = card.querySelector(".button");

        // limit description height to s200px
        description.style.maxHeight = `${cardHeight}px`;
        // hide read more button if description is less than card height
        if (description.scrollHeight <= cardHeight) {
            readMore.style.display = "none";
        }

        // function to add span with hellip
        const addSpan = () => {
            let span = document.createElement("span");
            span.innerHTML = "&hellip;";
            // append span after description
            //$('.zt-testimonial-item .user-review p:last').after('<span>Text</span>');
            description.parentNode.insertBefore(span, description.nextSibling);
        };

        // add a span with hellip at the end of the container if the card is not expanded
        if (description.scrollHeight > cardHeight) {
            addSpan();
        }

        // add event listener to read more button to toggle description height
        readMore.addEventListener("click", () => {
            if (description.style.maxHeight === `${cardHeight}px`) {
                $(".zt-testimonial-item").css('height', "auto")
                description.style.maxHeight = `${description.scrollHeight}px`;
                readMore.innerHTML = "Read less<i class='fas fa-angle-double-left'>";
                // remove span with hellip when description is expanded
                description.nextSibling.remove();
            } else {
                description.style.maxHeight = `${cardHeight}px`;
                readMore.innerHTML = "Read more<i class='fas fa-angle-double-right'>";
                // add span with hellip when description is collapsed
                addSpan();
            }
        });
    }
});
