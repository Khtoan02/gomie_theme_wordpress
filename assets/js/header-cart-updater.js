/**
 * Header Cart Updater - Gomie Theme
 * Ensures immediate and accurate cart count updates in header
 */

(function ($) {
  "use strict";

  // Header Cart Updater Object
  window.GomieHeaderCartUpdater = {
    // Configuration
    config: {
      headerCartSelector: "#cart-header-btn .cart-count",
      mobileCartSelector: ".offcanvas-body .btn-primary .badge",
      animationDuration: 800,
      updateDelay: 100, // Small delay to ensure WC processes the request
    },

    // Initialize updater
    init: function () {
      this.bindEvents();
      console.log("Gomie Header Cart Updater initialized");
    },

    // Bind events
    bindEvents: function () {
      var self = this;

      // Listen for successful add to cart
      $("body").on(
        "added_to_cart",
        function (event, fragments, cart_hash, button) {
          setTimeout(function () {
            self.updateCartCount(fragments, cart_hash);
          }, self.config.updateDelay);
        }
      );

      // Listen for cart fragments refresh
      $("body").on("wc_fragments_refreshed", function () {
        self.refreshCartDisplay();
      });

      // Listen for manual cart updates
      $(document).on("cart_updated", function () {
        self.forceUpdateCartCount();
      });
    },

    // Update cart count with fragments
    updateCartCount: function (fragments, cart_hash) {
      var self = this;
      var updated = false;

      // First try to use provided fragments
      if (fragments) {
        $.each(fragments, function (selector, html) {
          if (selector.includes("cart-count") || selector.includes(".badge")) {
            try {
              var $target = $(selector);
              if ($target.length) {
                $target.replaceWith(html);
                self.animateCartCount(selector);
                updated = true;
              }
            } catch (e) {
              console.warn("Fragment update failed for:", selector, e);
            }
          }
        });
      }

      // If fragments didn't work, force refresh
      if (!updated) {
        this.forceUpdateCartCount();
      }

      // Update cart hash if provided
      if (cart_hash) {
        localStorage.setItem("wc_cart_hash", cart_hash);
      }
    },

    // Force update cart count via AJAX
    forceUpdateCartCount: function () {
      var self = this;

      if (typeof wc_add_to_cart_params === "undefined") {
        console.warn("WooCommerce parameters not available for cart update");
        return;
      }

      $.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        dataType: "json",
        data: {
          action: "woocommerce_get_refreshed_fragments",
          security: wc_add_to_cart_params.wc_ajax_nonce || "",
        },
        success: function (response) {
          if (response && response.fragments) {
            // Update each fragment
            $.each(response.fragments, function (selector, html) {
              try {
                var $target = $(selector);
                if ($target.length) {
                  $target.replaceWith(html);

                  // Animate specific cart count elements
                  if (
                    selector.includes("cart-count") ||
                    selector.includes(".badge")
                  ) {
                    self.animateCartCount(selector);
                  }
                }
              } catch (e) {
                console.warn("Fragment update failed for:", selector, e);
              }
            });

            console.log("Cart count force updated successfully");
          }
        },
        error: function (xhr, status, error) {
          console.warn("Force cart count update failed:", status, error);

          // Last resort: try to get count from WooCommerce directly
          self.getCartCountDirect();
        },
      });
    },

    // Get cart count directly from WooCommerce
    getCartCountDirect: function () {
      var self = this;

      $.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        dataType: "json",
        data: {
          action: "get_cart_count",
          security: wc_add_to_cart_params.wc_ajax_nonce || "",
        },
        success: function (response) {
          if (response.success && typeof response.data.count !== "undefined") {
            var count = parseInt(response.data.count) || 0;

            // Update header cart count
            var $headerCart = $(self.config.headerCartSelector);
            if ($headerCart.length) {
              $headerCart.text(count);
              self.animateCartCount(self.config.headerCartSelector);
            }

            // Update mobile cart count
            var $mobileCart = $(self.config.mobileCartSelector);
            if ($mobileCart.length) {
              $mobileCart.text(count);
              self.animateCartCount(self.config.mobileCartSelector);
            }

            console.log("Cart count updated directly:", count);
          }
        },
        error: function (xhr, status, error) {
          console.warn("Direct cart count fetch failed:", status, error);
        },
      });
    },

    // Animate cart count update
    animateCartCount: function (selector) {
      var $element = $(selector);
      if (!$element.length) return;

      // Add updated class for animation
      $element.addClass("updated");

      // Remove animation class after duration
      setTimeout(function () {
        $element.removeClass("updated");
      }, this.config.animationDuration);
    },

    // Refresh entire cart display
    refreshCartDisplay: function () {
      this.forceUpdateCartCount();
    },

    // Get current cart count from DOM
    getCurrentCartCount: function () {
      var $headerCart = $(this.config.headerCartSelector);
      return $headerCart.length ? parseInt($headerCart.text()) || 0 : 0;
    },

    // Check if cart is empty
    isCartEmpty: function () {
      return this.getCurrentCartCount() === 0;
    },
  };

  // Initialize when document is ready
  $(document).ready(function () {
    // Wait for other scripts to load
    setTimeout(function () {
      window.GomieHeaderCartUpdater.init();
    }, 300);
  });

  // Also initialize on window load as fallback
  $(window).on("load", function () {
    if (!window.GomieHeaderCartUpdater.initialized) {
      window.GomieHeaderCartUpdater.init();
      window.GomieHeaderCartUpdater.initialized = true;
    }
  });
})(jQuery);
