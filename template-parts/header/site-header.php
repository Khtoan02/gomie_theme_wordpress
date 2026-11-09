<?php
/**
 * Template part for displaying the site header
 *
 * @package Gomie
 */
?>

<div class="header-inner">
    <div class="container">
        <div class="header-wrapper">
            <!-- Logo -->
            <div class="site-logo">
                <?php
                if (has_custom_logo()) :
                    the_custom_logo();
                else :
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <span class="site-name"><?php bloginfo('name'); ?></span>
                    </a>
                    <?php
                endif;
                ?>
            </div>
            
            <!-- Navigation -->
            <nav class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'nav-menu',
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>
            
            <!-- Header Tools -->
            <div class="header-tools">
                <!-- Search -->
                <button class="search-toggle" aria-label="<?php esc_attr_e('Toggle search', 'gomie-theme'); ?>">
                    <i class="fas fa-search"></i>
                </button>
                
                <!-- Phone -->
                <?php
                $phone = gomie_get_option('phone_number');
                if ($phone) :
                    ?>
                    <a href="tel:<?php echo gomie_format_phone($phone); ?>" class="header-phone">
                        <i class="fas fa-phone"></i>
                        <span><?php echo esc_html($phone); ?></span>
                    </a>
                    <?php
                endif;
                ?>
                
                <!-- CTA Button -->
                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="header-cta glass-button">
                    <?php esc_html_e('Báo giá', 'gomie-theme'); ?>
                </a>
                
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" aria-label="<?php esc_attr_e('Toggle menu', 'gomie-theme'); ?>">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Search Dropdown -->
<div class="header-search-dropdown">
    <div class="container">
        <?php get_search_form(); ?>
    </div>
</div>