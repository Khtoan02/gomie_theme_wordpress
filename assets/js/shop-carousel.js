/**
 * Shop Carousel JavaScript - Gomie Theme
 * Handles product carousels and enhanced UX interactions
 */

(function ($) {
  "use strict";

  // DOM Ready
  $(document).ready(function () {
    // Initialize Swiper Carousels for Categories
    function initCategoryCarousels() {
      console.log("Looking for carousels...");

      // Find all category swipers
      $(".category-products-carousel .swiper").each(function () {
        var $swiper = $(this);
        var slideCount = $swiper.find(".swiper-slide").length;

        console.log("Found carousel with", slideCount, "slides");

        // Only initialize if we have slides
        if (slideCount === 0) {
          console.log("No slides found, skipping carousel");
          return;
        }

        var categorySlug = $swiper
          .attr("class")
          .match(/category-swiper-([a-z-]+)/);

        if (categorySlug && categorySlug[1]) {
          var slug = categorySlug[1];

          console.log("Initializing Swiper for category:", slug);

          var swiperConfig = {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: slideCount > 4, // Only loop if we have enough slides
            autoplay:
              slideCount > 1
                ? {
                    delay: 5000,
                    disableOnInteraction: false,
                  }
                : false,
            pagination: {
              el: ".category-pagination-" + slug,
              clickable: true,
            },
            navigation: {
              nextEl: ".category-next-" + slug,
              prevEl: ".category-prev-" + slug,
            },
            breakpoints: {
              640: {
                slidesPerView: Math.min(2, slideCount),
                spaceBetween: 20,
              },
              768: {
                slidesPerView: Math.min(3, slideCount),
                spaceBetween: 20,
              },
              1024: {
                slidesPerView: Math.min(4, slideCount),
                spaceBetween: 20,
              },
            },
            on: {
              init: function () {
                console.log(
                  "Swiper successfully initialized for category:",
                  slug
                );
                console.log("Slides count:", slideCount);
              },
              slideChange: function () {
                console.log("Slide changed for category:", slug);
              },
            },
          };

          try {
            var swiper = new Swiper($swiper[0], swiperConfig);
            console.log("Swiper instance created:", swiper);
          } catch (error) {
            console.error("Error initializing Swiper:", error);
            // Fallback: Show as regular grid
            $swiper.addClass("swiper-fallback");
          }
        }
      });
    }

    // Wait for all scripts to load, then initialize carousels
    setTimeout(function () {
      if (typeof Swiper !== "undefined") {
        console.log("Swiper is available, initializing carousels...");
        initCategoryCarousels();
      } else {
        console.log("Swiper not available, waiting...");
        // Fallback: Wait for Swiper to load
        var checkSwiper = setInterval(function () {
          if (typeof Swiper !== "undefined") {
            console.log("Swiper loaded, initializing carousels...");
            clearInterval(checkSwiper);
            initCategoryCarousels();
          }
        }, 100);
      }
    }, 500); // Give time for all scripts to load

    // Smooth scroll for category navigation
    $('.btn-gomie[href^="#"], .link-soft[href^="#"]').on("click", function (e) {
      var target = $(this.getAttribute("href"));
      if (target.length) {
        e.preventDefault();
        $("html, body").animate(
          {
            scrollTop: target.offset().top - 100,
          },
          800
        );
      }
    });

    // Enhanced add to cart for carousel products
    $(document).on("click", ".btn-add-to-cart-apple", function (e) {
      e.preventDefault();
      e.stopPropagation();

      var $button = $(this);

      // Handle view cart state
      if ($button.hasClass("wc-forward")) {
        var cartUrl =
          typeof wc_add_to_cart_params !== "undefined" &&
          wc_add_to_cart_params.cart_url
            ? wc_add_to_cart_params.cart_url
            : "/gio-hang";
        window.location.href = cartUrl;
        return false;
      }

      // Prevent double clicks
      if ($button.hasClass("loading") || $button.prop("disabled")) {
        return false;
      }

      var productId = $button.data("product-id");
      var productUrl = $button.data("product-url");
      var $buttonText = $button.find(".button-text");
      var $buttonIcon = $button.find("i");
      var originalText = $buttonText.text();

      // Add loading state
      $button.addClass("loading").prop("disabled", true);
      $buttonText.text("Đang thêm...");
      $buttonIcon.removeClass("fa-plus").addClass("fa-spinner fa-spin");

      // Check WooCommerce availability
      if (typeof wc_add_to_cart_params === "undefined") {
        if (productUrl) {
          window.location.href = productUrl;
        }
        return false;
      }

      // AJAX add to cart
      $.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        dataType: "json",
        cache: false,
        timeout: 8000,
        data: {
          action: "woocommerce_add_to_cart",
          product_id: productId,
          quantity: 1,
          security: wc_add_to_cart_params.wc_ajax_nonce,
        },
        success: function (response) {
          if (response.error && response.product_url) {
            window.location.href = response.product_url;
            return;
          }

          if (response.error) {
            // Error state
            $button.removeClass("loading").addClass("error");
            $buttonText.text("Thử lại");
            $buttonIcon
              .removeClass("fa-spinner fa-spin")
              .addClass("fa-exclamation-triangle");
            setTimeout(function () {
              $button.removeClass("error").prop("disabled", false);
              $buttonText.text(originalText);
              $buttonIcon
                .removeClass("fa-exclamation-triangle")
                .addClass("fa-plus");
            }, 2500);
            return;
          }

          // Success state
          $button.removeClass("loading").addClass("success");
          $buttonText.text("Đã thêm!");
          $buttonIcon.removeClass("fa-spinner fa-spin").addClass("fa-check");

          // Update cart fragments efficiently
          if (response.fragments) {
            var $temp = $("<div>");
            $.each(response.fragments, function (key, value) {
              try {
                var $existing = $(key);
                if ($existing.length) {
                  $temp.html(value);
                  $existing.replaceWith($temp.children());
                }
              } catch (e) {
                console.warn("Fragment update failed for:", key, e);
              }
            });
          }

          // Trigger WooCommerce events
          $("body").trigger("added_to_cart", [
            response.fragments,
            response.cart_hash,
            $button,
          ]);

          // Force update header cart count
          if (
            window.GomieHeaderCartUpdater &&
            window.GomieHeaderCartUpdater.forceUpdateCartCount
          ) {
            setTimeout(function () {
              window.GomieHeaderCartUpdater.forceUpdateCartCount();
            }, 100);
          }

          // Update cart state immediately for this product
          if (window.GomieCartStateSync) {
            window.GomieCartStateSync.setProductCartState(productId, true);
          }

          // Show success animation
          $button.addClass("added_to_cart");

          // Convert to view cart button after 1.2 seconds
          setTimeout(function () {
            $button
              .removeClass("success added_to_cart")
              .addClass("wc-forward")
              .prop("disabled", false);
            $buttonText.text("Xem giỏ hàng");
            $buttonIcon.removeClass("fa-check").addClass("fa-shopping-cart");
          }, 1200);
        },
        error: function (xhr, status, error) {
          console.error("Add to cart failed:", status, error);
          // Error state
          $button.removeClass("loading").addClass("error");
          $buttonText.text("Lỗi kết nối");
          $buttonIcon.removeClass("fa-spinner fa-spin").addClass("fa-wifi");

          // Reset button after delay
          setTimeout(function () {
            $button.removeClass("error").prop("disabled", false);
            $buttonText.text(originalText);
            $buttonIcon.removeClass("fa-wifi").addClass("fa-plus");
          }, 2500);
        },
      });
    });

    // Carousel navigation enhancements
    $(".category-products-carousel")
      .on("mouseenter", function () {
        $(this)
          .find(".swiper-button-next, .swiper-button-prev")
          .addClass("visible");
      })
      .on("mouseleave", function () {
        $(this)
          .find(".swiper-button-next, .swiper-button-prev")
          .removeClass("visible");
      });

    // Lazy loading for carousel images
    if ("IntersectionObserver" in window) {
      var imageObserver = new IntersectionObserver(function (
        entries,
        observer
      ) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            var img = entry.target;
            if (img.dataset.src) {
              img.src = img.dataset.src;
              img.classList.remove("lazy");
              observer.unobserve(img);
            }
          }
        });
      });

      $(".swiper-slide .product-image[data-src]").each(function () {
        imageObserver.observe(this);
      });
    }

    // Scroll to top button
    var $scrollTop = $(
      '<button class="scroll-to-top" aria-label="Lên đầu trang"><i class="fas fa-chevron-up"></i></button>'
    );
    $("body").append($scrollTop);

    $(window).scroll(function () {
      if ($(this).scrollTop() > 500) {
        $scrollTop.addClass("visible");
      } else {
        $scrollTop.removeClass("visible");
      }
    });

    $scrollTop.on("click", function () {
      $("html, body").animate({ scrollTop: 0 }, 600);
    });

    // Accessibility enhancements for carousel
    $(".swiper-slide").on("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        $(this).find(".product-image-link")[0].click();
      }
    });

    // Performance optimization
    function debounce(func, wait) {
      var timeout;
      return function executedFunction() {
        var later = function () {
          clearTimeout(timeout);
          func();
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    }

    // Optimize scroll events
    $(window).on(
      "scroll",
      debounce(function () {
        // Scroll optimizations can go here
      }, 16)
    );
  });
})(jQuery);

// Add additional CSS for carousel enhancements
jQuery(document).ready(function ($) {
  var carouselCSS = `
    <style>
    .scroll-to-top {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: var(--gradient-button);
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
      opacity: 0;
      visibility: hidden;
      transform: translateY(20px);
      transition: all 0.3s ease;
      z-index: 1000;
      box-shadow: var(--shadow-medium);
    }
    
    .scroll-to-top.visible {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    
    .scroll-to-top:hover {
      background: var(--gradient-button-hover);
      transform: translateY(-2px);
      box-shadow: var(--shadow-heavy);
    }
    
    .category-products-carousel .swiper-button-next,
    .category-products-carousel .swiper-button-prev {
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .category-products-carousel:hover .swiper-button-next,
    .category-products-carousel:hover .swiper-button-prev {
      opacity: 1;
    }
    
    .category-products-carousel .swiper-button-next.visible,
    .category-products-carousel .swiper-button-prev.visible {
      opacity: 1;
    }
    
    @media (max-width: 768px) {
      .scroll-to-top {
        width: 45px;
        height: 45px;
        bottom: 15px;
        right: 15px;
        font-size: 16px;
      }
      
      .category-products-carousel .swiper-button-next,
      .category-products-carousel .swiper-button-prev {
        opacity: 1; /* Always visible on mobile */
      }
    }
    </style>
  `;

  $("head").append(carouselCSS);
});
