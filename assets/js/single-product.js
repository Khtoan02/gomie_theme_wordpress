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

    // 7. Smart Enhancement for Product Custom Content
    function enhanceProductContent() {
      var $content = $('.product-custom-content');
      if (!$content.length) return;

      // Nếu đã được Server-side PHP (Gomie_Product_Content_Styler) render chuẩn rồi thì không lặp lại
      if ($content.find('.gomie-specs-section, .gomie-safety-callout, .gomie-pledge-section').length) {
        return;
      }

      // 7.1 Hide duplicate first heading if it repeats product title or Gomie Ceramic
      var $firstHeading = $content.find('h1, h2, h3').first();
      if ($firstHeading.length) {
        var hText = $firstHeading.text().trim().toLowerCase();
        var pTitle = $('.gomie-product-title').text().trim().toLowerCase();
        if (hText.indexOf(pTitle) !== -1 || (pTitle && pTitle.indexOf(hText) !== -1) || hText.indexOf('gomie ceramic') !== -1) {
          $firstHeading.addClass('product-duplicate-title');
        }
      }

      // 7.2 Detect "AN TOÀN SỨC KHỎE" or "QUATEST 1" paragraph and convert to Callout
      $content.find('p').each(function() {
        var pHtml = $(this).html();
        var pText = $(this).text();
        if (pText.indexOf('AN TOÀN SỨC KHỎE') !== -1 || pText.indexOf('QUATEST') !== -1 || pText.indexOf('Không chứa chì') !== -1) {
          var $callout = $(
            '<div class="product-cert-callout">' +
              '<div class="cert-icon"><i class="fa-solid fa-shield-halved"></i></div>' +
              '<div class="cert-body">' + pHtml + '</div>' +
            '</div>'
          );
          $(this).replaceWith($callout);
        }
      });

      // 7.3 Detect Headings and transform following lists
      $content.find('h1, h2, h3, h4, p > strong').each(function() {
        var titleText = $(this).text().trim().toUpperCase();

        // 7.3.1 THÔNG TIN SẢN PHẨM -> Specification Grid
        if (titleText.indexOf('THÔNG TIN SẢN PHẨM') !== -1 || titleText.indexOf('THÔNG SỐ KỸ THUẬT') !== -1) {
          var $heading = $(this).is('strong') ? $(this).closest('p') : $(this);
          var $nextUl = $heading.next('ul');
          if ($nextUl.length) {
            var $grid = $('<div class="product-spec-grid"></div>');
            $nextUl.find('li').each(function() {
              var fullText = $(this).text().trim();
              var colonIdx = fullText.indexOf(':');
              if (colonIdx !== -1) {
                var label = fullText.substring(0, colonIdx).trim();
                var val = fullText.substring(colonIdx + 1).trim();
                
                var iconClass = 'fa-circle-dot';
                var lowerL = label.toLowerCase();
                if (lowerL.indexOf('tên') !== -1) iconClass = 'fa-tag';
                else if (lowerL.indexOf('thương hiệu') !== -1) iconClass = 'fa-award';
                else if (lowerL.indexOf('chất liệu') !== -1) iconClass = 'fa-gem';
                else if (lowerL.indexOf('màu men') !== -1) iconClass = 'fa-palette';
                else if (lowerL.indexOf('kiểu dáng') !== -1) iconClass = 'fa-shapes';
                else if (lowerL.indexOf('kích thước') !== -1) iconClass = 'fa-ruler-combined';
                else if (lowerL.indexOf('xuất xứ') !== -1) iconClass = 'fa-location-dot';
                else if (lowerL.indexOf('quy cách') !== -1) iconClass = 'fa-box-open';

                $grid.append(
                  '<div class="spec-cell">' +
                    '<span class="spec-label"><i class="fa-solid ' + iconClass + '"></i> ' + label + '</span>' +
                    '<span class="spec-value">' + val + '</span>' +
                  '</div>'
                );
              }
            });
            if ($grid.children().length > 0) {
              $nextUl.replaceWith($grid);
            }
          }
        }

        // 7.3.2 ƯU ĐIỂM NỔI BẬT -> Highlights Grid
        if (titleText.indexOf('ƯU ĐIỂM NỔI BẬT') !== -1 || titleText.indexOf('ĐẶC ĐIỂM NỔI BẬT') !== -1) {
          var $headingH = $(this).is('strong') ? $(this).closest('p') : $(this);
          var $nextUlH = $headingH.next('ul');
          if ($nextUlH.length) {
            var $hGrid = $('<div class="product-highlights-grid"></div>');
            $nextUlH.find('li').each(function() {
              var text = $(this).text().trim();
              if (text) {
                $hGrid.append(
                  '<div class="product-highlight-card">' +
                    '<div class="highlight-icon"><i class="fa-solid fa-circle-check"></i></div>' +
                    '<div class="highlight-text">' + text + '</div>' +
                  '</div>'
                );
              }
            });
            if ($hGrid.children().length > 0) {
              $nextUlH.replaceWith($hGrid);
            }
          }
        }

        // 7.3.3 CAM KẾT CỦA GOMIE -> Brand Pledge Grid
        if (titleText.indexOf('CAM KẾT CỦA GOMIE') !== -1 || titleText.indexOf('CAM KẾT') !== -1) {
          var $headingC = $(this).is('strong') ? $(this).closest('p') : $(this);
          var $nextUlC = $headingC.next('ul');
          var $pGrid = $(
            '<div class="product-pledge-grid">' +
              '<div class="product-pledge-card">' +
                '<div class="pledge-icon"><i class="fa-solid fa-fire-flame-curved"></i></div>' +
                '<h5 class="pledge-title">Nung Khử 1.300°C</h5>' +
                '<p class="pledge-desc">Triệt tiêu hoàn toàn chì & kim loại nặng, an toàn thực phẩm 100%.</p>' +
              '</div>' +
              '<div class="product-pledge-card">' +
                '<div class="pledge-icon"><i class="fa-solid fa-shield-halved"></i></div>' +
                '<h5 class="pledge-title">Bảo Hiểm 100% Vận Chuyển</h5>' +
                '<p class="pledge-desc">Đổi mới miễn phí ngay lập tức nếu có bất kỳ nứt vỡ nào khi giao hàng.</p>' +
              '</div>' +
              '<div class="product-pledge-card">' +
                '<div class="pledge-icon"><i class="fa-solid fa-hand-sparkles"></i></div>' +
                '<h5 class="pledge-title">Thủ Công Bát Tràng</h5>' +
                '<p class="pledge-desc">Nghệ nhân vuốt nặn tỉ mỉ, mỗi tác phẩm là một kiệt tác men độc bản.</p>' +
              '</div>' +
            '</div>'
          );
          if ($nextUlC.length) {
            $nextUlC.replaceWith($pGrid);
          } else {
            $headingC.after($pGrid);
          }
        }
      });
    }

    enhanceProductContent();

    // =========================================================================
    // 8. VARIABLE PRODUCT SWATCHES & VARIATION PRICE / ADD TO CART CONTROLLER
    // =========================================================================
    function initVariableProductSwatches() {
      var $form = $('.gomie-action-trio-form.variations_form');
      if (!$form.length) return;

      var variationsData = [];
      try {
        var rawData = $form.attr('data-product_variations');
        if (rawData) {
          variationsData = JSON.parse(rawData);
        }
      } catch (err) {
        variationsData = [];
      }

      var $priceDisplay = $('#gomie-variable-price-display');
      var $varIdInput = $form.find('input[name="variation_id"]');
      var $addCartBtn = $('#gomie-add-cart-btn');
      var $buyNowBtn = $('#gomie-buy-now-btn');
      var $alertBox = $('.gomie-variation-alert');

      function formatVNCurrency(num) {
        return new Intl.NumberFormat('vi-VN').format(num) + '&nbsp;₫';
      }

      function updateMatchingVariation() {
        var selectedAttrs = {};
        var totalGroups = 0;
        var selectedCount = 0;

        $('.gomie-attribute-group').each(function() {
          totalGroups++;
          var attrKey = $(this).data('attribute');
          var val = $(this).find('.gomie-hidden-variation-select').val();
          if (val) {
            selectedAttrs[attrKey] = val;
            selectedCount++;
          }
        });

        if (selectedCount === totalGroups && totalGroups > 0 && variationsData.length > 0) {
          // Find matching variation
          var matched = variationsData.find(function(v) {
            for (var k in selectedAttrs) {
              if (v.attributes.hasOwnProperty(k)) {
                if (v.attributes[k] !== '' && v.attributes[k] !== selectedAttrs[k]) {
                  return false;
                }
              }
            }
            return true;
          });

          if (matched) {
            $varIdInput.val(matched.variation_id);
            $alertBox.addClass('d-none');

            // Update Dynamic Price
            if ($priceDisplay.length) {
              $priceDisplay.addClass('price-updating');
              setTimeout(function() {
                if (matched.price_html && matched.price_html.trim() !== '') {
                  $priceDisplay.html(matched.price_html);
                } else if (matched.display_price) {
                  var pStr = formatVNCurrency(matched.display_price);
                  if (matched.display_regular_price && matched.display_regular_price > matched.display_price) {
                    var rStr = formatVNCurrency(matched.display_regular_price);
                    $priceDisplay.html('<ins>' + pStr + '</ins> <del>' + rStr + '</del>');
                  } else {
                    $priceDisplay.html(pStr);
                  }
                }
                $priceDisplay.removeClass('price-updating');
              }, 120);
            }

            // Update Stock Status
            if (matched.is_in_stock) {
              $('.stock-status').removeClass('out-stock').addClass('in-stock').html('<span class="status-dot"></span>Còn hàng');
              $addCartBtn.prop('disabled', false).removeClass('disabled');
              $buyNowBtn.prop('disabled', false).removeClass('disabled');
            } else {
              $('.stock-status').removeClass('in-stock').addClass('out-stock').html('<span class="status-dot"></span>Tạm hết hàng');
              $addCartBtn.prop('disabled', true).addClass('disabled');
              $buyNowBtn.prop('disabled', true).addClass('disabled');
            }

            // Update gallery image if variation has custom image
            if (matched.image && matched.image.src && matched.image.src !== '') {
              var $mainImg = $('#gomie-main-product-img');
              if ($mainImg.length && $mainImg.attr('src') !== matched.image.src) {
                $mainImg.css('opacity', '0.4').attr('src', matched.image.src);
                setTimeout(function() { $mainImg.css('opacity', '1'); }, 150);
              }
            }

            return matched;
          }
        }

        $varIdInput.val('0');
        return null;
      }

      // Swatch Pill Click Event
      $(document).off('click', '.gomie-swatch-pill').on('click', '.gomie-swatch-pill', function(e) {
        e.preventDefault();
        var $pill = $(this);
        var attrKey = $pill.data('attr-key');
        var val = $pill.data('value');

        var $group = $pill.closest('.gomie-attribute-group');
        $group.find('.gomie-swatch-pill').removeClass('active');
        $pill.addClass('active');

        $group.find('.attr-selected-value').text(val);
        $group.find('.gomie-hidden-variation-select').val(val).trigger('change');

        updateMatchingVariation();
      });

      // Form submission validation
      $form.off('submit.gomieVar').on('submit.gomieVar', function(e) {
        var varId = parseInt($varIdInput.val(), 10);
        if (!varId || varId <= 0) {
          e.preventDefault();
          $alertBox.removeClass('d-none');
          $('.gomie-swatch-pills-list').addClass('animate-shake');
          setTimeout(function() {
            $('.gomie-swatch-pills-list').removeClass('animate-shake');
          }, 600);
          return false;
        }
      });

      // Buy Now Button Click
      $buyNowBtn.off('click.gomieBuyNow').on('click.gomieBuyNow', function(e) {
        e.preventDefault();
        var varId = parseInt($varIdInput.val(), 10);
        if (!varId || varId <= 0) {
          $alertBox.removeClass('d-none');
          $('html, body').animate({
            scrollTop: $('.gomie-variations-section').offset().top - 120
          }, 300);
          $('.gomie-swatch-pills-list').addClass('animate-shake');
          setTimeout(function() {
            $('.gomie-swatch-pills-list').removeClass('animate-shake');
          }, 600);
          return false;
        }

        var productId = $form.find('input[name="product_id"]').val() || $form.find('input[name="add-to-cart"]').val();
        var qty = parseInt($form.find('input[name="quantity"]').val(), 10) || 1;
        var baseUrl = window.location.origin + '/thanh-toan/';

        var checkoutUrl = baseUrl + '?add-to-cart=' + encodeURIComponent(productId) + '&variation_id=' + encodeURIComponent(varId) + '&quantity=' + encodeURIComponent(qty);

        $form.find('.gomie-hidden-variation-select').each(function() {
          var name = $(this).attr('name');
          var val = $(this).val();
          if (val) {
            checkoutUrl += '&' + encodeURIComponent(name) + '=' + encodeURIComponent(val);
          }
        });

        window.location.href = checkoutUrl;
      });

      // Initial check on page load
      updateMatchingVariation();
    }

    initVariableProductSwatches();

    $(document).on('wp:page-transitioned', function() {
      enhanceProductContent();
      initVariableProductSwatches();
    });
  });

})(jQuery);
