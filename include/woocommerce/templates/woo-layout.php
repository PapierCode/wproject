<?php

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

add_action('woocommerce_before_main_content', 'pc_woo_main_start_tag', 10);

   function pc_woo_main_start_tag() {

      if ( !is_shop() ) { // autre que la page d'accueil de la boutique

         echo '<div class="layout layout--cols2 layout--woo mw"><main id="main" class="main anime-cat-nav">';

      } else {

         echo '<div class="layout mw"><main id="main" class="main">';

      }
   }

remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_after_main_content', 'pc_woo_main_end_tag', 10);

   function pc_woo_main_end_tag() {
      
      if ( !is_shop() ) { // autre que la page d'accueil de la boutique

         echo '</main>';
         pc_woo_sidebar();
         echo '</div>';

      } else {

         echo '</main></div>';

      }
      
   }
