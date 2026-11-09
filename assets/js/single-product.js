/**
 * Single Product JavaScript - GOMIE CERAMIC
 * Modern gallery thumbnail switcher, Lightbox Pop Up & quantity stepper
 *
 * @package Gomie
 * @version 1.2.0
 */

(function($) {
  'use strict';

  $(document).ready(function() {
    // 1. Pop Up Lightbox Logic
    var $galleryCard = $('.gomie-main-gallery-card');
    var galleryImages = [];
    try {
      var rawImages = $galleryCard.attr('data-images');
      if (rawImages) {
        galleryImages = JSON.parse(rawImages);
      }
    } catch (err) {
      galleryImages = [];
    }

    if (!galleryImages.length) {
      var fallbackSrc = $('#gomie-main-product-img').attr('src');
      if (fallbackSrc) galleryImages = [fallbackSrc];
    }

    var currentLightboxIdx = 0;
    var $lightboxModal = $('#gomie-lightbox-modal');
    var $lightboxImg = $('#gomie-lightbox-current-img');
    var $lightboxIdx = $('#gomie-lightbox-idx');
    var $lightboxTotal = $('#gomie-lightbox-total');

    if ($lightboxTotal.length) {
      $lightboxTotal.text(galleryImages.length);
    }

    // Hide arrows if only 1 image
    if (galleryImages.length <= 1) {
      $('.gomie-lightbox-arrow').hide();
      $('.lightbox-image-counter').hide();
    }

    function openLightbox(url) {
      var idx = galleryImages.indexOf(url);
      if (idx === -1) idx = 0;
      currentLightboxIdx = idx;

      updateLightboxView();
      $lightboxModal.addClass('active').attr('aria-hidden', 'false');
      $('body').css('overflow', 'hidden');
    }

    function closeLightbox() {
      $lightboxModal.removeClass('active').attr('aria-hidden', 'true');
      $('body').css('overflow', '');
    }

    function updateLightboxView() {
      if (!galleryImages.length) return;
      var src = galleryImages[currentLightboxIdx];
      $lightboxImg.css('opacity', '0.2').attr('src', src);
      $lightboxImg.on('load', function() {
        $(this).css('opacity', '1');
      });
      setTimeout(function() {
        $lightboxImg.css('opacity', '1');
      }, 150);

      $lightboxIdx.text(currentLightboxIdx + 1);

      // Also sync thumbnails on page
      $('.thumb-item').removeClass('active');
      $('.thumb-item').each(function() {
        if ($(this).data('full') === src) {
          $(this).addClass('active');
        }
      });
      $('#gomie-main-product-img').attr('src', src);
    }

    // Trigger open on Zoom Button or Main Image click
    $(document).on('click', '.gomie-zoom-button, .gomie-zoom-link', function(e) {
      e.preventDefault();
      var currentMainSrc = $('#gomie-main-product-img').attr('src');
      openLightbox(currentMainSrc);
    });

    // Close button & backdrop click
    $(document).on('click', '.gomie-lightbox-close-btn, .gomie-lightbox-backdrop', function(e) {
      e.preventDefault();
      closeLightbox();
    });

    // Next / Prev buttons
    $(document).on('click', '.gomie-lightbox-next', function(e) {
      e.preventDefault();
      if (galleryImages.length > 1) {
        currentLightboxIdx = (currentLightboxIdx + 1) % galleryImages.length;
        updateLightboxView();
      }
    });

    $(document).on('click', '.gomie-lightbox-prev', function(e) {
      e.preventDefault();
      if (galleryImages.length > 1) {
        currentLightboxIdx = (currentLightboxIdx - 1 + galleryImages.length) % galleryImages.length;
        updateLightboxView();
      }
    });

    // Keyboard navigation
    $(document).on('keydown', function(e) {
      if (!$lightboxModal.hasClass('active')) return;
      if (e.key === 'Escape' || e.keyCode === 27) {
        closeLightbox();
      } else if (e.key === 'ArrowRight' || e.keyCode === 39) {
        if (galleryImages.length > 1) {
          currentLightboxIdx = (currentLightboxIdx + 1) % galleryImages.length;
          updateLightboxView();
        }
      } else if (e.key === 'ArrowLeft' || e.keyCode === 37) {
        if (galleryImages.length > 1) {
          currentLightboxIdx = (currentLightboxIdx - 1 + galleryImages.length) % galleryImages.length;
          updateLightboxView();
        }
      }
    });

    // 2. Thumbnail click to swap main product image
    $('.gomie-product-gallery-wrapper').on('click', '.thumb-item', function(e) {
      e.preventDefault();
      var $this = $(this);
      var fullUrl = $this.data('full');

      if (!fullUrl) return;

      $('.thumb-item').removeClass('active');
      $this.addClass('active');

      var $mainImg = $('#gomie-main-product-img');
      $mainImg.css('opacity', '0.3');
      $mainImg.attr('src', fullUrl);

      $mainImg.on('load', function() {
        $(this).css('opacity', '1');
      });
      setTimeout(function() {
        $mainImg.css('opacity', '1');
      }, 180);
    });

    // 3. Modern Quantity Stepper buttons injection
    var $qtyWrapper = $('.gomie-purchase-actions .quantity');
    if ($qtyWrapper.length && !$qtyWrapper.find('.qty-stepper-btn').length) {
      var $qtyInput = $qtyWrapper.find('input.qty');
      
      if ($qtyInput.length && $qtyInput.attr('type') !== 'hidden') {
        var $minusBtn = $('<button type="button" class="qty-stepper-btn qty-minus" aria-label="Giảm số lượng"><i class="fa-solid fa-minus"></i></button>');
        var $plusBtn = $('<button type="button" class="qty-stepper-btn qty-plus" aria-label="Tăng số lượng"><i class="fa-solid fa-plus"></i></button>');

        $qtyInput.before($minusBtn);
        $qtyInput.after($plusBtn);

        $minusBtn.on('click', function(e) {
          e.preventDefault();
          var val = parseFloat($qtyInput.val()) || 1;
          var min = parseFloat($qtyInput.attr('min')) || 1;
          var step = parseFloat($qtyInput.attr('step')) || 1;
          if (val > min) {
            $qtyInput.val(val - step).trigger('change');
          }
        });

        $plusBtn.on('click', function(e) {
          e.preventDefault();
          var val = parseFloat($qtyInput.val()) || 1;
          var max = parseFloat($qtyInput.attr('max')) || 9999;
          var step = parseFloat($qtyInput.attr('step')) || 1;
          if (val < max) {
            $qtyInput.val(val + step).trigger('change');
          }
        });
      }
    }

    // 4. Buy Now Button Quantity Synchronization
    $('#gomie-buy-now-btn').on('click', function(e) {
      var qty = $('.gomie-qty-col input.qty').val() || 1;
      var currentHref = $(this).attr('href');
      if (currentHref) {
        var baseHref = currentHref.split('&quantity=')[0];
        $(this).attr('href', baseHref + '&quantity=' + encodeURIComponent(qty));
      }
    });

    // 5. Star Rating Picker Interactivity
    var $starWrapper = $('.gomie-star-rating-select');
    if ($starWrapper.length) {
      var ratingTexts = {
        1: 'Rất không hài lòng (1 sao)',
        2: 'Chưa hài lòng (2 sao)',
        3: 'Tạm được (3 sao)',
        4: 'Hài lòng (4 sao)',
        5: 'Tuyệt vời (5 sao)'
      };

      $starWrapper.on('click', '.star-btn', function(e) {
        e.preventDefault();
        var val = parseInt($(this).data('val'), 10);
        $('#gomie_rating').val(val);

        $starWrapper.find('.star-btn').each(function() {
          var btnVal = parseInt($(this).data('val'), 10);
          if (btnVal <= val) {
            $(this).addClass('active');
          } else {
            $(this).removeClass('active');
          }
        });

        $starWrapper.find('.rating-feedback-text').text(ratingTexts[val] || (val + ' sao'));
      });
    }

    // 6. Tab switching URL hash support & auto-scroll
    var hash = window.location.hash;
    if (hash === '#reviews' || hash === '#reviews-pane') {
      $('#reviews-tab').trigger('click');
      if ($('#productTab').length) {
        $('html, body').animate({
          scrollTop: $('#productTab').offset().top - 80
        }, 300);
      }
    } else if (hash === '#usage' || hash === '#usage-pane' || hash === '#huong-dan' || hash === '#care') {
      $('#usage-tab').trigger('click');
      if ($('#productTab').length) {
        $('html, body').animate({
          scrollTop: $('#productTab').offset().top - 80
        }, 300);
      }
    }
  });

})(jQuery);
