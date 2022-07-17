<?php

add_filter( 'pc_filter_form_contact_css_classes', 'pc_projet_edit_form_contact_css_classes' );

	function pc_projet_edit_form_contact_css_classes( $classes ) {

		$classes['button-submit'] = array_merge(
			$classes['button-submit'],
			array( 'button--xl', 'button--orange' )
		);
		return $classes;

	}