<?php
/*
Template Name: Blank Page Builder
Template Post Type: page, portfolio 
Description:One Page Builder with container. 
*/
get_header();

if (class_exists('\ThemescampPlugin\ThemescampPlugin')) {

	(new Themescamp_Blank());

}else{

	//page content
	echo'<div class="blank-builder tcg-theme">';
	while (have_posts()) : the_post();
		the_content();
	endwhile;
	echo'</div>';

}
		
get_footer(); ?>