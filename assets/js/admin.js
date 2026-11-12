/**
 * Gomie Theme - Admin Safe Helper
 * Đảm bảo tab dữ liệu sản phẩm WooCommerce chuyển đổi chính xác và mượt mà 100%
 */
(function($) {
    'use strict';

    // Xử lý chuyển đổi tab sản phẩm WooCommerce tin cậy và mượt mà
    $(document).on('click', '#woocommerce-product-data ul.wc-tabs li a', function(e) {
        var $link = $(this);
        var targetId = $link.attr('href');
        if (!targetId || targetId.indexOf('#') !== 0) {
            return;
        }

        e.preventDefault();

        var $wrap = $link.closest('div.panel-wrap');
        if (!$wrap.length) {
            $wrap = $('#woocommerce-product-data');
        }

        // Active tab styling
        $link.closest('ul.wc-tabs').find('li').removeClass('active');
        $link.closest('li').addClass('active');

        // Hide all panels & show the selected target panel
        $wrap.find('div.panel').hide();
        var $target = $(targetId);
        if ($target.length) {
            $target.show(0, function() {
                $(this).trigger('woocommerce_tab_shown');
            });
        }
    });

    // Tự động gỡ bỏ overlay BlockUI nếu WooCommerce bị kẹt AJAX khi thêm hoặc lưu thuộc tính
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings && settings.data && typeof settings.data === 'string') {
            if (settings.data.indexOf('woocommerce_add_attribute') !== -1 || settings.data.indexOf('woocommerce_save_attributes') !== -1) {
                setTimeout(function() {
                    if ($.fn.unblock) {
                        $('#product_attributes').unblock();
                        $('#woocommerce-product-data').unblock();
                    }
                }, 1000);
            }
        }
    });

})(jQuery);
