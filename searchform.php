<?php
/**
 * The template for displaying search forms in Gomie Ceramic Editorial V11
 *
 * @package Gomie
 */

$current_search = get_search_query();
?>

<form role="search" method="get" class="gomie-search-form-v11" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="search-form-inner">
        <span class="search-icon-prefix" aria-hidden="true">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="search" 
               class="search-input-field" 
               placeholder="<?php echo esc_attr_x('Tìm kiếm bát đĩa, ấm chén, dòng men, quà tặng, bài viết...', 'placeholder', 'gomie'); ?>" 
               value="<?php echo esc_attr($current_search); ?>" 
               name="s" 
               autocomplete="off" 
               required />
        <?php if (!empty($current_search)) : ?>
            <button type="button" class="btn-clear-search" onclick="var inp=this.previousElementSibling; inp.value=''; inp.focus();" aria-label="Xóa từ khóa" title="Xóa từ khóa">
                <i class="fa-solid fa-xmark"></i>
            </button>
        <?php endif; ?>
        <button type="submit" class="btn-submit-search">
            <span>Tìm kiếm</span>
            <i class="fa-solid fa-arrow-right ms-1"></i>
        </button>
    </div>
</form>

<style id="gomie-searchform-style">
.gomie-search-form-v11 {
    width: 100%;
    margin: 0 auto;
}
.gomie-search-form-v11 .search-form-inner {
    display: flex;
    align-items: center;
    background: #ffffff;
    border-radius: 999px;
    padding: 6px 8px 6px 20px;
    border: 1.5px solid rgba(235, 222, 206, 0.95);
    box-shadow: 0 8px 24px rgba(45, 30, 15, 0.05);
    transition: all 0.25s ease;
    box-sizing: border-box;
}
.gomie-search-form-v11 .search-form-inner:focus-within {
    border-color: var(--orange, #f47a20);
    box-shadow: 0 10px 28px rgba(244, 122, 32, 0.16);
    background: #ffffff;
}
.gomie-search-form-v11 .search-icon-prefix {
    color: var(--orange, #f47a20);
    font-size: 16px;
    margin-right: 12px;
    display: flex;
    align-items: center;
    flex-shrink: 0;
}
.gomie-search-form-v11 .search-input-field {
    flex: 1;
    border: none !important;
    background: transparent !important;
    outline: none !important;
    font-size: 15px;
    color: #1e2830;
    padding: 8px 0;
    min-width: 0;
}
.gomie-search-form-v11 .search-input-field::placeholder {
    color: #94a3b8;
    font-size: 14.5px;
}
.gomie-search-form-v11 .btn-clear-search {
    background: transparent;
    border: none;
    color: #94a3b8;
    padding: 6px 10px;
    font-size: 14px;
    cursor: pointer;
    transition: color 0.2s;
    display: flex;
    align-items: center;
}
.gomie-search-form-v11 .btn-clear-search:hover {
    color: #e0592a;
}
.gomie-search-form-v11 .btn-submit-search {
    background: linear-gradient(135deg, #f47a20 0%, #db6109 100%);
    color: #ffffff !important;
    border: none;
    border-radius: 999px;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 750;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 4px 14px rgba(244, 122, 32, 0.3);
    transition: all 0.25s ease;
    flex-shrink: 0;
}
.gomie-search-form-v11 .btn-submit-search:hover {
    background: linear-gradient(135deg, #db6109 0%, #b84c00 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(244, 122, 32, 0.45);
}
@media (max-width: 576px) {
    .gomie-search-form-v11 .search-form-inner {
        padding: 5px 6px 5px 14px;
    }
    .gomie-search-form-v11 .search-input-field {
        font-size: 13.5px;
    }
    .gomie-search-form-v11 .search-input-field::placeholder {
        font-size: 12.5px;
    }
    .gomie-search-form-v11 .btn-submit-search {
        padding: 8px 16px;
        font-size: 13px;
    }
}
</style>
