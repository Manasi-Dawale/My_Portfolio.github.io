<?php
add_action( 'wp_enqueue_scripts', 'hubfolio_child_theme_styles',3);
function hubfolio_child_theme_styles() {
		
    wp_enqueue_style('hubfolio-parent-style', get_template_directory_uri(). '/style.css', array('bootstrap'));
    wp_enqueue_style('hubfolio-child-style', get_stylesheet_uri(), array( 'hubfolio-parent-style') );
}





