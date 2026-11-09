# Custom Video Player - Trình Phát Video Tùy Chỉnh

## Tổng Quan

Trình phát video tùy chỉnh này được thiết kế để nhúng video YouTube với giao diện riêng, không sử dụng trình phát mặc định của YouTube. Trình phát có thiết kế hiện đại, responsive và hỗ trợ nhiều tính năng điều khiển.

## Tính Năng

### 🎥 **Chất Lượng Video**

- Tự động phát ở chất lượng 4K (hd2160)
- Hỗ trợ tỷ lệ khung hình 16:9
- Tự động phát khi trang được tải

### 🎮 **Điều Khiển Video**

- Nút phát/dừng với icon động
- Điều khiển âm lượng với slider
- Thanh tiến trình video có thể click để seek
- Hiển thị thời gian hiện tại và tổng thời gian

### ⌨️ **Phím Tắt**

- **Space**: Phát/Dừng video
- **←/→**: Lùi/Tiến 10 giây
- **↑/↓**: Tăng/Giảm âm lượng

### 🎨 **Giao Diện**

- Thiết kế hiện đại với gradient và shadow
- Hiệu ứng hover và transition mượt mà
- Responsive design cho mọi thiết bị
- Hỗ trợ dark mode và high contrast

### ♿ **Tính Năng Accessibility**

- Hỗ trợ keyboard navigation
- Focus states rõ ràng
- Hỗ trợ screen readers
- Reduced motion support

## Cài Đặt

### 1. **File JavaScript**

```javascript
// File: assets/js/custom-video-player.js
// Trình phát video chính với YouTube IFrame API
```

### 2. **File CSS**

```css
// File: assets/css/custom-video-player.css
// Styles cho giao diện trình phát
```

### 3. **HTML Structure**

```html
<div class="custom-video-container">
  <!-- Trình phát video sẽ được khởi tạo tự động -->
</div>
```

### 4. **Enqueue Scripts**

Các file đã được tự động enqueue trong `functions.php`:

- CSS: `custom-video-player.css`
- JS: `custom-video-player.js`

## Sử Dụng

### **Khởi Tạo Tự Động**

Trình phát sẽ tự động khởi tạo khi tìm thấy element có class `custom-video-container`:

```html
<div class="custom-video-container">
  <!-- Trình phát sẽ được tạo tự động -->
</div>
```

### **Khởi Tạo Thủ Công**

```javascript
const container = document.querySelector(".video-container");
const videoUrl = "https://www.youtube.com/watch?v=VIDEO_ID";
const player = new CustomVideoPlayer(container, videoUrl);
```

### **Thay Đổi Video**

```javascript
// Thay đổi video hiện tại
if (window.customVideoPlayer) {
  window.customVideoPlayer.destroy();
  window.customVideoPlayer = new CustomVideoPlayer(container, newVideoUrl);
}
```

## Tùy Chỉnh

### **Thay Đổi Video URL**

Cập nhật URL video trong file `custom-video-player.js`:

```javascript
const videoUrl = "https://www.youtube.com/watch?v=YOUR_VIDEO_ID";
```

### **Tùy Chỉnh Chất Lượng**

Thay đổi tham số `vq` trong `createYouTubePlayer()`:

```javascript
playerVars: {
    vq: 'hd2160', // 4K
    // vq: 'hd1080', // Full HD
    // vq: 'hd720',  // HD
    // vq: 'large',  // 480p
}
```

### **Tùy Chỉnh Giao Diện**

Chỉnh sửa CSS trong file `custom-video-player.css`:

```css
.custom-video-player {
  border-radius: 12px; /* Bo góc */
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); /* Shadow */
}

.video-placeholder {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); /* Gradient */
}
```

## API Methods

### **Playback Control**

```javascript
player.playVideo(); // Phát video
player.pauseVideo(); // Dừng video
player.seekTo(time, true); // Nhảy đến thời điểm
```

### **Volume Control**

```javascript
player.setVolume(50); // Đặt âm lượng (0-100)
player.mute(); // Tắt âm
player.unMute(); // Bật âm
```

### **State Management**

```javascript
player.getPlayerState(); // Lấy trạng thái hiện tại
player.getCurrentTime(); // Lấy thời gian hiện tại
player.getDuration(); // Lấy tổng thời gian
```

## Browser Support

- ✅ Chrome 60+
- ✅ Firefox 55+
- ✅ Safari 12+
- ✅ Edge 79+
- ✅ Mobile browsers

## Troubleshooting

### **Video Không Phát**

1. Kiểm tra URL video có hợp lệ không
2. Kiểm tra console để xem lỗi
3. Đảm bảo YouTube IFrame API đã load

### **Controls Không Hiển Thị**

1. Kiểm tra CSS đã được load
2. Kiểm tra JavaScript errors
3. Đảm bảo container có class đúng

### **Performance Issues**

1. Sử dụng `player.destroy()` khi không cần thiết
2. Tối ưu hóa CSS animations
3. Kiểm tra memory leaks

## Changelog

### **v1.0.0** (Current)

- ✅ YouTube IFrame API integration
- ✅ Custom controls design
- ✅ Responsive layout
- ✅ Keyboard shortcuts
- ✅ Volume control
- ✅ Progress bar
- ✅ Error handling

## License

Trình phát video này được phát triển cho theme GOMIE và tuân theo license của theme.

## Hỗ Trợ

Nếu gặp vấn đề hoặc cần hỗ trợ, vui lòng:

1. Kiểm tra console browser
2. Xem file log WordPress
3. Liên hệ developer team

---

**Lưu ý**: Trình phát này sử dụng YouTube IFrame API và tuân theo [YouTube Terms of Service](https://www.youtube.com/static?template=terms).
