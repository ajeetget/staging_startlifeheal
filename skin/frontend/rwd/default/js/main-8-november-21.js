// JQuery-PrototypeJS Conflict
if ('NodeList' in window) {
    if (!NodeList.prototype.each && NodeList.prototype.forEach) {
        NodeList.prototype.each = NodeList.prototype.forEach;
    }
}

//  AOS Animation
var isIE = /*@cc_on!@*/ false || !!document.documentMode;
AOS.init({
    disable: isIE,
});

window.addEventListener('load', function() {
  AOS.refresh();
});

//JQuery Code Start
jQuery(function ($) {
    

    $(document).ready(function() {
      
        // Account Items Dropdown
        $(document).click(function(){
            $(".account-items-dropdown").removeClass( "account-items-dropdown-active" );
        });

        $(".account-items-user").click(function(e) {
            e.stopPropagation();
            $(".account-items-dropdown").toggleClass( "account-items-dropdown-active" );
        });
        
        $(".account-items-dropdown").click(function(e) {
            e.stopPropagation();
        });
        
        // Mobile Menu Toogle
        $(".mobile-menu").click(function() {
            $(".menu").toggleClass("menu-show");
            $(".mobile-menu").toggleClass("change");
        });
        
        
        
         //Search Suggestion
        $(".search-form").click(function(){
            $('.search-suggestion').toggle();
        });
    // $(".search-form").focusout(function(){
         // $('.search-suggestion').hide();
      //  });
		
        
        // Home Carousel
        var home_carousel = $('.home-carousel-container');
        home_carousel.owlCarousel({
            loop: true,
            items: 1,
            margin: 0,
            autoplay: false,
            dots: false,
            mouseDrag: false,
            smartSpeed: 1000,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut',
            nav: true,
            navText: ["<span>&#10094;</span>", "<span>&#10095;</span>"],
        })
        
       // Toggle Video Modal
        function toggle_video_modal() {
            $(".js-trigger-video-modal").on("click", function(e) {
                e.preventDefault();
                var id = $(this).attr('data-youtube-id');
                var autoplay = '?autoplay=1';
                var related_no = '&rel=0';
                var src = '//www.youtube.com/embed/' + id + autoplay + related_no;
                $("#youtube").attr('src', src);
                $("body").addClass("show-video-modal noscroll");
            });
            function close_video_modal() {
                event.preventDefault();
                $("body").removeClass("show-video-modal noscroll");
                $("#youtube").attr('src', '');
            }
            $('body').on('click', '.close-video-modal, .video-modal .overlay', function(event) {
                close_video_modal();
            });
            $('body').keyup(function(e) {
                if (e.keyCode == 27) {
                    close_video_modal();
                }
            });
        }
        toggle_video_modal();
        
        //Stats Counter Home
        $("span.home-stats-counter").counterUp({
            delay: 10,
            time: 1000,
            offset: 100,
        });
        
        //Stats Counter 
        $("span.stats-counter").counterUp({
            delay: 10,
            time: 1000,
            offset: 100,
        });
        
        //Accordion
        $(".accordion-header").on("click", function() {
            if ($(this).hasClass("active")) {
              $(this).removeClass("active");
              $(this)
                .siblings(".accordion-content")
                .slideUp(200);
              $(".accordion-header i")
                .removeClass("fa-chevron-up")
                .addClass("fa-chevron-down");
            } else {
              $(".accordion-header i")
                .removeClass("fa-chevron-up")
                .addClass("fa-chevron-down");
              $(this)
                .find("i")
                .removeClass("fa-chevron-down")
                .addClass("fa-chevron-up");
              $(".accordion-header").removeClass("active");
              $(this).addClass("active");
              $(".accordion-content").slideUp(200);
              $(this)
                .siblings(".accordion-content")
                .slideDown(200);
            }
        });
        
        //Food Subscriptio Tab
        $(function () {

          var activeIndex = $('.food-subscription-tab .active-tab').index(),
              $contentlis = $('.food-subscription-tab .tabs-content li'),
              $tabslis = $('.food-subscription-tab .tabs li');
          
          // Show content of active tab on load
          $contentlis.eq(activeIndex).addClass('active-content');
        
          $('.food-subscription-tab .tabs').on('click', 'li', function (e) {
            var $current = $(e.currentTarget),
                index = $current.index();
            
            $tabslis.removeClass('active-tab');
            $current.addClass('active-tab');
            $contentlis.removeClass('active-content').eq(index).addClass('active-content');
        	 });
        });
        
        //Menu Highlights Tab
        $(function () {

          var activeIndex = $('.menu-highlights-tab .active-tab').index(),
              $contentlis = $('.menu-highlights-tab .tabs-content li'),
              $tabslis = $('.menu-highlights-tab .tabs li');
          
          // Show content of active tab on load
          $contentlis.eq(activeIndex).addClass('active-content');
        
          $('.menu-highlights-tab .tabs').on('click', 'li', function (e) {
            var $current = $(e.currentTarget),
                index = $current.index();
            
            $tabslis.removeClass('active-tab');
            $current.addClass('active-tab');
            $contentlis.removeClass('active-content').eq(index).addClass('active-content');
        	 });
        });
        
        
        // Kitchen Gallery Carousel
        var image_gallery_carousel = $('.image-gallery-carousel-container');
        image_gallery_carousel.owlCarousel({
            loop: true,
            items: 3,
            margin: 15,
            autoplay: false,
            dots: false,
            mouseDrag: false,
            smartSpeed: 1000,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut',
            nav: true,
            navText: ["<span>&#10094;</span>", "<span>&#10095;</span>"],
            responsive: {
    			0: {
    				items: 1,
    				nav: false,
    				dots: true
    			},
    			640: {
    				items: 1,
    				nav: false,
    				dots: true
    			},
    	    	768: {
    	    		items: 2,
    	    		nav: false,
    	    		dots: true
    			},
    			1024: {
    				items: 3,
    				nav: false,
    				dots: true
    			},
    			1025: {
    				items: 3,
    				nav: true
    			}
    		}
        });
        
        //About Tab
        $(function () {

          var activeIndex = $('.about-tab .active-tab').index(),
              $contentlis = $('.about-tab .tabs-content li'),
              $tabslis = $('.about-tab .tabs li');
          
          // Show content of active tab on load
          $contentlis.eq(activeIndex).addClass('active-content');
        
          $('.about-tab .tabs').on('click', 'li', function (e) {
            var $current = $(e.currentTarget),
                index = $current.index();
            
            $tabslis.removeClass('active-tab');
            $current.addClass('active-tab');
            $contentlis.removeClass('active-content').eq(index).addClass('active-content');
        	 });
        });
        
        //Sign In
        $(".switch-to-create-account").click(function() {
            $(".sign-in-create-account-header-background").addClass("switch-to-create-account-header");
            $(".create-account-header").removeClass("sign-in-create-account-header-active");
            $(".sign-in-header").addClass("sign-in-create-account-header-active");
            $(".sign-in-detail").removeClass("sign-in-create-account-detail-active");
            $(".create-account-detail").addClass("sign-in-create-account-detail-active");
        });
        
        $(".switch-to-sign-in").click(function() {
            $(".sign-in-create-account-header-background").removeClass("switch-to-create-account-header");
            $(".sign-in-header").removeClass("sign-in-create-account-header-active");
            $(".create-account-header").addClass("sign-in-create-account-header-active");
            $(".create-account-detail").removeClass("sign-in-create-account-detail-active");
            $(".sign-in-detail").addClass("sign-in-create-account-detail-active");
        });
        
        $(".sign-in-detail-forgot-password").click(function() {
            $(".sign-in-detail-wrapper").hide();
            $(".forgot-password-wrapper").show();
        });
        
        $("#forgot-password").submit(function(event){ 
            event.preventDefault();
			//alert($("#forgot-email").val());
			var email= $("#forgot-email").val();
			var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
           if (email!='' && filter.test(email))
		   {
			   var base_url = window.location.origin;
			   var URL= base_url+"/override/index/sendforgotemail"
			  $.ajax({
						url: URL,
						type: "POST",
						data: { email: email },
						success: function(response)
						 {  
						   // alert(response);  
							
						 }
			});
			
	       }
			$(".forgot-password-wrapper").hide();
            $(".password-sent-wrapper").show(); 
							  
           
        });
        
        $(".forgot-password-cancel").click(function() {
            $(".forgot-password-wrapper").hide();
            $(".sign-in-detail-wrapper").show();
        });
        
        $(".back-to-sign-in").click(function() {
            $(".password-sent-wrapper").hide();
            $(".sign-in-detail-wrapper").show();
        });
        
        $(".sign-in-detail-create-account-mobile").click(function() {
            $(".sign-in-header").removeClass('show');
            $(".sign-in-detail").removeClass('show');
            $(".create-account-header").addClass('show');
            $(".create-account-detail").addClass('show');
            $('html,body').animate({scrollTop:0},0);
        });
        
        $(".create-account-detail-sign-in-mobile").click(function() {
            $(".create-account-header").removeClass('show');
            $(".create-account-detail").removeClass('show');
            $(".sign-in-header").addClass('show');
            $(".sign-in-detail").addClass('show');
            $('html,body').animate({scrollTop:0},0);
        });


        // Promo Code 
        $("#checkout-order-review-detail-promo-form").submit(function(event){
            event.preventDefault();
            $(this).hide();
            $(".checkout-order-review-detail-promo-text").html("WooHoo!! You have saved <strong>Rs. 800</strong><br>by using Promocode <strong>LHNEW</strong>");
        });


        // Why Choose Lifeheal Modal
        $(".download-info-pack-cta").click(function() {
            $(".why-choose-lifeheal-modal").addClass('why-choose-lifeheal-modal-active');
        });
        
        $(".why-choose-lifeheal-modal-close").click(function() {
            $(".why-choose-lifeheal-modal").removeClass('why-choose-lifeheal-modal-active');
        });
        
        
        
        
    });

});

//JQuery Code End


