/**
 * Cart State Synchronizer - Gomie Theme
 * Accurately tracks which products are in cart and updates button states
 */

(function ($) {
  "use strict";

  // Cart State Synchronizer Object
  window.GomieCartStateSync = {
    // Configuration
    config: {
      buttonSelector: ".btn-add-to-cart-apple",
      syncInterval: 15000, // 15 seconds
      storageKey: "gomie_cart_products",
      logPrefix: "[Cart State Sync]",
    },

    // Current cart state
    cartState: {
      productIds: [],
      lastSync: 0,
      syncing: false,
    },

    // Initialize synchronizer
    init: function () {
      this.bindEvents();
      this.syncCartState();
      this.startPeriodicSync();
      console.log(this.config.logPrefix, "Cart State Synchronizer initialized");
    },

    // Bind events
    bindEvents: function () {
      var self = this;

      // Listen for cart updates
      $("body").on(
        "added_to_cart",
        function (event, fragments, cart_hash, button) {
          setTimeout(function () {
            self.syncCartState();
          }, 200); // Small delay to ensure WC processes the add
        }
      );

      // Listen for cart changes (removals, updates)
      $("body").on("wc_fragments_refreshed", function () {
        self.syncCartState();
      });

      // Listen for WooCommerce cart updated event
      $("body").on("wc_cart_updated", function () {
        self.syncCartState();
      });

      // Listen for page visibility change
      $(document).on("visibilitychange", function () {
        if (!document.hidden) {
          self.syncCartState();
        }
      });

      // Listen for storage changes (multi-tab support)
      $(window).on("storage", function (e) {
        if (e.originalEvent.key === self.config.storageKey) {
          self.loadCartStateFromStorage();
          self.updateAllButtonStates();
        }
      });
    },

    // Sync cart state with WooCommerce
    syncCartState: function () {
      var self = this;

      if (this.cartState.syncing) {
        console.log(
          this.config.logPrefix,
          "Sync already in progress, skipping"
        );
        return;
      }

      if (typeof wc_add_to_cart_params === "undefined") {
        console.warn(
          this.config.logPrefix,
          "WooCommerce parameters not available"
        );
        return;
      }

      this.cartState.syncing = true;

      $.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        dataType: "json",
        timeout: 8000,
        data: {
          action: "get_cart_contents",
          security: wc_add_to_cart_params.wc_ajax_nonce || "",
        },
        success: function (response) {
          self.cartState.syncing = false;

          if (response.success && response.data) {
            var newProductIds = response.data.product_ids || [];
            var oldProductIds = self.cartState.productIds;

            // Update cart state
            self.cartState.productIds = newProductIds;
            self.cartState.lastSync = Date.now();

            // Save to storage
            self.saveCartStateToStorage();

            // Find products that were removed
            var removedProducts = oldProductIds.filter(function (id) {
              return newProductIds.indexOf(id) === -1;
            });

            // Find products that were added
            var addedProducts = newProductIds.filter(function (id) {
              return oldProductIds.indexOf(id) === -1;
            });

            // Update button states
            self.updateAllButtonStates();

            // Log changes
            if (removedProducts.length > 0) {
              console.log(
                self.config.logPrefix,
                "Products removed from cart:",
                removedProducts
              );
            }
            if (addedProducts.length > 0) {
              console.log(
                self.config.logPrefix,
                "Products added to cart:",
                addedProducts
              );
            }

            console.log(
              self.config.logPrefix,
              "Cart state synced successfully",
              {
                productIds: newProductIds,
                count: response.data.count,
              }
            );
          }
        },
        error: function (xhr, status, error) {
          self.cartState.syncing = false;
          console.warn(
            self.config.logPrefix,
            "Cart sync failed:",
            status,
            error
          );
        },
      });
    },

    // Update all button states
    updateAllButtonStates: function () {
      var self = this;

      $(this.config.buttonSelector).each(function () {
        var $button = $(this);
        var productId = parseInt($button.data("product-id"));

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
      var productId = $button.data("product-id");

      if (inCart) {
        // Set to view cart state
        $button
          .removeClass("success added_to_cart error")
          .addClass("wc-forward")
          .prop("disabled", false);

        $buttonText.text("Xem giỏ hàng");
        $buttonIcon.attr("class", "fa-solid fa-shopping-cart");

        console.log(
          this.config.logPrefix,
          `Product ${productId} button set to VIEW CART state`
        );
      } else {
        // Set to add to cart state
        $button
          .removeClass("success added_to_cart error wc-forward")
          .prop("disabled", false);

        $buttonText.text("Thêm vào giỏ");
        $buttonIcon.attr("class", "fa-solid fa-plus");

        console.log(
          this.config.logPrefix,
          `Product ${productId} button set to ADD TO CART state`
        );
      }
    },

    // Check if product is in cart
    isProductInCart: function (productId) {
      return this.cartState.productIds.indexOf(parseInt(productId)) !== -1;
    },

    // Save cart state to localStorage
    saveCartStateToStorage: function () {
      try {
        var stateData = {
          productIds: this.cartState.productIds,
          lastSync: this.cartState.lastSync,
          timestamp: Date.now(),
        };
        localStorage.setItem(this.config.storageKey, JSON.stringify(stateData));
      } catch (e) {
        console.warn(
          this.config.logPrefix,
          "Failed to save cart state to storage:",
          e
        );
      }
    },

    // Load cart state from localStorage
    loadCartStateFromStorage: function () {
      try {
        var stored = localStorage.getItem(this.config.storageKey);
        if (stored) {
          var stateData = JSON.parse(stored);

          // Only use if recent (within 5 minutes)
          if (Date.now() - stateData.timestamp < 300000) {
            this.cartState.productIds = stateData.productIds || [];
            this.cartState.lastSync = stateData.lastSync || 0;
            console.log(
              this.config.logPrefix,
              "Cart state loaded from storage:",
              this.cartState.productIds
            );
            return true;
          }
        }
      } catch (e) {
        console.warn(
          this.config.logPrefix,
          "Failed to load cart state from storage:",
          e
        );
      }
      return false;
    },

    // Start periodic synchronization
    startPeriodicSync: function () {
      var self = this;

      setInterval(function () {
        // Only sync if not done recently
        if (Date.now() - self.cartState.lastSync > self.config.syncInterval) {
          self.syncCartState();
        }
      }, self.config.syncInterval);
    },

    // Force immediate sync
    forceSyncCartState: function () {
      this.cartState.lastSync = 0; // Reset last sync time
      this.syncCartState();
    },

    // Clear cart state
    clearCartState: function () {
      this.cartState.productIds = [];
      this.cartState.lastSync = 0;
      localStorage.removeItem(this.config.storageKey);
      this.updateAllButtonStates();
      console.log(this.config.logPrefix, "Cart state cleared");
    },

    // Get current cart state
    getCurrentCartState: function () {
      return {
        productIds: [...this.cartState.productIds],
        lastSync: this.cartState.lastSync,
        syncing: this.cartState.syncing,
      };
    },

    // Manual product state update (for immediate feedback)
    setProductCartState: function (productId, inCart) {
      productId = parseInt(productId);
      var index = this.cartState.productIds.indexOf(productId);

      if (inCart && index === -1) {
        this.cartState.productIds.push(productId);
      } else if (!inCart && index !== -1) {
        this.cartState.productIds.splice(index, 1);
      }

      this.saveCartStateToStorage();

      // Update specific button
      var $button = $(
        this.config.buttonSelector + '[data-product-id="' + productId + '"]'
      );
      this.updateButtonState($button, inCart);
    },
  };

  // Initialize when document is ready
  $(document).ready(function () {
    // Load initial state from storage
    window.GomieCartStateSync.loadCartStateFromStorage();

    // Initialize after a short delay
    setTimeout(function () {
      window.GomieCartStateSync.init();
    }, 500);
  });

  // Also initialize on window load as fallback
  $(window).on("load", function () {
    if (!window.GomieCartStateSync.initialized) {
      window.GomieCartStateSync.init();
      window.GomieCartStateSync.initialized = true;
    }
  });

  // Expose useful functions globally for debugging
  window.debugCartState = function () {
    console.log(
      "Current Cart State:",
      window.GomieCartStateSync.getCurrentCartState()
    );
  };

  window.forceCartSync = function () {
    window.GomieCartStateSync.forceSyncCartState();
  };
})(jQuery);
