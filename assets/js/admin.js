/**
 * Gomie Theme - Admin Fail-safe Tab Handler
 * Đảm bảo các tab Dữ liệu sản phẩm & Thuộc tính trong WooCommerce Admin
 * luôn chuyển đổi mượt mà, không bao giờ bị lỗi trắng trơn.
 */
(function($) {
    'use strict';

    // 1. Event delegation trên document để luôn bắt được sự kiện click tab
    // kể cả khi DOM được load bất đồng bộ hoặc WooCommerce chưa kịp bind
    $(document).on('click', '#woocommerce-product-data ul.product_data_tabs li a, ul.wc-tabs li a', function(e) {
        var $link = $(this);
        var targetId = $link.attr('href');
        if (!targetId || targetId.indexOf('#') !== 0) return;

        var $targetPanel = $(targetId);
        if (!$targetPanel.length) return;

        e.preventDefault();
        e.stopPropagation();

        var $panelWrap = $link.closest('.panel-wrap');
        if (!$panelWrap.length) {
            $panelWrap = $('#woocommerce-product-data .panel-wrap');
        }

        // Đổi trạng thái active cho tab
        $link.closest('ul').find('li').removeClass('active');
        $link.closest('li').addClass('active');

        // Ẩn tất cả các panels khác
        $panelWrap.find('> div.panel, > .panel').each(function() {
            if (this.id === targetId.substring(1)) {
                $(this).removeClass('hidden').show().css('display', 'block');
                $(this).trigger('woocommerce_tab_shown');
            } else {
                $(this).addClass('hidden').hide().css('display', 'none');
            }
        });

        // Tự động gỡ bỏ overlay BlockUI nếu có
        if ($.fn.unblock) {
            $targetPanel.unblock();
            $('#product_attributes').unblock();
        }
    });

    // 2. Kích hoạt an toàn tab đầu tiên / tab hiện tại khi tải trang
    function ensureActiveTab() {
        var $productData = $('#woocommerce-product-data');
        if (!$productData.length) return;

        var $activeLi = $productData.find('ul.product_data_tabs li.active a, ul.wc-tabs li.active a');
        if ($activeLi.length) {
            var targetId = $activeLi.attr('href');
            if (targetId && $(targetId).length) {
                $(targetId).removeClass('hidden').show().css('display', 'block');
            }
        } else {
            // Chưa có tab nào active -> Kích hoạt tab hiển thị đầu tiên
            var $firstTab = $productData.find('ul.product_data_tabs li:visible:not(.hidden) a, ul.wc-tabs li:visible:not(.hidden) a').first();
            if ($firstTab.length) {
                $firstTab.trigger('click');
            }
        }
    }

    $(document).ready(function() {
        ensureActiveTab();
        setTimeout(ensureActiveTab, 200);
        setTimeout(ensureActiveTab, 600);
    });

    $(window).on('load', function() {
        ensureActiveTab();
    });

    // 3. Lắng nghe thay đổi loại sản phẩm (Simple, Variable, v.v.)
    $(document).on('change', '#product-type', function() {
        setTimeout(function() {
            var $productData = $('#woocommerce-product-data');
            var $activeLi = $productData.find('ul.product_data_tabs li.active:visible a');
            if (!$activeLi.length) {
                $productData.find('ul.product_data_tabs li:visible:not(.hidden) a').first().trigger('click');
            }
        }, 100);
    });

    // 4. Lắng nghe hoàn tất AJAX liên quan đến attributes
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings && settings.data && typeof settings.data === 'string') {
            if (settings.data.indexOf('woocommerce_add_attribute') !== -1 || settings.data.indexOf('woocommerce_save_attributes') !== -1) {
                setTimeout(function() {
                    $('#product_attributes').removeClass('hidden').show().css('display', 'block');
                    if ($.fn.unblock) {
                        $('#product_attributes').unblock();
                    }
                }, 100);
            }
        }
    });

})(jQuery);
