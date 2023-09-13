<?php

add_filter( 'pc_filter_news_home_btn_more', 'project_edit_home_btn_more' );
add_filter( 'pc_filter_events_home_btn_more', 'project_edit_home_btn_more' );

    function project_edit_home_btn_more( $btn_more_args ) {

        $btn_more_args['display'] = true;
        return $btn_more_args;

    }