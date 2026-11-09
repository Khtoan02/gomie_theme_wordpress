/**
 * Gomie Cart Page - Optimized JavaScript
 * Clean, efficient code for cart functionality
 */

(function ($) {
  "use strict";

  class GomieCart {
    constructor() {
      this.form = $(".woocommerce-cart-form");
      this.isUpdating = false;
      this.init();
    }

    init() {
      this.bindEvents();
      this.hideDefaultButton();
      console.log("Gomie Cart initialized");
    }

    hideDefaultButton() {
      $('button[name="update_cart"]:not(.btn-update-cart)').hide();
    }

    bindEvents() {
      $(document)
        .on("click", ".qty-decrease", (e) => this.changeQuantity(e, -1))
        .on("click", ".qty-increase", (e) => this.changeQuantity(e, 1))
        .on("change", '.quantity input[type="number"]', (e) =>
          this.onQuantityChange(e)
        )
        .on("click", ".remove-item", (e) => this.removeItem(e))
        .on("click", ".btn-update-cart", (e) => this.updateCart(e))
        .on("click", ".btn-apply-coupon", (e) => this.applyCoupon(e))
        .on(
          "keypress",
          "#coupon_code",
          (e) => e.which === 13 && (e.preventDefault(), this.applyCoupon(e))
        );
    }

    // Quantity Management
    changeQuantity(e, delta) {
      e.preventDefault();
      const btn = $(e.currentTarget);
      const input = this.findQuantityInput(btn);
      const current = parseInt(input.val()) || 1;
      const max = parseInt(input.attr("max")) || 999;
      const newValue = Math.max(1, Math.min(max, current + delta));

      if (newValue !== current) {
        input.val(newValue).trigger("change");
        this.highlightChange(input);
        setTimeout(() => this.updateCartAjax(), 100);
      }
    }

    findQuantityInput(btn) {
      return (
        btn.siblings('input[type="number"]').first() ||
        btn
          .closest(".quantity-input-wrapper")
          .find('input[type="number"]')
          .first() ||
        $(`.quantity input[name="cart[${btn.data("cart-key")}][qty]"]`).first()
      );
    }

    onQuantityChange(e) {
      const input = $(e.currentTarget);
      const value = parseInt(input.val()) || 1;
      const min = parseInt(input.attr("min")) || 1;
      const max = parseInt(input.attr("max")) || 999;

      if (value < min) input.val(min);
      else if (value > max) input.val(max);

      this.highlightChange(input);
      setTimeout(() => this.updateCartAjax(), 100);
    }

    highlightChange(input) {
      const wrapper = input.closest(".quantity-input-wrapper");
      wrapper.addClass("updating");
      setTimeout(() => wrapper.removeClass("updating"), 200);
    }

    // Cart Updates
    updateCart(e) {
      e.preventDefault();
      const btn = $(e.currentTarget);

      btn.prop("disabled", true).text("Cập nhật...");
      this.updateCartAjax();

      setTimeout(() => {
        btn
          .prop("disabled", false)
          .html('<i class="fas fa-sync-alt"></i> Cập nhật giỏ hàng');
      }, 500);
    }

    updateCartAjax() {
      if (this.isUpdating) return;
      this.isUpdating = true;

      const data = this.form.serialize() + "&action=update_cart_item";
      const nonce = this.getNonce();

      $.ajax({
        url: this.getAjaxUrl(),
        type: "POST",
        data: data + (nonce ? "&woocommerce-cart-nonce=" + nonce : ""),
        dataType: "json",
        success: (response) => {
          if (response.success && response.data) {
            this.updateFragments(response.data.fragments);
            this.updateTotals(response.data);
            this.triggerEvents();
          }
        },
        error: (xhr) => console.error("Cart update error:", xhr.responseText),
        complete: () => {
          this.isUpdating = false;
          $(".cart-item-card").removeClass("updating");
        },
      });
    }

    // Item Removal
    removeItem(e) {
      e.preventDefault();
      const link = $(e.currentTarget);

      if (e.shiftKey) {
        this.removeItemAjax(link);
        return;
      }

      const productName = link
        .closest(".cart-item-card")
        .find(".cart-item-name")
        .text()
        .trim();
      this.showConfirmModal(
        "Xóa sản phẩm",
        `Xóa "${productName}" khỏi giỏ hàng?`,
        () => this.removeItemAjax(link)
      );
    }

    removeItemAjax(link) {
      const cartItem = link.closest(".cart-item-card");
      const url = link.attr("href");
      const params = new URLSearchParams(url.split("?")[1]);
      const itemKey = params.get("remove_item");
      const nonce = params.get("_wpnonce");

      if (!itemKey) {
        window.location.href = url;
        return;
      }

      cartItem.addClass("removing");

      $.ajax({
        url: this.getAjaxUrl(),
        type: "POST",
        data: {
          action: "remove_cart_item",
          cart_item_key: itemKey,
          security: nonce || this.getNonce(),
        },
        success: (response) => {
          if (response && response.success) {
            cartItem.slideUp(300, () => {
              cartItem.remove();
              this.updateFragments(response.data.fragments);
              this.updateTotals(response.data);
              this.triggerEvents();

              if (
                response.data.cart_count === 0 ||
                $(".cart-item-card").length === 0
              ) {
                this.showEmptyCart();
              }
            });
          } else {
            cartItem.removeClass("removing");
            window.location.href = url;
          }
        },
        error: () => {
          cartItem.removeClass("removing");
          window.location.href = url;
        },
      });
    }

    // Coupon Management
    applyCoupon(e) {
      e.preventDefault();
      const input = $("#coupon_code");
      const btn = $(".btn-apply-coupon");
      const code = input.val().trim();

      this.clearCouponMessage();

      if (!code) {
        this.showCouponMessage("Vui lòng nhập mã giảm giá", "error");
        return;
      }

      btn
        .prop("disabled", true)
        .html('<i class="fas fa-spinner fa-spin"></i> Đang áp dụng...');

      $.ajax({
        url: this.getAjaxUrl(),
        type: "POST",
        data: {
          action: "apply_coupon_ajax",
          coupon_code: code,
          security: this.getNonce(),
        },
        success: (response) => {
          if (response.success) {
            this.showCouponMessage(
              "✅ Mã giảm giá đã được áp dụng thành công!",
              "success"
            );
            input.val("");
            this.updateFragments(response.data.fragments);
            this.updateTotals(response.data);
            this.triggerEvents();
          } else {
            const msg = response.data?.message || "Mã giảm giá không hợp lệ";
            this.showCouponMessage("❌ " + msg, "error");
          }
        },
        error: () =>
          this.showCouponMessage(
            "❌ Có lỗi xảy ra khi áp dụng mã giảm giá",
            "error"
          ),
        complete: () => {
          btn
            .prop("disabled", false)
            .html('<i class="fas fa-check"></i> Áp dụng');
        },
      });
    }

    // UI Updates
    updateFragments(fragments) {
      if (fragments) {
        $.each(fragments, (selector, html) => {
          const $target = $(selector);
          if ($target.length) $target.replaceWith(html);
        });
      }
    }

    updateTotals(data) {
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
        $(".section-badge, .summary-badge").text(data.cart_count + " sản phẩm");
      }
    }

    triggerEvents() {
      $(document.body).trigger("updated_wc_div wc_fragments_refreshed");
    }

    // Modals & Messages
    showConfirmModal(title, message, onConfirm) {
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
              <button class="btn cancel-btn">Hủy</button>
              <button class="btn confirm-btn btn-danger">Xóa</button>
            </div>
          </div>
        </div>
      `);

      $("body").append(modal);
      this.addModalStyles();

      modal.find(".confirm-btn").on("click", () => {
        onConfirm();
        modal.remove();
      });

      modal
        .find(".cancel-btn, .modal-close, .gomie-modal-overlay")
        .on("click", () => {
          modal.remove();
        });

      setTimeout(() => modal.remove(), 5000);
    }

    addModalStyles() {
      if ($("#gomie-modal-styles").length) return;

      $("head").append(`
        <style id="gomie-modal-styles">
        .gomie-modal-overlay {
          position: fixed; top: 0; left: 0; width: 100%; height: 100%;
          background: rgba(0, 0, 0, 0.5); display: flex; align-items: center;
          justify-content: center; z-index: 10000; animation: fadeIn 0.2s ease;
        }
        .gomie-modal {
          background: #fff; border-radius: 12px; max-width: 400px; width: 90%;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); animation: slideIn 0.3s ease;
        }
        .modal-header { padding: 1.5rem; border-bottom: 1px solid #e9ecef; display: flex;
          justify-content: space-between; align-items: center; }
        .modal-header h3 { margin: 0; color: #333; font-size: 1.2rem; }
        .modal-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #999; }
        .modal-body { padding: 1.5rem; }
        .modal-body p { margin: 0; color: #666; line-height: 1.5; }
        .modal-footer { padding: 1.5rem; border-top: 1px solid #e9ecef; display: flex;
          gap: 1rem; justify-content: flex-end; }
        .modal-footer .btn { padding: 0.6rem 1.2rem; border-radius: 6px; border: none;
          cursor: pointer; font-weight: 500; transition: all 0.2s ease; }
        .cancel-btn { background: #f8f9fa; color: #333; border: 1px solid #dee2e6; }
        .cancel-btn:hover { background: #e9ecef; }
        .btn-danger { background: #dc3545; color: #fff; }
        .btn-danger:hover { background: #c82333; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideIn { from { transform: translateY(-20px); opacity: 0; }
          to { transform: translateY(0); opacity: 1; } }
        </style>
      `);
    }

    showCouponMessage(message, type) {
      const className = type === "success" ? "coupon-success" : "coupon-error";
      const html = `<div class="coupon-message ${className}">${message}</div>`;

      $(".coupon-messages-container").html(html);

      if (type === "success") {
        setTimeout(() => this.clearCouponMessage(), 5000);
      }
    }

    clearCouponMessage() {
      $(".coupon-messages-container").empty();
    }

    showEmptyCart() {
      const html = `
        <div class="cart-empty-state">
          <div class="empty-cart-icon"><i class="fas fa-shopping-cart"></i></div>
          <h2>Giỏ hàng trống</h2>
          <p>Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
          <a href="/shop" class="btn-continue-shopping">
            <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
          </a>
        </div>
      `;
      $(".cart-content-wrapper").replaceWith(html);
    }

    // Utilities
    getAjaxUrl() {
      return (
        (typeof gomie_cart_params !== "undefined"
          ? gomie_cart_params.ajax_url
          : wc_add_to_cart_params?.ajax_url) || ajaxurl
      );
    }

    getNonce() {
      return (
        $('[name="woocommerce-cart-nonce"]').val() ||
        (typeof gomie_cart_params !== "undefined"
          ? gomie_cart_params.nonce
          : "") ||
        (typeof wc_add_to_cart_params !== "undefined"
          ? wc_add_to_cart_params.wc_ajax_nonce
          : "")
      );
    }
  }

  // Initialize
  $(document).ready(() => {
    if ($(".gomie-cart-container").length) {
      window.gomieCart = new GomieCart();
    }
  });

  // Handle WooCommerce updates
  $(document.body).on("updated_wc_div", () => {
    if (
      window.gomieCart &&
      typeof window.gomieCart.updateTotals === "function"
    ) {
      // Refresh cart data
      $.ajax({
        url:
          (typeof gomie_cart_params !== "undefined"
            ? gomie_cart_params.ajax_url
            : wc_add_to_cart_params?.ajax_url) || ajaxurl,
        type: "POST",
        data: { action: "get_cart_totals" },
        success: (response) => {
          if (response.success) {
            window.gomieCart.updateTotals(response.data);
          }
        },
      });
    }
  });

  // Fallback form submission
  $(document).on("submit", ".woocommerce-cart-form", (e) => {
    if (!window.gomieCart?.isUpdating) {
      return true; // Allow normal submission
    }
    e.preventDefault();
    return false;
  });
})(jQuery);
