/**
 * Gomie Checkout Page JavaScript
 * Enhanced UX for checkout process with smooth interactions
 */

(function ($) {
  "use strict";

  class GomieCheckout {
    constructor() {
      this.form = $("form.checkout");
      this.isProcessing = false;
      this.init();
    }

    init() {
      this.bindEvents();
      this.enhanceFormFields();
      this.setupValidation();
      console.log("Gomie Checkout initialized");
    }

    bindEvents() {
      // Form submission
      $(document).on("submit", "form.checkout", (e) => this.onSubmit(e));

      // Payment method selection
      $(document).on("change", 'input[name="payment_method"]', (e) =>
        this.onPaymentMethodChange(e)
      );

      // Field validation
      $(document).on(
        "blur",
        ".checkout input, .checkout select, .checkout textarea",
        (e) => this.validateField(e)
      );

      // Terms checkbox
      $(document).on("change", "#terms", (e) => this.onTermsChange(e));

      // Real-time form updates
      $(document).on("change", ".checkout input, .checkout select", () =>
        this.updateCheckout()
      );
    }

    onSubmit(e) {
      if (this.isProcessing) {
        e.preventDefault();
        return false;
      }

      const placeOrderBtn = $("#place_order");

      // Show loading state
      this.isProcessing = true;
      placeOrderBtn.addClass("loading");
      placeOrderBtn.find(".main-text").text("Đang xử lý...");
      placeOrderBtn.find(".sub-text").text("Vui lòng đợi");

      // Add processing overlay
      $(".gomie-checkout-container").addClass("processing-checkout");

      // Let WooCommerce handle the rest
      return true;
    }

    onPaymentMethodChange(e) {
      const selectedMethod = $(e.currentTarget);
      const methodId = selectedMethod.val();

      // Update payment method styling
      $(".payment_methods li").removeClass("payment_method_selected");
      selectedMethod.closest("li").addClass("payment_method_selected");

      // Show/hide payment method descriptions
      $(".payment_method_description").slideUp(200);
      selectedMethod
        .closest("li")
        .find(".payment_method_description")
        .slideDown(300);

      // Update place order button text based on payment method
      this.updatePlaceOrderButton(methodId);
    }

    updatePlaceOrderButton(methodId) {
      const placeOrderBtn = $("#place_order");
      const mainText = placeOrderBtn.find(".main-text");
      const subText = placeOrderBtn.find(".sub-text");

      const buttonTexts = {
        bacs: { main: "Đặt hàng", sub: "Chuyển khoản ngân hàng" },
        cod: { main: "Đặt hàng", sub: "Thanh toán khi nhận hàng" },
        paypal: { main: "Thanh toán PayPal", sub: "An toàn & nhanh chóng" },
        stripe: { main: "Thanh toán thẻ", sub: "Visa, MasterCard" },
        default: { main: "Đặt hàng", sub: "Thanh toán an toàn" },
      };

      const text = buttonTexts[methodId] || buttonTexts.default;
      mainText.text(text.main);
      subText.text(text.sub);
    }

    validateField(e) {
      const field = $(e.currentTarget);
      const value = field.val().trim();
      const isRequired =
        field.closest(".form-row").find("label .required").length > 0;

      // Remove previous validation classes
      field
        .closest(".form-row")
        .removeClass("woocommerce-invalid woocommerce-validated");

      if (isRequired && !value) {
        field.closest(".form-row").addClass("woocommerce-invalid");
        return false;
      } else if (value) {
        // Basic validation for common field types
        if (this.validateFieldType(field, value)) {
          field.closest(".form-row").addClass("woocommerce-validated");
          return true;
        } else {
          field.closest(".form-row").addClass("woocommerce-invalid");
          return false;
        }
      }

      return true;
    }

    validateFieldType(field, value) {
      const fieldType =
        field.attr("type") || field.prop("tagName").toLowerCase();
      const fieldName = field.attr("name") || "";

      switch (fieldType) {
        case "email":
          return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        case "tel":
          return /^[\d\s\-\+\(\)]+$/.test(value);
        default:
          if (fieldName.includes("email")) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
          }
          if (fieldName.includes("phone") || fieldName.includes("tel")) {
            return /^[\d\s\-\+\(\)]+$/.test(value);
          }
          return value.length >= 2; // Minimum length validation
      }
    }

    onTermsChange(e) {
      const checkbox = $(e.currentTarget);
      const placeOrderBtn = $("#place_order");

      if (checkbox.is(":checked")) {
        placeOrderBtn.prop("disabled", false);
        placeOrderBtn.removeClass("disabled");
      } else {
        placeOrderBtn.prop("disabled", true);
        placeOrderBtn.addClass("disabled");
      }
    }

    updateCheckout() {
      // Debounce checkout updates
      clearTimeout(this.updateTimeout);
      this.updateTimeout = setTimeout(() => {
        $(document.body).trigger("update_checkout");
      }, 500);
    }

    enhanceFormFields() {
      // Add floating labels effect
      $(".form-row input, .form-row select, .form-row textarea").each(
        function () {
          const field = $(this);
          const label = field.closest(".form-row").find("label");

          if (field.val()) {
            label.addClass("has-value");
          }

          field.on("focus", () => label.addClass("focused"));
          field.on("blur", () => {
            label.removeClass("focused");
            if (field.val()) {
              label.addClass("has-value");
            } else {
              label.removeClass("has-value");
            }
          });
        }
      );

      // Enhance select fields
      $(".form-row select").wrap('<div class="select-wrapper"></div>');
    }

    setupValidation() {
      // Real-time validation feedback
      $(".checkout input[required], .checkout select[required]").on(
        "invalid",
        function (e) {
          e.preventDefault();
          const field = $(this);
          const row = field.closest(".form-row");

          row.addClass("woocommerce-invalid");

          // Custom validation messages
          const fieldName = field
            .closest(".form-row")
            .find("label")
            .text()
            .replace("*", "")
            .trim();
          this.showValidationMessage(row, `${fieldName} là bắt buộc`);
        }
      );
    }

    showValidationMessage(row, message) {
      // Remove existing message
      row.find(".validation-message").remove();

      // Add new message
      const messageHtml = `<div class="validation-message">${message}</div>`;
      row.append(messageHtml);

      // Auto-remove after 5 seconds
      setTimeout(() => {
        row.find(".validation-message").fadeOut(300, function () {
          $(this).remove();
        });
      }, 5000);
    }

    showNotification(message, type = "info", duration = 4000) {
      // Remove existing notifications
      $(".gomie-checkout-notification").remove();

      const notification = $(`
        <div class="gomie-checkout-notification ${type}">
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

      // Add notification styles
      if (!$("#gomie-checkout-notification-styles").length) {
        this.addNotificationStyles();
      }

      // Auto-remove
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
      $("head").append(`
        <style id="gomie-checkout-notification-styles">
        .gomie-checkout-notification {
          position: fixed; top: 20px; right: 20px; z-index: 9999;
          max-width: 400px; border-radius: 8px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
          animation: slideInRight 0.3s ease;
        }
        .gomie-checkout-notification.success {
          background: #d4edda; border-left: 4px solid #28a745; color: #155724;
        }
        .gomie-checkout-notification.error {
          background: #f8d7da; border-left: 4px solid #dc3545; color: #721c24;
        }
        .gomie-checkout-notification.warning {
          background: #fff3cd; border-left: 4px solid #ffc107; color: #856404;
        }
        .gomie-checkout-notification.info {
          background: #d1ecf1; border-left: 4px solid #17a2b8; color: #0c5460;
        }
        .notification-content {
          padding: 1rem 1.5rem; display: flex; align-items: center; gap: 0.8rem;
        }
        .notification-icon { font-size: 1.2rem; flex-shrink: 0; }
        .notification-message { flex: 1; font-weight: 500; }
        .notification-close {
          background: none; border: none; font-size: 1.2rem;
          cursor: pointer; opacity: 0.7; flex-shrink: 0;
        }
        .notification-close:hover { opacity: 1; }
        @keyframes slideInRight {
          from { transform: translateX(100%); opacity: 0; }
          to { transform: translateX(0); opacity: 1; }
        }
        @media (max-width: 768px) {
          .gomie-checkout-notification {
            top: 10px; right: 10px; left: 10px; max-width: none;
          }
        }
        </style>
      `);
    }
  }

  // Initialize when DOM is ready
  $(document).ready(() => {
    if ($(".gomie-checkout-container").length) {
      window.gomieCheckout = new GomieCheckout();
    }
  });

  // Handle WooCommerce checkout updates
  $(document.body).on("updated_checkout", () => {
    // Reinitialize enhanced fields after checkout update
    if (window.gomieCheckout) {
      window.gomieCheckout.enhanceFormFields();
    }
  });

  // Handle checkout errors
  $(document.body).on("checkout_error", () => {
    if (window.gomieCheckout) {
      window.gomieCheckout.isProcessing = false;
      $(".place-order-button").removeClass("loading");
      $(".gomie-checkout-container").removeClass("processing-checkout");

      // Reset place order button
      const placeOrderBtn = $("#place_order");
      placeOrderBtn.find(".main-text").text("Đặt hàng");
      placeOrderBtn.find(".sub-text").text("Thanh toán an toàn");
    }
  });
})(jQuery);

