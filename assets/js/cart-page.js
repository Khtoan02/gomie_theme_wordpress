/**
 * Gomie Cart Page JavaScript
 * Enhanced UX for cart functionality with smooth animations and real-time updates
 */

(function ($) {
  "use strict";

  class GomieCartPage {
    constructor() {
      this.init();
      this.bindEvents();
    }

    init() {
      this.cartForm = $(".woocommerce-cart-form");
      this.updateCartBtn = $(".btn-update-cart");
      this.isUpdating = false;

      // Hide default WooCommerce update cart button if using custom one
      $('button[name="update_cart"]:not(.btn-update-cart)').hide();
    }

    bindEvents() {
      // Quantity controls
      $(document).on("click", ".qty-decrease", (e) => this.decreaseQuantity(e));
      $(document).on("click", ".qty-increase", (e) => this.increaseQuantity(e));
      $(document).on("change", '.quantity input[type="number"]', (e) =>
        this.onQuantityChange(e)
      );

      // Remove item with confirmation
      $(document).on("click", ".remove-item", (e) => this.confirmRemoveItem(e));

      // Update cart button
      $(document).on("click", ".btn-update-cart", (e) => this.updateCart(e));

      // Auto-update cart on quantity change (with debounce)
      this.setupAutoUpdate();

      // Coupon form enhancement
      this.enhanceCouponForm();

      // Add loading states
      this.setupLoadingStates();
    }

    decreaseQuantity(e) {
      e.preventDefault();
      const button = $(e.currentTarget);
      const cartKey = button.data("cart-key");

      // More flexible selector for quantity input
      let quantityInput = button.siblings('input[type="number"]');
      if (!quantityInput.length) {
        quantityInput = button
          .closest(".quantity-input-wrapper")
          .find('input[type="number"]');
      }
      if (!quantityInput.length) {
        quantityInput = $(`.quantity input[name="cart[${cartKey}][qty]"]`);
      }

      const currentValue = parseInt(quantityInput.val()) || 1;

      if (currentValue > 1) {
        quantityInput.val(currentValue - 1);
        quantityInput.trigger("change");
        this.highlightQuantityChange(quantityInput);

        // Instant update - no delay
        setTimeout(() => this.silentUpdateCart(), 100);
      }
    }

    increaseQuantity(e) {
      e.preventDefault();
      const button = $(e.currentTarget);
      const cartKey = button.data("cart-key");

      // More flexible selector for quantity input
      let quantityInput = button.siblings('input[type="number"]');
      if (!quantityInput.length) {
        quantityInput = button
          .closest(".quantity-input-wrapper")
          .find('input[type="number"]');
      }
      if (!quantityInput.length) {
        quantityInput = $(`.quantity input[name="cart[${cartKey}][qty]"]`);
      }

      const currentValue = parseInt(quantityInput.val()) || 1;
      const maxValue = parseInt(quantityInput.attr("max")) || 999;

      if (currentValue < maxValue) {
        quantityInput.val(currentValue + 1);
        quantityInput.trigger("change");
        this.highlightQuantityChange(quantityInput);

        // Instant update - no delay
        setTimeout(() => this.silentUpdateCart(), 100);
      }
    }

    onQuantityChange(e) {
      const input = $(e.currentTarget);
      const value = parseInt(input.val()) || 1;
      const min = parseInt(input.attr("min")) || 1;
      const max = parseInt(input.attr("max")) || 999;

      // Validate and correct value
      if (value < min) {
        input.val(min);
      } else if (value > max) {
        input.val(max);
        // No warning notification - just silent correction
      }

      this.highlightQuantityChange(input);

      // Instant update instead of scheduled
      this.silentUpdateCart();
    }

    highlightQuantityChange(input) {
      const wrapper = input.closest(".quantity-input-wrapper");
      const cartItem = input.closest(".cart-item-card");

      // Very subtle visual feedback - no delay
      wrapper.addClass("updating");

      // Remove updating state quickly
      setTimeout(() => {
        wrapper.removeClass("updating");
      }, 200);

      // No success glow - keep it instant and clean
    }

    confirmRemoveItem(e) {
      e.preventDefault();
      const link = $(e.currentTarget);

      // Check if user wants instant remove (hold Shift key)
      if (e.shiftKey) {
        // Instant remove without confirmation
        this.removeItemWithAnimation(link);
        return;
      }

      const productName = link
        .closest(".cart-item-card")
        .find(".cart-item-name")
        .text()
        .trim();

      // Create fast confirmation modal
      const modal = this.createConfirmationModal(
        "Xóa sản phẩm",
        `Xóa "${productName}" khỏi giỏ hàng?`,
        "Xóa",
        "Hủy"
      );

      modal.find(".confirm-btn").on("click", () => {
        this.removeItemWithAnimation(link);
        modal.remove();
      });

      modal.find(".cancel-btn, .modal-overlay").on("click", () => {
        modal.remove();
      });

      // Auto-remove modal after 5 seconds if no action
      setTimeout(() => {
        if (modal.length) {
          modal.remove();
        }
      }, 5000);
    }

    createConfirmationModal(title, message, confirmText, cancelText) {
      const modal = $(`
                <div class="gomie-modal-overlay">
                    <div class="gomie-modal">
                        <div class="modal-header">
                            <h3>${title}</h3>
                            <button class="modal-close">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn cancel-btn">${cancelText}</button>
                            <button class="btn confirm-btn btn-danger">${confirmText}</button>
                        </div>
                    </div>
                </div>
            `);

      $("body").append(modal);

      // Add modal styles if not already added
      if (!$("#gomie-modal-styles").length) {
        this.addModalStyles();
      }

      return modal;
    }

    addModalStyles() {
      const styles = `
                <style id="gomie-modal-styles">
                .gomie-modal-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 10000;
                    animation: fadeIn 0.2s ease;
                }
                .gomie-modal {
                    background: #fff;
                    border-radius: 12px;
                    max-width: 400px;
                    width: 90%;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                    animation: slideIn 0.3s ease;
                }
                .modal-header {
                    padding: 1.5rem;
                    border-bottom: 1px solid #e9ecef;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                .modal-header h3 {
                    margin: 0;
                    color: #333;
                    font-size: 1.2rem;
                }
                .modal-close {
                    background: none;
                    border: none;
                    font-size: 1.5rem;
                    cursor: pointer;
                    color: #999;
                }
                .modal-body {
                    padding: 1.5rem;
                }
                .modal-body p {
                    margin: 0;
                    color: #666;
                    line-height: 1.5;
                }
                .modal-footer {
                    padding: 1.5rem;
                    border-top: 1px solid #e9ecef;
                    display: flex;
                    gap: 1rem;
                    justify-content: flex-end;
                }
                .modal-footer .btn {
                    padding: 0.6rem 1.2rem;
                    border-radius: 6px;
                    border: none;
                    cursor: pointer;
                    font-weight: 500;
                    transition: all 0.2s ease;
                }
                .cancel-btn {
                    background: #f8f9fa;
                    color: #333;
                    border: 1px solid #dee2e6;
                }
                .cancel-btn:hover {
                    background: #e9ecef;
                }
                .btn-danger {
                    background: #dc3545;
                    color: #fff;
                }
                .btn-danger:hover {
                    background: #c82333;
                }
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                @keyframes slideIn {
                    from { transform: translateY(-20px); opacity: 0; }
                    to { transform: translateY(0); opacity: 1; }
                }
                </style>
            `;
      $("head").append(styles);
    }

    removeItemWithAnimation(link) {
      const cartItem = link.closest(".cart-item-card");
      const removeUrl = link.attr("href");

      // Add removing animation
      cartItem.addClass("removing");

      // Extract cart item key from URL
      const urlParams = new URLSearchParams(removeUrl.split("?")[1]);
      const removeCartItem = urlParams.get("remove_item");
      const nonce = urlParams.get("_wpnonce");

      if (removeCartItem) {
        // AJAX remove instead of page redirect
        $.ajax({
          url:
            (typeof gomie_cart_params !== "undefined"
              ? gomie_cart_params.ajax_url
              : wc_add_to_cart_params.ajax_url) || ajaxurl,
          type: "POST",
          data: {
            action: "remove_cart_item",
            cart_item_key: removeCartItem,
            security:
              nonce ||
              (typeof gomie_cart_params !== "undefined"
                ? gomie_cart_params.nonce
                : ""),
          },
          success: (response) => {
            console.log("Remove item response:", response);

            if (response && response.success) {
              // Remove item from UI with animation
              cartItem.slideUp(300, () => {
                cartItem.remove();

                // Update cart fragments
                if (response.data && response.data.fragments) {
                  $.each(response.data.fragments, (selector, html) => {
                    const $target = $(selector);
                    if ($target.length) {
                      $target.replaceWith(html);
                    }
                  });
                }

                // Update totals if available
                if (response.data) {
                  this.updateCartTotalsOnPage(response.data);
                }

                // Trigger events
                $(document.body).trigger("updated_wc_div");
                $(document.body).trigger("wc_fragments_refreshed");

                // Check if cart is empty
                if (response.data && response.data.cart_count === 0) {
                  this.showEmptyCartState();
                } else if ($(".cart-item-card").length === 0) {
                  // Fallback empty check
                  this.showEmptyCartState();
                }
              });
            } else {
              // Remove animation and fallback to page redirect
              cartItem.removeClass("removing");
              console.log("AJAX remove failed, using page redirect");
              window.location.href = removeUrl;
            }
          },
          error: (xhr, status, error) => {
            console.error("Remove item AJAX error:", error);
            // Remove animation and fallback to page redirect
            cartItem.removeClass("removing");
            window.location.href = removeUrl;
          },
        });
      } else {
        // Fallback to page redirect
        window.location.href = removeUrl;
      }
    }

    updateCart(e) {
      // Don't block multiple clicks
      // if (this.isUpdating) return;

      e.preventDefault();

      const button = $(e.currentTarget);

      // Very brief visual feedback
      button.addClass("loading");
      button.text("Cập nhật...");

      // Use AJAX for instant update
      this.silentUpdateCart();

      // Reset button quickly
      setTimeout(() => {
        button.removeClass("loading");
        button.html('<i class="fas fa-sync-alt"></i> Cập nhật giỏ hàng');
      }, 500);
    }

    setupAutoUpdate() {
      let updateTimeout;

      $(document).on("input change", '.quantity input[type="number"]', () => {
        clearTimeout(updateTimeout);
        updateTimeout = setTimeout(() => {
          // Remove blocking check - allow immediate updates
          this.silentUpdateCart();
        }, 300); // Much faster - 0.3 seconds after user stops typing
      });
    }

    scheduleAutoUpdate() {
      clearTimeout(this.autoUpdateTimeout);
      this.autoUpdateTimeout = setTimeout(() => {
        // Remove blocking check for faster updates
        this.silentUpdateCart();
      }, 500); // Faster auto-update - 0.5 seconds
    }

    silentUpdateCart() {
      // Allow multiple concurrent updates
      // if (this.isUpdating) return;

      // Set updating flag but allow overlapping updates
      this.isUpdating = true;

      // No notifications for speed - silent updates only

      // Get form data and add required parameters
      const formData = this.cartForm.serialize();
      const ajaxData = formData + "&action=update_cart_item";

      // Add nonce for security
      const nonce =
        $('[name="woocommerce-cart-nonce"]').val() ||
        (typeof gomie_cart_params !== "undefined"
          ? gomie_cart_params.nonce
          : "") ||
        (typeof wc_add_to_cart_params !== "undefined"
          ? wc_add_to_cart_params.wc_ajax_nonce
          : "");

      $.ajax({
        url:
          (typeof gomie_cart_params !== "undefined"
            ? gomie_cart_params.ajax_url
            : wc_add_to_cart_params.ajax_url) || ajaxurl,
        type: "POST",
        data: ajaxData + (nonce ? "&woocommerce-cart-nonce=" + nonce : ""),
        dataType: "json",
        success: (response) => {
          console.log("Cart update response:", response);

          if (response.success && response.data) {
            // Update cart fragments first
            if (response.data.fragments) {
              $.each(response.data.fragments, (selector, html) => {
                const $target = $(selector);
                if ($target.length) {
                  $target.replaceWith(html);
                }
              });
            }

            // Update cart totals in the page
            this.updateCartTotalsOnPage(response.data);

            // Update individual item totals
            this.updateItemTotalsFromCart();

            // Trigger WooCommerce events
            $(document.body).trigger("updated_wc_div");
            $(document.body).trigger("wc_fragments_refreshed");
            $(document.body).trigger("wc_fragment_refresh");

            // No success notification - silent update
          } else {
            console.error("Cart update failed:", response);
            // Only show error notifications when needed
            // this.showNotification(response.data?.message || "Có lỗi xảy ra", "error");
          }
        },
        error: (xhr, status, error) => {
          console.error("AJAX error:", xhr.responseText);
          // Only show critical errors
          // this.showNotification("Lỗi kết nối", "error");
        },
        complete: () => {
          // Reset flag immediately to allow next update
          this.isUpdating = false;
          $(".cart-item-card").removeClass("updating");
        },
      });
    }

    updateCartFragments(response) {
      // Get fresh cart fragments via AJAX
      $.ajax({
        url:
          (typeof gomie_cart_params !== "undefined"
            ? gomie_cart_params.ajax_url
            : wc_add_to_cart_params.ajax_url) || ajaxurl,
        type: "POST",
        data: {
          action: "woocommerce_get_refreshed_fragments",
        },
        success: (fragmentResponse) => {
          if (fragmentResponse && fragmentResponse.fragments) {
            // Update all cart fragments
            $.each(fragmentResponse.fragments, (selector, html) => {
              $(selector).replaceWith(html);
            });

            // Trigger cart fragments updated event
            $(document.body).trigger("wc_fragments_refreshed");
          }
        },
      });
    }

    updateCartTotalsOnPage(data) {
      // Update cart totals in the summary section with new selectors
      if (data.cart_subtotal) {
        $(".subtotal-row .value, .cart-summary-row.subtotal .value").html(
          data.cart_subtotal
        );
      }
      if (data.cart_total) {
        $(".total-row .value, .cart-summary-row.total .value").html(
          data.cart_total
        );
      }
      if (data.cart_count !== undefined) {
        $("#cart-header-btn .cart-count").text(data.cart_count);
        $(".section-badge, .summary-badge, .items-count").text(
          data.cart_count + " sản phẩm"
        );
      }
    }

    updateItemTotalsFromCart() {
      // Update individual item totals by recalculating from quantities
      $(".cart-item-card").each(function () {
        const $card = $(this);
        const $qtyInput = $card.find('.quantity input[type="number"]');
        const $totalElement = $card.find(".cart-item-total");

        if ($qtyInput.length && $totalElement.length) {
          const cartKey = $qtyInput.attr("name")?.match(/cart\[([^\]]+)\]/);
          if (cartKey && cartKey[1]) {
            // Get updated total for this specific item
            $.ajax({
              url:
                (typeof gomie_cart_params !== "undefined"
                  ? gomie_cart_params.ajax_url
                  : wc_add_to_cart_params.ajax_url) || ajaxurl,
              type: "POST",
              data: {
                action: "get_cart_item_total",
                cart_key: cartKey[1],
              },
              success: (response) => {
                if (response.success && response.data.total) {
                  $totalElement.html(response.data.total);
                }
              },
            });
          }
        }
      });
    }

    updateItemTotals() {
      // Legacy method - redirect to new method
      this.updateItemTotalsFromCart();
    }

    refreshCartTotals() {
      // Update cart totals via AJAX
      $.ajax({
        url:
          (typeof gomie_cart_params !== "undefined"
            ? gomie_cart_params.ajax_url
            : wc_add_to_cart_params.ajax_url) || ajaxurl,
        type: "POST",
        data: {
          action: "get_cart_totals",
        },
        success: (response) => {
          if (response.success && response.data) {
            // Update cart totals in summary
            if (response.data.subtotal) {
              $(".cart-summary-row.subtotal .value").html(
                response.data.subtotal
              );
            }
            if (response.data.total) {
              $(".cart-summary-row.total .value").html(response.data.total);
            }
          }
        },
      });
    }

    enhanceCouponForm() {
      const couponInput = $("#coupon_code");
      const couponBtn = $(".btn-apply-coupon");

      // Add enter key support
      couponInput.on("keypress", (e) => {
        if (e.which === 13) {
          e.preventDefault();
          this.applyCouponAjax();
        }
      });

      // AJAX coupon application
      couponBtn.on("click", (e) => {
        e.preventDefault();
        this.applyCouponAjax();
      });
    }

    applyCouponAjax() {
      const couponInput = $("#coupon_code");
      const couponBtn = $(".btn-apply-coupon");
      const couponCode = couponInput.val().trim();

      // Clear any existing messages
      this.clearCouponMessage();

      if (!couponCode) {
        this.showCouponMessage("Vui lòng nhập mã giảm giá", "error");
        couponInput.focus();
        return;
      }

      // Show loading state
      couponBtn.prop("disabled", true);
      couponBtn.html('<i class="fas fa-spinner fa-spin"></i> Đang áp dụng...');

      // AJAX apply coupon
      $.ajax({
        url:
          (typeof gomie_cart_params !== "undefined"
            ? gomie_cart_params.ajax_url
            : wc_add_to_cart_params.ajax_url) || ajaxurl,
        type: "POST",
        data: {
          action: "apply_coupon_ajax",
          coupon_code: couponCode,
          security:
            (typeof gomie_cart_params !== "undefined"
              ? gomie_cart_params.nonce
              : "") ||
            (typeof wc_add_to_cart_params !== "undefined"
              ? wc_add_to_cart_params.wc_ajax_nonce
              : ""),
        },
        success: (response) => {
          console.log("Apply coupon response:", response);

          if (response.success) {
            // Success - coupon applied
            this.showCouponMessage(
              "✅ Mã giảm giá đã được áp dụng thành công!",
              "success"
            );

            // Clear input
            couponInput.val("");

            // Update cart fragments and totals
            if (response.data.fragments) {
              $.each(response.data.fragments, (selector, html) => {
                $(selector).replaceWith(html);
              });
            }

            // Update totals
            this.updateCartTotalsOnPage(response.data);

            // Trigger events
            $(document.body).trigger("updated_wc_div");
            $(document.body).trigger("wc_fragments_refreshed");

            // Refresh the coupon section to show applied coupon
            setTimeout(() => {
              this.refreshCouponSection();
            }, 500);
          } else {
            // Error - coupon invalid or failed
            const errorMessage =
              response.data?.message ||
              "Mã giảm giá không hợp lệ hoặc đã hết hạn";
            this.showCouponMessage("❌ " + errorMessage, "error");
          }
        },
        error: (xhr, status, error) => {
          console.error("Apply coupon AJAX error:", error);
          this.showCouponMessage(
            "❌ Có lỗi xảy ra khi áp dụng mã giảm giá",
            "error"
          );
        },
        complete: () => {
          // Reset button
          couponBtn.prop("disabled", false);
          couponBtn.html('<i class="fas fa-check"></i> Áp dụng');
        },
      });
    }

    showCouponMessage(message, type) {
      // Remove existing message
      this.clearCouponMessage();

      // Create message element
      const messageClass =
        type === "success" ? "coupon-success" : "coupon-error";
      const messageHtml = `<div class="coupon-message ${messageClass}">${message}</div>`;

      // Add message to container
      $(".coupon-messages-container").html(messageHtml);

      // Auto-remove success messages after 5 seconds
      if (type === "success") {
        setTimeout(() => {
          this.clearCouponMessage();
        }, 5000);
      }
    }

    clearCouponMessage() {
      $(".coupon-messages-container").empty();
    }

    refreshCouponSection() {
      // Refresh the entire cart totals section to show applied coupons
      $.ajax({
        url:
          (typeof gomie_cart_params !== "undefined"
            ? gomie_cart_params.ajax_url
            : wc_add_to_cart_params.ajax_url) || ajaxurl,
        type: "POST",
        data: {
          action: "get_cart_totals_html",
        },
        success: (response) => {
          if (response.success && response.data.html) {
            $(".cart-totals-container").html(response.data.html);
          }
        },
      });
    }

    setupLoadingStates() {
      // Show loading state for checkout button
      $(".checkout-button").on("click", function () {
        const btn = $(this);
        if (!btn.hasClass("loading")) {
          btn.addClass("loading");
          btn.html(
            '<i class="fas fa-spinner fa-spin"></i> Đang chuyển hướng...'
          );
        }
      });
    }

    showNotification(message, type = "info", duration = 4000) {
      // Remove existing notifications
      $(".gomie-notification").remove();

      const notification = $(`
                <div class="gomie-notification ${type}">
                    <div class="notification-content">
                        <i class="notification-icon fas ${this.getNotificationIcon(
                          type
                        )}"></i>
                        <span class="notification-message">${message}</span>
                        <button class="notification-close">&times;</button>
                    </div>
                </div>
            `);

      $("body").append(notification);

      // Add notification styles if not already added
      if (!$("#gomie-notification-styles").length) {
        this.addNotificationStyles();
      }

      // Auto-remove after duration
      setTimeout(() => {
        notification.fadeOut(300, () => notification.remove());
      }, duration);

      // Manual close
      notification.find(".notification-close").on("click", () => {
        notification.fadeOut(300, () => notification.remove());
      });
    }

    getNotificationIcon(type) {
      const icons = {
        success: "fa-check-circle",
        error: "fa-exclamation-circle",
        warning: "fa-exclamation-triangle",
        info: "fa-info-circle",
      };
      return icons[type] || icons.info;
    }

    addNotificationStyles() {
      const styles = `
                <style id="gomie-notification-styles">
                .gomie-notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    max-width: 400px;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                    animation: slideInRight 0.3s ease;
                }
                .gomie-notification.success {
                    background: #d4edda;
                    border-left: 4px solid #28a745;
                    color: #155724;
                }
                .gomie-notification.error {
                    background: #f8d7da;
                    border-left: 4px solid #dc3545;
                    color: #721c24;
                }
                .gomie-notification.warning {
                    background: #fff3cd;
                    border-left: 4px solid #ffc107;
                    color: #856404;
                }
                .gomie-notification.info {
                    background: #d1ecf1;
                    border-left: 4px solid #17a2b8;
                    color: #0c5460;
                }
                .notification-content {
                    padding: 1rem 1.5rem;
                    display: flex;
                    align-items: center;
                    gap: 0.8rem;
                }
                .notification-icon {
                    font-size: 1.2rem;
                    flex-shrink: 0;
                }
                .notification-message {
                    flex: 1;
                    font-weight: 500;
                }
                .notification-close {
                    background: none;
                    border: none;
                    font-size: 1.2rem;
                    cursor: pointer;
                    opacity: 0.7;
                    flex-shrink: 0;
                }
                .notification-close:hover {
                    opacity: 1;
                }
                @keyframes slideInRight {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @media (max-width: 768px) {
                    .gomie-notification {
                        top: 10px;
                        right: 10px;
                        left: 10px;
                        max-width: none;
                    }
                }
                </style>
            `;
      $("head").append(styles);
    }

    showEmptyCartState() {
      // Replace cart content with empty state
      const emptyStateHtml = `
        <div class="cart-empty-state">
          <div class="empty-cart-icon">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <h2>Giỏ hàng trống</h2>
          <p>Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
          <a href="${window.location.origin}/shop" class="btn-continue-shopping">
            <i class="fas fa-arrow-left"></i>
            Tiếp tục mua sắm
          </a>
        </div>
      `;

      $(".cart-content-wrapper").replaceWith(emptyStateHtml);
    }
  }

  // Initialize when DOM is ready
  $(document).ready(function () {
    if ($(".gomie-cart-container").length) {
      window.gomieCartPage = new GomieCartPage();
    }
  });

  // Handle WooCommerce cart updates
  $(document.body).on("updated_wc_div", function () {
    // Don't reinitialize, just refresh data
    if (
      window.gomieCartPage &&
      typeof window.gomieCartPage.refreshCartTotals === "function"
    ) {
      window.gomieCartPage.refreshCartTotals();
    }
  });

  // Additional fallback for cart fragments
  $(document.body).on("wc_fragments_refreshed", function () {
    // Update cart count in header if it exists
    const cartCount = WC?.cart?.get_cart_contents_count?.() || 0;
    if (cartCount !== undefined) {
      $("#cart-header-btn .cart-count").text(cartCount);
    }
  });

  // Fallback: Use WooCommerce's built-in cart update if our AJAX fails
  $(document).on("submit", ".woocommerce-cart-form", function (e) {
    if (!window.gomieCartPage?.isUpdating) {
      // Allow normal form submission as fallback
      return true;
    }
    e.preventDefault();
    return false;
  });
})(jQuery);
