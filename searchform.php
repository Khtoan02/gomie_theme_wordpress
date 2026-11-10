<?php
/**
 * The template for displaying search forms
 *
 * @package Gomie
 */
?>

<form role="search" method="get" class="gomie-search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="input-group search-input-group p-1 bg-white rounded-pill border shadow-sm">
        <span class="input-group-text bg-transparent border-0 ps-3 text-muted">
            <i class="fas fa-search"></i>
        </span>
        <input type="search" 
               class="form-control border-0 bg-transparent py-2 px-2 shadow-none" 
               placeholder="<?php echo esc_attr_x('Tìm kiếm bát đĩa, dòng men, quà tặng...', 'placeholder', 'gomie-theme'); ?>" 
               value="<?php echo get_search_query(); ?>" 
               name="s" 
               autocomplete="off" />
        <input type="hidden" name="post_type" value="product" />
        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold" style="background: #C75C2C; border-color: #C75C2C;">
            <?php esc_html_e('Tìm kiếm', 'gomie-theme'); ?>
        </button>
    </div>
</form>
