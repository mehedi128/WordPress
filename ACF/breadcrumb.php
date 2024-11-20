<?php

function hunky_breadcrumb(){
    global $post;  
    $breadcrumb_class = '';
    $breadcrumb_show = 1;

    if ( is_front_page() && is_home() ) {
        $title = get_theme_mod('breadcrumb_blog_title', __('Blog','hunky'));
        $breadcrumb_class = 'home_front_page';
    }
    elseif ( is_front_page() ) {
        $title = get_theme_mod('breadcrumb_blog_title', __('Blog','hunky'));
        $breadcrumb_show = 0;
    }
    elseif ( is_home() ) {
        if ( get_option( 'page_for_posts' ) ) {
            $title = get_the_title( get_option( 'page_for_posts') );
        }
    }
    elseif ( is_single() && 'post' == get_post_type() ) {
      $title = get_the_title();
    } 
    elseif ( is_single() && 'service' == get_post_type() ) {
      $title = get_the_title();
    } 
    elseif ( is_single() && 'product' == get_post_type() ) {
        $title = get_theme_mod( 'breadcrumb_product_details', __( 'Shop', 'hunky' ) );
    } 
    elseif ( is_search() ) {
        $title = esc_html__( 'Search Results for : ', 'hunky' ) . get_search_query();
    } 
    elseif ( is_404() ) {
        $title = esc_html__( 'Page not Found', 'hunky' );
    } 
    elseif ( is_archive() ) {
        $title = get_the_archive_title();
    } 
    else {
        $title = get_the_title();
    }


    $_id = get_the_ID();



    $breadcrumb_image_from_global = get_theme_mod('breadcrumb_image_setting_url');
    $breadcrumb_image_from_page = function_exists('get_field') ? get_field('breadcrumb_image') : null;

    if(!empty($breadcrumb_image_from_page)){
        $breadcrumb_image_url = $breadcrumb_image_from_page['url'] ? $breadcrumb_image_from_page['url'] : ''; 
    }else{
        $breadcrumb_image_url = $breadcrumb_image_from_global ? $breadcrumb_image_from_global : ''; 
    }
    
    $breadcrumb_switch = null;
    // Ensure ACF function exists
    if (function_exists('get_field')) {
        // Attempt to fetch the field with the current post ID
        $post_id = get_the_ID();
        $breadcrumb_switch = get_field('breadcrumb_hide', $post_id);

        // Set default to true if the value is null
        if ($breadcrumb_switch === null) {
            $breadcrumb_switch = true; // Default to true
        }
    }

    ?>
    <?php if(!empty($breadcrumb_switch) && $breadcrumb_switch) : ?>
    <!-- breadcrumb start -->
    <section class="breadcrumb" style="background-image: url('<?php echo esc_url($breadcrumb_image_url); ?>')">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb__info">
                        <h2><?php echo $title; ?></h2>
                        <div class="breadcrumb-list">
                        <?php if(function_exists('bcn_display')):?> 
                            <?php bcn_display(); ?> 
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- breadcrumb end -->
    <?php endif; ?>
<?php
}
