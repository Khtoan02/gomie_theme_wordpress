/**
 * Restaurant Category Page JavaScript
 * Handles interactive features for the restaurant category page
 */

(function ($) {
  "use strict";

  // DOM Ready
  $(document).ready(function () {
    initRestaurantCategory();
  });

  function initRestaurantCategory() {
    initFloatingWidgets();
    initEnhancedGallery();
    initMasonryGrid();
    initProductFilters();
    initImageModal();
    initSmoothScrolling();
    initLazyLoading();
    initAnimations();
    initContactForms();
  }

  /**
   * Initialize Floating Widgets Sidebar
   */
  function initFloatingWidgets() {
    const $floatingWidgets = $("#floatingWidgets");
    const $toggleBtn = $("#widgetToggle");

    // Toggle sidebar
    $toggleBtn.on("click", function () {
      $floatingWidgets.toggleClass("active");

      // Update icon and text
      const isActive = $floatingWidgets.hasClass("active");
      $(this)
        .find("i")
        .removeClass("fas fa-bars fas fa-times")
        .addClass(isActive ? "fas fa-times" : "fas fa-bars");
      $(this)
        .find(".toggle-text")
        .text(isActive ? "Đóng" : "Menu");
    });

    // Close on click outside
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".floating-widget-sidebar").length) {
        $floatingWidgets.removeClass("active");
        $toggleBtn
          .find("i")
          .removeClass("fas fa-times")
          .addClass("fas fa-bars");
        $toggleBtn.find(".toggle-text").text("Menu");
      }
    });

    // Close on escape key
    $(document).on("keydown", function (e) {
      if (e.key === "Escape" && $floatingWidgets.hasClass("active")) {
        $floatingWidgets.removeClass("active");
        $toggleBtn
          .find("i")
          .removeClass("fas fa-times")
          .addClass("fas fa-bars");
        $toggleBtn.find(".toggle-text").text("Menu");
      }
    });

    // Auto-show on desktop scroll
    $(window).on(
      "scroll",
      throttle(function () {
        const scrollTop = $(this).scrollTop();

        if (window.innerWidth > 992) {
          if (scrollTop > 500) {
            $floatingWidgets.addClass("auto-visible");
          } else {
            $floatingWidgets.removeClass("auto-visible");
          }
        }
      }, 100)
    );
  }

  /**
   * Initialize Enhanced Gallery
   */
  function initEnhancedGallery() {
    const $galleryGrid = $(".masonry-gallery-grid");
    const $galleryFilters = $(".gallery-filter");
    const $favoriteButtons = $(".favorite-btn");
    const $shareButtons = $(".share-btn");

    // Gallery filter functionality
    $galleryFilters.on("click", function () {
      const $this = $(this);
      const filter = $this.data("filter");

      // Update active state
      $galleryFilters.removeClass("active");
      $this.addClass("active");

      // Filter gallery items
      filterGalleryItems(filter);
    });

    // Favorite functionality
    $favoriteButtons.on("click", function (e) {
      e.stopPropagation();
      const $this = $(this);
      const imageId = $this.data("image-id");

      $this.toggleClass("active");

      // Update icon
      const icon = $this.find("i");
      if ($this.hasClass("active")) {
        icon.removeClass("far fa-heart").addClass("fas fa-heart");
        showNotification("Đã thêm vào yêu thích!", "success");

        // Store in localStorage
        let favorites = JSON.parse(
          localStorage.getItem("restaurant_favorites") || "[]"
        );
        if (!favorites.includes(imageId)) {
          favorites.push(imageId);
          localStorage.setItem(
            "restaurant_favorites",
            JSON.stringify(favorites)
          );
        }
      } else {
        icon.removeClass("fas fa-heart").addClass("far fa-heart");
        showNotification("Đã xóa khỏi yêu thích!", "info");

        // Remove from localStorage
        let favorites = JSON.parse(
          localStorage.getItem("restaurant_favorites") || "[]"
        );
        favorites = favorites.filter((id) => id !== imageId);
        localStorage.setItem("restaurant_favorites", JSON.stringify(favorites));
      }
    });

    // Share functionality
    $shareButtons.on("click", function (e) {
      e.stopPropagation();
      const imageUrl = $(this).data("image-url");

      if (navigator.share) {
        navigator
          .share({
            title: "Hình ảnh nhà hàng - Gomie",
            text: "Khám phá không gian nhà hàng đẳng cấp với sản phẩm gốm sứ Gomie",
            url: imageUrl,
          })
          .catch((err) => console.log("Error sharing:", err));
      } else {
        // Fallback: copy to clipboard
        navigator.clipboard
          .writeText(imageUrl)
          .then(() => {
            showNotification("Đã copy link hình ảnh!", "success");
          })
          .catch(() => {
            showNotification("Không thể copy link", "error");
          });
      }
    });

    // Load favorites from localStorage
    loadFavorites();

    function filterGalleryItems(filter) {
      const $items = $galleryGrid.find(".gallery-item");

      if (filter === "all") {
        $items.fadeIn(300);
      } else {
        $items.each(function () {
          const $item = $(this);
          const category = $item.data("category");

          if (category === filter) {
            $item.fadeIn(300);
          } else {
            $item.fadeOut(300);
          }
        });
      }

      // No need for masonry layout recalculation with CSS Grid
      // The CSS Grid will automatically adjust
    }

    function loadFavorites() {
      const favorites = JSON.parse(
        localStorage.getItem("restaurant_favorites") || "[]"
      );

      favorites.forEach((imageId) => {
        const $btn = $(`.favorite-btn[data-image-id="${imageId}"]`);
        $btn.addClass("active");
        $btn.find("i").removeClass("far fa-heart").addClass("fas fa-heart");
      });
    }
  }

  /**
   * Initialize Masonry Grid (CSS Grid based - no JavaScript needed)
   */
  function initMasonryGrid() {
    // CSS Grid handles the layout automatically
    // Just trigger AOS refresh for animations
    if (typeof AOS !== "undefined") {
      // Wait for images to load before triggering AOS
      const images = document.querySelectorAll(".gallery-image");
      let loadedImages = 0;
      const totalImages = images.length;

      if (totalImages === 0) {
        AOS.refresh();
        return;
      }

      images.forEach((img) => {
        if (img.complete) {
          loadedImages++;
          if (loadedImages === totalImages) {
            AOS.refresh();
          }
        } else {
          img.addEventListener("load", () => {
            loadedImages++;
            if (loadedImages === totalImages) {
              AOS.refresh();
            }
          });
        }
      });
    }
  }

  /**
   * Initialize Product Filters
   */
  function initProductFilters() {
    const $filterTabs = $(".filter-tab");
    const $sortSelect = $("#sortProducts");
    const $productGrid = $(".gomie-product-grid");

    // Filter tabs functionality
    $filterTabs.on("click", function (e) {
      e.preventDefault();

      const $this = $(this);
      const filter = $this.data("filter");

      // Update active state
      $filterTabs.removeClass("active");
      $this.addClass("active");

      // Filter products
      filterProducts(filter);
    });

    // Sort functionality
    $sortSelect.on("change", function () {
      const sortBy = $(this).val();
      sortProducts(sortBy);
    });

    function filterProducts(filter) {
      const $products = $productGrid.find(".gomie-product-item");

      if (filter === "all") {
        $products.fadeIn(300);
      } else {
        $products.each(function () {
          const $product = $(this);
          const categories = $product
            .find(".category-label")
            .text()
            .toLowerCase();

          if (categories.includes(filter) || $product.hasClass(filter)) {
            $product.fadeIn(300);
          } else {
            $product.fadeOut(300);
          }
        });
      }

      // Trigger layout recalculation
      setTimeout(function () {
        $(window).trigger("resize");
      }, 350);
    }

    function sortProducts(sortBy) {
      const $products = $productGrid.find(".gomie-product-item");
      const $container = $productGrid;

      let sortedProducts;

      switch (sortBy) {
        case "price-asc":
          sortedProducts = $products.sort(function (a, b) {
            const priceA =
              parseFloat(
                $(a)
                  .find(".product-price")
                  .text()
                  .replace(/[^\d.]/g, "")
              ) || 0;
            const priceB =
              parseFloat(
                $(b)
                  .find(".product-price")
                  .text()
                  .replace(/[^\d.]/g, "")
              ) || 0;
            return priceA - priceB;
          });
          break;

        case "price-desc":
          sortedProducts = $products.sort(function (a, b) {
            const priceA =
              parseFloat(
                $(a)
                  .find(".product-price")
                  .text()
                  .replace(/[^\d.]/g, "")
              ) || 0;
            const priceB =
              parseFloat(
                $(b)
                  .find(".product-price")
                  .text()
                  .replace(/[^\d.]/g, "")
              ) || 0;
            return priceB - priceA;
          });
          break;

        case "popularity":
          sortedProducts = $products.sort(function (a, b) {
            const salesA =
              parseInt(
                $(a).find(".stat-value").eq(1).text().replace(/[^\d]/g, "")
              ) || 0;
            const salesB =
              parseInt(
                $(b).find(".stat-value").eq(1).text().replace(/[^\d]/g, "")
              ) || 0;
            return salesB - salesA;
          });
          break;

        case "rating":
          sortedProducts = $products.sort(function (a, b) {
            const ratingA = $(a).find(".star-rating .filled").length || 0;
            const ratingB = $(b).find(".star-rating .filled").length || 0;
            return ratingB - ratingA;
          });
          break;

        case "date":
          sortedProducts = $products.sort(function (a, b) {
            const dateA = new Date($(a).data("date") || 0);
            const dateB = new Date($(b).data("date") || 0);
            return dateB - dateA;
          });
          break;

        default:
          return;
      }

      // Animate and reorder
      $products.fadeOut(200, function () {
        $container.append(sortedProducts);
        $products.fadeIn(300);
      });
    }
  }

  /**
   * Initialize Image Modal
   */
  function initImageModal() {
    const $modal = $("#imageModal");
    const $modalImage = $("#modalImage");
    const $modalTitle = $("#imageModalLabel");

    $(".view-image").on("click", function (e) {
      e.preventDefault();

      const imageUrl = $(this).data("image");
      const imageTitle = $(this).data("title");

      $modalImage.attr("src", imageUrl);
      $modalImage.attr("alt", imageTitle);
      $modalTitle.text(imageTitle);
    });

    // Preload next/previous images for smooth navigation
    $modal.on("shown.bs.modal", function () {
      const currentSrc = $modalImage.attr("src");
      const $allImages = $(".view-image");
      const currentIndex = $allImages.index(
        $('[data-image="' + currentSrc + '"]')
      );

      // Preload adjacent images
      if (currentIndex > 0) {
        const prevSrc = $allImages.eq(currentIndex - 1).data("image");
        $("<img>").attr("src", prevSrc);
      }

      if (currentIndex < $allImages.length - 1) {
        const nextSrc = $allImages.eq(currentIndex + 1).data("image");
        $("<img>").attr("src", nextSrc);
      }
    });

    // Keyboard navigation
    $(document).on("keydown", function (e) {
      if ($modal.hasClass("show")) {
        const currentSrc = $modalImage.attr("src");
        const $allImages = $(".view-image");
        const currentIndex = $allImages.index(
          $('[data-image="' + currentSrc + '"]')
        );

        if (e.key === "ArrowLeft" && currentIndex > 0) {
          const $prevImage = $allImages.eq(currentIndex - 1);
          $modalImage.attr("src", $prevImage.data("image"));
          $modalTitle.text($prevImage.data("title"));
        } else if (
          e.key === "ArrowRight" &&
          currentIndex < $allImages.length - 1
        ) {
          const $nextImage = $allImages.eq(currentIndex + 1);
          $modalImage.attr("src", $nextImage.data("image"));
          $modalTitle.text($nextImage.data("title"));
        }
      }
    });
  }

  /**
   * Initialize Smooth Scrolling
   */
  function initSmoothScrolling() {
    $('a[href^="#"]').on("click", function (e) {
      const target = $($(this).attr("href"));

      if (target.length) {
        e.preventDefault();

        $("html, body").animate(
          {
            scrollTop: target.offset().top - 100,
          },
          800,
          "easeInOutCubic"
        );
      }
    });
  }

  /**
   * Initialize Lazy Loading
   */
  function initLazyLoading() {
    if ("IntersectionObserver" in window) {
      const imageObserver = new IntersectionObserver(function (
        entries,
        observer
      ) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const img = entry.target;
            const src = img.dataset.src;

            if (src) {
              img.src = src;
              img.classList.remove("lazy");
              img.classList.add("loaded");
              observer.unobserve(img);
            }
          }
        });
      });

      document.querySelectorAll("img[data-src]").forEach(function (img) {
        imageObserver.observe(img);
      });
    }
  }

  /**
   * Initialize Animations
   */
  function initAnimations() {
    // Initialize AOS (Animate On Scroll) if available
    if (typeof AOS !== "undefined") {
      AOS.init({
        duration: 800,
        easing: "ease-in-out-cubic",
        once: true,
        offset: 100,
        disable: function () {
          return window.innerWidth < 768;
        },
      });
    }

    // Custom scroll animations
    const $animatedElements = $("[data-animate]");

    if ($animatedElements.length) {
      const observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              const element = entry.target;
              const animation = element.dataset.animate;

              element.classList.add("animate-" + animation);
              observer.unobserve(element);
            }
          });
        },
        {
          threshold: 0.1,
          rootMargin: "0px 0px -50px 0px",
        }
      );

      $animatedElements.each(function () {
        observer.observe(this);
      });
    }

    // Parallax effect for hero background
    $(window).on("scroll", function () {
      const scrolled = $(this).scrollTop();
      const parallaxSpeed = 0.5;

      $(".hero-bg-image").css(
        "transform",
        "translateY(" + scrolled * parallaxSpeed + "px)"
      );
    });

    // Counter animation for stats
    $(".stat-number").each(function () {
      const $this = $(this);
      const countTo = $this.text();

      if (!isNaN(countTo)) {
        const observer = new IntersectionObserver(function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              $({ countNum: 0 }).animate(
                {
                  countNum: countTo,
                },
                {
                  duration: 2000,
                  easing: "swing",
                  step: function () {
                    $this.text(Math.floor(this.countNum));
                  },
                  complete: function () {
                    $this.text(countTo);
                  },
                }
              );
              observer.unobserve(entry.target);
            }
          });
        });

        observer.observe(this);
      }
    });
  }

  /**
   * Initialize Contact Forms
   */
  function initContactForms() {
    // Handle consultation modal
    $("#consultModal").on("show.bs.modal", function () {
      // Reset form if exists
      const $form = $(this).find("form");
      if ($form.length) {
        $form[0].reset();
      }
    });

    // Handle contact form submissions
    $(".contact-form").on("submit", function (e) {
      e.preventDefault();

      const $form = $(this);
      const $submitBtn = $form.find('[type="submit"]');
      const originalText = $submitBtn.text();

      // Show loading state
      $submitBtn.prop("disabled", true).text("Đang gửi...");

      // Simulate form submission (replace with actual AJAX call)
      setTimeout(function () {
        // Show success message
        showNotification(
          "Cảm ơn bạn! Chúng tôi sẽ liên hệ trong thời gian sớm nhất.",
          "success"
        );

        // Reset form
        $form[0].reset();

        // Close modal if in modal
        const $modal = $form.closest(".modal");
        if ($modal.length) {
          $modal.modal("hide");
        }

        // Reset button
        $submitBtn.prop("disabled", false).text(originalText);
      }, 2000);
    });
  }

  /**
   * Show notification
   */
  function showNotification(message, type = "info") {
    const $notification = $(`
            <div class="alert alert-${type} alert-dismissible fade show notification-toast" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);

    $("body").append($notification);

    // Auto dismiss after 5 seconds
    setTimeout(function () {
      $notification.alert("close");
    }, 5000);
  }

  /**
   * Utility: Check if element is in viewport
   */
  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top >= 0 &&
      rect.left >= 0 &&
      rect.bottom <=
        (window.innerHeight || document.documentElement.clientHeight) &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  }

  /**
   * Utility: Debounce function
   */
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

  /**
   * Performance optimization: Throttle scroll events
   */
  function throttle(func, limit) {
    let inThrottle;
    return function () {
      const args = arguments;
      const context = this;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => (inThrottle = false), limit);
      }
    };
  }

  // Apply throttling to scroll events
  $(window).on(
    "scroll",
    throttle(function () {
      // Scroll-based animations and effects
      const scrollTop = $(this).scrollTop();

      // Update header on scroll
      if (scrollTop > 100) {
        $("body").addClass("scrolled");
      } else {
        $("body").removeClass("scrolled");
      }

      // Update progress indicator if exists
      const $progressBar = $(".scroll-progress");
      if ($progressBar.length) {
        const scrollHeight = $(document).height() - $(window).height();
        const scrollPercent = (scrollTop / scrollHeight) * 100;
        $progressBar.css("width", scrollPercent + "%");
      }
    }, 16)
  ); // ~60fps
})(jQuery);

// Vanilla JS fallback for essential functionality
document.addEventListener("DOMContentLoaded", function () {
  // Basic image loading fallback
  const images = document.querySelectorAll("img[data-src]");

  images.forEach(function (img) {
    const src = img.getAttribute("data-src");
    if (src) {
      img.src = src;
      img.removeAttribute("data-src");
    }
  });

  // Basic modal functionality fallback
  const modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');

  modalTriggers.forEach(function (trigger) {
    trigger.addEventListener("click", function (e) {
      e.preventDefault();
      const targetId = this.getAttribute("data-bs-target");
      const modal = document.querySelector(targetId);

      if (modal) {
        modal.style.display = "block";
        modal.classList.add("show");
        document.body.classList.add("modal-open");

        // Close modal functionality
        const closeButtons = modal.querySelectorAll(
          '[data-bs-dismiss="modal"], .btn-close'
        );
        closeButtons.forEach(function (btn) {
          btn.addEventListener("click", function () {
            modal.style.display = "none";
            modal.classList.remove("show");
            document.body.classList.remove("modal-open");
          });
        });

        // Close on backdrop click
        modal.addEventListener("click", function (e) {
          if (e.target === modal) {
            modal.style.display = "none";
            modal.classList.remove("show");
            document.body.classList.remove("modal-open");
          }
        });
      }
    });
  });
});
