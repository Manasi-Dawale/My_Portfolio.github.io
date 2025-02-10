<?php
/**
 * The template for index posts 
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ThemesCamp 
 */

get_header();

	if ( ! class_exists('\ThemescampPlugin\ThemescampPlugin') ) { 

		get_template_part('template-parts/content','blog');

	}  else{

		do_action( "themescamp_archive" );

	}
        
get_footer(); ?>