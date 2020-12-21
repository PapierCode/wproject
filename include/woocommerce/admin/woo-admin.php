<?php

/**
 * 
 * Woocommerce : customisation de l'admin
 * 
 */


/*====================================
=            Éditor accès            =
====================================*/

add_action( 'admin_init', 'pc_editor_access_woo');

   function pc_editor_access_woo() {

      $role = get_role( 'editor' );

      // produits
      $role->add_cap('edit_product' );
      $role->add_cap('read_product' );
      $role->add_cap('delete_product' );
      $role->add_cap('edit_products' );
      $role->add_cap('edit_others_products' );
      $role->add_cap('publish_products' );
      $role->add_cap('read_private_products' );
      $role->add_cap('delete_products' );
      $role->add_cap('delete_private_products' );
      $role->add_cap('delete_published_products' );
      $role->add_cap('delete_others_products' );
      $role->add_cap('edit_private_products' );
      $role->add_cap('edit_published_products' );

      // catégories
      $role->add_cap('manage_product_terms');
      $role->add_cap('edit_product_terms');
      $role->add_cap('delete_product_terms');
      $role->add_cap('assign_product_terms');

      // commandes
      $role->add_cap('edit_shop_orders');
      $role->add_cap('edit_others_shop_orders');
      $role->add_cap('publish_shop_orders');
      $role->add_cap('read_private_shop_orders');
      $role->add_cap('delete_shop_orders');
      $role->add_cap('delete_private_shop_orders');
      $role->add_cap('delete_published_shop_orders');
      $role->add_cap('delete_others_shop_orders');
      $role->add_cap('edit_private_shop_orders');
	  $role->add_cap('edit_published_shop_orders');

      // rapports
	  $role->add_cap('view_woocommerce_reports');
	  
	  // liste des utilisateurs
      $role->add_cap('list_users');
      $role->add_cap('edit_users');

   }

// plus de cap ?
// wp_get_current_user();
// pc_var($current_user,true);

/*----------  Duplication de produits  ----------*/

add_filter('woocommerce_duplicate_product_capability', 'pc_product_duplicate_capability');

   function pc_product_duplicate_capability($cap) {

      return 'edit_products';

   }


/*----------  Ne pas "afficher" un utlisateur  ----------*/

//add_filter( 'user_row_actions', 'pc_editor_user_row_actions', 10, 2 );

	function pc_editor_user_row_actions( $actions, $user ) {
		
		global $current_user_role;
		if ( $current_user_role == 'editor' ) {
			unset($actions['view']);
		}

		return $actions;

	}


/*----------  Afficher les datas clients pour les éditeurs  ----------*/

add_filter( 'woocommerce_current_user_can_edit_customer_meta_fields', function(){ return 'editor'; });


/*=====  FIN Éditor accès  ======*/

/*====================================================
=            Supprimer diverses fonctions            =
====================================================*/

// À voir aussi d'autres suppression dans woo.custom-admin.css


/*----------  Étiquettes  ----------*/

// modifier l'affichage plutôt que que désactiver qui provoque toute une série de message d'erreur

add_action('init', function() {
    register_taxonomy('product_tag', 'product', [
       'public'            => false,
       'show_ui'           => false,
       'show_admin_column' => false,
       'show_in_nav_menus' => false,
       'show_tagcloud'     => false,
    ]);
}, 100);


/*----------  Liste produits  ----------*/

// gestions des colonnes
add_filter( 'manage_product_posts_columns', 'pc_products_list_columns', 99 );

   function pc_products_list_columns( $columns ) {
      
      unset($columns['product_tag']); // étiquettes
      unset($columns['featured']); // étoile (?!)
      unset($columns['date']); // date
      $columns['producer'] = 'Producteur';
      return $columns;

   };

// remplissage nouvelle colonne
add_action( 'manage_product_posts_custom_column', 'pc_products_list_columns_populate', 10, 2);

   function pc_products_list_columns_populate( $column, $post_id ) {

      if ( 'producer' === $column ) {

         echo get_the_title( get_post_meta( $post_id, 'prod-producer', true ) );

      }

   }

// ajout filtre
add_action( 'restrict_manage_posts', 'pc_products_list_filters', 99, 2);

   function pc_products_list_filters( $post_type, $which ) {

      // si s'affiche la liste des  produits
      if( $post_type == 'product' ) { 

         // requête bdd pour trouver toutes les formations
         global $wpdb;
         $producers = $wpdb->get_results("SELECT id, post_title FROM loc_posts WHERE post_type='".POST_PRODUCER."' AND post_status='publish' ORDER BY post_title ASC");

         // si s'affiche la liste filtrée
         $current = isset( $_GET['select-producer'] ) ? $_GET['select-producer'] : '';

         // affichage select
         echo '<select name="select-producer" id="select-producer"><option value="">Toutes les producteurs</option>';
         foreach ($producers as $producer) {
            echo '<option value="'.$producer->id.'" '.selected($current,$producer->id,false).'>'.$producer->post_title.'</option>';
         }
         echo '</select>';

      }

   }

// ajout du filtre à la requête
add_filter( 'pre_get_posts', 'pc_products_list_filters_query' );

   function pc_products_list_filters_query( $query ) {

      // page affichée
      global $pagenow;
      // type de posts affichés
      $postType = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';

      // si c'est l'admin
      // & si c'est une page de liste
      // & si s'affichent des produits
      // & si le formulaire de filtre a été envoyé avec le select
      if ( is_admin() && $pagenow == 'edit.php' && $postType == 'product' && isset( $_GET['select-producer'] ) && $_GET['select-producer'] != '' ) {

         $query->set('meta_key', 'prod-producer');
         $query->set('meta_value', $_GET['select-producer']);
         $query->set('meta_compare', '=');

      }

   }

//pc_var($_GET,true);

//add_filter( 'woocommerce_product_filters', 'bbloomer_filter_by_custom_taxonomy_dashboard_products' );
 
// function bbloomer_filter_by_custom_taxonomy_dashboard_products( $output ) {
 
//   $output .= '<select name="prod-producer" id="prod-producer"><option value="">Tous les producteurs</option><option value="695">celui la</option></select>';
   
//   return $output;
// }


/*----------  Fiche produit  ----------*/

// wysiwyg par défaut
add_action( 'init', function() { remove_post_type_support( 'product', 'editor' );} );

// type de produits
add_filter( 'product_type_selector', 'he_add_custom_product_type',10,1 );

   function he_add_custom_product_type( $types ){
      unset( $types['grouped'] );
      unset( $types['external'] );
      return $types;
   }

// virtuel/téléchargeable
add_filter('product_type_options', function() { return array(); } );

// onglets
add_filter('woocommerce_product_data_tabs', 'he_product_datas_tabs', 10, 1);

   function he_product_datas_tabs( $tabs ) {
      unset($tabs['shipping']); // livraison
      unset($tabs['advanced']); // avancé
      unset($tabs['linked_product']); // produits liés
      $tabs['attribute']['class'][] = 'hide_if_simple';
      return($tabs);
   }


/*----------  Fiche produit & commande : metaboxes  ----------*/

add_action( 'add_meta_boxes', function() {
   // produit
   remove_meta_box('woocommerce-product-images','product','side'); // gallerie
   remove_meta_box( 'postcustom', 'product', 'normal' ); // champs personnalisés
   remove_meta_box( 'slugdiv', 'product', 'normal' ); // slug
   remove_meta_box( 'postexcerpt', 'product', 'normal' ); // description
   // commande
   remove_meta_box( 'postcustom', 'shop_order', 'normal' ); // champs personnalisés
   remove_meta_box( 'woocommerce-order-downloads', 'shop_order', 'normal' ); // champs personnalisés
}, 40 );


/*----------  Menu : metaboxes  ----------*/

add_filter( 'manage_nav-menus_columns', 'pc_admin_menu_remove_woo_metaboxes' );

   function pc_admin_menu_remove_woo_metaboxes($columns) {

      remove_meta_box('add-post-type-product', 'nav-menus', 'side');
      remove_meta_box('add-product_cat', 'nav-menus', 'side');
      remove_meta_box('woocommerce_endpoints_nav_link', 'nav-menus', 'side');

      return $columns;

   }


/*----------  Liste des commandes  ----------*/

// gestions des colonnes
add_filter( 'manage_shop_order_posts_columns', 'pc_shop_order_list_columns', 99 );

function pc_shop_order_list_columns( $columns ) {

   $new = array();
   foreach($columns as $key => $value) {
      if ( $key == 'order_date' ) { $new['msg'] = 'Message'; }
      $new[$key] = $value;
   }

   return $new;

};

// remplissage nouvelle colonne
add_action( 'manage_shop_order_posts_custom_column', 'pc_shop_order_list_columns_populate', 10, 2);

   function pc_shop_order_list_columns_populate( $column, $post_id ) {

      if ( 'msg' === $column ) {

         $order = wc_get_order($post_id);
         echo $order->get_customer_note();

      }

   }




/*=====  FIN Supprimer diverses fonctions  ======*/
