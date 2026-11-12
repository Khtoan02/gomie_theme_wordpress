/**
 * Gomie Theme - Admin Fail-safe Tab Handler
 * Đảm bảo các tab Dữ liệu sản phẩm & Thuộc tính trong WooCommerce Admin
 * luôn chuyển đổi mượt mà, không bao giờ bị lỗi trắng trơn.
 */
(function($) {
    'use strict';

    function initProductDataTabsSafe() {
        var $productData = $('#woocommerce-product-data');
        if (!$productData.length) return;

        var $tabs = $productData.find('ul.product_data_tabs');
        var $panelWrap = $productData.find('div.panel-wrap');
        if (!$tabs.length || !$panelWrap.length) return;

        // 1. Gắn sự kiện click an toàn cho các tab
        $tabs.off('click.gomieTabsSafe', 'li a').on('click.gomieTabsSafe', 'li a', function(e) {
            var $link = $(this);
            var targetId = $link.attr('href');
            if (!targetId || targetId.indexOf('#') !== 0) return;

            var $targetPanel = $(targetId);
            if (!$targetPanel.length) return;

            // Chuyển class active cho li
            $tabs.find('li').removeClass('active');
            $link.closest('li').addClass('active');

            // Ẩn các panel khác và hiển thị panel được chọn
            $panelWrap.find('> div.panel, > .panel').each(function() {
                if (this.id === targetId.substring(1)) {
                    $(this).removeClass('hidden').css('display', 'block').show();
                    $(this).trigger('woocommerce_tab_shown');
                } else {
                    $(this).hide().css('display', 'none');
                }
            });

            // Tự động gỡ bỏ block overlay nếu bị treo quá lâu
            setTimeout(function() {
                if ($targetPanel.hasClass('blockUI') || $targetPanel.find('.blockUI').length) {
                    if ($.fn.unblock) {
                        $targetPanel.unblock();
                    }
                }
            }, 1200);
        });

        // 2. Kiểm tra trạng thái ban đầu khi vừa load trang
        setTimeout(function() {
            var $activeTab = $tabs.find('li.active a');
            if (!$activeTab.length) {
                // Kích hoạt tab hiển thị đầu tiên
                var $firstVisible = $tabs.find('li:visible:not(.hidden) a').first();
                if ($firstVisible.length) {
                    $firstVisible.trigger('click');
                }
            } else {
                // Đảm bảo panel của tab active đang hiển thị
                var targetId = $activeTab.attr('href');
                if (targetId && $(targetId).length) {
                    $(targetId).removeClass('hidden').css('display', 'block').show();
                }
            }
        }, 300);

        // 3. Lắng nghe thay đổi loại sản phẩm (Simple, Variable, v.v.)
        $('#product-type').off('change.gomieTypeSafe').on('change.gomieTypeSafe', function() {
            setTimeout(function() {
                var $activeTab = $tabs.find('li.active:visible a');
                if (!$activeTab.length) {
                    $tabs.find('li:visible:not(.hidden) a').first().trigger('click');
                }
            }, 100);
        });
    }

    // Khởi chạy khi DOM sẵn sàng
    $(document).ready(function() {
        initProductDataTabsSafe();
    });

    // Lắng nghe thêm sự kiện ajaxComplete của WP
    $(document).ajaxComplete(function(event, xhr, settings) {
        if (settings && settings.data && typeof settings.data === 'string') {
            if (settings.data.indexOf('woocommerce_add_attribute') !== -1 || settings.data.indexOf('woocommerce_save_attributes') !== -1) {
                setTimeout(function() {
                    $('#product_attributes').removeClass('hidden').show();
                    if ($.fn.unblock) {
                        $('#product_attributes').unblock();
                    }
                }, 500);
            }
        }
    });

})(jQuery);
