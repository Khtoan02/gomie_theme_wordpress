/**
 * Ultra-Fast Page Transitions & Speculative Prefetching (Vanilla JS - Zero Dependency)
 * Gomie Ceramic Architecture
 *
 * - Luxury Terracotta & Gold top progress bar for instant visual feedback (0ms perceived latency)
 * - Speculative link prefetching on hover & touchstart for instant subsequent page loads
 * - 100% Native Browser History compliance (Back/Forward button works perfectly with bfcache)
 * - Smart Logo click handler (smooth scroll to top on same page, clean navigation from other pages)
 * - Automatic cleanup of open Modals, Drawers and Backdrops before navigation
 *
 * @package Gomie
 */
(function () {
  'use strict';

  // 1. Tạo thanh tiến trình Terracotta & Gold sang trọng chạy trên đỉnh trang
  const progressBar = document.createElement('div');
  progressBar.id = 'wp-page-progress';
  progressBar.style.cssText =
    'position:fixed;top:0;left:0;height:2.5px;width:0%;background:linear-gradient(90deg, #e2725b, #c45a45, #f4a261);box-shadow:0 0 10px rgba(226,114,91,0.8);z-index:9999999;transition:width 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease;pointer-events:none;opacity:0;';

  if (document.body) {
    document.body.appendChild(progressBar);
  } else {
    document.addEventListener('DOMContentLoaded', () => {
      if (document.body && !document.getElementById('wp-page-progress')) {
        document.body.appendChild(progressBar);
      }
    });
  }

  let progressTimer = null;
  let isProgressActive = false;

  function startProgress() {
    clearTimeout(progressTimer);
    isProgressActive = true;
    progressBar.style.transition = 'width 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease';
    progressBar.style.opacity = '1';
    progressBar.style.width = '35%';

    progressTimer = setTimeout(() => {
      if (isProgressActive) {
        progressBar.style.transition = 'width 0.8s ease-out';
        progressBar.style.width = '82%';
      }
    }, 150);
  }

  function finishProgress() {
    clearTimeout(progressTimer);
    isProgressActive = false;
    progressBar.style.transition = 'width 0.15s ease, opacity 0.25s ease';
    progressBar.style.width = '100%';

    setTimeout(() => {
      progressBar.style.opacity = '0';
      setTimeout(() => {
        progressBar.style.width = '0%';
      }, 250);
    }, 150);
  }

  // 2. Dọn dẹp an toàn các Modal, Drawer/Offcanvas đang mở
  function cleanupOpenModalsAndDrawers() {
    try {
      // Đóng Bootstrap Modals
      document.querySelectorAll('.modal.show').forEach((m) => {
        try {
          if (window.bootstrap && window.bootstrap.Modal) {
            const inst = window.bootstrap.Modal.getInstance(m);
            if (inst) inst.hide();
          }
        } catch (e) {}
        m.classList.remove('show');
        m.style.display = 'none';
        m.setAttribute('aria-hidden', 'true');
      });

      // Đóng Popup Báo giá
      const quotePopup = document.getElementById('contact-popup');
      if (quotePopup) {
        quotePopup.classList.remove('active');
      }

      // Đóng Offcanvas mobile menu
      document.querySelectorAll('.offcanvas.show').forEach((o) => {
        try {
          if (window.bootstrap && window.bootstrap.Offcanvas) {
            const inst = window.bootstrap.Offcanvas.getInstance(o);
            if (inst) inst.hide();
          }
        } catch (e) {}
        o.classList.remove('show');
      });

      // Gỡ bỏ hoàn toàn backdrops bị sót
      document.querySelectorAll('.modal-backdrop, .offcanvas-backdrop').forEach((b) => b.remove());
      if (document.body) {
        document.body.classList.remove('modal-open', 'popup-open', 'mobile-menu-active');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
      }
    } catch (e) {}
  }

  // 3. Kiểm tra xem link có hợp lệ để chuyển hướng nội bộ không
  function isInternalNavigableUrl(url) {
    try {
      if (!url) return false;
      const parsed = new URL(url, window.location.href);

      // Chỉ xử lý cùng origin
      if (parsed.origin !== window.location.origin) return false;

      const path = parsed.pathname;

      // Bỏ qua admin, login, checkout, cart, wp-json, wc-ajax
      if (path.includes('/wp-admin') || path.includes('/wp-login.php') || path.includes('/wp-json')) return false;
      if (path.includes('/cart') || path.includes('/gio-hang') || path.includes('/checkout') || path.includes('/thanh-toan')) return false;
      if (parsed.searchParams.has('wc-ajax') || parsed.searchParams.has('action') || parsed.searchParams.has('add-to-cart')) return false;

      // Bỏ qua file tải về / media
      if (path.match(/\.(pdf|zip|tar|gz|rar|docx?|xlsx?|pptx?|jpe?g|png|webp|gif|svg|mp4|mp3)$/i)) return false;

      return true;
    } catch (e) {
      return false;
    }
  }

  // 4. Speculative Link Prefetching (Tải trước tài nguyên khi rê chuột hoặc chạm nhẹ)
  const prefetchedUrls = new Set();
  const hasSlowConnection = () => {
    const conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    return conn && (conn.saveData || (conn.effectiveType && conn.effectiveType.includes('2g')));
  };

  function prefetchUrl(url) {
    if (hasSlowConnection()) return;
    try {
      const fullUrl = new URL(url, window.location.href).href;
      if (prefetchedUrls.has(fullUrl) || fullUrl === window.location.href) return;
      prefetchedUrls.add(fullUrl);

      // Dùng <link rel="prefetch">
      const link = document.createElement('link');
      link.rel = 'prefetch';
      link.href = fullUrl;
      link.as = 'document';
      document.head.appendChild(link);
    } catch (e) {}
  }

  // Lắng nghe mouseover / touchstart trên các liên kết
  document.addEventListener('mouseover', (e) => {
    const link = e.target.closest('a');
    if (!link) return;
    const href = link.getAttribute('href');
    if (href && isInternalNavigableUrl(href) && !href.startsWith('#')) {
      prefetchUrl(href);
    }
  }, { passive: true });

  document.addEventListener('touchstart', (e) => {
    const link = e.target.closest('a');
    if (!link) return;
    const href = link.getAttribute('href');
    if (href && isInternalNavigableUrl(href) && !href.startsWith('#')) {
      prefetchUrl(href);
    }
  }, { passive: true });

  // 5. Bắt sự kiện Click trên thẻ <a>
  document.addEventListener('click', (e) => {
    const link = e.target.closest('a');
    if (!link) return;

    // Bỏ qua tab mới, download, chuột giữa/phải, phím tắt
    if (link.target === '_blank' || link.hasAttribute('download') || link.getAttribute('rel') === 'external') return;
    if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;

    const href = link.getAttribute('href');
    if (!href || href === '#' || href.startsWith('javascript:')) return;

    // Xử lý anchor hash link nội bộ trong trang (e.g. #gomie-v11-collection)
    if (href.startsWith('#')) {
      const targetEl = document.querySelector(href);
      if (targetEl) {
        e.preventDefault();
        targetEl.scrollIntoView({ behavior: 'smooth' });
        cleanupOpenModalsAndDrawers();
      }
      return;
    }

    // Xử lý Logo click
    const isLogo = link.classList.contains('custom-logo-link') ||
                   link.classList.contains('gomie-editorial-logo-link') ||
                   link.closest('.site-branding');

    if (isLogo) {
      try {
        const clickedUrl = new URL(href, window.location.href);
        const currentUrl = new URL(window.location.href);

        // Nếu người dùng ĐANG ở chính xác trang chủ (path là / và không có query ?s= hoặc params khác)
        if (currentUrl.pathname === '/' && !currentUrl.search && clickedUrl.pathname === '/') {
          e.preventDefault();
          window.scrollTo({ top: 0, behavior: 'smooth' });
          cleanupOpenModalsAndDrawers();
          return;
        }
      } catch (err) {}
    }

    // Nếu là link nội bộ hợp lệ
    if (isInternalNavigableUrl(href)) {
      try {
        const targetUrl = new URL(href, window.location.href);
        const currentUrl = new URL(window.location.href);

        // Click vào đúng URL hiện tại (không đổi trang): cuộn lên đầu
        if (targetUrl.href === currentUrl.href) {
          e.preventDefault();
          window.scrollTo({ top: 0, behavior: 'smooth' });
          cleanupOpenModalsAndDrawers();
          return;
        }

        // Bật progress bar mượt mà cho trải nghiệm visual 0ms
        startProgress();
        cleanupOpenModalsAndDrawers();
      } catch (err) {}
    }
  });

  // 6. Xử lý khi trang được hiển thị (bao gồm cả khi Back/Forward từ bfcache)
  window.addEventListener('pageshow', (e) => {
    finishProgress();
    cleanupOpenModalsAndDrawers();
  });

  // 7. Xử lý trước khi rời trang
  window.addEventListener('beforeunload', () => {
    startProgress();
  });

  // Hoàn tất progress bar khi DOM đã sẵn sàng
  if (document.readyState === 'complete') {
    finishProgress();
  } else {
    window.addEventListener('load', finishProgress);
  }
})();
