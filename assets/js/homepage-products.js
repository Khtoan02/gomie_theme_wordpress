/**
 * Homepage Products JavaScript - GOMIE Theme (Optimized)
 * Handles product interactions and animations with better performance
 */

(function ($) {
  "use strict";

  // Cache frequently used elements
  const $window = $(window);
  const $body = $("body");
  const $document = $(document);

  // Performance optimizations
  let ticking = false;
  const animationFrame = window.requestAnimationFrame || window.setTimeout;

  // Initialize when DOM is ready
  $document.ready(function () {
    initHomepageProducts();
  });

  function initHomepageProducts() {
    // Initialize all components
    initProductCardEffects();
    initLazyLoading();
    initSmoothScrolling();
    initProductStatsAnimation();
    initAddToCartEnhancement();
    initCartState();
  }

  function initProductCardEffects() {
    // Use event delegation for better performance
    $document.on("mouseenter", ".gomie-product-card", function () {
      const $overlay = $(this).find(".product-overlay");
      $overlay.addClass("active");
    });

    $document.on("mouseleave", ".gomie-product-card", function () {
      const $overlay = $(this).find(".product-overlay");
      $overlay.removeClass("active");
    });

    $document.on("click", ".gomie-product-card", function (e) {
      if (!$(e.target).closest(".product-actions").length) {
        $(this).addClass("clicked");
        setTimeout(() => {
          $(this).removeClass("clicked");
        }, 150); // Faster animation
      }
    });
  }

  function initLazyLoading() {
    if ("IntersectionObserver" in window) {
      const imageObserver = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              const img = entry.target;
              if (img.dataset.src) {
                img.src = img.dataset.src;
                img.classList.remove("lazy");
              }
              imageObserver.unobserve(img);
            }
          });
        },
        { rootMargin: "50px" }
      );

      document.querySelectorAll('img[loading="lazy"]').forEach((img) => {
        imageObserver.observe(img);
      });
    }
  }

  function initSmoothScrolling() {
    // Optimized smooth scrolling with event delegation
    $document.on("click", 'a[href^="#"]', function (e) {
      const href = this.getAttribute("href");
      if (href === "#") return;

      const target = $(href);
      if (target.length) {
        e.preventDefault();
        $("html, body").animate(
          { scrollTop: target.offset().top - 80 },
          600, // Faster scroll
          "easeInOutCubic"
        );
      }
    });
  }

  function initProductStatsAnimation() {
    const statsObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const $stats = $(entry.target).find(".stat-item");
            $stats.each(function (index) {
              setTimeout(() => {
                $(this).addClass("animate-in");
              }, index * 50); // Faster animation
            });
            statsObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.3 }
    );

    document.querySelectorAll(".gomie-product-card").forEach((card) => {
      statsObserver.observe(card);
    });
  }

  // Utility functions for button state management
  function setButtonState($button, className, text, iconClass) {
    const $buttonText = $button.find(".button-text");
    const $buttonIcon = $button.find("i");

    $button
      .removeClass("loading success error added_to_cart")
      .addClass(className)
      .prop("disabled", className === "loading");

    $buttonText.text(text);
    $buttonIcon.attr("class", iconClass);
  }

  function setViewCartState($button) {
    const $buttonText = $button.find(".button-text");
    const $buttonIcon = $button.find("i");

    $button
      .removeClass("loading success error added_to_cart")
      .addClass("wc-forward")
      .prop("disabled", false);

    $buttonText.text("Xem giỏ hàng");
    $buttonIcon.attr("class", "fa-solid fa-shopping-cart");
  }

  function resetButton($button, originalText, originalIcon) {
    const $buttonText = $button.find(".button-text");
    const $buttonIcon = $button.find("i");

    $button
      .removeClass("loading success error added_to_cart wc-forward")
      .prop("disabled", false);

    $buttonText.text(originalText);
    $buttonIcon.attr("class", originalIcon);
  }

  function updateCartFragments(fragments) {
    // Optimized fragment updates
    if (!fragments) return;

    // Use DocumentFragment for better performance
    const $temp = $("<div>");

    $.each(fragments, function (key, value) {
      try {
        const $existing = $(key);
        if ($existing.length) {
          $temp.html(value);
          $existing.replaceWith($temp.children());
        }
      } catch (e) {
        console.warn("Fragment update failed for:", key, e);
      }
    });
  }

  function initAddToCartEnhancement() {
    // Add to cart handling - chỉ áp dụng cho nút button mua hàng trực tiếp có data-product-id
    $document.on("click", "button.btn-add-to-cart-apple[data-product-id]", function (e) {
      const $button = $(this);

      e.preventDefault();
      e.stopPropagation();

      // Handle view cart state
      if ($button.hasClass("wc-forward")) {
        const cartUrl =
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

      const productId = $button.data("product-id");
      const productUrl = $button.data("product-url");
      const originalText = $button.find(".button-text").text();
      const originalIcon = $button.find("i").attr("class");

      // Check WooCommerce availability
      if (typeof wc_add_to_cart_params === "undefined") {
        window.location.href = productUrl;
        return false;
      }

      // Set loading state immediately
      setButtonState(
        $button,
        "loading",
        "Đang thêm...",
        "fa-solid fa-spinner fa-spin"
      );

      // Optimized AJAX request
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
            setButtonState(
              $button,
              "error",
              "Thử lại",
              "fa-solid fa-exclamation-triangle"
            );
            setTimeout(
              () => resetButton($button, originalText, originalIcon),
              2500
            );
            return;
          }

          // Success handling
          setButtonState(
            $button,
            "success added_to_cart",
            "Đã thêm!",
            "fa-solid fa-check"
          );

          // Update cart fragments efficiently
          if (response.fragments) {
            updateCartFragments(response.fragments);
          }

          // Trigger WooCommerce event
          $body.trigger("added_to_cart", [
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

          // Convert to view cart button after 1.2 seconds
          setTimeout(() => {
            setViewCartState($button);
          }, 1200);
        },
        error: function (xhr, status, error) {
          console.error("Add to cart failed:", status, error);
          setButtonState($button, "error", "Lỗi kết nối", "fa-solid fa-wifi");
          setTimeout(
            () => resetButton($button, originalText, originalIcon),
            2500
          );
        },
      });
    });

    // Enhanced legacy add to cart buttons (if any)
    $document.on(
      "click",
      ".gomie-product-card .add_to_cart_button",
      function (e) {
        const $button = $(this);
        const originalText = $button.text();

        $button
          .prop("disabled", true)
          .html('<i class="fa-solid fa-spinner fa-spin"></i> Đang thêm...');

        setTimeout(() => {
          $button
            .prop("disabled", false)
            .html('<i class="fa-solid fa-check"></i> Đã thêm!')
            .addClass("added");

          setTimeout(() => {
            $button.html(originalText).removeClass("added");
          }, 2000);
        }, 800);
      }
    );
  }

  function initCartState() {
    // Check existing cart state (placeholder for future implementation)
    $(".btn-add-to-cart-apple").each(function () {
      const $button = $(this);
      const productId = $button.data("product-id");

      if (isProductInCart(productId)) {
        setViewCartState($button);
      }
    });
  }

  function isProductInCart(productId) {
    // Placeholder - implement actual cart checking logic
    // Could check localStorage, sessionStorage, or make AJAX call
    return false;
  }

  // WooCommerce event handlers
  $body.on("added_to_cart", function (event, fragments, cart_hash, $button) {
    if ($button && $button.hasClass("btn-add-to-cart-apple")) {
      console.log("Product successfully added to cart");
    }
  });

  $body.on("wc_fragments_refreshed", function () {
    // Refresh button states when cart is updated
    initCartState();
  });

  // Optimized scroll handling
  function updateOnScroll() {
    if (!ticking) {
      animationFrame(function () {
        // Handle scroll-based animations here if needed
        ticking = false;
      });
      ticking = true;
    }
  }

  $window.on("scroll", updateOnScroll);

  // Custom easing function
  $.easing.easeInOutCubic = function (x, t, b, c, d) {
    if ((t /= d / 2) < 1) return (c / 2) * t * t * t + b;
    return (c / 2) * ((t -= 2) * t * t + 2) + b;
  };

  // Debounce utility
  function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction() {
      const context = this;
      const args = arguments;
      const later = function () {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };
      const callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    };
  }

  // Export optimized functions
  window.GomieHomepage = {
    init: initHomepageProducts,
    setButtonState: setButtonState,
    setViewCartState: setViewCartState,
    resetButton: resetButton,
    updateCartFragments: updateCartFragments,
  };
})(jQuery);
