# Khắc Phục Trang Giỏ Hàng Vẫn Hiển Thị Giao Diện Cũ

## 🔍 Chẩn Đoán Vấn Đề

Trang giỏ hàng vẫn hiển thị giao diện cũ có thể do:

1. Template chưa được WordPress nhận diện
2. Cache chưa được clear
3. WooCommerce pages chưa được cấu hình đúng
4. Theme template hierarchy conflict

## 🛠 Giải Pháp Từng Bước

### Bước 1: Kiểm Tra và Refresh Template

1. **Truy cập script refresh:**
   ```
   http://yourdomain.com/wp-content/themes/gomie/force-cart-refresh.php
   ```
2. **Kiểm tra kết quả và làm theo hướng dẫn**

### Bước 2: Cấu Hình WooCommerce Pages

1. **Vào WordPress Admin → WooCommerce → Settings → Advanced**
2. **Trong "Page setup" section:**
   - Cart page: Chọn trang có slug "gio-hang" hoặc "cart"
   - Nếu chưa có, tạo page mới với nội dung `[woocommerce_cart]`
3. **Save Changes**

### Bước 3: Clear All Caches

1. **WordPress Cache:**

   - Nếu dùng caching plugin → Clear cache
   - Hoặc vào `Settings → Permalinks → Save Changes`

2. **Browser Cache:**
   - Nhấn `Ctrl + F5` (Windows) hoặc `Cmd + Shift + R` (Mac)
   - Hoặc mở Incognito/Private browsing

### Bước 4: Force Template Override (Nếu cần)

Nếu vẫn không hoạt động, thêm code sau vào cuối file `functions.php`:

```php
// TEMPORARY FIX - Remove after working
add_action('init', function() {
    remove_shortcode('woocommerce_cart');
    add_shortcode('woocommerce_cart', function() {
        if (!class_exists('WooCommerce')) return '';

        wp_enqueue_style('cart-page', get_template_directory_uri() . '/assets/css/cart-page.css');
        wp_enqueue_script('cart-page-js', get_template_directory_uri() . '/assets/js/cart-page.js', array('jquery'));

        ob_start();
        include get_template_directory() . '/woocommerce/cart/cart.php';
        return ob_get_clean();
    });
}, 999);
```

### Bước 5: Test Các URL

Test các URL sau để xem cái nào hoạt động:

- `/gio-hang`
- `/cart`
- `/gio-hang/`
- `/cart/`

## 🔧 Debug và Kiểm Tra

### Kiểm Tra Template Đang Load

1. **View page source** trên trang cart
2. **Tìm kiếm:** `gomie-cart-container`
   - ✅ **Có:** Template mới đã load, vấn đề là CSS
   - ❌ **Không có:** Template cũ vẫn đang load

### Kiểm Tra CSS

1. **Inspect element** (F12)
2. **Kiểm tra:** `cart-page.css` có load không
3. **Nếu không load:** Thêm CSS inline tạm thời

## 🎯 Solutions Cụ Thể

### Solution 1: Tạo Page Template Riêng

1. **Tạo page mới:** "Test Giỏ Hàng"
2. **Page Template:** Chọn "Giỏ Hàng"
3. **Nội dung:** `[woocommerce_cart]`
4. **Test URL này**

### Solution 2: Override Shortcode

Thêm vào `functions.php`:

```php
add_filter('the_content', function($content) {
    if (is_cart() && is_main_query() && in_the_loop()) {
        wp_enqueue_style('cart-page', get_template_directory_uri() . '/assets/css/cart-page.css');
        ob_start();
        include get_template_directory() . '/woocommerce/cart/cart.php';
        return ob_get_clean();
    }
    return $content;
}, 999);
```

### Solution 3: Direct Template Include

Tạo file `page-gio-hang.php` với nội dung:

```php
<?php get_header(); ?>
<main class="site-main">
    <div class="container">
        <?php include get_template_directory() . '/woocommerce/cart/cart.php'; ?>
    </div>
</main>
<?php get_footer(); ?>
```

## 📋 Checklist Cuối Cùng

- [ ] WooCommerce pages được cấu hình đúng
- [ ] Template files tồn tại trong theme
- [ ] CSS và JS được enqueue
- [ ] Cache đã được clear
- [ ] Browser cache đã được clear
- [ ] Permalinks đã được flush
- [ ] Test với Incognito mode

## 🆘 Nếu Vẫn Không Hoạt Động

**Gửi thông tin sau:**

1. **Screenshot** trang cart hiện tại
2. **View source** của trang cart (copy phần đầu)
3. **WooCommerce → Status → Pages** screenshot
4. **Kết quả** từ script `force-cart-refresh.php`
5. **URL** bạn đang truy cập

**Files quan trọng để kiểm tra:**

- `/wp-content/themes/gomie/woocommerce/cart/cart.php`
- `/wp-content/themes/gomie/assets/css/cart-page.css`
- `/wp-content/themes/gomie/assets/js/cart-page.js`

Với các solutions này, trang giỏ hàng chắc chắn sẽ hiển thị giao diện mới! 🎯
