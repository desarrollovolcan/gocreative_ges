"use strict";

(function ($) {
  "use strict";

  /*--------------------------------------------------------------
  CUSTOM PRE DEFINE FUNCTION
  ------------------------------------------------------------*/
  /* is_exist() */
  jQuery.fn.is_exist = function () {
    return this.length;
  };
  $(function () {
    /*--------------------------------------------------------------
   PRELOADER JS INIT
    --------------------------------------------------------------*/
    $(".lonyo-preloader-wrap").fadeOut(500);

    /*--------------------------------------------------------------
    HEADER SEARCH JS INIT
    ------------------------------------------------------------*/
    $(document).on("click", ".lonyo-header-search, .lonyo-header-search-close, .search-overlay", function () {
      $(".lonyo-header-search-section, .search-overlay").toggleClass("open");
    });

    $('.sub-menu li.menu-item-has-children > a').addClass('no-border');


    /*----------  Mobile Menu Active ----------*/
    $.fn.vsmobilemenu = function (options) {
      var opt = $.extend({
          menuToggleBtn: ".lonyo-menu-toggle",
          bodyToggleClass: "lonyo-body-visible",
          subMenuClass: "lonyo-submenu",
          subMenuParent: "lonyo-item-has-children",
          subMenuParentToggle: "lonyo-active",
          meanExpandClass: "lonyo-mean-expand",
          appendElement: '<span class="lonyo-mean-expand"></span>',
          subMenuToggleClass: "lonyo-open",
          toggleSpeed: 400,
        },
        options
      );
    
      return this.each(function () {
        var menu = $(this); // Select menu
    
        // Menu Show & Hide
        function menuToggle() {
          menu.toggleClass(opt.bodyToggleClass);
    
          // collapse submenu on menu hide or show
          var subMenu = "." + opt.subMenuClass;
          $(subMenu).each(function () {
            if ($(this).hasClass(opt.subMenuToggleClass)) {
              $(this).removeClass(opt.subMenuToggleClass);
              $(this).css("display", "none");
              $(this).parent().removeClass(opt.subMenuParentToggle);
            }
          });
        }
    
        // Class Set Up for every submenu
        menu.find("li").each(function () {
          var submenu = $(this).find("ul");
          submenu.addClass(opt.subMenuClass);
          submenu.css("display", "none");
          submenu.parent().addClass(opt.subMenuParent);
          submenu.prev("a").append(opt.appendElement);
          submenu.next("a").append(opt.appendElement);
        });
    
        // Toggle Submenu
        function toggleDropDown($element) {
          var $submenu = $element.next("ul").length > 0 ? $element.next("ul") : $element.prev("ul");
    
          // Close only sibling submenus
          $element.parent().siblings().find("." + opt.subMenuClass).each(function () {
            if ($(this).hasClass(opt.subMenuToggleClass)) {
              $(this).removeClass(opt.subMenuToggleClass).slideUp(opt.toggleSpeed);
              $(this).parent().removeClass(opt.subMenuParentToggle);
            }
          });
    
          // Toggle the clicked submenu
          $element.parent().toggleClass(opt.subMenuParentToggle);
          $submenu.slideToggle(opt.toggleSpeed).toggleClass(opt.subMenuToggleClass);
        }
    
        // Submenu toggle Button
        var expandToggler = "." + opt.meanExpandClass;
        $(expandToggler).each(function () {
          $(this).on("click", function (e) {
            e.preventDefault();
            toggleDropDown($(this).parent());
          });
        });
    
        // Menu Show & Hide On Toggle Btn click
        $(opt.menuToggleBtn).each(function () {
          $(this).on("click", function () {
            menuToggle();
          });
        });
    
        // Hide Menu On outside click
        menu.on("click", function (e) {
          e.stopPropagation();
          menuToggle();
        });
    
        // Stop Hide full menu on menu click
        menu.find("div").on("click", function (e) {
          e.stopPropagation();
        });
      });
    };
    
    $(".lonyo-menu-wrapper").vsmobilemenu();
    

    /*--------------------------------------------------------------
   STICKY MENU JS INIT
    --------------------------------------------------------------*/
    $(window).on('scroll', function () {
      if ($(window).scrollTop() > 50) {
        $('#sticky-menu').addClass('sticky-menu');
      } else {
        $('#sticky-menu').removeClass('sticky-menu');
      }
    });

    /*===========================================
      =    		 Cart Active  	         =
    =============================================*/
    $(".qty-btn").on("click", function () {
      var $button = $(this);
      var $input = $button.siblings("input");
      var oldValue = parseFloat($input.val()) || 0;
      var newVal;

      if ($button.hasClass("quantity-plus")) {
        newVal = oldValue + 1;
      } else if ($button.hasClass("quantity-minus")) {
        newVal = Math.max(oldValue - 1, 0); // prevent going below 0
      }

      $input.val(newVal);
    });




    /*--------------------------------------------------------------
   MENU SIDEBAR JS INIT
    --------------------------------------------------------------*/
    $(".lonyo-header-barger").on("click", function (e) {
      $(".lonyo-sidemenu-column, .offcanvas-overlay").addClass("active");
      event.preventDefault(e);
    });
    $(".lonyo-sidemenu-close, .offcanvas-overlay").on("click", function () {
      $(".lonyo-sidemenu-column, .offcanvas-overlay").removeClass("active");
    });
    
    // Set offset and duration for scroll-to-top animation
    var offset = 50;
    var duration = 550;

    // Function to handle scroll event and toggle class
    function handleScroll() {
      if ($(window).scrollTop() > offset) {
        $('.progress-wrap').addClass('active-progress');
      } else {
        $('.progress-wrap').removeClass('active-progress');
      }
    }

    // Add scroll event listener to handle class toggling
    $(window).on('scroll', handleScroll);

    // Function to handle click event and animate scroll to top
    function handleClick(event) {
      event.preventDefault();
      $('html, body').animate({ scrollTop: 0 }, duration);
    }

    // Add click event listener to scroll-to-top element
    $('.progress-wrap').on('click', handleClick);

  }); /*End document ready*/

  $(window).on("resize", function () {}); // end window resize

  $(window).on('load', function () {}); // End window LOAD

})(jQuery);