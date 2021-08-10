<?php

add_action( 'admin_enqueue_scripts', 'pc_project_enqueue_scripts', 999 );

    function pc_project_enqueue_scripts() {

        wp_enqueue_style( 'pc-project-css-admin', get_stylesheet_directory_uri().'/include/admin/admin.css' );
        
    };

include 'block-editor/block-editor.php';
