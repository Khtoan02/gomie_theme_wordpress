/**
 * Cart State Manager - Gomie Theme
 * Manages add to cart button states and cart synchronization
 */

(function ($) {
  "use strict";

  // Cart State Manager Object
  window.GomieCartManager = {
    // Configuration
    config: {
      storageKey: "gomie_cart_items",
      buttonSelector: ".btn-add-to-cart-apple",
      updateInterval: 30000, // 30 seconds
    },

    // Initialize cart manager
    init: function () {
      this.bindEvents();
      this.updateButtonStates();
      this.startPeriodicUpdate();
      console.log("Gomie Cart Manager initialized");
    },

    // Bind events
    bindEvents: function () {
      var self = this;

      // Listen for WooCommerce cart updates
      $("body").on(
        "added_to_cart",
        function (event, fragments, cart_hash, button) {
          self.handleCartUpdate(fragments, cart_hash, button);
        }
      );

      $("body").on("removed_from_cart", function (event, fragments, cart_hash) {
        self.handleCartRemoval(fragments, cart_hash);
      });

      // Listen for fragments refresh
      $("body").on("wc_fragments_refreshed", function () {
        self.updateButtonStates();
      });

      // Handle page visibility change
      $(document).on("visibilitychange", function () {
        if (!document.hidden) {
          self.updateButtonStates();
        }
      });
    },

    // Handle cart update
    handleCartUpdate: function (fragments, cart_hash, button) {
      if (button && button.length) {
        var productId = button.data("product-id");
        if (productId) {
          this.setProductInCart(productId, true);
          this.updateButtonState(button, true);
        }
      }

      // Update cart hash
      if (cart_hash) {
        localStorage.setItem("gomie_cart_hash", cart_hash);
      }

      // Force update header cart count with animation
      this.updateHeaderCartCount();

      console.log("Cart updated successfully");
    },

    // Handle cart removal
    handleCartRemoval: function (fragments, cart_hash) {
      // Reset all buttons to add state
      $(this.config.buttonSelector).each(function () {
        var $button = $(this);
        var productId = $button.data("product-id");
        if (productId) {
          window.GomieCartManager.setProductInCart(productId, false);
          window.GomieCartManager.updateButtonState($button, false);
        }
      });

      // Update cart hash
      if (cart_hash) {
        localStorage.setItem("gomie_cart_hash", cart_hash);
      }

      console.log("Cart items removed");
    },

    // Update all button states
    updateButtonStates: function () {
      var self = this;
      $(this.config.buttonSelector).each(function () {
        var $button = $(this);
        var productId = $button.data("product-id");

        if (productId) {
          var inCart = self.isProductInCart(productId);
          self.updateButtonState($button, inCart);
        }
      });
    },

    // Update individual button state
    updateButtonState: function ($button, inCart) {
      if (!$button || !$button.length) return;

      // Don't update if button is in loading state
      if ($button.hasClass("loading")) return;

      var $buttonText = $button.find(".button-text");
      var $buttonIcon = $button.find("i");

      if (inCart) {
        // Set to view cart state
        $button
          .removeClass("success added_to_cart error")
          .addClass("wc-forward")
          .prop("disabled", false);

        $buttonText.text("Xem giỏ hàng");
        $buttonIcon.attr("class", "fa-solid fa-shopping-cart");
      } else {
        // Set to add to cart state
        $button
          .removeClass("success added_to_cart error wc-forward")
          .prop("disabled", false);

        $buttonText.text("Thêm vào giỏ");
        $buttonIcon.attr("class", "fa-solid fa-plus");
      }
    },

    // Check if product is in cart
    isProductInCart: function (productId) {
      try {
        var cartItems = JSON.parse(
          localStorage.getItem(this.config.storageKey) || "{}"
        );
        return cartItems.hasOwnProperty(productId) && cartItems[productId] > 0;
      } catch (e) {
        console.warn("Error reading cart items from localStorage:", e);
        return false;
      }
    },

    // Set product cart status
    setProductInCart: function (productId, inCart) {
      try {
        var cartItems = JSON.parse(
          localStorage.getItem(this.config.storageKey) || "{}"
        );

        if (inCart) {
          cartItems[productId] = 1; // Simple quantity tracking
        } else {
          delete cartItems[productId];
        }

        localStorage.setItem(this.config.storageKey, JSON.stringify(cartItems));
      } catch (e) {
        console.warn("Error saving cart items to localStorage:", e);
      }
    },

    // Sync with WooCommerce cart
    syncWithWooCommerce: function () {
      if (typeof wc_add_to_cart_params === "undefined") {
        console.warn("WooCommerce parameters not available for cart sync");
        return;
      }

      $.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        dataType: "json",
        data: {
          action: "get_cart_contents",
          security: wc_add_to_cart_params.wc_ajax_nonce || "",
        },
        success: function (response) {
          if (response.success && response.data) {
            window.GomieCartManager.updateCartFromWooCommerce(response.data);
          }
        },
        error: function (xhr, status, error) {
          console.warn("Cart sync failed:", status, error);
        },
      });
    },

    // Update cart from WooCommerce response
    updateCartFromWooCommerce: function (cartData) {
      var cartItems = {};

      if (cartData.cart_contents) {
        $.each(cartData.cart_contents, function (key, item) {
          if (item.product_id) {
            cartItems[item.product_id] = item.quantity;
          }
        });
      }

      localStorage.setItem(this.config.storageKey, JSON.stringify(cartItems));
      this.updateButtonStates();

      console.log("Cart synced with WooCommerce");
    },

    // Start periodic updates
    startPeriodicUpdate: function () {
      var self = this;
      setInterval(function () {
        if (typeof wc_add_to_cart_params !== "undefined") {
          self.syncWithWooCommerce();
        }
      }, this.config.updateInterval);
    },

    // Clear cart data
    clearCartData: function () {
      localStorage.removeItem(this.config.storageKey);
      localStorage.removeItem("gomie_cart_hash");
      this.updateButtonStates();
      console.log("Cart data cleared");
    },

    // Get cart summary
    getCartSummary: function () {
      try {
        var cartItems = JSON.parse(
          localStorage.getItem(this.config.storageKey) || "{}"
        );
        var totalItems = 0;
        var productCount = 0;

        $.each(cartItems, function (productId, quantity) {
          totalItems += parseInt(quantity) || 0;
          productCount++;
        });

        return {
          productCount: productCount,
          totalItems: totalItems,
          items: cartItems,
        };
      } catch (e) {
        console.warn("Error getting cart summary:", e);
        return {
          productCount: 0,
          totalItems: 0,
          items: {},
        };
      }
    },

    // Update header cart count with animation
    updateHeaderCartCount: function () {
      var self = this;

      // Get current cart count from WooCommerce if available
      if (typeof wc_add_to_cart_params !== "undefined") {
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
              // Update fragments
              $.each(response.fragments, function (key, value) {
                try {
                  var $existing = $(key);
                  if ($existing.length) {
                    $existing.replaceWith(value);

                    // Add animation to cart count
                    if (key.includes("cart-count") || key.includes(".badge")) {
                      $(key).addClass("updated");
                      setTimeout(function () {
                        $(key).removeClass("updated");
                      }, 600);
                    }
                  }
                } catch (e) {
                  console.warn("Fragment update failed for:", key, e);
                }
              });

              console.log("Header cart count updated successfully");
            }
          },
          error: function (xhr, status, error) {
            console.warn("Failed to update header cart count:", status, error);

            // Fallback: Update from localStorage
            var cartSummary = self.getCartSummary();
            var $cartCount = $(
              "#cart-header-btn .cart-count, .offcanvas-body .btn-primary .badge"
            );

            if ($cartCount.length) {
              $cartCount.text(cartSummary.totalItems);
              $cartCount.addClass("updated");
              setTimeout(function () {
                $cartCount.removeClass("updated");
              }, 600);
            }
          },
        });
      } else {
        // Fallback when WC params not available
        var cartSummary = this.getCartSummary();
        var $cartCount = $(
          "#cart-header-btn .cart-count, .offcanvas-body .btn-primary .badge"
        );

        if ($cartCount.length) {
          $cartCount.text(cartSummary.totalItems);
          $cartCount.addClass("updated");
          setTimeout(function () {
            $cartCount.removeClass("updated");
          }, 600);
        }
      }
    },
  };

  // Initialize when document is ready
  $(document).ready(function () {
    // Wait a bit for other scripts to load
    setTimeout(function () {
      window.GomieCartManager.init();
    }, 500);
  });

  // Also initialize on window load as fallback
  $(window).on("load", function () {
    if (!window.GomieCartManager.initialized) {
      window.GomieCartManager.init();
    }
  });
})(jQuery);
