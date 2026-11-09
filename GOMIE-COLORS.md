# GOMIE CERAMIC - Bảng Màu Mới

## Tổng Quan

Website GOMIE CERAMIC đã được cập nhật với bảng màu gốm sứ nhẹ nhàng, phù hợp với thương hiệu gốm sứ thủ công Việt Nam.

## Bảng Màu Chính

### Màu Chính

- **Màu chính**: `#0b89e7` (Xanh dương)
- **Màu phụ**: `#ef661a` (Cam)
- **Màu sáng**: `#ffffff` (Trắng)

### Candy Orange Colors

- **Candy Orange Primary**: `#ff6b35`
- **Candy Orange Secondary**: `#ff8d4e`
- **Candy Orange Light**: `#ffb992`
- **Candy Orange Dark**: `#ff4d1a`

### Gradient Buttons

- **Button thường**: `linear-gradient(135deg, #f06619 0%, #ffb992 50%, #ff8d4e 100%)`
- **Button hover**: `linear-gradient(135deg, #0b89e7 0%, #7fc8ff 50%, #39aaff 100%)`

### Header Top Gradient

- **Header Top**: `linear-gradient(135deg, #ff6b35 0%, #ff8d4e 50%, #ffb992 100%)`

### Background Gradients

- **Background chính**: `linear-gradient(135deg, #ffede4 0%, #ffd8c3 50%, #ffebe0 100%)`

## Các Thay Đổi Đã Thực Hiện

### 1. CSS Variables

Đã cập nhật các biến CSS trong `style.css`:

```css
:root {
  --color-primary: #0b89e7;
  --color-secondary: #ef661a;
  --color-white: #ffffff;
  --gradient-button: linear-gradient(
    135deg,
    #f06619 0%,
    #ffb992 50%,
    #ff8d4e 100%
  );
  --gradient-button-hover: linear-gradient(
    135deg,
    #0b89e7 0%,
    #7fc8ff 50%,
    #39aaff 100%
  );
  --color-background: linear-gradient(
    135deg,
    #ffede4 0%,
    #ffd8c3 50%,
    #ffebe0 100%
  );
}
```

### 2. Button Styles

- Tất cả các button đã được cập nhật với gradient mới
- Hover effects sử dụng màu xanh dương
- Shadow effects phù hợp với từng trạng thái

### 3. Background Updates

- Body background sử dụng gradient gốm sứ nhẹ nhàng
- Các section có background phù hợp với theme

### 4. Footer & Header

- Footer sử dụng gradient xanh dương
- Header buttons sử dụng gradient cam
- Top-header sử dụng Candy Orange gradient với hiệu ứng Pattern gốm sứ

## File CSS Mới

- `assets/css/gomie-colors.css`: File CSS bổ sung để đảm bảo tất cả màu sắc được áp dụng đúng

## Cách Sử Dụng

### Trong CSS

```css
/* Sử dụng màu chính */
color: var(--color-primary);

/* Sử dụng gradient button */
background: var(--gradient-button);

/* Sử dụng background */
background: var(--color-background);
```

### Trong HTML

```html
<!-- Button với gradient mới -->
<button class="btn-primary">Click me</button>

<!-- Text với màu chính -->
<span class="text-primary">GOMIE CERAMIC</span>
```

## Responsive Design

Tất cả các màu sắc đều hoạt động tốt trên các thiết bị:

- Desktop
- Tablet
- Mobile

## Browser Support

- Chrome/Edge: ✅
- Firefox: ✅
- Safari: ✅
- Mobile browsers: ✅

## Lưu Ý

- Các màu sắc được thiết kế để tạo cảm giác ấm áp, thân thiện
- Gradient buttons tạo hiệu ứng hiện đại
- Background gradient nhẹ nhàng, không gây mỏi mắt
- Tất cả màu sắc đều đạt tiêu chuẩn accessibility

## Cập Nhật Tương Lai

Để thay đổi màu sắc trong tương lai, chỉ cần cập nhật các biến CSS trong `:root` hoặc file `gomie-colors.css`.
