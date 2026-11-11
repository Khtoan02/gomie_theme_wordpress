/**
 * Shop Page Instant Filter & Interactivity Engine (Editorial V11)
 * Gomie Ceramic - Zero-Plugin Handcrafted Architecture
 *
 * Supports:
 * - 9-Glaze Ceramic Attribute System (pa_mau-sac)
 * - Category / Gift filtering
 * - Instant client-side filtering & search with pagination (Load More)
 * - Sorting by Price, Title, Featured
 * - Seamless integration with SPA Page Transitions (wp:page-transitioned)
 * - Robust Event Delegation on document level
 */

(function($) {
    'use strict';

    var pageSize = 16;
    var currentlyVisibleLimit = 16;
    var currentGlaze = 'all';
    var currentCat = 'all';

    function renderActiveTags() {
        var activeTagsContainer = document.getElementById('activeFilterTags');
        if (!activeTagsContainer) return;
        activeTagsContainer.innerHTML = '';

        if (currentGlaze !== 'all') {
            var activeGlazeEl = document.querySelector('#glazeFilter .glaze-chip-widget.active');
            var name = activeGlazeEl ? (activeGlazeEl.querySelector('.chip-title') ? activeGlazeEl.querySelector('.chip-title').textContent.trim() : currentGlaze) : currentGlaze;
            var tag = document.createElement('span');
            tag.className = 'active-tag';
            tag.setAttribute('data-filter-type', 'glaze');
            tag.innerHTML = name + ' <i class="fa-solid fa-xmark"></i>';
            tag.title = 'Bỏ lọc men';
            activeTagsContainer.appendChild(tag);
        }

        if (currentCat !== 'all') {
            var activeCatEl = document.querySelector('#categoryFilter .cat-pill-widget.active, .gift-pill-widget.active');
            var catName = activeCatEl ? (activeCatEl.querySelector('.cat-name, .gift-name') ? activeCatEl.querySelector('.cat-name, .gift-name').textContent.trim() : currentCat) : currentCat;
            var catTag = document.createElement('span');
            catTag.className = 'active-tag';
            catTag.setAttribute('data-filter-type', 'cat');
            catTag.innerHTML = catName + ' <i class="fa-solid fa-xmark"></i>';
            catTag.title = 'Bỏ lọc danh mục';
            activeTagsContainer.appendChild(catTag);
        }
    }

    function applyFilters() {
        var grid = document.getElementById('productGrid');
        if (!grid) return;

        var cards = Array.from(grid.querySelectorAll('.product-card-col'));
        var matchingCards = [];

        var filterGlazeClean = currentGlaze.replace(/^men-/, '').toLowerCase();

        cards.forEach(function(card) {
            var cardGlaze = (card.getAttribute('data-glaze') || '').toLowerCase();
            var cardGlazeClean = cardGlaze.replace(/^men-/, '');
            var rawCats = (card.getAttribute('data-cat') || '').toLowerCase();
            var cardCats = rawCats.split(/\s+/);

            // Glaze match with alias support (song-bien = hoa-bien, etc.)
            var glazeMatch = (currentGlaze === 'all');
            if (!glazeMatch) {
                if (cardGlaze === currentGlaze || cardGlazeClean === filterGlazeClean) {
                    glazeMatch = true;
                } else if ((filterGlazeClean === 'xanh-song-bien' || filterGlazeClean === 'song-bien' || filterGlazeClean === 'hoa-bien') && 
                           (cardGlazeClean === 'xanh-song-bien' || cardGlazeClean === 'song-bien' || cardGlazeClean === 'hoa-bien' || cardGlazeClean === 'xanh-hoa-bien')) {
                    glazeMatch = true;
                } else if ((filterGlazeClean === 'xanh-ngoc' || filterGlazeClean === 'ngoc-trai') && 
                           (cardGlazeClean === 'xanh-ngoc' || cardGlazeClean === 'ngoc-trai' || cardGlazeClean === 'bich-ngoc')) {
                    glazeMatch = true;
                } else if (filterGlazeClean === 'xanh-thien-thanh' && cardGlazeClean === 'thien-thanh') {
                    glazeMatch = true;
                }
            }

            // Category match
            var catMatch = (currentCat === 'all');
            if (!catMatch) {
                catMatch = (cardCats.indexOf(currentCat.toLowerCase()) !== -1 || rawCats.indexOf(currentCat.toLowerCase()) !== -1);
            }

            if (glazeMatch && catMatch) {
                matchingCards.push(card);
            } else {
                card.classList.add('d-none');
            }
        });

        var totalMatches = matchingCards.length;
        var countEl = document.getElementById('productCount');
        if (countEl) countEl.textContent = totalMatches;

        var tbCount = document.getElementById('toolbarFilterCount');
        if (tbCount) tbCount.textContent = totalMatches;

        var isFiltered = (currentGlaze !== 'all' || currentCat !== 'all');
        var activeLimit = isFiltered ? Math.max(currentlyVisibleLimit, pageSize) : currentlyVisibleLimit;

        matchingCards.forEach(function(card, index) {
            if (index < activeLimit) {
                card.classList.remove('d-none');
            } else {
                card.classList.add('d-none');
            }
        });

        var loadMoreWrap = document.getElementById('loadMoreWrap');
        var btnLoadMore = document.getElementById('btnLoadMore');
        var loadMoreBadge = document.getElementById('loadMoreBadge');
        if (loadMoreWrap && btnLoadMore) {
            var remaining = totalMatches - activeLimit;
            if (remaining > 0) {
                loadMoreWrap.classList.remove('d-none');
                if (loadMoreBadge) loadMoreBadge.textContent = '+' + (remaining > pageSize ? pageSize : remaining);
            } else {
                loadMoreWrap.classList.add('d-none');
            }
        }

        var emptyAlert = document.getElementById('noProductsAlert');
        if (emptyAlert) {
            if (totalMatches === 0) emptyAlert.classList.remove('d-none');
            else emptyAlert.classList.add('d-none');
        }

        renderActiveTags();
    }

    function initShopFilters() {
        var grid = document.getElementById('productGrid');
        if (!grid) return;

        try {
            var urlParams = new URLSearchParams(window.location.search);
            var urlGlaze = urlParams.get('glaze') || urlParams.get('pa_mau-sac') || urlParams.get('mau-sac') || urlParams.get('filter_mau-sac');
            var urlCat = urlParams.get('cat') || urlParams.get('category') || urlParams.get('product_cat');

            if (urlGlaze) {
                var cleanUrlGlaze = urlGlaze.replace(/^men-/, '').toLowerCase();
                var allChips = document.querySelectorAll('#glazeFilter .glaze-chip-widget');
                var matched = false;

                allChips.forEach(function(chip) {
                    var dg = (chip.getAttribute('data-glaze') || '').toLowerCase();
                    var dgClean = dg.replace(/^men-/, '');
                    if (dg === urlGlaze.toLowerCase() || dgClean === cleanUrlGlaze ||
                        ((cleanUrlGlaze === 'xanh-song-bien' || cleanUrlGlaze === 'song-bien' || cleanUrlGlaze === 'hoa-bien') && 
                         (dgClean === 'xanh-song-bien' || dgClean === 'song-bien' || dgClean === 'hoa-bien')) ||
                        ((cleanUrlGlaze === 'xanh-ngoc' || cleanUrlGlaze === 'ngoc-trai') && 
                         (dgClean === 'xanh-ngoc' || dgClean === 'ngoc-trai')) ||
                        ((cleanUrlGlaze === 'xanh-thien-thanh' || cleanUrlGlaze === 'thien-thanh') && 
                         (dgClean === 'xanh-thien-thanh' || dgClean === 'thien-thanh'))) {
                        allChips.forEach(function(c) { c.classList.remove('active'); });
                        chip.classList.add('active');
                        currentGlaze = chip.getAttribute('data-glaze');
                        matched = true;
                    }
                });

                if (!matched && urlGlaze !== 'all') {
                    currentGlaze = urlGlaze;
                }
            } else {
                // If no glaze in URL, default to active chip or 'all'
                var activeChip = document.querySelector('#glazeFilter .glaze-chip-widget.active');
                if (activeChip) {
                    currentGlaze = activeChip.getAttribute('data-glaze') || 'all';
                }
            }

            if (urlCat) {
                var allPills = document.querySelectorAll('#categoryFilter .cat-pill-widget, .gift-pill-widget');
                allPills.forEach(function(pill) {
                    if ((pill.getAttribute('data-cat') || '').toLowerCase() === urlCat.toLowerCase()) {
                        allPills.forEach(function(p) { p.classList.remove('active'); });
                        pill.classList.add('active');
                        currentCat = pill.getAttribute('data-cat');
                    }
                });
            } else {
                var activePill = document.querySelector('#categoryFilter .cat-pill-widget.active, .gift-pill-widget.active');
                if (activePill) {
                    currentCat = activePill.getAttribute('data-cat') || 'all';
                }
            }
        } catch (e) {
            console.warn('URL params parsing error:', e);
        }

        applyFilters();
    }

    function resetFilters() {
        var allGlazeBtn = document.querySelector('#glazeFilter .glaze-chip-widget[data-glaze="all"]');
        if (allGlazeBtn) {
            document.querySelectorAll('#glazeFilter .glaze-chip-widget').forEach(function(c) { c.classList.remove('active'); });
            allGlazeBtn.classList.add('active');
        }

        var allCatBtn = document.querySelector('#categoryFilter .cat-pill-widget[data-cat="all"]');
        if (allCatBtn) {
            document.querySelectorAll('#categoryFilter .cat-pill-widget, .gift-pill-widget').forEach(function(p) { p.classList.remove('active'); });
            allCatBtn.classList.add('active');
        }

        currentGlaze = 'all';
        currentCat = 'all';
        currentlyVisibleLimit = pageSize;

        // Clean query params in URL without full reload
        try {
            var url = new URL(window.location.href);
            url.searchParams.delete('glaze');
            url.searchParams.delete('pa_mau-sac');
            url.searchParams.delete('cat');
            url.searchParams.delete('category');
            url.searchParams.delete('swoof');
            window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
        } catch(e) {}

        applyFilters();
    }

    // ==========================================
    // DELEGATED EVENT LISTENERS (Document Level)
    // Ensures clicks always work after SPA swap
    // ==========================================

    // 1. Click Glaze Chip
    $(document).on('click', '#glazeFilter .glaze-chip-widget', function(e) {
        e.preventDefault();
        $('#glazeFilter .glaze-chip-widget').removeClass('active');
        $(this).addClass('active');
        currentGlaze = $(this).attr('data-glaze') || 'all';
        currentlyVisibleLimit = pageSize;

        try {
            var url = new URL(window.location.href);
            if (currentGlaze === 'all') {
                url.searchParams.delete('glaze');
                url.searchParams.delete('pa_mau-sac');
                url.searchParams.delete('swoof');
            } else {
                url.searchParams.set('glaze', currentGlaze);
            }
            window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
        } catch(err) {}

        applyFilters();
    });

    // 2. Click Category Pill
    $(document).on('click', '#categoryFilter .cat-pill-widget, .gift-pill-widget', function(e) {
        e.preventDefault();
        $('#categoryFilter .cat-pill-widget, .gift-pill-widget').removeClass('active');
        $(this).addClass('active');
        currentCat = $(this).attr('data-cat') || 'all';
        currentlyVisibleLimit = pageSize;

        try {
            var url = new URL(window.location.href);
            if (currentCat === 'all') {
                url.searchParams.delete('cat');
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('cat', currentCat);
            }
            window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
        } catch(err) {}

        applyFilters();
    });

    // 3. Clear Filters Button
    $(document).on('click', '.btn-clear-filters', function(e) {
        e.preventDefault();
        resetFilters();
    });

    // 4. Click Active Tag to dismiss
    $(document).on('click', '.active-tag', function(e) {
        e.preventDefault();
        var filterType = $(this).attr('data-filter-type');
        if (filterType === 'glaze') {
            var allBtn = document.querySelector('#glazeFilter .glaze-chip-widget[data-glaze="all"]');
            if (allBtn) {
                $('#glazeFilter .glaze-chip-widget').removeClass('active');
                $(allBtn).addClass('active');
            }
            currentGlaze = 'all';
            try {
                var url = new URL(window.location.href);
                url.searchParams.delete('glaze');
                url.searchParams.delete('pa_mau-sac');
                window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
            } catch(e) {}
            applyFilters();
        } else if (filterType === 'cat') {
            var allCatBtn = document.querySelector('#categoryFilter .cat-pill-widget[data-cat="all"]');
            if (allCatBtn) {
                $('#categoryFilter .cat-pill-widget, .gift-pill-widget').removeClass('active');
                $(allCatBtn).addClass('active');
            }
            currentCat = 'all';
            try {
                var u = new URL(window.location.href);
                u.searchParams.delete('cat');
                u.searchParams.delete('category');
                window.history.replaceState({}, '', u.pathname + (u.search ? u.search : ''));
            } catch(e) {}
            applyFilters();
        }
    });

    // 5. Load More Button
    $(document).on('click', '#btnLoadMore', function(e) {
        e.preventDefault();
        currentlyVisibleLimit += pageSize;
        applyFilters();
    });

    // 6. Sort Select Change
    $(document).on('change', '#shopSort', function(e) {
        var val = $(this).val();
        var grid = document.getElementById('productGrid');
        if (!grid) return;

        var cards = Array.from(grid.querySelectorAll('.product-card-col'));
        cards.sort(function(a, b) {
            if (val === 'price-asc') {
                return (parseFloat(a.dataset.price) || 0) - (parseFloat(b.dataset.price) || 0);
            } else if (val === 'price-desc') {
                return (parseFloat(b.dataset.price) || 0) - (parseFloat(a.dataset.price) || 0);
            } else if (val === 'title-asc') {
                return (a.dataset.title || '').localeCompare(b.dataset.title || '', 'vi');
            }
            return (parseInt(a.dataset.index, 10) || 0) - (parseInt(b.dataset.index, 10) || 0);
        });

        cards.forEach(function(c) { grid.appendChild(c); });
        applyFilters();
    });

    // 7. Toggle Mobile Filter Sidebar
    $(document).on('click', '#btnToggleMobileFilter', function(e) {
        e.preventDefault();
        var sidebarEl = document.getElementById('shopFilterSidebar');
        if (sidebarEl) {
            sidebarEl.classList.toggle('show-mobile');
            if (sidebarEl.classList.contains('show-mobile')) {
                sidebarEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });

    // 8. AJAX Add to Cart Button (V11)
    $(document).on('click', '.btn-add-cart-v11', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var pid = $btn.attr('data-product-id');
        var originalHtml = $btn.html();
        var toast = document.getElementById('cartToast');

        $btn.addClass('loading').html('<i class="fa-solid fa-spinner fa-spin"></i> Đang thêm...');

        var formData = new FormData();
        formData.append('product_id', pid);
        formData.append('quantity', 1);

        var cartEndpoint = (window.wc_add_to_cart_params && window.wc_add_to_cart_params.wc_ajax_url)
            ? window.wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart')
            : '/?wc-ajax=add_to_cart';

        fetch(cartEndpoint, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(function(res) {
            $btn.removeClass('loading').html('<i class="fa-solid fa-check"></i> Đã thêm');
            if (toast) {
                toast.classList.add('show');
                setTimeout(function() { toast.classList.remove('show'); }, 4000);
            }
            setTimeout(function() { $btn.html(originalHtml); }, 2000);

            // Refresh fragments for header cart counter
            fetch('/?wc-ajax=get_refreshed_fragments', { method: 'POST' })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data && data.fragments) {
                    for (var key in data.fragments) {
                        var el = document.querySelector(key);
                        if (el) el.outerHTML = data.fragments[key];
                    }
                }
            }).catch(function() {});
        })
        .catch(function(err) {
            $btn.removeClass('loading').html(originalHtml);
            alert('Có lỗi xảy ra khi thêm vào giỏ hàng. Vui lòng thử lại!');
        });
    });

    // Expose helpers globally
    window.initShopFilters = initShopFilters;
    window.resetFilters = resetFilters;
    window.applyShopFilters = applyFilters;

    // Attach lifecycle triggers
    $(document).ready(initShopFilters);
    window.addEventListener('DOMContentLoaded', initShopFilters);
    window.addEventListener('wp:page-transitioned', initShopFilters);
    window.addEventListener('popstate', initShopFilters);

})(jQuery);
