<?php
/**
 * 
 * Woocommerce template : fil d'ariane
 * 
 */

////////// à relire ///////////

/*----------  Global  ----------*/

add_filter( 'woocommerce_breadcrumb_defaults', 'pc_woo_breadcrum_custom' );
   
   function pc_woo_breadcrum_custom() {

      return array(
         'delimiter'   => '',
         'wrap_before' => '<nav class="breadcrumb"><ol class="breadcrumb-list reset-list">',
         'wrap_after'  => '</ol></nav>',
         'before'      => '<li class="breadcrumb-item">',
         'after'       => '</li>',
         'home'        => get_the_title(wc_get_page_id( 'shop' )),
      );
      
   }


/*----------  Lien "Accueil"  ----------*/

add_filter( 'woocommerce_breadcrumb_home_url', 'pc_woo_custom_breadrumb_home_url' );

   function pc_woo_custom_breadrumb_home_url() {

      return get_permalink( wc_get_page_id( 'shop' ) );

   }


/*----------  Condition d'affichage  ----------*/

add_action('template_redirect', 'pc_woo_breadcrumb_display' );

   function pc_woo_breadcrumb_display() {
    
      remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

      if ( is_product_category() ) {
         add_action( 'woocommerce_archive_description', 'woocommerce_breadcrumb', 5 );
      }
      if ( is_product() ) {
         add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 6 );
      }
    
   }
