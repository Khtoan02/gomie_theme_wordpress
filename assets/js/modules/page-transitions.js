/**
 * Seamless Persistent Header & Ultra-Fast Page Transitions (Vanilla JS - Zero Dependency)
 * - Persistent header across page navigations without page reload flicker
 * - Instant back/forward navigation using in-memory page cache (0ms delay)
 * - Single-request on-demand loading on user click
 * - Safe 3.5s timeout with automatic native browser fallback
 * - Luxury gold/accent top loading progress bar
 * - Dynamic head assets (CSS & scripts) synchronization
 * 
 * @package Gomie
 * @author TD Classic Architecture
 */
(function () {
  'use strict';

  // In-memory cache lưu HTML cho việc lùi/tiến 0ms
  const pageCache = new Map();
  let isNavigating = false;
  let activeAbort = null;

  // Lưu trang đầu tiên vào cache
  if (typeof document !== 'undefined' && document.documentElement) {
    const initialHtml = '<!DOCTYPE html>' + document.documentElement.outerHTML;
    pageCache.set(window.location.href, initialHtml);
    try {
      const initUrl = new URL(window.location.href);
      pageCache.set(initUrl.origin + initUrl.pathname, initialHtml);
    } catch (e) {}
  }

  // 1. Tạo thanh tiến trình vàng kim luxury chạy trên đỉnh trang
  const progressBar = document.createElement('div');
  progressBar.id = 'wp-page-progress';
  progressBar.style.cssText =
    'position:fixed;top:0;left:0;height:2.5px;width:0%;background:linear-gradient(90deg, #f47a20, #e0592a, #ffb380);box-shadow:0 0 10px rgba(244,122,32,0.8);z-index:999999;transition:width 0.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease;pointer-events:none;opacity:0;';
  
  if (document.body) {
    document.body.appendChild(progressBar);
  } else {
    document.addEventListener('DOMContentLoaded', () => document.body.appendChild(progressBar));
  }

  let progressTimer = null;
  function startProgress() {
    clearTimeout(progressTimer);
    progressBar.style.opacity = '1';
    progressBar.style.width = '35%';
    progressTimer = setTimeout(() => {
      if (isNavigating) progressBar.style.width = '75%';
    }, 120);
  }

  function finishProgress() {
    clearTimeout(progressTimer);
    progressBar.style.width = '100%';
    setTimeout(() => {
      progressBar.style.opacity = '0';
      setTimeout(() => {
        progressBar.style.width = '0%';
      }, 250);
    }, 120);
  }

  // 2. Kiểm tra xem link có đủ điều kiện nạp mượt mà không
  function isInternalNavigableUrl(url) {
    try {
      const parsed = new URL(url, window.location.href);
      // Chỉ xử lý cùng tên miền
      if (parsed.origin !== window.location.origin) return false;
      // Bỏ qua admin, login, checkout, cart, wp-json
      const path = parsed.pathname;
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

  // 3. Cập nhật trạng thái active cho Menu
  function updateNavActiveStates(targetUrl) {
    let targetPath = '/';
    try {
      const parsedTarget = new URL(targetUrl, window.location.href);
      targetPath = parsedTarget.pathname.replace(/\/$/, '') || '/';
    } catch (e) {}

    document.querySelectorAll('#masthead a, #main-header a, .main-nav a, .mobile-drawer a').forEach((link) => {
      const href = link.getAttribute('href');
      if (!href) return;
      try {
        const linkParsed = new URL(href, window.location.href);
        const linkPath = linkParsed.pathname.replace(/\/$/, '') || '/';

        const isMatch = (targetPath === '/' && linkPath === '/') || (linkPath !== '/' && targetPath.startsWith(linkPath));
        if (isMatch) {
          link.classList.add('active');
        } else {
          link.classList.remove('active');
        }
      } catch (e) {}
    });
  }

  // 4. Đồng bộ Stylesheet và Script mới trong <head>
  function updateHeadAssets(newDoc) {
    // Thêm các file CSS mới của trang đích
    const currentStyles = new Set(Array.from(document.querySelectorAll('link[rel="stylesheet"]')).map((l) => l.href));
    newDoc.querySelectorAll('link[rel="stylesheet"]').forEach((link) => {
      if (link.href && !currentStyles.has(link.href)) {
        const newLink = document.createElement('link');
        newLink.rel = 'stylesheet';
        newLink.href = link.href;
        if (link.id) newLink.id = link.id;
        if (link.media) newLink.media = link.media;
        document.head.appendChild(newLink);
      }
    });

    // Thêm các thẻ script bên ngoài mới trong <head> và <body>
    const currentScripts = new Set(Array.from(document.querySelectorAll('script[src]')).map((s) => s.src));
    newDoc.querySelectorAll('script[src]').forEach((script) => {
      if (script.src && !currentScripts.has(script.src)) {
        const newScript = document.createElement('script');
        Array.from(script.attributes).forEach((attr) => newScript.setAttribute(attr.name, attr.value));
        document.body.appendChild(newScript);
      }
    });
  }

  // 5. Kích hoạt lại các thành phần tương tác của trang
  function reinitPageFeatures() {
    // Re-dispatch events
    window.dispatchEvent(new Event('DOMContentLoaded'));
    window.dispatchEvent(new Event('wp:page-transitioned'));

    // Re-init AOS nếu có
    if (window.AOS && typeof window.AOS.refresh === 'function') {
      window.AOS.refresh();
    }
  }

  // 6. Tráo đổi DOM
  async function renderPageHtml(html, canonicalUrl, pushState) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');

    const canonicalTag = doc.querySelector('link[rel="canonical"]');
    if (canonicalTag && canonicalTag.href) {
      canonicalUrl = canonicalTag.href;
    }

    const currentMain = document.getElementById('main-content') || document.getElementById('content');
    const newMain = doc.getElementById('main-content') || doc.getElementById('content');

    // Nếu trang mới không có container chính, fallback về chuyển trang thông thường
    if (!currentMain || !newMain) {
      window.location.href = canonicalUrl;
      return;
    }

    updateHeadAssets(doc);

    // Cập nhật Title và Body Classes
    document.title = doc.title;
    document.body.className = doc.body.className;

    // Tráo đổi nội dung chính
    currentMain.innerHTML = newMain.innerHTML;

    // Cuộn lên đầu trang mượt mà
    window.scrollTo({ top: 0, behavior: 'instant' });

    // Cập nhật URL trình duyệt
    if (pushState) {
      window.history.pushState({ url: canonicalUrl }, '', canonicalUrl);
    }

    updateNavActiveStates(canonicalUrl);
    reinitPageFeatures();
  }

  // 7. Thực hiện điều hướng
  async function navigateTo(url, pushState = true) {
    if (isNavigating) {
      if (activeAbort) activeAbort.abort();
    }

    const targetUrl = new URL(url, window.location.href).href;
    if (targetUrl === window.location.href && !window.location.hash) return;

    // Trường hợp anchor hash link nội bộ
    if (url.startsWith('#')) {
      const el = document.querySelector(url);
      if (el) el.scrollIntoView({ behavior: 'smooth' });
      return;
    }

    isNavigating = true;
    startProgress();

    // Kiểm tra in-memory cache để hiển thị 0ms
    if (pageCache.has(targetUrl)) {
      const cachedHtml = pageCache.get(targetUrl);
      finishProgress();
      isNavigating = false;
      renderPageHtml(cachedHtml, targetUrl, pushState);
      return;
    }

    const controller = new AbortController();
    activeAbort = controller;

    // Safe timeout 3.5s tự động fallback
    const timeoutId = setTimeout(() => {
      controller.abort();
      window.location.href = targetUrl;
    }, 3500);

    try {
      const response = await fetch(targetUrl, {
        headers: { 'X-Requested-With': 'WP-Seamless-Transition' },
        signal: controller.signal
      });
      clearTimeout(timeoutId);

      if (!response.ok) {
        window.location.href = targetUrl;
        return;
      }

      const html = await response.text();
      pageCache.set(targetUrl, html);

      finishProgress();
      isNavigating = false;
      activeAbort = null;

      renderPageHtml(html, response.url || targetUrl, pushState);
    } catch (err) {
      clearTimeout(timeoutId);
      if (err.name !== 'AbortError') {
        window.location.href = targetUrl;
      }
    }
  }

  // 8. Bắt sự kiện click vào các thẻ <a>
  document.addEventListener('click', (e) => {
    const link = e.target.closest('a');
    if (!link) return;

    if (link.target === '_blank' || link.hasAttribute('download') || link.getAttribute('rel') === 'external') return;
    if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;

    const href = link.getAttribute('href');
    if (!href || href === '#' || href.startsWith('javascript:')) return;

    if (isInternalNavigableUrl(href)) {
      e.preventDefault();
      navigateTo(href, true);
    }
  });

  // 9. Bắt sự kiện Back/Forward của trình duyệt (Popstate)
  window.addEventListener('popstate', (e) => {
    const url = (e.state && e.state.url) || window.location.href;
    navigateTo(url, false);
  });
})();
