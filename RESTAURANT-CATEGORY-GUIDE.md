# Hướng dẫn Trang Danh mục Nhà hàng - Theme Gomie

## Tổng quan

Trang danh mục nhà hàng được thiết kế đặc biệt cho theme Gomie với UX/UI hiện đại, chuẩn SEO và tối ưu hóa cho trải nghiệm người dùng. Trang này hiển thị các sản phẩm gốm sứ dành riêng cho nhà hàng với layout chuyên nghiệp.

## Cấu trúc Files

### 1. Template Files

- `taxonomy-product_cat-nha-hang.php` - Template chính cho danh mục nhà hàng
- `assets/css/restaurant-category.css` - CSS styling cho trang danh mục
- `assets/js/restaurant-category.js` - JavaScript cho tương tác

### 2. Helper Functions

Các functions được thêm vào `inc/helpers.php`:

- `gomie_is_restaurant_category()` - Kiểm tra trang danh mục nhà hàng
- `gomie_get_restaurant_images()` - Lấy hình ảnh cho masonry grid
- `gomie_get_restaurant_category_stats()` - Thống kê danh mục
- `gomie_restaurant_breadcrumb()` - Breadcrumb tùy chỉnh
- `gomie_get_optimized_product_image()` - Tối ưu hình ảnh sản phẩm
- `gomie_restaurant_category_structured_data()` - Structured data cho SEO

### 3. Enqueue Scripts

Được cập nhật trong `inc/enqueue.php`:

- CSS và JS chỉ load khi cần thiết (conditional loading)
- Tích hợp AOS (Animate On Scroll)
- Masonry và ImagesLoaded libraries

## Tính năng chính

### 1. Hero Section

- Background image với overlay gradient
- Breadcrumb navigation
- Tiêu đề và mô tả danh mục
- Thống kê danh mục (số sản phẩm, danh mục con, đánh giá)
- Responsive design với mobile-first approach

### 2. Sidebar Widget

- **Category Navigation**: Danh sách danh mục con
- **Featured Products**: Sản phẩm nổi bật
- **Contact Widget**: Thông tin liên hệ tư vấn

### 3. CSS Grid Masonry Gallery

- **Pure CSS Grid** layout (không cần JavaScript Masonry)
- **4 cột trên desktop**, **2 cột trên tablet/mobile**
- **Auto-height** cho từng hình ảnh (giống Flowbite Masonry)
- **Lazy loading** và animations
- **Modal popup** để xem chi tiết hình ảnh
- **Keyboard navigation** (mũi tên trái/phải)
- **Favorite system** với localStorage
- **Share functionality** với Web Share API

### 4. Product Grid

- Tái sử dụng component từ homepage
- Filter và sort functionality
- Pagination
- Apple-style product cards với hover effects

### 5. Call-to-Action Section

- Khuyến khích liên hệ tư vấn
- Multiple contact methods
- Professional presentation

## Tối ưu SEO

### 1. Structured Data

- Schema.org CollectionPage markup
- Breadcrumb structured data
- Aggregate rating data
- Product list information

### 2. Meta Tags

- **Optimized title và description**
- **Open Graph tags**
- **Twitter Cards**
- **Canonical URLs**
- **Referrer Policy** cho external images
- **Robots meta tags** với noarchive, nosnippet
- **External image optimization** với proper attributes

### 3. Performance

- **Pure CSS Grid** (không cần Masonry JavaScript)
- **Conditional script loading** chỉ khi cần
- **Image optimization** với WebP support
- **Lazy loading** cho hình ảnh
- **Reduced bundle size** (loại bỏ Masonry + ImagesLoaded)
- **CSS/JS minification ready**

## Responsive Design

### Breakpoints

- **Desktop**: 1200px+
- **Tablet**: 992px - 1199px
- **Mobile**: 768px - 991px
- **Small Mobile**: 576px - 767px

### Mobile Optimizations

- Stacked layout cho sidebar
- Touch-friendly buttons
- Optimized image sizes
- Simplified navigation

## Customization

### 1. Thay đổi hình ảnh Masonry

```php
// Trong functions.php hoặc child theme
function custom_restaurant_images($images) {
    // Thêm hoặc thay đổi hình ảnh
    $images[] = array(
        'url' => 'path-to-your-image.jpg',
        'alt' => 'Alt text',
        'title' => 'Image title',
        'description' => 'Description'
    );
    return $images;
}
add_filter('gomie_restaurant_images', 'custom_restaurant_images');
```

### 2. Tùy chỉnh CSS

```css
/* Thay đổi màu chủ đạo */
:root {
  --restaurant-primary: #your-color;
  --restaurant-secondary: #your-secondary-color;
}
```

### 3. Thêm custom fields

```php
// Thêm meta fields cho category
function add_category_custom_fields($term) {
    // Your custom fields here
}
add_action('product_cat_edit_form_fields', 'add_category_custom_fields');
```

## JavaScript Features

### 1. CSS Grid Masonry

- **Pure CSS implementation** (không cần JavaScript)
- **Auto-responsive** với CSS Grid
- **Better performance** (không có layout calculations)
- **Smooth animations** với CSS transitions

### 2. Product Filters

- Real-time filtering
- Sort functionality
- Smooth transitions

### 3. Image Modal

- Lightbox functionality
- Keyboard navigation
- Touch support

### 4. Animations

- AOS (Animate On Scroll)
- Custom scroll effects
- Parallax background
- Counter animations

## Browser Support

- **Modern Browsers**: Chrome 70+, Firefox 65+, Safari 12+, Edge 79+
- **Mobile**: iOS Safari 12+, Android Chrome 70+
- **Fallbacks**: Graceful degradation cho older browsers

## Performance Metrics

### Target Scores

- **Google PageSpeed**: 90+ (Mobile), 95+ (Desktop)
- **GTmetrix**: A Grade
- **Core Web Vitals**: Pass all metrics

### Optimizations

- Critical CSS inlining
- JavaScript deferred loading
- Image lazy loading
- Font display optimization

## Troubleshooting

### 1. Masonry không hoạt động

```javascript
// Kiểm tra jQuery và ImagesLoaded
if (typeof jQuery !== "undefined" && jQuery.fn.imagesLoaded) {
  // Masonry code
}
```

### 2. CSS không load

- Kiểm tra conditional loading trong `enqueue.php`
- Verify category slug 'nha-hang'
- Clear cache

### 3. Images không hiển thị

- Kiểm tra image URLs
- Verify image permissions
- Check lazy loading implementation

## Future Enhancements

### Planned Features

1. **AJAX Product Loading**: Infinite scroll
2. **Advanced Filters**: Price range, ratings, attributes
3. **Wishlist Integration**: Save favorite products
4. **Compare Products**: Side-by-side comparison
5. **Virtual Tour**: 360° restaurant views

### Performance Improvements

1. **WebP Image Generation**: Automatic conversion
2. **CDN Integration**: Global content delivery
3. **Service Worker**: Offline functionality
4. **Database Optimization**: Query caching

## Support

### Documentation

- WordPress Codex
- WooCommerce Documentation
- Theme specific documentation

### Contact

- Email: support@gomie.vn
- Phone: +84 123 456 789
- Website: https://gomie.vn

---

**Lưu ý**: Template này được thiết kế đặc biệt cho danh mục "nha-hang" (slug: nha-hang). Để sử dụng cho danh mục khác, cần thay đổi tên file template và điều kiện trong helper functions.
