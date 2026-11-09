/**
 * Shop Page JavaScript - Gomie Theme
 * Handles shop page interactions and enhancements
 */

(function ($) {
  "use strict";

  // DOM Ready
  $(document).ready(function () {
    // Smooth scroll for category navigation
    $('.btn-gomie[href^="#"], .link-soft[href^="#"]').on("click", function (e) {
      var target = $(this.getAttribute("href"));
      if (target.length) {
        e.preventDefault();
        $("html, body").animate(
          {
            scrollTop: target.offset().top - 100,
          },
          800,
          "easeInOutQuart"
        );
      }
    });

    // Add to cart functionality enhancement
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
      var $buttonText = $button.find(".button-text");
      var $buttonIcon = $button.find("i");
      var originalText = $buttonText.text();

      // Add loading state
      $button.addClass("loading").prop("disabled", true);
      $buttonText.text("Đang thêm...");
      $buttonIcon.removeClass("fa-plus").addClass("fa-spinner fa-spin");

      // Check WooCommerce availability
      if (typeof wc_add_to_cart_params === "undefined") {
        var productUrl = $button.data("product-url");
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

    // Category section animations on scroll
    function initCategoryAnimations() {
      var $categories = $(".category-section");
      var windowHeight = $(window).height();

      function checkCategoryVisibility() {
        var scrollTop = $(window).scrollTop();

        $categories.each(function () {
          var $category = $(this);
          var elementTop = $category.offset().top;
          var elementBottom = elementTop + $category.outerHeight();
          var viewportTop = scrollTop;
          var viewportBottom = viewportTop + windowHeight;

          if (elementBottom > viewportTop && elementTop < viewportBottom) {
            $category.addClass("in-view");
          }
        });
      }

      $(window).on("scroll resize", checkCategoryVisibility);
      checkCategoryVisibility();
    }

    // Initialize if AOS is not available
    if (typeof AOS === "undefined") {
      initCategoryAnimations();
    }

    // Product card hover enhancements
    $(".gomie-product-card.apple-style")
      .on("mouseenter", function () {
        $(this).addClass("hovered");
      })
      .on("mouseleave", function () {
        $(this).removeClass("hovered");
      });

    // Lazy load images enhancement
    if ("IntersectionObserver" in window) {
      var imageObserver = new IntersectionObserver(function (
        entries,
        observer
      ) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            var img = entry.target;
            img.src = img.dataset.src || img.src;
            img.classList.remove("lazy");
            observer.unobserve(img);
          }
        });
      });

      $(".product-image[data-src]").each(function () {
        imageObserver.observe(this);
      });
    }

    // Search and filter enhancements
    if ($(".woocommerce-ordering select").length) {
      $(".woocommerce-ordering select").on("change", function () {
        var $form = $(this).closest("form");
        if ($form.length === 0) {
          // Create form if not exists
          $form = $('<form method="get"></form>');
          $(this).wrap($form);
        }
        $form.submit();
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

    // Accessibility enhancements
    $(".gomie-product-card").on("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        $(this).find(".product-image-link")[0].click();
      }
    });

    // Performance: Debounce scroll events
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

    // Apply debounce to scroll handlers
    if (typeof AOS === "undefined") {
      $(window)
        .off("scroll.categoryAnimations")
        .on(
          "scroll.categoryAnimations",
          debounce(function () {
            initCategoryAnimations();
          }, 16)
        );
    }
  });
})(jQuery);

// Add CSS for scroll to top button and loading states
jQuery(document).ready(function ($) {
  var additionalCSS = `
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
        
        .category-section {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }
        
        .category-section.in-view {
            opacity: 1;
            transform: translateY(0);
        }
        
        .gomie-product-card.apple-style.hovered {
            transform: translateY(-8px) scale(1.02);
        }
        
        @media (max-width: 768px) {
            .scroll-to-top {
                width: 45px;
                height: 45px;
                bottom: 15px;
                right: 15px;
                font-size: 16px;
            }
        }
        </style>
    `;

  $("head").append(additionalCSS);
});
