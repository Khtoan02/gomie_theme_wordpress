/**
 * Cart Fallback System - Simple and Reliable
 * Ensures cart updates work even if main system fails
 */

(function ($) {
  "use strict";

  // Simple cart update system
  const CartFallback = {
    init() {
      this.bindEvents();
      console.log("Cart Fallback System initialized");
    },

    bindEvents() {
      // Quantity change with immediate update
      $(document).on("change", '.quantity input[type="number"]', (e) => {
        this.handleQuantityChange(e);
      });

      // Manual update button
      $(document).on("click", ".btn-update-cart", (e) => {
        e.preventDefault();
        this.updateCartViaForm();
      });

      // Remove item
      $(document).on("click", ".remove-item", (e) => {
        // Let default WooCommerce handle this
        return true;
      });
    },

    handleQuantityChange(e) {
      const $input = $(e.target);
      const $card = $input.closest(".cart-item-card");
      const quantity = parseInt($input.val()) || 1;

      // Update line total immediately (estimate)
      this.updateLineTotal($card, quantity);

      // Instant update - no delay
      clearTimeout(this.updateTimeout);
      this.updateTimeout = setTimeout(() => {
        this.updateCartViaAjax();
      }, 100); // Very fast update
    },

    updateLineTotal($card, quantity) {
      const $total = $card.find(".cart-item-total");
      const $priceElement = $card.find(".cart-item-price-single");

      // Try to extract unit price and calculate
      const priceText = $priceElement.text() || "";
      const priceMatch = priceText.match(/[\d,]+/);

      if (priceMatch && $total.length) {
        const unitPrice = parseFloat(priceMatch[0].replace(/,/g, ""));
        const newTotal = unitPrice * quantity;

        // Format price (simple formatting)
        const formattedPrice = new Intl.NumberFormat("vi-VN", {
          style: "currency",
          currency: "VND",
        }).format(newTotal);

        $total.html(formattedPrice);
        $total.addClass("updating");
        setTimeout(() => $total.removeClass("updating"), 500);
      }
    },

    updateCartViaAjax() {
      const formData = $(".woocommerce-cart-form").serialize();

      $.post({
        url: ajaxurl || "/wp-admin/admin-ajax.php",
        data: formData + "&action=woocommerce_update_cart",
        success: (response) => {
          console.log("Cart updated via fallback AJAX");
          this.refreshPage();
        },
        error: () => {
          console.log("AJAX failed, using form submit fallback");
          this.updateCartViaForm();
        },
      });
    },

    updateCartViaForm() {
      // Fallback: submit form normally
      const $form = $(".woocommerce-cart-form");
      if ($form.length) {
        // Add update_cart parameter
        if (!$form.find('[name="update_cart"]').length) {
          $form.append(
            '<input type="hidden" name="update_cart" value="Cập nhật giỏ hàng">'
          );
        }
        $form[0].submit();
      }
    },

    refreshPage() {
      // Soft refresh - just reload cart fragments
      if (typeof wc_cart_fragments_params !== "undefined") {
        $(document.body).trigger("wc_fragment_refresh");
      } else {
        // Hard refresh as last resort
        setTimeout(() => {
          window.location.reload();
        }, 500);
      }
    },
  };

  // Initialize fallback system
  $(document).ready(() => {
    CartFallback.init();

    // Make it globally available
    window.CartFallback = CartFallback;
  });

  // Integrate with existing cart system
  $(document.body).on("updated_wc_div", () => {
    console.log("WooCommerce cart updated - triggering header refresh");

    // Update header cart count
    $.post({
      url: ajaxurl || "/wp-admin/admin-ajax.php",
      data: { action: "get_cart_count" },
      success: (response) => {
        if (response.success) {
          $("#cart-header-btn .cart-count").text(response.data.count);
        }
      },
    });
  });
})(jQuery);
