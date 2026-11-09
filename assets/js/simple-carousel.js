/**
 * Simple CSS Carousel JavaScript
 * Fallback implementation without external dependencies
 */

(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    console.log("Simple carousel script loaded");

    // Initialize simple carousels
    document
      .querySelectorAll(".category-products-simple-carousel")
      .forEach(function (carousel) {
        var container = carousel.querySelector(".simple-carousel-container");
        var slides = carousel.querySelectorAll(".simple-carousel-slide");
        var prevBtn = carousel.querySelector(".simple-carousel-nav.prev");
        var nextBtn = carousel.querySelector(".simple-carousel-nav.next");
        var indicators = carousel.querySelector(".simple-carousel-indicators");

        if (!container || slides.length === 0) return;

        var currentIndex = 0;
        var slideWidth = slides[0].offsetWidth + 16; // width + gap
        var maxIndex = slides.length - 1;

        // Create indicators
        if (indicators) {
          indicators.innerHTML = "";
          for (var i = 0; i < slides.length; i++) {
            var indicator = document.createElement("div");
            indicator.className =
              "carousel-indicator" + (i === 0 ? " active" : "");
            indicator.onclick = (function (index) {
              return function () {
                goToSlide(index);
              };
            })(i);
            indicators.appendChild(indicator);
          }
        }

        function updateIndicators() {
          if (indicators) {
            var dots = indicators.querySelectorAll(".carousel-indicator");
            dots.forEach(function (dot, index) {
              dot.classList.toggle("active", index === currentIndex);
            });
          }
        }

        function goToSlide(index) {
          if (index < 0) index = maxIndex;
          if (index > maxIndex) index = 0;

          currentIndex = index;
          container.scrollTo({
            left: index * slideWidth,
            behavior: "smooth",
          });

          updateIndicators();
        }

        // Navigation buttons
        if (prevBtn) {
          prevBtn.onclick = function () {
            goToSlide(currentIndex - 1);
          };
        }

        if (nextBtn) {
          nextBtn.onclick = function () {
            goToSlide(currentIndex + 1);
          };
        }

        // Auto-play
        var autoplayInterval;
        function startAutoplay() {
          autoplayInterval = setInterval(function () {
            goToSlide(currentIndex + 1);
          }, 5000);
        }

        function stopAutoplay() {
          if (autoplayInterval) {
            clearInterval(autoplayInterval);
          }
        }

        // Start autoplay
        startAutoplay();

        // Pause on hover
        carousel.addEventListener("mouseenter", stopAutoplay);
        carousel.addEventListener("mouseleave", startAutoplay);

        // Touch/scroll handling
        var isScrolling = false;
        container.addEventListener("scroll", function () {
          if (!isScrolling) {
            isScrolling = true;

            // Update current index based on scroll position
            var scrollLeft = container.scrollLeft;
            var newIndex = Math.round(scrollLeft / slideWidth);

            if (newIndex !== currentIndex) {
              currentIndex = newIndex;
              updateIndicators();
            }

            setTimeout(function () {
              isScrolling = false;
            }, 150);
          }
        });

        console.log(
          "Simple carousel initialized with",
          slides.length,
          "slides"
        );
      });
  });
})();
