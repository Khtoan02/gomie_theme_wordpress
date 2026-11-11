/**
 * Gomie Vietnam Theme - Main JavaScript
 */

(function ($) {
  "use strict";

  // Document ready
  $(document).ready(function () {
    // Initialize all modules
    initHeaderScroll();
    initMobileMenu();
    initSearchToggle();
    initDropdownMenu();
    initNavActiveHighlight();
    initSmoothScroll();
    initBackToTop();
    initAnimations();
    initCounters();
    initHeroCounters();
    initProductFilter();
    initProductsTabs();
    initProductsCarousel();
    initPopups();
    initForms();
  });

  // Header scroll effect
  function initHeaderScroll() {
    var header = $(".site-header");
    var scrollThreshold = 100;

    $(window).on("scroll", function () {
      if ($(this).scrollTop() > scrollThreshold) {
        header.addClass("scrolled");
      } else {
        header.removeClass("scrolled");
      }
    });
  }

  // Mobile menu
  function initMobileMenu() {
    var toggle = $(".mobile-menu-toggle");
    var close = $(".mobile-menu-close");
    var overlay = $(".mobile-menu-overlay");
    var body = $("body");

    toggle.on("click", function () {
      body.toggleClass("mobile-menu-active");
    });

    close.on("click", function () {
      body.removeClass("mobile-menu-active");
    });

    overlay.on("click", function () {
      body.removeClass("mobile-menu-active");
    });

    // Close menu on escape key
    $(document).on("keydown", function (e) {
      if (e.keyCode === 27 && body.hasClass("mobile-menu-active")) {
        body.removeClass("mobile-menu-active");
      }
    });
  }

  // Search toggle
  function initSearchToggle() {
    var toggle = $(".search-toggle");
    var searchDropdown = $(".header-search");
    var searchClose = $(".search-close");

    toggle.on("click", function () {
      searchDropdown.toggleClass("active");
      if (searchDropdown.hasClass("active")) {
        searchDropdown.find(".search-field").focus();
      }
    });

    searchClose.on("click", function () {
      searchDropdown.removeClass("active");
    });

    // Close on click outside
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".search-toggle, .header-search").length) {
        searchDropdown.removeClass("active");
      }
    });

    // Close on escape key
    $(document).on("keydown", function (e) {
      if (e.keyCode === 27 && searchDropdown.hasClass("active")) {
        searchDropdown.removeClass("active");
      }
    });
  }

  // Dropdown menu
  function initDropdownMenu() {
    var dropdownItems = $(".has-dropdown");
    var dropdownMenus = $(".dropdown-menu");

    // Show dropdown on hover for desktop
    dropdownItems.on("mouseenter", function () {
      if ($(window).width() > 1024) {
        $(this).find(".dropdown-menu").addClass("show");
      }
    });

    dropdownItems.on("mouseleave", function () {
      if ($(window).width() > 1024) {
        $(this).find(".dropdown-menu").removeClass("show");
      }
    });

    // Toggle dropdown on click for mobile
    dropdownItems.find("a").on("click", function (e) {
      if ($(window).width() <= 1024) {
        var parentItem = $(this).closest(".has-dropdown");
        var dropdownMenu = parentItem.find(".dropdown-menu");

        if (dropdownMenu.length && $(this).attr("href") === "#") {
          e.preventDefault();
          dropdownMenu.slideToggle();
          parentItem.toggleClass("active");
        }
      }
    });

    // Close dropdowns when clicking outside
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".has-dropdown").length) {
        dropdownMenus.removeClass("show");
        dropdownItems.removeClass("active");
        if ($(window).width() <= 1024) {
          dropdownMenus.slideUp();
        }
      }
    });
  }

  // Active Navigation State Highlighter
  function initNavActiveHighlight() {
    var currentPath = window.location.pathname.replace(/\/$/, '') || '/';
    var navItems = $('.gomie-nav-menu > li.nav-item, #primary-menu > li');

    navItems.each(function() {
      var item = $(this);
      var link = item.find('> a');
      var href = link.attr('href') || '';
      var linkPath = '';

      try {
        linkPath = new URL(href, window.location.origin).pathname.replace(/\/$/, '') || '/';
      } catch(e) {
        linkPath = href.replace(/\/$/, '') || '/';
      }

      var text = link.text().toLowerCase().trim();
      var isMatch = false;

      if (linkPath === currentPath && currentPath !== '' && currentPath !== '/') {
        isMatch = true;
      }

      // Check sub links in dropdown
      item.find('.dropdown-link, ul a').each(function() {
        var subHref = $(this).attr('href') || '';
        var subPath = '';
        try {
          subPath = new URL(subHref, window.location.origin).pathname.replace(/\/$/, '') || '/';
        } catch(e) {
          subPath = subHref.replace(/\/$/, '') || '/';
        }
        if (subPath === currentPath && currentPath !== '' && currentPath !== '/') {
          isMatch = true;
          $(this).addClass('active');
        }
      });

      // Contextual fallback:
      if (!isMatch) {
        // Chia sẻ
        if (text.indexOf('chia sẻ') !== -1 || text.indexOf('chia se') !== -1) {
          if (currentPath === '/chia-se' || currentPath.indexOf('/chia-se/') === 0 || $('body').hasClass('single-post') || $('body').hasClass('blog')) {
            isMatch = true;
          }
        }
        // Sản phẩm
        if (text === 'sản phẩm' || text === 'san pham') {
          if (currentPath === '/san-pham' || currentPath.indexOf('/san-pham/') === 0 || $('body').hasClass('woocommerce') || $('body').hasClass('post-type-archive-product')) {
            isMatch = true;
          }
        }
        // Câu chuyện / Về chúng tôi
        if (text.indexOf('câu chuyện') !== -1 || text.indexOf('cau chuyen') !== -1 || text.indexOf('về chúng tôi') !== -1 || text.indexOf('ve chung toi') !== -1) {
          var aboutList = ['/cau-chuyen', '/chung-nhan', '/nha-hang', '/khach-san', '/qua-tang', '/ve-chung-toi'];
          if (aboutList.indexOf(currentPath) !== -1) {
            isMatch = true;
          }
        }
        // Loại sản phẩm
        if (text.indexOf('loại sản phẩm') !== -1 || text.indexOf('loai san pham') !== -1) {
          if (currentPath === '/loai-san-pham' || $('body').hasClass('tax-product_cat')) {
            isMatch = true;
          }
        }
        // Màu men
        if (text.indexOf('màu men') !== -1 || text.indexOf('mau men') !== -1) {
          if (currentPath === '/mau-men') {
            isMatch = true;
          }
        }
        // Liên hệ
        if (text.indexOf('liên hệ') !== -1 || text.indexOf('lien he') !== -1) {
          if (currentPath === '/contact' || currentPath === '/lien-he') {
            isMatch = true;
          }
        }
      }

      if (isMatch) {
        item.addClass('current-menu-item active');
        link.addClass('active');
      }
    });
  }

  // Smooth scroll
  function initSmoothScroll() {
    $('a[href^="#"]').on("click", function (e) {
      var target = $(this.getAttribute("href"));
      if (target.length) {
        e.preventDefault();
        $("html, body").animate(
          {
            scrollTop: target.offset().top - 100,
          },
          1000
        );
      }
    });
  }

  // Back to top
  function initBackToTop() {
    var button = $(".back-to-top");
    var showThreshold = 300;

    $(window).on("scroll", function () {
      if ($(this).scrollTop() > showThreshold) {
        button.addClass("show");
      } else {
        button.removeClass("show");
      }
    });

    button.on("click", function () {
      $("html, body").animate(
        {
          scrollTop: 0,
        },
        600
      );
    });
  }

  // Scroll animations
  function initAnimations() {
    var animateElements = $(
      ".animate-fadeIn, .animate-slideInLeft, .animate-slideInRight"
    );

    function checkIfInView() {
      var windowHeight = $(window).height();
      var windowTopPosition = $(window).scrollTop();
      var windowBottomPosition = windowTopPosition + windowHeight;

      $.each(animateElements, function () {
        var element = $(this);
        var elementHeight = element.outerHeight();
        var elementTopPosition = element.offset().top;
        var elementBottomPosition = elementTopPosition + elementHeight;

        // Check if element is in viewport
        if (
          elementBottomPosition >= windowTopPosition &&
          elementTopPosition <= windowBottomPosition
        ) {
          element.addClass("in-view");
        }
      });
    }

    $(window).on("scroll resize", checkIfInView);
    $(window).trigger("scroll");
  }

  // Number counters
  function initCounters() {
    var counters = $(".achievement-number");
    var counted = false;

    function startCounting() {
      if (counted) return;

      counters.each(function () {
        var $this = $(this);
        var countTo = $this.attr("data-count");

        $({ countNum: $this.text() }).animate(
          {
            countNum: countTo,
          },
          {
            duration: 2000,
            easing: "linear",
            step: function () {
              $this.text(Math.floor(this.countNum));
            },
            complete: function () {
              $this.text(this.countNum);
            },
          }
        );
      });

      counted = true;
    }

    // Check if counters are in view
    $(window).on("scroll", function () {
      if (counters.length) {
        var counterTop = counters.first().offset().top;
        var windowBottom = $(window).scrollTop() + $(window).height();

        if (windowBottom > counterTop) {
          startCounting();
        }
      }
    });
  }

  // Hero counter animation
  function initHeroCounters() {
    var heroCounters = $(".hero-stats .stat-number");
    var counted = false;

    function startHeroCounting() {
      if (counted) return;

      heroCounters.each(function () {
        var $this = $(this);
        var countTo = parseInt($this.attr("data-count"));
        var duration = 2000;
        var startTime = null;

        function animateCounter(timestamp) {
          if (!startTime) startTime = timestamp;
          var progress = Math.min((timestamp - startTime) / duration, 1);
          var currentCount = Math.floor(progress * countTo);

          $this.text(currentCount + (countTo >= 100 ? "+" : ""));

          if (progress < 1) {
            requestAnimationFrame(animateCounter);
          }
        }

        requestAnimationFrame(animateCounter);
      });

      counted = true;
    }

    // Check if hero counters are in view
    $(window).on("scroll", function () {
      if (heroCounters.length) {
        var heroTop = $(".hero-section").offset().top;
        var windowBottom = $(window).scrollTop() + $(window).height();

        if (windowBottom > heroTop + 200) {
          startHeroCounting();
        }
      }
    });
  }

  // Product filter functionality
  function initProductFilter() {
    var filterBtns = $(".filter-btn");
    var productCards = $(".product-card");
    var productCount = $(".product-count strong");

    filterBtns.on("click", function () {
      var filter = $(this).data("filter");

      // Update active button
      filterBtns.removeClass("active");
      $(this).addClass("active");

      // Filter products
      if (filter === "all") {
        productCards.fadeIn(300);
        productCount.text(productCards.length);
        $(".no-products-message").remove();
      } else {
        productCards.hide();
        var filteredCards = productCards.filter(
          '[data-category="' + filter + '"]'
        );
        filteredCards.fadeIn(300);
        productCount.text(filteredCards.length);

        // Show message if no products found
        if (filteredCards.length === 0) {
          if ($(".no-products-message").length === 0) {
            $(".products-grid").append(
              '<div class="no-products-message"><p>Không có sản phẩm nào trong danh mục này.</p></div>'
            );
          }
        } else {
          $(".no-products-message").remove();
        }
      }
    });

    // Wishlist functionality
    $(".wishlist-btn").on("click", function () {
      var $this = $(this);
      var icon = $this.find("i");

      if (icon.hasClass("far")) {
        icon.removeClass("far").addClass("fas");
        $this.addClass("active");
        showNotification("Đã thêm vào yêu thích", "success");
      } else {
        icon.removeClass("fas").addClass("far");
        $this.removeClass("active");
        showNotification("Đã xóa khỏi yêu thích", "info");
      }
    });

    // Quick view functionality
    $(".quick-view").on("click", function () {
      var productTitle = $(this)
        .closest(".product-card")
        .find(".product-title a")
        .text();
      showNotification("Tính năng xem nhanh đang phát triển", "info");
    });
  }

  // Notification system
  function showNotification(message, type) {
    var notification = $(
      '<div class="notification notification-' +
        type +
        '">' +
        message +
        "</div>"
    );
    $("body").append(notification);

    setTimeout(function () {
      notification.addClass("show");
    }, 100);

    setTimeout(function () {
      notification.removeClass("show");
      setTimeout(function () {
        notification.remove();
      }, 300);
    }, 3000);
  }

  // Popups
  function initPopups() {
    var triggers = $('.popup-trigger, .header-cta[href*="lien-he"]');
    var popup = $("#contact-popup");
    var close = popup.find(".popup-close");

    triggers.on("click", function (e) {
      if ($(this).attr("href") === "#contact-popup") {
        e.preventDefault();
        popup.addClass("active");
        $("body").addClass("popup-open");
      }
    });

    close.on("click", function () {
      popup.removeClass("active");
      $("body").removeClass("popup-open");
    });

    popup.on("click", function (e) {
      if (e.target === this) {
        popup.removeClass("active");
        $("body").removeClass("popup-open");
      }
    });
  }

  // Forms
  function initForms() {
    // Contact form validation (exclude dedicated AJAX quote & contact forms)
    $(".contact-form").not("#contact-popup form, .quote-popup-form, .quote-form").on("submit", function (e) {
      e.preventDefault();

      var form = $(this);
      var submitBtn = form.find('button[type="submit"]');
      var originalText = submitBtn.text();

      // Basic validation
      var isValid = true;
      form.find("input[required], textarea[required]").each(function () {
        if (!$(this).val().trim()) {
          isValid = false;
          $(this).addClass("error");
        } else {
          $(this).removeClass("error");
        }
      });

      if (isValid) {
        submitBtn.text("Đang gửi...").prop("disabled", true);

        // Simulate form submission
        setTimeout(function () {
          showNotification(
            "Cảm ơn bạn! Chúng tôi sẽ liên hệ sớm nhất.",
            "success"
          );
          form[0].reset();
          submitBtn.text(originalText).prop("disabled", false);
        }, 2000);
      } else {
        showNotification("Vui lòng điền đầy đủ thông tin.", "error");
      }
    });
  }

  // Products Tabs
  function initProductsTabs() {
    var tabButtons = $(".tab-btn");
    var productCarousels = $(".products-carousel");

    tabButtons.on("click", function () {
      var targetTab = $(this).data("tab");

      // Remove active class from all tabs and carousels
      tabButtons.removeClass("active");
      productCarousels.removeClass("active");

      // Add active class to clicked tab
      $(this).addClass("active");

      // Show corresponding carousel
      $('.products-carousel[data-tab="' + targetTab + '"]').addClass("active");

      // Reinitialize carousel for the active tab
      initCarouselForTab(targetTab);
    });
  }

  // Products Carousel
  function initProductsCarousel() {
    // Initialize carousel for the default active tab
    var activeTab = $(".tab-btn.active").data("tab");
    if (activeTab) {
      initCarouselForTab(activeTab);
    }
  }

  function initCarouselForTab(tabName) {
    var carousel = $('.products-carousel[data-tab="' + tabName + '"]');
    var track = carousel.find(".carousel-track");
    var prevBtn = carousel.find(".prev-btn");
    var nextBtn = carousel.find(".next-btn");
    var cards = track.find(".product-card");

    if (cards.length === 0) return;

    var cardWidth = cards.first().outerWidth(true);
    var visibleCards = Math.floor(track.width() / cardWidth);
    var currentIndex = 0;
    var maxIndex = Math.max(0, cards.length - visibleCards);

    // Update navigation buttons
    function updateNavButtons() {
      prevBtn.prop("disabled", currentIndex === 0);
      nextBtn.prop("disabled", currentIndex >= maxIndex);
    }

    // Initialize navigation buttons
    updateNavButtons();

    // Previous button click
    prevBtn.off("click").on("click", function () {
      if (currentIndex > 0) {
        currentIndex--;
        track.css(
          "transform",
          "translateX(-" + currentIndex * cardWidth + "px)"
        );
        updateNavButtons();
      }
    });

    // Next button click
    nextBtn.off("click").on("click", function () {
      if (currentIndex < maxIndex) {
        currentIndex++;
        track.css(
          "transform",
          "translateX(-" + currentIndex * cardWidth + "px)"
        );
        updateNavButtons();
      }
    });

    // Touch/swipe support for mobile
    var startX = 0;
    var currentX = 0;
    var isDragging = false;

    track.on("touchstart mousedown", function (e) {
      isDragging = true;
      startX = e.type === "mousedown" ? e.pageX : e.touches[0].pageX;
      currentX = startX;
      track.css("transition", "none");
    });

    track.on("touchmove mousemove", function (e) {
      if (!isDragging) return;

      e.preventDefault();
      currentX = e.type === "mousemove" ? e.pageX : e.touches[0].pageX;
      var diff = currentX - startX;
      track.css("transform", "translateX(" + diff + "px)");
    });

    track.on("touchend mouseup", function (e) {
      if (!isDragging) return;

      isDragging = false;
      track.css("transition", "transform 0.3s ease");

      var diff = currentX - startX;
      var threshold = cardWidth / 3;

      if (Math.abs(diff) > threshold) {
        if (diff > 0 && currentIndex > 0) {
          // Swipe right - go to previous
          currentIndex--;
        } else if (diff < 0 && currentIndex < maxIndex) {
          // Swipe left - go to next
          currentIndex++;
        }
      }

      track.css("transform", "translateX(-" + currentIndex * cardWidth + "px)");
      updateNavButtons();
    });

    // Keyboard navigation
    carousel.on("keydown", function (e) {
      if (e.key === "ArrowLeft" && currentIndex > 0) {
        currentIndex--;
        track.css(
          "transform",
          "translateX(-" + currentIndex * cardWidth + "px)"
        );
        updateNavButtons();
      } else if (e.key === "ArrowRight" && currentIndex < maxIndex) {
        currentIndex++;
        track.css(
          "transform",
          "translateX(-" + currentIndex * cardWidth + "px)"
        );
        updateNavButtons();
      }
    });

    // Auto-play functionality (optional)
    var autoPlayInterval;

    function startAutoPlay() {
      autoPlayInterval = setInterval(function () {
        if (currentIndex < maxIndex) {
          currentIndex++;
        } else {
          currentIndex = 0;
        }
        track.css(
          "transform",
          "translateX(-" + currentIndex * cardWidth + "px)"
        );
        updateNavButtons();
      }, 5000); // Change slide every 5 seconds
    }

    function stopAutoPlay() {
      if (autoPlayInterval) {
        clearInterval(autoPlayInterval);
      }
    }

    // Start auto-play on hover
    carousel.hover(stopAutoPlay, startAutoPlay);

    // Responsive handling
    $(window).on("resize", function () {
      cardWidth = cards.first().outerWidth(true);
      visibleCards = Math.floor(track.width() / cardWidth);
      maxIndex = Math.max(0, cards.length - visibleCards);

      if (currentIndex > maxIndex) {
        currentIndex = maxIndex;
      }

      track.css("transform", "translateX(-" + currentIndex * cardWidth + "px)");
      updateNavButtons();
    });
  }

  // Cart dropdown hover with improved UX
  $(document).ready(function () {
    var cartBtn = $("#cart-header-btn");
    var cartDropdown = $("#cart-dropdown");
    var cartHeaderWrapper = $(".cart-header-wrapper");
    var cartDropdownTimeout;
    var isDropdownHovered = false;

    function loadCartDropdown() {
      cartDropdown.html('<div class="cart-loading">Đang tải...</div>');
      $.ajax({
        url: "/?wc-ajax=get_refreshed_fragments",
        type: "POST",
        success: function (response) {
          if (
            response &&
            response.fragments &&
            response.fragments["div.widget_shopping_cart_content"]
          ) {
            cartDropdown.html(
              response.fragments["div.widget_shopping_cart_content"]
            );
          } else {
            cartDropdown.html(
              '<div class="cart-empty"><i class="fas fa-shopping-cart"></i>Không có sản phẩm trong giỏ hàng.</div>'
            );
          }
        },
        error: function () {
          cartDropdown.html(
            '<div class="cart-empty"><i class="fas fa-exclamation-circle"></i>Không thể tải giỏ hàng.</div>'
          );
        },
      });
    }

    function showCartDropdown() {
      clearTimeout(cartDropdownTimeout);
      cartDropdown.show();
      cartDropdown.css({
        opacity: 1,
        pointerEvents: "auto",
        transform: "translateX(-50%) scale(1)",
      });
      loadCartDropdown();
    }

    function hideCartDropdown() {
      cartDropdownTimeout = setTimeout(function () {
        if (!isDropdownHovered) {
          cartDropdown.hide();
          cartDropdown.css({
            opacity: 0,
            pointerEvents: "none",
            transform: "translateX(-50%) scale(0.98)",
          });
        }
      }, 300); // Increased delay for better UX
    }

    // Show dropdown on hover/focus
    cartHeaderWrapper.on("mouseenter focusin", function () {
      showCartDropdown();
    });

    // Hide dropdown when leaving wrapper (but not if hovering dropdown)
    cartHeaderWrapper.on("mouseleave", function () {
      if (!isDropdownHovered) {
        hideCartDropdown();
      }
    });

    // Handle dropdown hover to keep it visible
    cartDropdown.on("mouseenter", function () {
      isDropdownHovered = true;
      clearTimeout(cartDropdownTimeout);
    });

    cartDropdown.on("mouseleave", function () {
      isDropdownHovered = false;
      hideCartDropdown();
    });

    // Prevent dropdown from hiding on cart button click if going to cart page
    cartBtn.on("click", function (e) {
      // Only hide dropdown if not going to cart page
      if ($(this).attr("href") !== "/gio-hang") {
        cartDropdown.hide();
      }
    });

    // Handle clicks on cart action buttons
    $(document).on("click", ".btn-checkout, .btn-view-cart", function (e) {
      // Allow the click to proceed normally
      cartDropdown.hide();
    });
  });
})(jQuery);
