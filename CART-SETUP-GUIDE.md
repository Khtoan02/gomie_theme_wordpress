# Hướng Dẫn Thiết Lập Trang Giỏ Hàng Gomie

## Vấn Đề Hiện Tại

Trang `/gio-hang` chưa hoạt động vì cần thiết lập trong WordPress Admin.

## Giải Pháp

### 1. Kiểm tra WooCommerce Pages

Vào **WordPress Admin → WooCommerce → Settings → Advanced → Page setup**

Đảm bảo các trang sau đã được tạo:

- Cart page
- Checkout page
- My account page
- Terms and conditions page

### 2. Tạo Trang Giỏ Hàng Mới (Nếu cần)

#### Cách 1: Tạo page với shortcode

1. Vào **WordPress Admin → Pages → Add New**
2. Tiêu đề: "Giỏ hàng"
3. Slug: "gio-hang"
4. Nội dung: `[woocommerce_cart]`
5. Template: Chọn "Giỏ Hàng" (nếu có)
6. Publish

#### Cách 2: Sử dụng template có sẵn

1. Vào **WordPress Admin → Pages → Add New**
2. Tiêu đề: "Giỏ hàng"
3. Slug: "gio-hang"
4. Page Template: Chọn "Giỏ Hàng"
5. Publish

### 3. Cấu hình WooCommerce

1. Vào **WooCommerce → Settings → Advanced**
2. Trong **Page setup**, chọn trang "Giỏ hàng" cho **Cart page**
3. Save changes

### 4. Test các URL

Sau khi thiết lập, test các URL:

- `/gio-hang` - Trang giỏ hàng chính
- `/cart` - Trang giỏ hàng mặc định
- `/debug-cart.php` - Debug page (temporary)

### 5. Sử dụng Shortcode Test

Thêm shortcode `[test_cart]` vào bất kỳ trang nào để test template.

## Files Đã Tạo

1. **Templates:**

   - `woocommerce/cart/cart.php` - Template giỏ hàng chính
   - `woocommerce/cart/cart-empty.php` - Template giỏ hàng trống
   - `woocommerce/cart.php` - Wrapper template
   - `page-cart.php` - Page template
   - `page-gio-hang.php` - Vietnamese page template

2. **Assets:**

   - `assets/css/cart-page.css` - CSS styles
   - `assets/js/cart-page.js` - JavaScript functionality

3. **Functions:**
   - Updated `inc/woocommerce-integration.php`
   - Added cart shortcode to `functions.php`

## Troubleshooting

### Nếu trang vẫn không hoạt động:

1. **Flush Rewrite Rules:**

   - Vào **Settings → Permalinks**
   - Click "Save Changes" (không cần thay đổi gì)

2. **Check WooCommerce Status:**

   - Vào **WooCommerce → Status**
   - Kiểm tra "Pages" section

3. **Manual URL Test:**

   - Truy cập `/wp-content/themes/gomie/debug-cart.php`
   - Kiểm tra thông tin debug

4. **Template Hierarchy:**
   WordPress sẽ tìm template theo thứ tự:
   - `page-gio-hang.php` (nếu slug là "gio-hang")
   - `page-cart.php` (nếu slug là "cart")
   - `woocommerce/cart.php`
   - `page.php`
   - `index.php`

## Features Của Template Mới

✅ **UX/UI Modern:** Card-based design, smooth animations
✅ **Responsive:** Hoạt động tốt trên mobile
✅ **Màu sắc Gomie:** Xanh #0b89e7, cam #f06619
✅ **Interactive:** Quantity controls, remove confirmations
✅ **Vietnamese:** Hoàn toàn bằng tiếng Việt
✅ **Performance:** Optimized loading và AJAX updates

## Liên Hệ Support

Nếu vẫn gặp vấn đề, vui lòng cung cấp:

1. Screenshot trang `/gio-hang`
2. Screenshot WooCommerce → Settings → Advanced → Page setup
3. URL hiện tại của trang cart trong WooCommerce
