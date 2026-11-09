/**
 * Cart Test Helper - Gomie Theme
 * Development helper to test cart functionality
 */

(function ($) {
  "use strict";

  // Only load in development/testing environment
  if (
    typeof console === "undefined" ||
    (!window.location.hostname.includes("localhost") &&
      !window.location.hostname.includes("127.0.0.1") &&
      !window.location.hostname.includes(".local"))
  ) {
    return; // Skip in production
  }

  // Cart Test Helper Object
  window.GomieCartTestHelper = {
    // Test configuration
    config: {
      testButtonSelector: ".btn-add-to-cart-apple",
      headerCartSelector: "#cart-header-btn .cart-count",
      mobileCartSelector: ".offcanvas-body .btn-primary .badge",
      logPrefix: "[Gomie Cart Test]",
    },

    // Initialize test helper
    init: function () {
      this.bindTestEvents();
      this.addTestControls();
      console.log(this.config.logPrefix, "Cart Test Helper initialized");
    },

    // Bind test events
    bindTestEvents: function () {
      var self = this;

      // Monitor cart updates
      $("body").on(
        "added_to_cart",
        function (event, fragments, cart_hash, button) {
          self.logCartUpdate("Product added to cart", {
            fragments: fragments,
            cart_hash: cart_hash,
            button: button ? button.data("product-id") : "unknown",
          });
        }
      );

      // Monitor fragment updates
      $("body").on("wc_fragments_refreshed", function () {
        self.logCartUpdate("Cart fragments refreshed");
      });

      // Monitor header cart updater
      if (window.GomieHeaderCartUpdater) {
        var originalForceUpdate =
          window.GomieHeaderCartUpdater.forceUpdateCartCount;
        window.GomieHeaderCartUpdater.forceUpdateCartCount = function () {
          self.logCartUpdate("Header cart updater triggered");
          return originalForceUpdate.apply(this, arguments);
        };
      }

      // Monitor cart state sync
      if (window.GomieCartStateSync) {
        var originalSync = window.GomieCartStateSync.syncCartState;
        window.GomieCartStateSync.syncCartState = function () {
          self.logCartUpdate("Cart state sync triggered");
          return originalSync.apply(this, arguments);
        };
      }
    },

    // Add test controls to page
    addTestControls: function () {
      var self = this;

      // Create test panel
      var $testPanel = $(`
        <div id="gomie-cart-test-panel" style="
          position: fixed;
          bottom: 20px;
          left: 20px;
          background: #fff;
          border: 2px solid #e67e22;
          border-radius: 8px;
          padding: 15px;
          box-shadow: 0 4px 12px rgba(0,0,0,0.15);
          z-index: 10000;
          font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
          font-size: 14px;
          min-width: 250px;
          max-width: 300px;
        ">
          <div style="font-weight: bold; color: #e67e22; margin-bottom: 10px;">
            🛒 Cart Test Helper
          </div>
          <div style="margin-bottom: 10px;">
            <strong>Header Count:</strong> <span id="test-header-count">-</span><br>
            <strong>Mobile Count:</strong> <span id="test-mobile-count">-</span><br>
            <strong>Cart Products:</strong> <span id="test-cart-products">-</span>
          </div>
          <div style="margin-bottom: 10px;">
            <button id="test-refresh-cart" style="
              background: #3498db;
              color: white;
              border: none;
              padding: 5px 10px;
              border-radius: 4px;
              cursor: pointer;
              margin-right: 5px;
            ">Refresh</button>
            <button id="test-clear-log" style="
              background: #95a5a6;
              color: white;
              border: none;
              padding: 5px 10px;
              border-radius: 4px;
              cursor: pointer;
            ">Clear Log</button>
          </div>
          <div id="test-log" style="
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px;
            font-size: 12px;
            max-height: 150px;
            overflow-y: auto;
            font-family: monospace;
          "></div>
        </div>
      `);

      $("body").append($testPanel);

      // Bind test controls
      $("#test-refresh-cart").on("click", function () {
        self.refreshCartCounts();
      });

      $("#test-clear-log").on("click", function () {
        $("#test-log").empty();
      });

      // Initial count update
      this.refreshCartCounts();

      // Auto-refresh counts every 2 seconds
      setInterval(function () {
        self.refreshCartCounts();
      }, 2000);
    },

    // Refresh cart counts display
    refreshCartCounts: function () {
      var headerCount = $(this.config.headerCartSelector).text() || "0";
      var mobileCount = $(this.config.mobileCartSelector).text() || "0";

      $("#test-header-count").text(headerCount);
      $("#test-mobile-count").text(mobileCount);

      // Show cart products if available
      if (window.GomieCartStateSync) {
        var cartState = window.GomieCartStateSync.getCurrentCartState();
        $("#test-cart-products").text(
          cartState.productIds.join(", ") || "Empty"
        );
      }
    },

    // Log cart update
    logCartUpdate: function (message, data) {
      var timestamp = new Date().toLocaleTimeString();
      var logEntry = `[${timestamp}] ${message}`;

      if (data) {
        logEntry += "\n" + JSON.stringify(data, null, 2);
      }

      console.log(this.config.logPrefix, message, data);

      // Add to visual log
      var $log = $("#test-log");
      if ($log.length) {
        $log.append(
          `<div style="margin-bottom: 5px; padding: 3px; border-left: 3px solid #e67e22;">${logEntry}</div>`
        );
        $log.scrollTop($log[0].scrollHeight);
      }
    },

    // Test specific functionality
    testAddToCart: function (productId) {
      var $button = $(
        `.btn-add-to-cart-apple[data-product-id="${productId}"]`
      ).first();
      if ($button.length) {
        this.logCartUpdate(`Testing add to cart for product ${productId}`);
        $button.trigger("click");
      } else {
        this.logCartUpdate(`Product ${productId} button not found`);
      }
    },

    // Test cart count update
    testCartCountUpdate: function () {
      this.logCartUpdate("Testing cart count update");
      if (window.GomieHeaderCartUpdater) {
        window.GomieHeaderCartUpdater.forceUpdateCartCount();
      }
    },
  };

  // Initialize when document is ready
  $(document).ready(function () {
    setTimeout(function () {
      window.GomieCartTestHelper.init();
    }, 1000);
  });

  // Expose test functions globally for console use
  window.testAddToCart = function (productId) {
    window.GomieCartTestHelper.testAddToCart(productId);
  };

  window.testCartUpdate = function () {
    window.GomieCartTestHelper.testCartCountUpdate();
  };
})(jQuery);
